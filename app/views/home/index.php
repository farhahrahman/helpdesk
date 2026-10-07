<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<!-- Single Viewport Main Container (Fits in 1 Screen on Desktop) -->
<div class="flex-1 flex flex-col justify-center relative overflow-hidden bg-white">
    <!-- Desktop Background Accent Image with Mask -->
    <div class="hidden lg:block absolute right-0 top-0 bottom-0 w-1/2 pointer-events-none select-none overflow-hidden opacity-[0.07]">
        <img src="<?= asset('images/hero-counter.png') ?>" alt="BKP SUKJ" class="h-full w-full object-cover object-right">
    </div>
    <div class="hidden lg:block absolute inset-y-0 right-1/3 w-32 bg-gradient-to-r from-white to-transparent pointer-events-none z-[1]"></div>

    <!-- Main Content Area -->
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-3 xl:py-6 flex-1 flex flex-col justify-center relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 xl:gap-8 items-center">
            
            <!-- Left Column: Headline, Actions & Instant Ticket Tracker (7 Cols) -->
            <div class="lg:col-span-7 space-y-3.5 xl:space-y-4">
                
                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/80 text-[11px] font-extrabold text-[#1d3d75] shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>PORTAL SEHENTI &bull; SEKSYEN ICT BKP</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-2xl sm:text-4xl lg:text-3xl xl:text-4xl 2xl:text-5xl font-black text-slate-900 tracking-tight leading-[1.16]">
                    Sokongan ICT &amp; Perkhidmatan Aset<br>
                    <span class="text-amber-500">Lebih Mudah &amp; Teratur.</span>
                </h1>

                <!-- Subtitle Description -->
                <p class="text-slate-600 text-xs sm:text-sm lg:text-[12.5px] xl:text-sm leading-relaxed max-w-xl">
                    Permohonan pinjaman aset, liputan media rasmi, sokongan teknikal mesyuarat dan aduan ICT Bahagian Khidmat Pengurusan dalam satu platform pantas tanpa perlu login.
                </p>

                <!-- Dual Action Cards (Side-by-side) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 max-w-xl">
                    
                    <!-- Card 1: Buat Permohonan Baru (Royal Blue Card) -->
                    <a href="<?= url('/tickets/create') ?>" 
                       class="group p-4 rounded-2xl bg-[#1d3d75] hover:bg-[#163060] text-white shadow-lg shadow-blue-950/10 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between border border-blue-900/40">
                        <div class="flex items-center justify-between mb-2.5">
                            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:bg-white group-hover:text-blue-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center text-white group-hover:bg-white group-hover:text-blue-900 transition-all">
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm sm:text-base text-white leading-tight">Buat Permohonan Baru</h3>
                            <p class="text-[11px] text-blue-100/80 mt-1 leading-snug">Mohon laptop, media, mesyuarat atau aduan ICT segera.</p>
                        </div>
                    </a>

                    <!-- Card 2: Semak Status Tiket Pantas (Live Input Box) -->
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-md flex flex-col justify-between hover:border-blue-300 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight">Semak Status Tiket</h3>
                                    <p class="text-[10px] text-slate-400">Jejak permohonan semasa</p>
                                </div>
                            </div>
                        </div>
                        <form action="<?= url('/track') ?>" method="GET" class="mt-1 flex items-center gap-1.5">
                            <input type="text" name="ref" required placeholder="No. Tiket (cth: 0002)" 
                                   class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 outline-none focus:bg-white focus:border-blue-500 transition-all">
                            <button type="submit" class="px-3.5 py-1.5 bg-slate-900 hover:bg-[#1d3d75] text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0">
                                Cari
                            </button>
                        </form>
                    </div>

                </div>

            </div>

            <!-- Right Column: 4 Core Services Grid 2x2 (5 Cols) -->
            <div class="lg:col-span-5 space-y-2.5">
                <div class="flex items-center justify-between px-1">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">
                        Perkhidmatan Utama
                    </span>
                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">
                        Pilih &amp; Mohon
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2.5 xl:gap-3">
                    
                    <!-- Service 1: Pinjaman Laptop & Aset -->
                    <a href="<?= url('/tickets/create?category=PEMINJAMAN_ASET') ?>" 
                       class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">
                        <div class="relative h-20 sm:h-24 lg:h-20 xl:h-24 overflow-hidden bg-slate-100">
                            <img src="<?= asset('images/service-laptop.jpg') ?>" alt="Pinjaman Laptop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent"></div>
                            <span class="absolute bottom-2 left-2.5 text-white font-extrabold text-xs leading-tight drop-shadow-sm">Pinjaman Laptop</span>
                        </div>
                        <div class="p-2 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="truncate text-[10.5px]">Komputer &amp; Perkakasan</span>
                            <span class="w-4 h-4 rounded-full bg-slate-100 group-hover:bg-[#1d3d75] group-hover:text-white flex items-center justify-center text-[9px] text-slate-700 shrink-0 transition-colors">&rarr;</span>
                        </div>
                    </a>

                    <!-- Service 2: Liputan Media -->
                    <a href="<?= url('/tickets/create?category=MEDIA_JURUKAMERA') ?>" 
                       class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">
                        <div class="relative h-20 sm:h-24 lg:h-20 xl:h-24 overflow-hidden bg-slate-100">
                            <img src="<?= asset('images/service-media.jpg') ?>" alt="Liputan Media" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent"></div>
                            <span class="absolute bottom-2 left-2.5 text-white font-extrabold text-xs leading-tight drop-shadow-sm">Liputan Media</span>
                        </div>
                        <div class="p-2 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="truncate text-[10.5px]">Fotografi &amp; Rakaman</span>
                            <span class="w-4 h-4 rounded-full bg-slate-100 group-hover:bg-[#1d3d75] group-hover:text-white flex items-center justify-center text-[9px] text-slate-700 shrink-0 transition-colors">&rarr;</span>
                        </div>
                    </a>

                    <!-- Service 3: Sokongan Mesyuarat -->
                    <a href="<?= url('/tickets/create?category=SOKONGAN_MESYUARAT') ?>" 
                       class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">
                        <div class="relative h-20 sm:h-24 lg:h-20 xl:h-24 overflow-hidden bg-slate-100">
                            <img src="<?= asset('images/service-meeting.jpg') ?>" alt="Sokongan Mesyuarat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent"></div>
                            <span class="absolute bottom-2 left-2.5 text-white font-extrabold text-xs leading-tight drop-shadow-sm">Sokongan Mesyuarat</span>
                        </div>
                        <div class="p-2 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="truncate text-[10.5px]">Peralatan &amp; Online</span>
                            <span class="w-4 h-4 rounded-full bg-slate-100 group-hover:bg-[#1d3d75] group-hover:text-white flex items-center justify-center text-[9px] text-slate-700 shrink-0 transition-colors">&rarr;</span>
                        </div>
                    </a>

                    <!-- Service 4: Khidmat Teknikal ICT -->
                    <a href="<?= url('/tickets/create?category=LAIN_LAIN') ?>" 
                       class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">
                        <div class="relative h-20 sm:h-24 lg:h-20 xl:h-24 overflow-hidden bg-slate-100">
                            <img src="<?= asset('images/service-technical.jpg') ?>" alt="Khidmat Teknikal ICT" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent"></div>
                            <span class="absolute bottom-2 left-2.5 text-white font-extrabold text-xs leading-tight drop-shadow-sm">Khidmat Teknikal</span>
                        </div>
                        <div class="p-2 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="truncate text-[10.5px]">Aduan &amp; Sistem</span>
                            <span class="w-4 h-4 rounded-full bg-slate-100 group-hover:bg-[#1d3d75] group-hover:text-white flex items-center justify-center text-[9px] text-slate-700 shrink-0 transition-colors">&rarr;</span>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 1: SOALAN LAZIM (FAQ)
     ========================================================================= -->
<div id="faq-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-[#1d3d75] text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-amber-300 font-bold">
                    ?
                </div>
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base leading-tight">Soalan Lazim (FAQ)</h3>
                    <p class="text-[11px] text-blue-200">Panduan dan maklumat pantas permohonan ICT BKP</p>
                </div>
            </div>
            <button type="button" onclick="closeFaqModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Modal Body (Scrollable inside modal only) -->
        <div class="p-6 overflow-y-auto space-y-3.5 text-xs">
            <!-- FAQ 1 -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <h4 class="font-bold text-slate-900 text-xs sm:text-sm flex items-start gap-2">
                    <span class="text-blue-600 font-black">Q1.</span>
                    <span>Berapa hari sebelum program perlu hantar permohonan?</span>
                </h4>
                <p class="text-slate-600 mt-2 pl-5 leading-relaxed text-[11.5px]">
                    Permohonan disyorkan dihantar sekurang-kurangnya <strong>3 hingga 5 hari bekerja</strong> sebelum tarikh penggunaan bagi membolehkan pihak ICT menyemak ketersediaan aset dan membuat konfigurasi teknikal.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <h4 class="font-bold text-slate-900 text-xs sm:text-sm flex items-start gap-2">
                    <span class="text-blue-600 font-black">Q2.</span>
                    <span>Adakah pemohon perlu mendaftar akaun pengguna baru?</span>
                </h4>
                <p class="text-slate-600 mt-2 pl-5 leading-relaxed text-[11.5px]">
                    <strong>Tidak perlu.</strong> Sistem Helpdesk ICT BKP direka bentuk untuk capaian mudah warga SUKJ tanpa login. Cukup sekadar memasukkan alamat emel rasmi <em>@johor.gov.my</em> semasa memohon.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <h4 class="font-bold text-slate-900 text-xs sm:text-sm flex items-start gap-2">
                    <span class="text-blue-600 font-black">Q3.</span>
                    <span>Bagaimanakah cara menyemak status permohonan saya?</span>
                </h4>
                <p class="text-slate-600 mt-2 pl-5 leading-relaxed text-[11.5px]">
                    Anda boleh memasukkan No. Tiket rujukan pada kotak <strong>'Semak Status Tiket'</strong> di muka depan atau membuka halaman Semak Status pada bila-bila masa.
                </p>
            </div>

            <!-- FAQ 4 -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <h4 class="font-bold text-slate-900 text-xs sm:text-sm flex items-start gap-2">
                    <span class="text-blue-600 font-black">Q4.</span>
                    <span>Apakah yang perlu dibawa semasa mengambil peralatan?</span>
                </h4>
                <p class="text-slate-600 mt-2 pl-5 leading-relaxed text-[11.5px]">
                    Sila bawa slip permohonan bercetak atau tunjukkan No. Tiket bersama kad staf di Kaunter Khidmat Pelanggan Seksyen ICT, Aras 1, Bangunan Dato' Jaafar Muhammad.
                </p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-end shrink-0">
            <button type="button" onclick="closeFaqModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-colors cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 2: HUBUNGI KAMI
     ========================================================================= -->
<div id="hubungi-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-[#1d3d75] text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-emerald-300 font-bold">
                    📞
                </div>
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base leading-tight">Hubungi Seksyen ICT</h3>
                    <p class="text-[11px] text-blue-200">Bahagian Khidmat Pengurusan &bull; Pejabat SUKJ</p>
                </div>
            </div>
            <button type="button" onclick="closeHubungiModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto space-y-3.5 text-xs">
            <!-- Lokasi Pejabat -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                <span class="text-xl">📍</span>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs">Lokasi Kaunter</h4>
                    <p class="text-slate-600 text-[11.5px] mt-0.5 leading-relaxed">
                        Seksyen ICT, Bahagian Khidmat Pengurusan,<br>
                        Aras 1, Bangunan Dato' Jaafar Muhammad, Pusat Pentadbiran Kerajaan Negeri Johor, Kota Iskandar, 79000 Iskandar Puteri, Johor.
                    </p>
                </div>
            </div>

            <!-- Waktu Operasi -->
            <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 flex items-start gap-3 text-amber-950">
                <span class="text-xl">⏰</span>
                <div>
                    <h4 class="font-bold text-amber-900 text-xs">Waktu Operasi Rasmi</h4>
                    <p class="text-slate-800 text-[11.5px] mt-0.5 font-semibold">Isnin – Khamis : 8:00 Pagi – 5:00 Petang</p>
                    <p class="text-slate-800 text-[11.5px] font-semibold">Jumaat : 8:00 Pagi – 12:30 Tgh Hari | 2:45 Ptg – 5:00 Petang</p>
                    <p class="text-amber-800 text-[10.5px] mt-0.5">Sabtu &amp; Ahad : Cuti Hujung Minggu Negeri Johor</p>
                </div>
            </div>

            <!-- Talian & Emel -->
            <div class="grid grid-cols-2 gap-3">
                <a href="tel:0105528875" class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col justify-between hover:bg-emerald-100/70 transition-colors">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase">Talian Hotline</span>
                        <div class="font-mono font-black text-sm text-emerald-950 mt-0.5">010-5528875</div>
                    </div>
                    <span class="text-[10.5px] text-emerald-700 font-semibold mt-2">Panggilan / WhatsApp &rarr;</span>
                </a>

                <a href="mailto:farhah@johor.gov.my" class="p-3.5 rounded-2xl bg-blue-50 border border-blue-200 flex flex-col justify-between hover:bg-blue-100/70 transition-colors">
                    <div>
                        <span class="text-[10px] font-bold text-blue-800 uppercase">Emel Rasmi</span>
                        <div class="font-mono font-bold text-xs text-blue-950 mt-0.5 truncate" title="farhah@johor.gov.my">farhah@johor.gov.my</div>
                    </div>
                    <span class="text-[10.5px] text-blue-700 font-semibold mt-2">Hantar Emel &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-end shrink-0">
            <button type="button" onclick="closeHubungiModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-colors cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openFaqModal() {
    const m = document.getElementById('faq-modal');
    if (m) m.classList.remove('hidden');
}
function closeFaqModal() {
    const m = document.getElementById('faq-modal');
    if (m) m.classList.add('hidden');
}
function openHubungiModal() {
    const m = document.getElementById('hubungi-modal');
    if (m) m.classList.remove('hidden');
}
function closeHubungiModal() {
    const m = document.getElementById('hubungi-modal');
    if (m) m.classList.add('hidden');
}

// Close on backdrop click
window.addEventListener('click', function(e) {
    const faq = document.getElementById('faq-modal');
    const hubungi = document.getElementById('hubungi-modal');
    if (e.target === faq) closeFaqModal();
    if (e.target === hubungi) closeHubungiModal();
});

// Auto open modal if URL has ?modal=
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('modal') === 'faq') openFaqModal();
    if (params.get('modal') === 'hubungi') openHubungiModal();
});
</script>
