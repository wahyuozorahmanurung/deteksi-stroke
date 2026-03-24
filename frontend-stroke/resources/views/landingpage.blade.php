<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StrokeScan - Deteksi Dini Stroke AI</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0ea5e9',   /* Sky Blue */
                        secondary: '#0f172a', /* Dark Blue/Slate */
                        accent: '#fbbf24',    /* Amber/Yellow */
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Styles */
        body { font-family: 'Poppins', sans-serif; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .nav-glass {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 overflow-x-hidden">

    <nav class="w-full px-6 md:px-12 py-4 flex justify-between items-center fixed top-0 w-full z-50 nav-glass text-white shadow-lg transition-all duration-300">
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 class="text-2xl font-bold tracking-wide">Stroke<span class="text-primary">Scan</span></h1>
        </div>
        <ul class="hidden md:flex space-x-8 font-medium text-sm tracking-wide">
            <li><a href="#welcome" class="hover:text-primary transition duration-300">Beranda</a></li>
            <li><a href="#informasi" class="hover:text-primary transition duration-300">Edukasi</a></li>
            <li><a href="#cek" class="px-5 py-2 bg-primary rounded-full hover:bg-sky-600 transition shadow-md">Cek Sekarang</a></li>
        </ul>
        <button class="md:hidden text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg></button>
    </nav>

    <section id="welcome" class="relative min-h-screen flex items-center pt-20 overflow-hidden bg-secondary text-white">
        <div class="absolute top-0 right-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary rounded-full blur-3xl filter"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600 rounded-full blur-3xl filter"></div>
        </div>

        <div class="container mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-2 gap-10 items-center relative z-10">
            <div data-aos="fade-right">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-900 text-blue-300 text-xs font-bold mb-4 border border-blue-700">AI HEALTH TECHNOLOGY</span>
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                    Deteksi Dini Stroke <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-600">Lebih Cepat & Akurat</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 mb-8 max-w-lg leading-relaxed">
                    Bantu analisis hasil CT-Scan dengan kecerdasan buatan. Kenali jenis stroke dalam hitungan detik untuk penanganan yang tepat.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#cek" class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-sky-600 transition shadow-lg shadow-sky-500/30 text-center">
                        Mulai Analisis
                    </a>
                    <a href="#informasi" class="px-8 py-4 bg-transparent border border-slate-600 text-slate-300 font-semibold rounded-xl hover:bg-slate-800 transition text-center">
                        Pelajari Dulu
                    </a>
                </div>
            </div>

            <div class="flex justify-center" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1559757175-5700dde675bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Brain Scan Illustration" 
                     class="w-full max-w-md md:max-w-lg rounded-3xl shadow-2xl border-4 border-slate-700/50 hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    <section id="informasi" class="py-24 bg-slate-50 relative">
        <div class="container mx-auto px-6 md:px-12">
            
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-sm font-bold text-primary tracking-widest uppercase mb-2">Edukasi Kesehatan</h2>
                <h3 class="text-4xl font-extrabold text-slate-900">Mengenal Jenis Stroke</h3>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Stroke adalah kondisi darurat medis. Mengetahui perbedaannya dapat menyelamatkan nyawa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-100 card-hover transition duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="100">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-blue-900/10"></div>
                        <img 
            src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1663136389/attached_image/stroke-iskemik-0-alodokter.jpg" 
            onerror="this.src='https://placehold.co/600x400/e2e8f0/1e293b?text=Stroke+Iskemik'" 
            class="w-full h-full object-contain p-2" 
            alt="Stroke Iskemik">
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h4 class="text-2xl font-bold text-slate-800 mb-2">Stroke Iskemik</h4>
                        <span class="text-xs font-semibold text-white bg-red-500 px-2 py-1 rounded w-fit mb-4">Paling Umum (80%)</span>
                        <p class="text-slate-600 mb-6 text-sm leading-relaxed">
                            Terjadi ketika pembuluh darah arteri ke otak <strong>tersumbat</strong> (bekuan darah/plak). Otak kekurangan oksigen sehingga sel-sel mulai mati.
                        </p>
                        <div class="mt-auto bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Penanganan Utama:</p>
                            <ul class="text-sm text-slate-700 space-y-1">
                                <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Obat pemecah gumpalan (tPA)</li>
                                <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Trombektomi mekanis</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-100 card-hover transition duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="200">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-red-900/10"></div>
                        <img src="https://img.freepik.com/free-vector/human-with-hemorrhagic-stroke_1308-112710.jpg?t=st=1770823407~exp=1770827007~hmac=878127b0a045c90b123ffc512ff643c0e3865709c792961a313f728f00a36158&w=2000" onerror="this.src='https://placehold.co/600x400/ffe4e6/991b1b?text=Stroke+Hemoragik'"  class="w-full h-full object-contain p-2" alt="Stroke Hemoragik">
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h4 class="text-2xl font-bold text-slate-800 mb-2">Stroke Hemoragik</h4>
                        <span class="text-xs font-semibold text-white bg-orange-600 px-2 py-1 rounded w-fit mb-4">Sangat Berbahaya</span>
                        <p class="text-slate-600 mb-6 text-sm leading-relaxed">
                            Terjadi ketika pembuluh darah di otak <strong>pecah</strong> atau bocor. Darah menekan sel-sel otak. Sering disebabkan oleh Hipertensi yang tidak terkontrol.
                        </p>
                        <div class="mt-auto bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Penanganan Utama:</p>
                            <ul class="text-sm text-slate-700 space-y-1">
                                <li class="flex items-center"><span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>Kontrol tekanan darah segera</li>
                                <li class="flex items-center"><span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>Operasi bedah saraf (jika perlu)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-100 card-hover transition duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="300">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-yellow-900/10"></div>
                         <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqUnmc3pgxubcOqy5boeT7JS5cwPdk6v_K_w&s" onerror="this.src='https://placehold.co/600x400/fef3c7/92400e?text=TIA+(Mini+Stroke)'" class="w-full h-full object-contain p-2" alt="TIA">
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h4 class="text-2xl font-bold text-slate-800 mb-2">TIA (Mini Stroke)</h4>
                        <span class="text-xs font-semibold text-white bg-yellow-500 px-2 py-1 rounded w-fit mb-4">Tanda Peringatan</span>
                        <p class="text-slate-600 mb-6 text-sm leading-relaxed">
                            <em>Transient Ischemic Attack</em>. Aliran darah terganggu <strong>sementara</strong> (kurang dari 5 menit). Tidak menyebabkan kerusakan permanen, tapi tanda stroke besar akan datang.
                        </p>
                        <div class="mt-auto bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Penanganan Utama:</p>
                            <ul class="text-sm text-slate-700 space-y-1">
                                <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>Evaluasi medis segera</li>
                                <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>Perubahan gaya hidup & Obat</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="cek" class="relative py-24 bg-gradient-to-br from-blue-900 to-slate-900 text-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30">
            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="#0ea5e9" fill-opacity="0.3" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <div data-aos="zoom-in">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6">Sudah Punya Hasil CT-Scan?</h2>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto mb-12">
                    Unggah file CT-Scan (DICOM/JPG) Anda sekarang. Sistem ini akan membantu menganalisis indikasi stroke dengan cepat.
                </p>

                <div class="bg-white/10 backdrop-blur-md p-10 rounded-3xl max-w-3xl mx-auto border border-white/20 shadow-2xl">
                    <div class="border-2 border-dashed border-slate-400 rounded-xl p-10 flex flex-col items-center justify-center hover:bg-white/5 transition cursor-pointer group">
                        <div class="bg-blue-600 p-4 rounded-full mb-4 group-hover:scale-110 transition duration-300 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Upload File Disini</h3>
                        <p class="text-slate-300 text-sm">Drag & drop file Anda atau klik untuk menjelajah</p>
                        
                        <a href="/upload" class="mt-8 px-10 py-3 bg-accent text-slate-900 font-bold rounded-lg shadow-lg hover:bg-yellow-300 transition transform hover:-translate-y-1">
                            Pilih File CT-Scan
                        </a>
                    </div>
                    <p class="mt-4 text-xs text-slate-400">*Data Anda dienkripsi dan aman. Hanya digunakan untuk proses analisis.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h3 class="text-2xl font-bold text-white mb-2">StrokeScan AI</h3>
                <p class="text-sm max-w-xs">Teknologi kesehatan masa depan untuk deteksi dini dan penanganan yang lebih baik.</p>
            </div>
            
            <div class="flex space-x-6 text-sm font-semibold">
                <a href="#" class="hover:text-primary transition"></a>
                <a href="#" class="hover:text-primary transition"></a>
                <a href="#" class="hover:text-primary transition"></a>
            </div>
        </div>
        <div class="text-center mt-10 text-xs text-slate-600">
            &copy; 2025 StrokeScan Team. All Rights Reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ 
            duration: 800, 
            easing: 'ease-out-cubic',
            once: true 
        });
    </script>
</body>
</html>