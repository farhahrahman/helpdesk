<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-4 sm:py-8 my-auto">
    <!-- Corporate Unified Hero Card (Kemaskini Latar Belakang Baharu) -->
    <div class="relative rounded-3xl overflow-hidden bg-cover bg-center bg-no-repeat border border-slate-200/90 shadow-2xl p-6 sm:p-10 lg:p-12 text-slate-900 transition-all"
         style="background-image: url('<?= asset('images/bg-helpdesk.png') ?>');">

        <div class="relative z-10 space-y-6 sm:space-y-8">
            <!-- Top Tag -->
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/85 backdrop-blur-sm border border-blue-200/80 text-blue-900 text-xs font-bold uppercase tracking-wider shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Portal Rasmi Khidmat Sokongan ICT & Aset BKP
                </div>
            </div>

            <!-- Main Heading & Description Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900 leading-tight">
                        Permohonan Mesyuarat, Peralatan ICT & Khidmat Media BKP
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-medium">
                        Sistem pengurusan permohonan peminjaman aset (Laptop Dell, iPhone 15, Lenovo Tab, Kamera DSLR), sokongan teknikal mesyuarat dalam talian (Cisco Webex / Zoom / Teams), dan liputan media rasmi Bahagian Khidmat Pengurusan.
                    </p>
                    
                    <!-- Action Button (Hanya Butang Utama Permohonan Baru) -->
                    <div class="pt-2">
                        <a href="<?= url('/tickets/create') ?>" 
                           class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm sm:text-base rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 hover:-translate-y-0.5 transition-all">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>+ Buat Permohonan Baru</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Status Tracker Box (Desktop / Laptop) -->
                <div class="lg:col-span-5">
                    <div class="bg-white/90 backdrop-blur-md p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xl shadow-slate-900/5 text-slate-900 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center font-bold">
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
                                       class="w-full pl-3.5 pr-4 py-3 bg-slate-50/90 border border-slate-300 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs font-mono font-bold text-slate-900 outline-none transition-all">
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
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-200/80 text-xs text-slate-700">
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/80 backdrop-blur-sm border border-slate-200/80 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all">
                    <span class="text-lg">💻</span>
                    <div class="min-w-0">
                        <span class="font-bold text-slate-900 block truncate">Peminjaman Laptop</span>
                        <span class="text-[10px] text-slate-500 block truncate">Dell, Lenovo Tab & Aksesori</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/80 backdrop-blur-sm border border-slate-200/80 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all">
                    <span class="text-lg">📹</span>
                    <div class="min-w-0">
                        <span class="font-bold text-slate-900 block truncate">Liputan Media</span>
                        <span class="text-[10px] text-slate-500 block truncate">Jurugambar & Juruvideo Rasmi</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/80 backdrop-blur-sm border border-slate-200/80 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all">
                    <span class="text-lg">🌐</span>
                    <div class="min-w-0">
                        <span class="font-bold text-slate-900 block truncate">Sokongan Mesyuarat</span>
                        <span class="text-[10px] text-slate-500 block truncate">Cisco Webex / Zoom / Teams</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/80 backdrop-blur-sm border border-slate-200/80 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all">
                    <span class="text-lg">🛠️</span>
                    <div class="min-w-0">
                        <span class="font-bold text-slate-900 block truncate">Khidmat Teknikal ICT</span>
                        <span class="text-[10px] text-slate-500 block truncate">Siar Raya & Aduan Sistem</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
