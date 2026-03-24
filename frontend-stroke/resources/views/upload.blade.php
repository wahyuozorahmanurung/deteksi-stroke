<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis CT-Scan - StrokeScan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#0f172a',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .loader {
            border-top-color: #0ea5e9;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm border-b border-slate-200 py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-40">
        <a href="/" class="flex items-center gap-2 group">
            <i class="fa-solid fa-arrow-left text-slate-400 group-hover:text-primary transition"></i>
            <span class="font-bold text-xl text-slate-800">Stroke<span class="text-primary">Scan</span></span>
        </a>
        <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
            Deploy Wahyu
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-4xl grid grid-cols-1 {{ isset($result) ? 'md:grid-cols-2' : '' }} gap-8 transition-all duration-500">

            <div class="bg-white shadow-xl rounded-3xl p-8 border border-slate-100 h-fit">
                <div class="text-center mb-8">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3 text-primary">
                        <i class="fa-solid fa-upload text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Upload Citra CT-Scan</h1>
                    <p class="text-sm text-slate-500 mt-2">Format: JPG, PNG, DICOM (Max 5MB)</p>
                </div>

                <form action="{{ route('process.image') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    
                    <div class="relative group">
                        <label for="file-upload" id="dropzone" class="flex flex-col items-center justify-center w-full h-72 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-primary transition-all duration-300 overflow-hidden relative">
                            
                            <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3 group-hover:text-primary transition"></i>
                                <p class="mb-2 text-sm text-slate-500 px-4 text-center"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-[10px] text-slate-400 bg-slate-200/50 px-2 py-1 rounded">Mendukung .dcm, .jpg, .png</p>
                            </div>

                            <div id="preview-container" class="hidden absolute inset-0 w-full h-full bg-white flex flex-col items-center justify-center p-4 animate-fade-in">
                                <img id="image-preview" class="hidden w-full h-full object-contain rounded-lg shadow-sm" />
                                
                                <div id="dicom-preview" class="hidden flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-file-medical text-4xl text-primary"></i>
                                    </div>
                                    <p id="filename-text" class="text-sm font-semibold text-slate-700 truncate max-w-[250px] mb-1"></p>
                                    <span class="text-[10px] uppercase tracking-widest font-bold text-primary bg-blue-50 px-3 py-1 rounded-full border border-blue-100">Digital Imaging (DICOM)</span>
                                </div>

                                <div class="absolute inset-0 bg-primary/20 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                    <div class="bg-white px-4 py-2 rounded-full shadow-lg text-xs font-bold text-primary flex items-center gap-2">
                                        <i class="fa-solid fa-sync"></i> Ganti File
                                    </div>
                                </div>
                            </div>
                            
                            <input id="file-upload" name="image" type="file" class="hidden" accept=".jpg,.jpeg,.png,.dcm,.dicom,application/dicom" required onchange="handleFileSelect(event)" />
                        </label>
                    </div>

                    <button type="submit" class="mt-6 w-full bg-gradient-to-r from-blue-600 to-primary text-white font-bold py-4 px-4 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] transition-all duration-300 flex justify-center items-center gap-2 group">
                        <span>Analisis Sekarang</span>
                        <i class="fa-solid fa-wand-magic-sparkles group-hover:rotate-12 transition"></i>
                    </button>
                </form>
            </div>

            @if(isset($result))
            <div class="bg-white shadow-xl rounded-3xl p-8 border border-slate-100 flex flex-col h-full animate-fade-in">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                    <i class="fa-solid fa-microscope text-primary text-xl"></i>
                    <h2 class="text-xl font-bold text-slate-800">Hasil Pemindaian AI</h2>
                </div>

                @if(isset($result['image_with_box']))
                <div class="relative rounded-2xl overflow-hidden shadow-inner border border-slate-200 mb-6 bg-slate-900 aspect-square flex items-center justify-center">
                    <img src="data:image/jpeg;base64,{{ $result['image_with_box'] }}" alt="Hasil Deteksi" class="max-w-full max-h-full object-contain shadow-2xl">
                    <div class="absolute top-3 right-3">
                        <span class="bg-primary/90 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg">AI Vision v1.0</span>
                    </div>
                </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Diagnosa Otomatis</p>
                        @php
                            $isStroke = !str_contains(strtolower($result['classification'] ?? ''), 'normal');
                            $themeColor = $isStroke ? 'red' : 'green';
                        @endphp
                        <div class="flex items-center p-4 rounded-2xl border-2 border-{{ $themeColor }}-100 bg-{{ $themeColor }}-50/50">
                            <div class="w-10 h-10 rounded-xl bg-{{ $themeColor }}-100 flex items-center justify-center mr-4 text-{{ $themeColor }}-600">
                                <i class="fa-solid {{ $isStroke ? 'fa-triangle-exclamation' : 'fa-circle-check' }} text-lg"></i>
                            </div>
                            <span class="text-xl font-extrabold text-{{ $themeColor }}-700 capitalize tracking-tight">{{ $result['classification'] ?? 'Unknown' }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Confidence Level</p>
                            <span class="text-lg font-black text-slate-800">{{ $result['percentage'] ?? '0' }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-4 p-1 shadow-inner">
                            <div class="bg-primary h-2 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: 0%" id="progress-bar"></div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                        <i class="fa-solid fa-shield-medical text-primary mt-1"></i>
                        <p class="text-[10px] text-slate-500 leading-relaxed italic">
                            Sistem AI ini ditujukan sebagai alat bantu. Keputusan medis akhir harus dilakukan oleh tenaga profesional medis berlisensi.
                        </p>
                    </div>
                </div>
            </div>
            
            <script>
                setTimeout(() => {
                    document.getElementById('progress-bar').style.width = "{{ $result['percentage'] ?? 0 }}%";
                }, 400);
            </script>
            @endif

        </div>
    </main>

    <div id="loading-overlay" class="fixed inset-0 bg-white/95 backdrop-blur-xl z-50 hidden flex-col items-center justify-center text-center px-6">
        <div class="loader rounded-full border-4 border-slate-100 h-20 w-20 mb-6 shadow-xl"></div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Sedang Menganalisis...</h2>
        <p class="text-slate-500 text-sm mt-2 max-w-xs">Mengidentifikasi fitur radiomics dan memproses citra CT-Scan untuk hasil yang akurat.</p>
    </div>

    <script>
       function handleFileSelect(event) {
    const input = event.target;
    const placeholder = document.getElementById('upload-placeholder');
    const previewContainer = document.getElementById('preview-container');
    const dicomPreview = document.getElementById('dicom-preview');
    const filenameText = document.getElementById('filename-text');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        const fileExt = fileName.split('.').pop().toLowerCase();

        // Reset tampilan
        placeholder.classList.add('hidden');
        previewContainer.classList.remove('hidden');
        dicomPreview.classList.remove('hidden');

        filenameText.textContent = fileName;

        const label = dicomPreview.querySelector('span');

        // Tentukan label berdasarkan tipe file
        if (['dcm', 'dicom'].includes(fileExt) || file.type === 'application/dicom') {
            label.textContent = 'DIGITAL IMAGING (DICOM)';
            label.className =
                'text-[10px] uppercase tracking-widest font-bold text-primary bg-blue-50 px-3 py-1 rounded-full border border-blue-100';
        } else if (['jpg', 'jpeg', 'png'].includes(fileExt)) {
            label.textContent = 'IMAGE FILE';
            label.className =
                'text-[10px] uppercase tracking-widest font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100';
        } else {
            label.textContent = 'UNKNOWN FILE';
            label.className =
                'text-[10px] uppercase tracking-widest font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200';
        }
    }
}

        document.getElementById('uploadForm').addEventListener('submit', function() {
            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('loading-overlay').classList.add('flex');
        });
    </script>
</body>
</html>