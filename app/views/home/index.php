<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-4 sm:py-8 my-auto">
    <!-- Corporate Unified Hero Card (Sempurna & Kemas untuk Desktop, Laptop & Mobile) -->
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 border border-blue-800/40 p-8 sm:p-12 lg:p-14 shadow-2xl text-white">
        <!-- Ambient Background Glow -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6 sm:space-y-8">
            <!-- Top Tag -->
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    Portal Rasmi Khidmat Sokongan ICT & Aset BKP
                </div>
            </div>

            <!-- Main Heading & Description Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                        Permohonan Mesyuarat, Peralatan ICT & Khidmat Media BKP
                    </h1>
                    <p class="text-blue-100/90 text-sm sm:text-base leading-relaxed">
                        Sistem pengurusan permohonan peminjaman aset (Laptop Dell, iPhone 15, Lenovo Tab, Kamera DSLR), sokongan teknikal mesyuarat dalam talian (Cisco Webex / Zoom / Teams), dan liputan media rasmi Bahagian Khidmat Pengurusan.
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3.5 pt-2">
                        <a href="<?= url('/tickets/create') ?>" 
                           class="px-6 py-3.5 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>+ Buat Permohonan Baru</span>
                        </a>

                        <?php if (!$isLoggedIn): ?>
                        <a href="<?= url('/login') ?>" 
                           class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-sm rounded-xl backdrop-blur-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            <span>Log Masuk Staf / Admin</span>
                        </a>
                        <?php else: ?>
                        <a href="<?= url('/dashboard') ?>" 
                           class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-sm rounded-xl backdrop-blur-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Papan Pemuka Utama</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Status Tracker Box (Desktop / Laptop) -->
                <div class="lg:col-span-5">
                    <div class="bg-white/95 backdrop-blur-md p-6 sm:p-7 rounded-2xl border border-white/30 shadow-2xl text-slate-900 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-600 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-900 leading-tight">Semak Status Permohonan</h3>
                                <p class="text-[11px] text-slate-500">Kemas kini masa nyata menggunakan No. Tiket</p>
                            </div>
                        </div>

                        <form action="<?= url('/track') ?>" method="GET" class="space-y-3">
                            <div class="relative">
                                <input type="text" name="ref" required 
                                       placeholder="Cth: ICTBKP/2026/08/0001 atau 0001" 
                                       class="w-full pl-3.5 pr-4 py-3 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs font-mono font-bold text-slate-900 outline-none transition-all">
                            </div>
                            <button type="submit" 
                                    class="w-full py-3 bg-slate-900 hover:bg-slate-800 active:bg-black text-white font-bold text-xs rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                                <span>Semak Status Sekarang</span>
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Service Badges (Grid 4 Pillars) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-white/10 text-xs text-slate-200">
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg">💻</span>
                    <div class="min-w-0">
                        <span class="font-bold text-white block truncate">Peminjaman Laptop</span>
                        <span class="text-[10px] text-blue-200 block truncate">Dell, Lenovo Tab & Aksesori</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg">📹</span>
                    <div class="min-w-0">
                        <span class="font-bold text-white block truncate">Liputan Media</span>
                        <span class="text-[10px] text-blue-200 block truncate">Jurugambar & Juruvideo Rasmi</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg">🌐</span>
                    <div class="min-w-0">
                        <span class="font-bold text-white block truncate">Sokongan Mesyuarat</span>
                        <span class="text-[10px] text-blue-200 block truncate">Cisco Webex / Zoom / Teams</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg">🛠️</span>
                    <div class="min-w-0">
                        <span class="font-bold text-white block truncate">Khidmat Teknikal ICT</span>
                        <span class="text-[10px] text-blue-200 block truncate">Siar Raya & Aduan Sistem</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
