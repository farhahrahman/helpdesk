<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 py-3 sm:py-6 my-auto">
    <!-- Single-Page Unified Corporate Card (No Scroll, Clean & Modern) -->
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 border border-blue-800/40 p-5 sm:p-8 lg:p-10 shadow-2xl text-white">
        <!-- Ambient Subtle Background Glow -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-4 sm:space-y-6">
            <!-- Top Tag -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                Portal Rasmi Khidmat Sokongan ICT & Aset BKP
            </div>

            <!-- Main Heading & Brief Subtitle -->
            <div class="space-y-2">
                <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    Permohonan Mesyuarat, Peralatan ICT & Khidmat Media BKP
                </h1>
                <p class="text-blue-100/90 text-xs sm:text-sm leading-relaxed max-w-3xl">
                    Sistem pengurusan permohonan peminjaman aset (Laptop Dell, iPhone 15, Lenovo Tab, Kamera DSLR), sokongan teknikal mesyuarat (Cisco Webex / Zoom / Teams), dan liputan media rasmi Bahagian Khidmat Pengurusan.
                </p>
            </div>

            <!-- Primary Action Buttons & Status Tracker Row -->
            <div class="pt-1 sm:pt-2 space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="<?= url('/tickets/create') ?>" 
                       class="px-5 py-2.5 sm:px-6 sm:py-3 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>+ Buat Permohonan Baru</span>
                    </a>

                    <?php if (!$isLoggedIn): ?>
                    <a href="<?= url('/login') ?>" 
                       class="px-4 py-2.5 sm:px-5 sm:py-3 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm rounded-xl backdrop-blur-sm transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        <span>Log Masuk Staf / Admin</span>
                    </a>
                    <?php else: ?>
                    <a href="<?= url('/dashboard') ?>" 
                       class="px-4 py-2.5 sm:px-5 sm:py-3 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm rounded-xl backdrop-blur-sm transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Papan Pemuka Utama</span>
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Integrated Fast Search Bar for Ticket Tracking -->
                <div class="bg-white/95 backdrop-blur-md p-2 rounded-2xl border border-white/30 shadow-lg max-w-2xl">
                    <form action="<?= url('/track') ?>" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
                        <div class="relative flex-1 w-full">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="ref" required 
                                   placeholder="Semak Status No. Tiket (Cth: ICTBKP/2026/08/0001 atau 0001)" 
                                   class="w-full pl-10 pr-3 py-2 sm:py-2.5 bg-transparent text-slate-900 placeholder-slate-400 text-xs font-semibold outline-none font-mono">
                        </div>
                        <button type="submit" 
                                class="w-full sm:w-auto px-5 py-2 sm:py-2.5 bg-slate-900 hover:bg-slate-800 active:bg-black text-white font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-1.5 shrink-0 shadow-sm">
                            <span>Semak Status</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Service Badges (Compact 4 Grid Pillars) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2 border-t border-white/10 text-[11px] text-slate-200">
                <div class="flex items-center gap-2 p-2 rounded-xl bg-white/5 border border-white/10">
                    <span class="text-base">💻</span>
                    <span class="font-medium truncate">Peminjaman Laptop & Tab</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-xl bg-white/5 border border-white/10">
                    <span class="text-base">📹</span>
                    <span class="font-medium truncate">Liputan Media & Kamera</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-xl bg-white/5 border border-white/10">
                    <span class="text-base">🌐</span>
                    <span class="font-medium truncate">Sokongan Cisco Webex</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-xl bg-white/5 border border-white/10">
                    <span class="text-base">🛠️</span>
                    <span class="font-medium truncate">Khidmat Teknikal ICT</span>
                </div>
            </div>
        </div>
    </div>
</div>
