<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<!-- 1. Hero Section (Clean, Professional High-Fidelity UI) -->
<section class="relative bg-white border-b border-slate-200/80 overflow-hidden">
    <!-- Desktop Background Hero Image with Smooth Left Alpha Gradient Mask -->
    <div class="hidden lg:block absolute right-0 top-0 bottom-0 w-1/2 xl:w-7/12 pointer-events-none select-none overflow-hidden">
        <img src="<?= asset('images/hero-counter.png') ?>" 
             alt="Kaunter Perkhidmatan BKP SUKJ" 
             class="h-full w-full object-cover object-right">
    </div>

    <!-- Soft Gradient Mask for Ultra-Crisp Left Text Readability on all screens -->
    <div class="hidden lg:block absolute inset-y-0 left-0 w-3/5 bg-gradient-to-r from-white via-white/90 to-transparent pointer-events-none z-[1]"></div>

    <!-- Mobile/Tablet Subtle Background Overlay -->
    <div class="lg:hidden absolute inset-0 pointer-events-none select-none opacity-10">
        <img src="<?= asset('images/hero-counter.png') ?>" 
             alt="Kaunter Perkhidmatan BKP SUKJ" 
             class="h-full w-full object-cover object-center">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24 relative z-10">
        <div class="max-w-xl lg:max-w-2xl space-y-6">
            <!-- Top Tagline Pill -->
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50/90 border border-blue-200/80 text-blue-800 text-xs font-extrabold uppercase tracking-widest shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>Satu Platform</span>
                </div>
            </div>

            <!-- Main Headline -->
            <h1 class="text-3xl sm:text-5xl lg:text-[52px] font-black text-slate-900 tracking-tight leading-[1.12]">
                Sokongan ICT dan Perkhidmatan Aset <span class="text-amber-500">Lebih Mudah.</span>
            </h1>

            <!-- Description Paragraph -->
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-normal">
                Sistem bersepadu pengurusan permohonan peminjaman peralatan ICT, sokongan teknikal mesyuarat, dan liputan media rasmi Bahagian Khidmat Pengurusan tanpa perlu log masuk.
            </p>

            <!-- Two Prominent Action Cards Side-by-Side -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3">
                <!-- Card 1: Navy/Dark Blue "Buat Permohonan Baru" -->
                <a href="<?= url('/tickets/create') ?>" 
                   class="group p-5 rounded-2xl bg-[#0a1931] hover:bg-[#0f244a] text-white shadow-xl shadow-slate-900/10 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between border border-blue-900/40">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-300 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/80 group-hover:bg-white group-hover:text-[#0a1931] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-base text-white leading-tight">Buat Permohonan Baru</h3>
                        <p class="text-xs text-blue-200/80 mt-1.5 leading-relaxed font-normal">Peminjaman laptop, mesyuarat, media & khidmat teknikal</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-bold text-blue-300 group-hover:text-white">
                        <span>Buka Borang Permohonan</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </div>
                </a>

                <!-- Card 2: White Card with Border "Semak Status Permohonan" -->
                <div class="p-5 rounded-2xl bg-white border-2 border-slate-200/90 hover:border-blue-400 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <a href="<?= url('/track') ?>" class="text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                Halaman Semakan &rarr;
                            </a>
                        </div>
                        <h3 class="font-bold text-base text-slate-900 leading-tight">Semak Status Permohonan</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed font-normal">Kemas kini masa nyata menggunakan No. Tiket</p>
                    </div>
                    <form action="<?= url('/track') ?>" method="GET" class="mt-4 flex items-center gap-2">
                        <input type="text" name="ref" required 
                               placeholder="Cth: ICTBKP/2026/08/0001" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs font-mono font-bold text-slate-900 outline-none transition-all placeholder:text-slate-400">
                        <button type="submit" 
                                class="w-9 h-9 shrink-0 rounded-xl bg-slate-900 hover:bg-slate-800 active:bg-black text-white flex items-center justify-center shadow-sm transition-all"
                                title="Semak Sekarang">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Section "PERKHIDMATAN UTAMA" (4 Cards Grid with High-Resolution Photos) -->
<section id="perkhidmatan" class="py-16 sm:py-20 bg-slate-50/70 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10 sm:mb-12">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-blue-700 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Perkhidmatan Utama
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Pilih Perkhidmatan Mengikut Keperluan Anda.
                </h2>
            </div>
            <p class="text-slate-600 text-xs sm:text-sm max-w-md font-medium leading-relaxed">
                Pilih salah satu perkhidmatan di bawah untuk terus mengisi borang permohonan rasmi yang dikhaskan.
            </p>
        </div>

        <!-- 4-Column Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Pinjaman Laptop -->
            <a href="<?= url('/tickets/create?category=PEMINJAMAN_ASET') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-laptop.jpg') ?>" 
                         alt="Pinjaman Laptop & Aset" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-10 h-10 rounded-xl bg-white/95 backdrop-blur-sm shadow-md border border-slate-200/80 flex items-center justify-center text-xl">
                        💻
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Pinjaman Laptop
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Komputer riba Dell, tablet Lenovo, telefon pintar (iPhone 15) dan aksesori untuk kegunaan tugasan rasmi.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">Mohon Sekarang</span>
                        <span class="w-7 h-7 rounded-full bg-blue-50 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 2: Liputan Media -->
            <a href="<?= url('/tickets/create?category=MEDIA_JURUKAMERA') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-media.jpg') ?>" 
                         alt="Liputan Media Rasmi" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-10 h-10 rounded-xl bg-white/95 backdrop-blur-sm shadow-md border border-slate-200/80 flex items-center justify-center text-xl">
                        📹
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Liputan Media
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Khidmat jurugambar, juruvideo dan liputan audio-visual untuk majlis atau program rasmi jabatan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">Mohon Sekarang</span>
                        <span class="w-7 h-7 rounded-full bg-blue-50 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 3: Sokongan Mesyuarat -->
            <a href="<?= url('/tickets/create?category=SOKONGAN_MESYUARAT') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-meeting.jpg') ?>" 
                         alt="Sokongan Mesyuarat" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-10 h-10 rounded-xl bg-white/95 backdrop-blur-sm shadow-md border border-slate-200/80 flex items-center justify-center text-xl">
                        🌐
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Sokongan Mesyuarat
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Bantuan teknikal persidangan video dalam talian (Cisco Webex / Zoom / Teams) di bilik mesyuarat.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">Mohon Sekarang</span>
                        <span class="w-7 h-7 rounded-full bg-blue-50 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 4: Khidmat Teknikal ICT -->
            <a href="<?= url('/tickets/create?category=LAIN_LAIN') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-technical.jpg') ?>" 
                         alt="Khidmat Teknikal ICT" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-10 h-10 rounded-xl bg-white/95 backdrop-blur-sm shadow-md border border-slate-200/80 flex items-center justify-center text-xl">
                        🛠️
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Khidmat Teknikal ICT
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Penyelenggaraan komputer, siar raya, sokongan capaian rangkaian dan bantuan teknikal am.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">Mohon Sekarang</span>
                        <span class="w-7 h-7 rounded-full bg-blue-50 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- 3. Section "PANDUAN PERMOHONAN" (3 Steps) -->
<section id="panduan" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-blue-700 mb-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Aliran Kerja Ringkas
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Panduan Permohonan Mudah (3 Langkah)
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm mt-3 font-medium">
                Urusan pantas, telus dan teratur tanpa perlu mendaftar akaun baru.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-base flex items-center justify-center mb-4 shadow-md shadow-blue-600/20">
                    1
                </div>
                <h3 class="font-bold text-base text-slate-900 leading-snug">Pilih Servis & Lengkapkan Borang</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Pilih perkhidmatan yang diperlukan (laptop, bilik mesyuarat, liputan media), masukkan maklumat pemohon, tarikh penggunaan serta peranti yang dimohon.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-base flex items-center justify-center mb-4 shadow-md shadow-blue-600/20">
                    2
                </div>
                <h3 class="font-bold text-base text-slate-900 leading-snug">Terima No. Rujukan Unik</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Sistem menjana No. Tiket rasmi (cth: <span class="font-mono font-bold text-slate-900">ICTBKP/2026/08/0001</span>) serta-merta tanpa perlu login atau kata laluan.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-base flex items-center justify-center mb-4 shadow-md shadow-blue-600/20">
                    3
                </div>
                <h3 class="font-bold text-base text-slate-900 leading-snug">Semakan Status & Pengambilan</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Pantau keputusan kelulusan pada bila-bila masa, cetak slip permohonan rasmi dan hadir ke Kaunter ICT BKP bagi urusan pengambilan aset.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Section "SOALAN LAZIM (FAQ)" -->
<section id="faq" class="py-16 sm:py-20 bg-slate-50/70 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-blue-700 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                Soalan Lazim
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Kerap Ditanya (FAQ)
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm mt-3 font-medium">
                Maklumat penting bagi melancarkan urusan permohonan anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            <!-- FAQ 1 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Berapa hari sebelum program perlu hantar permohonan?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    Permohonan disyorkan dihantar sekurang-kurangnya <strong>3 hingga 5 hari bekerja</strong> sebelum tarikh penggunaan bagi membolehkan pihak ICT menyemak ketersediaan aset dan membuat konfigurasi teknikal.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Adakah pemohon perlu mendaftar akaun pengguna baru?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    <strong>Tidak perlu.</strong> Sistem Helpdesk ICT BKP direka bentuk untuk capaian mudah warga SUKJ tanpa login. Cukup sekadar memasukkan alamat emel rasmi <em>@johor.gov.my</em> semasa memohon.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Bagaimanakah cara menyemak status permohonan saya?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    Anda boleh memasukkan No. Tiket rujukan pada kotak <strong>'Semak Status Permohonan'</strong> di laman utama atau membuka halaman <a href="<?= url('/track') ?>" class="text-blue-600 underline font-semibold">Semak Status</a> pada bila-bila masa.
                </p>
            </div>

            <!-- FAQ 4 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Apakah yang perlu dibawa semasa mengambil peralatan?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    Sila bawa slip permohonan bercetak atau tunjukkan No. Tiket bersama kad staf di Kaunter Khidmat Pelanggan Seksyen ICT, Aras 1, Bangunan Dato' Jaafar Muhammad.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 5. Section "HUBUNGI KAMI" -->
<section id="hubungi" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-blue-200 text-xs font-bold uppercase tracking-wider">
                        <span>Kaunter Khidmat Pelanggan</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Seksyen ICT, Bahagian Khidmat Pengurusan
                    </h3>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl">
                        Sebarang pertanyaan atau bantuan teknikal kecemasan bagi urusan majlis dan mesyuarat, sila hubungi talian hotline kami atau hadir terus ke kaunter perkhidmatan.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center gap-4 text-xs font-semibold">
                        <div class="flex items-center gap-2 bg-white/10 px-4 py-2.5 rounded-xl border border-white/10">
                            <span class="text-amber-400 text-base">📍</span>
                            <span>Aras 1, Bangunan Dato' Jaafar Muhammad, Kota Iskandar</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 px-4 py-2.5 rounded-xl border border-white/10">
                            <span class="text-emerald-400 text-base">⏰</span>
                            <span>Ahad - Rabu (8:00 AM - 5:00 PM) | Khamis (8:00 AM - 3:30 PM)</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                    <a href="tel:0105528875" 
                       class="p-4 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 flex items-center gap-3.5 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-300 block font-medium">Talian Hotline ICT</span>
                            <span class="text-base font-black text-white font-mono">010-5528875</span>
                        </div>
                    </a>

                    <a href="mailto:farhah@johor.gov.my" 
                       class="p-4 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 flex items-center gap-3.5 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-300 block font-medium">Emel Rasmi Pegawai</span>
                            <span class="text-sm font-bold text-white font-mono">farhah@johor.gov.my</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
