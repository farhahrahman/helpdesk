<?php
use App\Core\Auth;
use App\Core\Session;

$error = Session::getFlash('error');
$success = Session::getFlash('success');
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800 border border-emerald-200">
                    MODUL KESELAMATAN &amp; PEMULIHAN
                </span>
                <span class="text-xs text-slate-400 font-mono">v3.0.0-ENTERPRISE</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1.5 flex items-center gap-2.5">
                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7h16m-8 4v6m-3-3l3 3 3-3"></path></svg>
                Pusat Kawalan Sandaran &amp; Pemulihan Data
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Pengurusan sandaran pangkalan data JSON, fail lampiran, keselamatan luar talian dan pemulihan rekod tanpa kehilangan data.
            </p>
        </div>

        <!-- Quick Info Badge -->
        <div class="flex items-center gap-2 bg-slate-100 px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-700">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Storan Selamat: <strong class="font-mono text-slate-900">storage/backups/</strong></span>
        </div>
    </div>

    <!-- Live Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1: Data Semasa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Rekod Sistem Aktif</p>
                <div class="flex items-baseline gap-2 mt-0.5">
                    <span class="text-2xl font-black text-slate-900"><?= number_format($currentCounts['tickets']) ?></span>
                    <span class="text-xs font-semibold text-blue-700">Tiket Aduan</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    <?= number_format($currentCounts['users']) ?> Staf &bull; <?= number_format($currentCounts['assets']) ?> Aset ICT
                </p>
            </div>
        </div>

        <!-- Card 2: Jumlah Sandaran -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Jumlah Fail Sandaran</p>
                <div class="flex items-baseline gap-2 mt-0.5">
                    <span class="text-2xl font-black text-slate-900"><?= count($backups) ?></span>
                    <span class="text-xs font-semibold text-emerald-700">Arkib ZIP</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    <?= !empty($backups) ? 'Terkini: ' . e($backups[0]['created_at']) : 'Belum ada sandaran' ?>
                </p>
            </div>
        </div>

        <!-- Card 3: Keselamatan Fail -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Perlindungan Luar Talian</p>
                <div class="flex items-baseline gap-2 mt-0.5">
                    <span class="text-base font-bold text-slate-900">Salinan Emel</span>
                    <span class="text-xs font-semibold text-indigo-600">Gmail / Admin</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    Pencegahan risiko pelayan terpadam / rosak
                </p>
            </div>
        </div>
    </div>

    <!-- Action Section: Create Backup Form -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-850 to-slate-900 rounded-2xl p-6 text-white shadow-lg border border-slate-800">
        <form action="<?= url('/backups/create') ?>" method="POST" class="flex flex-col lg:flex-row items-stretch lg:items-end justify-between gap-5">
            <?= csrf_field() ?>

            <div class="flex-1 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                    <h2 class="text-base font-bold text-white tracking-wide">Cipta Sandaran Sistem Segera</h2>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Sistem akan membungkus fail pangkalan data JSON (<code class="text-blue-300 font-mono">tickets.json</code>, <code class="text-blue-300 font-mono">users.json</code>, <code class="text-blue-300 font-mono">assets.json</code> dll) serta lampiran ke dalam fail arkib ZIP yang disahkan dengan hash SHA-256.
                </p>
                
                <div class="pt-2 max-w-lg">
                    <label for="email_notification" class="block text-[11px] font-semibold text-slate-300 mb-1">
                        Hantar Salinan Sandaran ke Peti Masuk Gmail Pentadbir (Pilihan):
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" id="email_notification" name="email_notification" 
                               value="<?= e($user['email'] ?? '') ?>"
                               placeholder="nama@gmail.com atau emel rasmi"
                               class="w-full pl-9 pr-3 py-2 bg-slate-800/90 border border-slate-700 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-slate-800">
                    </div>
                    <span class="text-[10px] text-slate-400 mt-1 block">
                        * Lampiran ZIP penuh akan dihantar terus ke alamat e-mel di atas sebagai salinan luar talian.
                    </span>
                </div>
            </div>

            <div class="shrink-0">
                <button type="submit" 
                        onclick="this.disabled=true; this.innerText='Sedang Menjana Sandaran...'; this.form.submit();"
                        class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-emerald-900/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Cipta Sandaran Manual Sekarang</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Backups Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Senarai Rekod Sandaran Tersedia
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Arkib sandaran yang disimpan di pelayan sedia untuk dimuat turun atau dipulihkan.</p>
            </div>
            <span class="text-xs text-slate-500 font-mono"><?= count($backups) ?> fail tersimpan</span>
        </div>

        <?php if (empty($backups)): ?>
        <div class="p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
            <h4 class="text-sm font-bold text-slate-800">Tiada Fail Sandaran</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Sistem belum mempunyai sebarang fail sandaran. Sila klik butang di atas untuk mencipta sandaran pertama anda.
            </p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider text-[10.5px]">
                        <th class="px-5 py-3.5">Nama Fail Arkib</th>
                        <th class="px-4 py-3.5">Jenis Sandaran</th>
                        <th class="px-4 py-3.5">Tarikh &amp; Masa</th>
                        <th class="px-4 py-3.5">Saiz</th>
                        <th class="px-4 py-3.5">Pencipta</th>
                        <th class="px-5 py-3.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal text-slate-700">
                    <?php foreach ($backups as $b): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg <?= $b['is_snapshot'] ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' ?> flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900 font-mono text-[11px] truncate" title="<?= e($b['filename']) ?>">
                                        <?= e($b['filename']) ?>
                                    </p>
                                    <?php if (!empty($b['record_counts'])): ?>
                                    <p class="text-[10px] text-slate-500 mt-0.5">
                                        <?= ($b['record_counts']['tickets'] ?? 0) ?> Tiket &bull; <?= ($b['record_counts']['users'] ?? 0) ?> Staf &bull; <?= ($b['record_counts']['assets'] ?? 0) ?> Aset
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <?php if ($b['is_snapshot']): ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                🛡️ Pra-Restore (Kekal)
                            </span>
                            <?php elseif ($b['type'] === 'AUTO_DAILY'): ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-900 border border-purple-200">
                                ⏰ Auto Harian (Cron)
                            </span>
                            <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-900 border border-blue-200">
                                👤 Manual Pentadbir
                            </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3.5 whitespace-nowrap font-medium text-slate-600">
                            <?= e($b['created_at']) ?>
                        </td>

                        <td class="px-4 py-3.5 whitespace-nowrap font-mono text-slate-600 font-semibold">
                            <?= e($b['size_formatted']) ?>
                        </td>

                        <td class="px-4 py-3.5 whitespace-nowrap text-slate-500 text-[11px]">
                            <?= e($b['creator']) ?>
                        </td>

                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <!-- Download Button -->
                                <a href="<?= url('/backups/download/' . urlencode($b['filename'])) ?>" 
                                   title="Muat Turun Fail ZIP ke Komputer"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 font-semibold text-[11px] rounded-lg border border-blue-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <span>Muat Turun</span>
                                </a>

                                <!-- Restore Button -->
                                <button type="button" 
                                        onclick="openRestoreModal('<?= e($b['filename']) ?>', '<?= e($b['created_at']) ?>', '<?= e($b['size_formatted']) ?>')"
                                        title="Pulihkan data sistem dari fail ini"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-800 font-semibold text-[11px] rounded-lg border border-amber-200 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span>Pulihkan</span>
                                </button>

                                <!-- Delete Button (Hidden for protected pre-restore snapshots) -->
                                <?php if (!$b['is_snapshot']): ?>
                                <form action="<?= url('/backups/delete/' . urlencode($b['filename'])) ?>" method="POST" 
                                      onsubmit="return confirm('Adakah anda pasti ingin memadam fail sandaran <?= e($b['filename']) ?>? Tindakan ini tidak boleh dibatalkan.');"
                                      class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" 
                                            title="Padam Fail Sandaran"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Audit Logs Section -->
    <?php if (!empty($recentLogs)): ?>
    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Jejak Audit Aktiviti Sandaran &amp; Pemulihan Terkini
        </h4>
        <div class="space-y-2 max-h-48 overflow-y-auto font-mono text-[11px]">
            <?php foreach ($recentLogs as $log): ?>
            <div class="p-2 rounded-lg bg-slate-50 border border-slate-200/70 flex items-start justify-between gap-3">
                <div class="flex items-start gap-2">
                    <span class="px-1.5 py-0.5 rounded text-[9.5px] font-bold <?= ($log['action'] === 'DATA_RESTORED') ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-slate-200 text-slate-800' ?>">
                        <?= e($log['action'] ?? '') ?>
                    </span>
                    <span class="text-slate-800"><?= e($log['description'] ?? '') ?></span>
                </div>
                <span class="text-slate-400 shrink-0 text-[10px]"><?= e($log['created_at'] ?? '') ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- ========================================================================= -->
<!-- MODAL KESELAMATAN PEMULIHAN DATA (RESTORE MODAL)                           -->
<!-- ========================================================================= -->
<div id="restoreModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative animate-in fade-in zoom-in-95 duration-200">
        <!-- Close Button -->
        <button type="button" onclick="closeRestoreModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="flex items-center gap-3.5 mb-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Pengesahan Pemulihan Pangkalan Data</h3>
                <p class="text-xs text-slate-500">Operasi Kritikal Pentadbir Sistem</p>
            </div>
        </div>

        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 leading-relaxed space-y-2 mb-4">
            <p>
                <strong>PERHATIAN KESELAMATAN:</strong> Memulihkan arkib ini akan menukar ganti pangkalan data semasa kepada versi di dalam fail sandaran yang dipilih.
            </p>
            <p class="text-[11px] text-amber-800">
                &check; Sistem akan secara <strong>automatik menjana Salinan Keselamatan Pra-Pemulihan (Snapshot)</strong> bagi data semasa sebelum operasi dijalankan agar data anda tidak akan hilang.
            </p>
        </div>

        <form action="<?= url('/backups/restore') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" id="modalRestoreFilename" name="filename" value="">

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono">
                <div class="text-slate-500">Fail Arkib Dipilih:</div>
                <div id="modalTargetName" class="font-bold text-slate-900 mt-0.5 truncate"></div>
                <div id="modalTargetMeta" class="text-[11px] text-slate-500 mt-0.5"></div>
            </div>

            <!-- Confirm Phrase -->
            <div>
                <label for="confirm_phrase" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Sila taip frasa pengesahan: <span class="text-rose-600 font-mono">PULIHKAN DATA</span>
                </label>
                <input type="text" id="confirm_phrase" name="confirm_phrase" required autocomplete="off"
                       placeholder="PULIHKAN DATA"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-bold text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none">
            </div>

            <!-- Admin Password Re-auth -->
            <div>
                <label for="admin_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Kata Laluan Log Masuk Pentadbir:
                </label>
                <input type="password" id="admin_password" name="password" required
                       placeholder="Masukkan kata laluan akaun pentadbir anda"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeRestoreModal()" 
                        class="px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Sahkan &amp; Mulakan Pemulihan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRestoreModal(filename, createdAt, size) {
    document.getElementById('modalRestoreFilename').value = filename;
    document.getElementById('modalTargetName').innerText = filename;
    document.getElementById('modalTargetMeta').innerText = 'Dicipta: ' + createdAt + ' • Saiz: ' + size;
    document.getElementById('confirm_phrase').value = '';
    document.getElementById('admin_password').value = '';
    document.getElementById('restoreModal').classList.remove('hidden');
}

function closeRestoreModal() {
    document.getElementById('restoreModal').classList.add('hidden');
}
</script>
