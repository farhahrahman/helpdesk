<?php
use App\Core\Session;

$oldEmail = old('email', '');
$error = Session::getFlash('error');
$info = Session::getFlash('info');
?>

<div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden">
    <!-- Header Graphic -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 text-center border-b border-slate-800 text-white relative">
        <div class="w-16 h-16 rounded-2xl bg-blue-600/20 border border-blue-500/30 text-blue-400 mx-auto flex items-center justify-center shadow-lg mb-4 ring-4 ring-blue-500/10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">SISTEM HELPDESK ICT</h1>
        <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-medium">Bahagian Khidmat Pengurusan</p>
        <p class="text-[11px] text-blue-400 mt-0.5">Pejabat Setiausaha Kerajaan Negeri Johor</p>
    </div>

    <div class="p-8">
        <?php if ($error): ?>
        <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-center gap-2.5">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span><?= e($error) ?></span>
        </div>
        <?php endif; ?>

        <?php if ($info): ?>
        <div class="mb-5 p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-800 flex items-center gap-2.5">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span><?= e($info) ?></span>
        </div>
        <?php endif; ?>

        <!-- Demo Account Hint Box -->
        <div class="mb-5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-start gap-2.5">
            <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-bold">Akaun Percubaan / Demo (Try & Error):</span><br>
                ID Pengguna: <code class="bg-amber-100/80 px-1 py-0.5 rounded font-mono font-bold text-amber-950">admin</code> &bull; Kata Laluan: <code class="bg-amber-100/80 px-1 py-0.5 rounded font-mono font-bold text-amber-950">P@s5w06d</code>
            </div>
        </div>

        <form action="<?= url('/login') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    ID Pengguna / Emel Rasmi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input type="text" id="email" name="email" value="<?= e($oldEmail ?: 'admin') ?>" required autofocus
                           placeholder="admin atau nama@johor.gov.my"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-xl text-sm text-slate-900 transition-all outline-none">
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kata Laluan
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" id="password" name="password" required
                           placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-xl text-sm text-slate-900 transition-all outline-none">
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm rounded-xl shadow-md hover:shadow-lg transition-all focus:ring-4 focus:ring-blue-200">
                Log Masuk ke Sistem
            </button>
        </form>

        <!-- Pemakluman Catatan Password Default 123456 -->
        <div class="mt-6 p-4 rounded-xl bg-blue-50/80 border border-blue-200 text-xs text-blue-900 flex items-start gap-3">
            <div class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="font-bold text-blue-950 text-xs">Pemakluman Log Masuk Staf & Pegawai</p>
                <p class="text-blue-800 text-[11px] mt-1 leading-relaxed">
                    Sila gunakan <strong>Emel Rasmi Kerajaan</strong> anda (<span class="font-mono text-slate-700">@johor.gov.my</span>) dan kata laluan asas (<span class="font-mono font-bold bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 border border-blue-200">123456</span>) untuk log masuk melihat sejarah permohonan.
                </p>
            </div>
        </div>

        <!-- Pautan Kembali ke Portal Depan -->
        <div class="mt-5 text-center">
            <a href="<?= url('/') ?>" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-600 transition-colors font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali ke Portal Muka Depan</span>
            </a>
        </div>
    </div>
</div>
