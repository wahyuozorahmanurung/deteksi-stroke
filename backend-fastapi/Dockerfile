# Gunakan image Python yang ringan
FROM python:3.10-slim

# Install library sistem yang dibutuhkan oleh OpenCV, SimpleITK, dan Radiomics
RUN apt-get update && apt-get install -y \
    libgl1-mesa-glx \
    libglib2.0-0 \
    libxcb1 \
    libx11-6 \
    git \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy requirements dan install
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy seluruh kode aplikasi
COPY . .

# Jalankan aplikasi (Sesuaikan jika nama file Anda 'main.py')
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]
