# main_two_stage_model.py
import uvicorn
import joblib
from ultralytics import YOLO
import cv2
import numpy as np
import base64
import io
import os
import pandas as pd
from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from PIL import Image

import SimpleITK as sitk
from radiomics import featureextractor
import logging

# Setup Logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = FastAPI(title="API Deteksi dan Klasifikasi Stroke (Two-Stage Model)")

origins = ["*"]
app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# --- MODEL PATHS ---
YOLO_MODEL_PATH = "model/best.pt"
CLASSIFIER_MODEL_PATH = "model/model_klasifikasi_stroke.joblib"
LABEL_ENCODER_PATH = "model/label_encoder.joblib"
FEATURE_COLUMNS_PATH = "model/feature_columns.joblib"

# Globals
yolo_model = None
classifier_model = None
label_encoder = None
feature_columns = None
extractor = None

@app.on_event("startup")
def load_models():
    global yolo_model, classifier_model, label_encoder, feature_columns, extractor
    try:
        logger.info("🔄 Memuat model dan extractor...")
        yolo_model = YOLO(YOLO_MODEL_PATH)
        classifier_model = joblib.load(CLASSIFIER_MODEL_PATH)
        label_encoder = joblib.load(LABEL_ENCODER_PATH)
        feature_columns = joblib.load(FEATURE_COLUMNS_PATH)
        extractor = featureextractor.RadiomicsFeatureExtractor()
        logger.info("✅ Semua model berhasil dimuat.")
    except Exception as e:
        logger.exception(f"❌ Error loading models: {e}")

# --- HELPERS ---

def apply_windowing(img_array, window_center=40, window_width=80):
    """Mengonversi nilai pixel medis ke format visual JPG (Brain Window)"""
    img_min = window_center - window_width // 2
    img_max = window_center + window_width // 2
    windowed_img = np.clip(img_array, img_min, img_max)
    windowed_img = ((windowed_img - img_min) / (img_max - img_min) * 255).astype(np.uint8)
    return windowed_img

def safe_get_ml_probabilities(model, X):
    try:
        return model.predict_proba(X)[0]
    except:
        scores = model.decision_function(X)
        if scores.ndim == 1: scores = scores.reshape(1, -1)
        exp = np.exp(scores - np.max(scores, axis=1, keepdims=True))
        return (exp / np.sum(exp, axis=1, keepdims=True))[0]

def extract_features(image_input: np.ndarray):
    global extractor, feature_columns
    try:
        gray = cv2.cvtColor(image_input, cv2.COLOR_BGR2GRAY) if image_input.ndim == 3 else image_input
        if gray.shape[0] < 10: gray = cv2.resize(gray, (50, 50))
        
        sitk_image = sitk.GetImageFromArray(gray.astype(np.float32))
        sitk_mask = sitk.GetImageFromArray(np.ones_like(gray, dtype=np.uint8))
        sitk_mask.CopyInformation(sitk_image)

        result = extractor.execute(sitk_image, sitk_mask)
        feature_dict = {k: float(v) for k, v in result.items() if not k.startswith('diagnostics')}
        
        features_df = pd.DataFrame([feature_dict])
        return features_df.reindex(columns=feature_columns, fill_value=0.0)
    except Exception as e:
        logger.exception(f"⚠️ Feature extraction error: {e}")
        return pd.DataFrame(np.zeros((1, len(feature_columns))), columns=feature_columns)

def is_valid_brain_ct(image_cv):
    try:
        # 1. Konversi ke Grayscale jika belum
        gray = cv2.cvtColor(image_cv, cv2.COLOR_BGR2GRAY) if image_cv.ndim == 3 else image_cv
        
        # 2. Cek Intensitas Cahaya (Filter gambar hitam pekat atau putih polos)
        mean_val = np.mean(gray)
        if mean_val < 10 or mean_val > 200:
            return False, "Gambar terlalu gelap atau terlalu terang (Bukan CT Scan)."

        # 3. Deteksi Struktur Tengkorak (Tulang biasanya memiliki intensitas > 180)
        # Kita cari area putih yang membentuk lingkaran/oval
        _, thresh = cv2.threshold(gray, 180, 255, cv2.THRESH_BINARY)
        contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        if len(contours) == 0:
            return False, "Struktur tulang tengkorak tidak terdeteksi."

        # 4. Cek Luas Objek Utama
        max_cnt = max(contours, key=cv2.contourArea)
        area_ratio = cv2.contourArea(max_cnt) / (gray.shape[0] * gray.shape[1])
        
        if area_ratio < 0.10: # Jika objek putih terlalu kecil (kurang dari 10%)
            return False, "Objek terdeteksi terlalu kecil untuk sebuah CT Scan kepala."

        return True, "Valid"
    except Exception as e:
        logger.error(f"Validation error: {e}")
        return False, "Gagal memvalidasi format gambar."
        

@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    if not yolo_model or not classifier_model:
        raise HTTPException(status_code=500, detail="Model belum siap.")

    try:
        contents = await file.read()
        filename = file.filename.lower()

        # 1. KONVERSI FORMAT (Sama seperti kode lama kamu)
        if filename.endswith(('.dcm', '.dicom')):
            tmp_path = f"temp_{filename}"
            with open(tmp_path, "wb") as f: f.write(contents)
            sitk_img = sitk.ReadImage(tmp_path)
            img_array = sitk.GetArrayFromImage(sitk_img)
            if len(img_array.shape) == 3: img_array = img_array[len(img_array)//2]
            processed_img = apply_windowing(img_array)
            image_cv = cv2.cvtColor(processed_img, cv2.COLOR_GRAY2BGR)
            os.remove(tmp_path)
        else:
            pil_image = Image.open(io.BytesIO(contents)).convert("RGB")
            image_cv = cv2.cvtColor(np.array(pil_image), cv2.COLOR_RGB2BGR)

        # --- VALIDASI GAMBAR (TAMBAHAN BARU) ---
        is_valid, msg = is_valid_brain_ct(image_cv)
        if not is_valid:
            # Jika tidak valid, langsung return tanpa jalankan YOLO/Radiomics
            _, buffer = cv2.imencode('.jpg', image_cv)
            image_base64 = base64.b64encode(buffer).decode('utf-8')
            return {
                "classification": "Bukan Brain CT",
                "percentage": 0,
                "decision_note": f"Validasi Gagal: {msg}",
                "image_with_box": image_base64
            }

        # 2. PROSES YOLO
        results = yolo_model(image_cv, verbose=False)
        is_stroke_yolo = len(results[0].boxes) > 0
        yolo_label, yolo_conf, bbox, roi_img = "Normal", 0.0, [], image_cv
        
        if is_stroke_yolo:
            best_box = results[0].boxes[int(np.argmax(results[0].boxes.conf.cpu().numpy()))]
            x1, y1, x2, y2 = map(int, best_box.xyxy[0].tolist())
            bbox = [x1, y1, x2, y2]
            yolo_conf = float(best_box.conf)
            yolo_label = yolo_model.names[int(best_box.cls[0].item())]
            roi_img = image_cv[y1:y2, x1:x2] if image_cv[y1:y2, x1:x2].size > 0 else image_cv

        # 3. PROSES ML (RADIOMICS)
        features_df = extract_features(roi_img)
        probs = safe_get_ml_probabilities(classifier_model, features_df)
        ml_class_idx = int(np.argmax(probs))
        ml_class_name = label_encoder.inverse_transform([ml_class_idx])[0]
        ml_confidence = float(probs[ml_class_idx])

        # 4. LOGIKA KEPUTUSAN FINAL
        if is_stroke_yolo and yolo_conf >= 0.3:
            final_class = yolo_label.replace("Stroke ", "") if ml_class_name == "Normal" else ml_class_name
            final_conf = round(max(yolo_conf, ml_confidence) * 100, 2)
            reason = f"Terdeteksi area stroke oleh YOLO ({yolo_label})."
        else:
            # Jika YOLO tidak yakin, gunakan prediksi ML sepenuhnya
            final_class = ml_class_name
            final_conf = round(ml_confidence * 100, 2)
            reason = "Hasil berdasarkan analisis tekstur ML (Radiomics)."

        # 5. VISUALISASI
        vis_image = image_cv.copy()
        if final_class != "Normal" and bbox:
            cv2.rectangle(vis_image, (bbox[0], bbox[1]), (bbox[2], bbox[3]), (0, 255, 0), 3)
            cv2.putText(vis_image, f"{final_class} {final_conf}%", (bbox[0], bbox[1]-10), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 255, 0), 2)

        _, buffer = cv2.imencode('.jpg', vis_image)
        image_base64 = base64.b64encode(buffer).decode('utf-8')

        return {
            "classification": final_class,
            "percentage": final_conf,
            "decision_note": reason,
            "image_with_box": image_base64
        }

    except Exception as e:
        logger.exception("Error during prediction")
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    port = int(os.environ.get("PORT", 8000))
    uvicorn.run(app, host="0.0.0.0", port=port)
