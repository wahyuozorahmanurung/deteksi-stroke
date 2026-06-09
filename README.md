# api-sistem-deteksi-stroke

# 🧠 Comparative Analysis of Machine Learning for Stroke Classification Using YOLOv11 and Radiomics-Based Two-Stage Framework

![Python](https://img.shields.io/badge/Python-3.10-blue)
![YOLOv11](https://img.shields.io/badge/YOLOv11-Ultralytics-green)
![PyTorch](https://img.shields.io/badge/PyTorch-Deep%20Learning-red)
![Radiomics](https://img.shields.io/badge/Radiomics-Medical%20Imaging-orange)
![Status](https://img.shields.io/badge/Status-Research-success)

---

## 📖 Overview

Stroke is one of the leading causes of death and long-term disability worldwide. Accurate diagnosis from medical imaging is essential for determining appropriate treatment strategies and improving patient outcomes.

This research proposes a **Two-Stage Stroke Classification Framework** that combines:

1. **YOLOv11** for lesion detection and localization.
2. **Radiomics Feature Extraction** for quantitative imaging analysis.
3. **Machine Learning Classification** for stroke prediction.

The study evaluates whether radiomics-based machine learning models can outperform conventional end-to-end detection approaches while providing better interpretability for clinical decision support.

---

## 🎯 Research Objectives

* Detect stroke lesions using YOLOv11.
* Extract quantitative radiomic features from lesion regions.
* Compare multiple machine learning algorithms.
* Evaluate the effectiveness of radiomics in stroke classification.
* Develop an interpretable AI-assisted diagnostic workflow.

---

## 🏥 Dataset

| Attribute          | Description                       |
| ------------------ | --------------------------------- |
| Imaging Modality   | CT Scan / MRI                     |
| Task               | Stroke Detection & Classification |
| Annotation         | Bounding Boxes                    |
| Feature Extraction | Radiomics                         |
| Output             | Stroke Classification             |



---

## ⚙️ Proposed Framework

### Stage 1 — Stroke Lesion Detection

YOLOv11 is used to automatically detect and localize stroke lesions from medical images.

### Stage 2 — Radiomics-Based Classification

Detected lesion regions are converted into quantitative radiomic features and classified using machine learning models.

### Pipeline

```text
Medical Images
       │
       ▼
 Image Preprocessing
       │
       ▼
 YOLOv11 Detection
       │
       ▼
 ROI Extraction
       │
       ▼
 Radiomic Feature Extraction
       │
       ▼
 Feature Selection
       │
       ▼
 Machine Learning Classification
       │
       ▼
 Stroke Prediction
```

---

## 🔬 Radiomic Features

The extracted features include:

* First-Order Statistics
* Texture Features

---

## 🤖 Machine Learning Models

The following classifiers were evaluated:

| Model                        |
| ---------------------------- |
| Random Forest                |
| Support Vector Machine (SVM) |
| Naive Bayes    |

---



## 🚀 Installation

```bash
git clone https://github.com/your-username/stroke-classification.git

cd stroke-classification

pip install -r requirements.txt
```


---

## 📈 Evaluation Metrics

### Detection Metrics

* Precision
* Recall
* mAP@50
* mAP@50-95

### Classification Metrics

* Accuracy
* Precision
* Recall
* F1-Score
* ROC-AUC
* FPR
* Empirical Risk (ER)
* Generalization Gap (GG)
* Learning curves of three Models
* Robustness Analysis
* Cross-Validation Stability 


## 💡 Key Findings

* YOLOv11 effectively localizes stroke lesions.
* Radiomic features enhance classification performance.
* Two-stage classification improves interpretability.
* Machine learning models provide strong diagnostic support for medical image analysis.

---

## 🔮 Future Work

* Explainable AI (XAI)
* Deep Radiomics Integration
* Multi-Class Stroke Classification
* Multi-Center Dataset Validation
* Clinical Decision Support Integration
* Web-Based Deployment

---

## 📚 Research Contribution

This research demonstrates the integration of object detection, radiomics, and machine learning for stroke classification. The proposed framework improves model interpretability while maintaining strong predictive performance, making it suitable for future clinical decision-support applications.
This research has also been published in the scientific article SINTA 3
---

## 👨‍💻 Author

**Wahyu**

Final-Year Informatics Student — University of Bengkulu

**Research Interests**

* Artificial Intelligence
* Data Science
* Machine Learning
* Computer Vision
* Medical Imaging
* Healthcare AI

---

## 📄 License

This project is intended for academic, research, and educational purposes.
