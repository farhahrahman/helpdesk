<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<!-- 1. Hero Section (Matching User Mockup Layout) -->
<section class="relative bg-white border-b border-slate-200/80 overflow-hidden min-h-[500px] lg:min-h-[560px] flex items-center">
    <!-- Desktop Background Hero Image with Left Alpha Gradient Mask -->
    <div class="hidden lg:block absolute right-0 top-0 bottom-0 w-7/12 xl:w-2/3 pointer-events-none select-none overflow-hidden">
        <img src="<?= asset('images/hero-counter.png') ?>" 
             alt="Kaunter Perkhidmatan BKP SUKJ" 
             class="h-full w-full object-cover object-right">
    </div>

    <!-- Soft Left White Gradient Mask to blend seamlessly behind text -->
    <div class="hidden lg:block absolute inset-y-0 left-0 w-1/2 bg-gradient-to-r from-white via-white/95 to-transparent pointer-events-none z-[1]"></div>

    <!-- Mobile/Tablet Subtle Background Overlay -->
    <div class="lg:hidden absolute inset-0 pointer-events-none select-none opacity-15">
        <img src="<?= asset('images/hero-counter.png') ?>" 
             alt="Kaunter Perkhidmatan BKP SUKJ" 
             class="h-full w-full object-cover object-right">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 relative z-10 w-full">
        <div class="max-w-xl lg:max-w-2xl space-y-6">
            <!-- Top Tagline Pill -->
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">
                    Satu Platform
                </span>
            </div>

            <!-- Main Headline (Matching Mockup) -->
            <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                Sokongan ICT<br>dan Perkhidmatan Aset<br><span class="text-amber-500">Lebih Mudah.</span>
            </h1>

            <!-- Description Paragraph (Matching Mockup) -->
            <p class="text-slate-600 text-xs sm:text-sm lg:text-base leading-relaxed font-normal max-w-xl">
                Permohonan, aduan dan sokongan teknikal ICT BKP termasuk perkhidmatan aset, media dan mesyuarat dalam satu platform yang ringkas dan tersusun.
            </p>

            <!-- Two Action Cards (Matching Mockup Side-by-Side) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 max-w-2xl">
                <!-- Card 1: Blue Card "Buat Permohonan Baru" -->
                <a href="<?= url('/tickets/create') ?>" 
                   class="group p-5 rounded-2xl bg-[#1d3d75] hover:bg-[#163060] text-white shadow-xl shadow-blue-950/15 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-between gap-4 border border-blue-900/40">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white shrink-0 group-hover:bg-white group-hover:text-blue-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-base text-white leading-tight">Buat Permohonan Baru</h3>
                            <p class="text-[11px] text-blue-100/80 mt-1 leading-snug">Hantar permohonan, aduan atau sokongan teknikal ICT.</p>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white shrink-0 group-hover:bg-white group-hover:text-blue-900 transition-all">
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </a>

                <!-- Card 2: White Card "Semak Status Permohonan" -->
                <a href="<?= url('/track') ?>" 
                   class="group p-5 rounded-2xl bg-white/95 backdrop-blur-sm border border-slate-200/90 hover:border-blue-300 text-slate-900 shadow-xl shadow-slate-900/5 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-base text-slate-900 leading-tight">Semak Status Permohonan</h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug">Lihat perkembangan tiket anda dengan cepat.</p>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 2. Section "PERKHIDMATAN UTAMA" (Matching User Mockup Grid) -->
<section id="perkhidmatan" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10 sm:mb-12">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400 block mb-2">
                    Perkhidmatan Utama
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Pilih Perkhidmatan<br class="hidden sm:inline"> Mengikut <span class="text-amber-500">Keperluan Anda.</span>
                </h2>
            </div>
            <p class="text-slate-500 text-xs sm:text-sm max-w-md font-medium leading-relaxed">
                Kami menyediakan pelbagai perkhidmatan sokongan ICT dan perkhidmatan aset bagi memastikan urusan kerja anda berjalan lancar.
            </p>
        </div>

        <!-- 4-Column Card Grid (Matching Mockup Numbering 2, 3, 4, 5) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Pinjaman Laptop (Mockup #2) -->
            <a href="<?= url('/tickets/create?category=PEMINJAMAN_ASET') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-laptop.jpg') ?>" 
                         alt="Pinjaman Laptop & Aset" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Pinjaman Laptop
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Permohonan pinjaman peralatan ICT seperti komputer riba.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 flex items-center justify-end">
                        <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-600 text-slate-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 2: Liputan Media (Mockup #3) -->
            <a href="<?= url('/tickets/create?category=MEDIA_JURUKAMERA') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-media.jpg') ?>" 
                         alt="Liputan Media Rasmi" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Liputan Media
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Permohonan penggambaran, video dan liputan program rasmi.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 flex items-center justify-end">
                        <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-600 text-slate-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 3: Sokongan Mesyuarat (Mockup #4) -->
            <a href="<?= url('/tickets/create?category=SOKONGAN_MESYUARAT') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-meeting.jpg') ?>" 
                         alt="Sokongan Mesyuarat" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Sokongan Mesyuarat
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Permohonan peralatan dan sokongan teknikal mesyuarat.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 flex items-center justify-end">
                        <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-600 text-slate-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 4: Khidmat Teknikal ICT (Mockup #5) -->
            <a href="<?= url('/tickets/create?category=LAIN_LAIN') ?>" 
               class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group block">
                <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-100">
                    <img src="<?= asset('images/service-technical.jpg') ?>" 
                         alt="Khidmat Teknikal ICT" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-4 w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition-colors">
                            Khidmat Teknikal ICT
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-normal">
                            Aduan, penyelenggaraan dan sokongan teknikal ICT.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 flex items-center justify-end">
                        <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-600 text-slate-600 group-hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- 3. Section "PANDUAN PERMOHONAN" (3 Steps) -->
<section id="panduan" class="py-16 sm:py-20 bg-slate-50/70 border-b border-slate-200/80">
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
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm relative">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-base flex items-center justify-center mb-4 shadow-md shadow-blue-600/20">
                    1
                </div>
                <h3 class="font-bold text-base text-slate-900 leading-snug">Pilih Servis & Lengkapkan Borang</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Pilih perkhidmatan yang diperlukan (laptop, bilik mesyuarat, liputan media), masukkan maklumat pemohon, tarikh penggunaan serta peranti yang dimohon.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm relative">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-base flex items-center justify-center mb-4 shadow-md shadow-blue-600/20">
                    2
                </div>
                <h3 class="font-bold text-base text-slate-900 leading-snug">Terima No. Rujukan Unik</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Sistem menjana No. Tiket rasmi (cth: <span class="font-mono font-bold text-slate-900">ICTBKP/2026/08/0001</span>) serta-merta tanpa perlu login atau kata laluan.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm relative">
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
<section id="faq" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
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
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Berapa hari sebelum program perlu hantar permohonan?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    Permohonan disyorkan dihantar sekurang-kurangnya <strong>3 hingga 5 hari bekerja</strong> sebelum tarikh penggunaan bagi membolehkan pihak ICT menyemak ketersediaan aset dan membuat konfigurasi teknikal.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Adakah pemohon perlu mendaftar akaun pengguna baru?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    <strong>Tidak perlu.</strong> Sistem Helpdesk ICT BKP direka bentuk untuk capaian mudah warga SUKJ tanpa login. Cukup sekadar memasukkan alamat emel rasmi <em>@johor.gov.my</em> semasa memohon.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-sm">
                <h4 class="font-bold text-sm text-slate-900 flex items-start gap-2.5">
                    <span class="text-blue-600 font-extrabold shrink-0">Q.</span>
                    <span>Bagaimanakah cara menyemak status permohonan saya?</span>
                </h4>
                <p class="text-xs text-slate-600 mt-2.5 pl-5 leading-relaxed font-normal">
                    Anda boleh memasukkan No. Tiket rujukan pada kotak <strong>'Semak Status Permohonan'</strong> di laman utama atau membuka halaman <a href="<?= url('/track') ?>" class="text-blue-600 underline font-semibold">Semak Status</a> pada bila-bila masa.
                </p>
            </div>

            <!-- FAQ 4 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-sm">
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
<section id="hubungi" class="py-16 sm:py-20 bg-slate-50/70">
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
