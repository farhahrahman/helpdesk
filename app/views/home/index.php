<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<div class="space-y-14 py-8">
    <!-- Hero Banner Section (Modern Corporate Blue Gradient) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 border border-blue-800/40 p-8 sm:p-12 lg:p-16 shadow-xl text-white">
            <!-- Subtle Ambient Light -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    Portal Rasmi Khidmat Sokongan & Aset ICT
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                    Permohonan Mesyuarat, Peralatan ICT & Khidmat Media BKP
                </h1>

                <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                    Sistem pengurusan permohonan berpusat untuk urusan peminjaman Laptop Dell, iPhone 15, Lenovo Tab, Kamera DSLR, sokongan teknikal mesyuarat dalam talian (Cisco Webex/Zoom/Teams), dan khidmat jurugambar rasmi bagi 6 Unit BKP serta Pejabat TSUK Pengurusan.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="<?= url('/tickets/create') ?>" 
                       class="px-6 py-3.5 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>+ Buat Permohonan Baru</span>
                    </a>
                    <a href="#semak-status" 
                       class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm rounded-xl backdrop-blur-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span>Semak Status No. Tiket</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Status Tracker Search Bar Section -->
    <section id="semak-status" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-10 shadow-lg">
            <div class="max-w-3xl mx-auto text-center space-y-3 mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold uppercase tracking-wider border border-amber-200">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Semakan Status Permohonan Pantas
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Semak Status Menggunakan No. Tiket Permohonan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Masukkan No. Rujukan Tiket anda (contoh: <strong class="text-slate-800 font-mono font-bold">ICTBKP/2026/08/0001</strong> atau <strong class="text-slate-800 font-mono font-bold">0001</strong>) untuk melihat kemajuan kelulusan dan memuat turun slip rasmi.
                </p>
            </div>

            <form action="<?= url('/track') ?>" method="GET" class="max-w-2xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-2.5 bg-slate-50 p-2 rounded-2xl border border-slate-300 shadow-inner">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="ref" required 
                               placeholder="Cth: ICTBKP/2026/08/0001 atau 0001" 
                               class="w-full pl-11 pr-4 py-3 bg-transparent text-slate-900 placeholder-slate-400 font-mono font-bold text-xs sm:text-sm outline-none">
                    </div>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Semak Status</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
