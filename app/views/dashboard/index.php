<?php
use App\Core\Auth;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
?>

<div class="space-y-8">
    <!-- Welcome Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-850 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-md border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-semibold uppercase tracking-wider mb-3 border border-blue-400/20">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                Portal Pengurusan Permohonan & Khidmat Sokongan ICT
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
                Selamat Datang, <?= e($user['name'] ?? 'Pegawai') ?>
            </h1>
            <p class="text-slate-400 text-sm mt-1 max-w-2xl leading-relaxed">
                Penyelarasan rasmi permohonan peminjaman aset ICT, sokongan teknikal mesyuarat, dan khidmat media untuk 6 Unit BKP serta Pejabat TSUK Pengurusan.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="<?= url('/tickets/create') ?>" 
               class="px-5 py-3 bg-blue-600 hover:bg-blue-500 text-white font-medium text-sm rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center gap-2 focus:ring-4 focus:ring-blue-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Hantar Permohonan Baru</span>
            </a>
            <?php if ($role === 'ADMIN' || $role === 'KETUA_UNIT'): ?>
            <a href="<?= url('/approvals') ?>" 
               class="px-4 py-3 bg-slate-800 hover:bg-slate-700 text-slate-200 font-medium text-sm rounded-xl border border-slate-700 transition-all flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Pusat Kelulusan</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jumlah Permohonan</p>
                <p class="text-2xl font-bold text-slate-900 mt-0.5"><?= $metrics['total'] ?></p>
            </div>
        </div>

        <!-- Pending Unit -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sokongan Ketua Unit</p>
                <p class="text-2xl font-bold text-amber-600 mt-0.5"><?= $metrics['pending_unit'] ?></p>
            </div>
        </div>

        <!-- Pending ICT -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kelulusan ICT BKP</p>
                <p class="text-2xl font-bold text-indigo-600 mt-0.5"><?= $metrics['pending_ict'] ?></p>
            </div>
        </div>

        <!-- Active / Approved -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Aktif & Diluluskan</p>
                <p class="text-2xl font-bold text-emerald-600 mt-0.5"><?= $metrics['active_approved'] ?></p>
            </div>
        </div>
    </div>

    <!-- Two Columns: 6 Unit Distribution & Category Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 6 Units of BKP & Pejabat TSUK -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 tracking-tight">Status Permohonan Mengikut Unit BKP</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pemantauan aktiviti di bawah 6 Unit dan Pejabat TSUK Pengurusan</p>
                </div>
                <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-lg">7 Entiti</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <?php foreach ($unit_counts as $uCode => $unit): ?>
                <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition-colors flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-<?= $unit['color'] ?>-500 shrink-0"></span>
                        <div class="truncate">
                            <p class="text-xs font-bold text-slate-800 truncate"><?= e($unit['name']) ?></p>
                            <p class="text-[11px] text-slate-500 font-mono"><?= e($unit['code']) ?></p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-sm font-bold text-slate-900"><?= $unit['count'] ?></span>
                        <span class="text-[11px] text-slate-500 block">permohonan</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Category Breakdown & Asset Stock -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900 tracking-tight mb-1">Kategori Perkhidmatan</h2>
                <p class="text-xs text-slate-500 mb-5">Agihan perkhidmatan yang dimohon</p>

                <div class="space-y-4">
                    <!-- Peminjaman Aset -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-medium">
                            <span class="text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Peminjaman Peralatan (iPhone/DSLR/Mic)
                            </span>
                            <span class="text-slate-900 font-bold"><?= $category_counts['PEMINJAMAN_ASET'] ?></span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: <?= ($metrics['total'] > 0) ? ($category_counts['PEMINJAMAN_ASET'] / $metrics['total'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>

                    <!-- Sokongan Mesyuarat -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-medium">
                            <span class="text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                Mesyuarat Online & Teknikal
                            </span>
                            <span class="text-slate-900 font-bold"><?= $category_counts['SOKONGAN_MESYUARAT'] ?></span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: <?= ($metrics['total'] > 0) ? ($category_counts['SOKONGAN_MESYUARAT'] / $metrics['total'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>

                    <!-- Khidmat Media -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-medium">
                            <span class="text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                Jurukamera & Media Acara
                            </span>
                            <span class="text-slate-900 font-bold"><?= $category_counts['MEDIA_JURUKAMERA'] ?></span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: <?= ($metrics['total'] > 0) ? ($category_counts['MEDIA_JURUKAMERA'] / $metrics['total'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Asset Quick Metric -->
            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-slate-100 rounded-lg text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Ketersediaan Inventori Aset</p>
                        <p class="text-[11px] text-slate-500"><?= $metrics['available_assets'] ?> daripada <?= $metrics['total_assets'] ?> aset sedia untuk dipinjam</p>
                    </div>
                </div>
                <a href="<?= url('/assets') ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Semak &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Recent Tickets Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200/80 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900 tracking-tight">Permohonan Terkini</h2>
                <p class="text-xs text-slate-500 mt-0.5">Senarai aktiviti permohonan terkini dalam sistem</p>
            </div>
            <a href="<?= url('/tickets') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 transition-colors">
                <span>Lihat Semua Permohonan</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <?php if (empty($recent_tickets)): ?>
        <div class="p-12 text-center">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <p class="text-sm font-semibold text-slate-700">Tiada rekod permohonan setakat ini</p>
            <p class="text-xs text-slate-500 mt-1">Gunakan butang di bawah untuk menghantar permohonan baru.</p>
            <a href="<?= url('/tickets/create') ?>" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-lg">
                + Buat Permohonan Baru
            </a>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200/80 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">No. Rujukan / Kategori</th>
                        <th class="py-3.5 px-4">Tajuk Permohonan</th>
                        <th class="py-3.5 px-4">Pemohon & Unit</th>
                        <th class="py-3.5 px-4">Tarikh Acara</th>
                        <th class="py-3.5 px-4">Status Aliran</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($recent_tickets as $t): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="font-mono font-bold text-xs text-slate-900 block"><?= e($t['reference_no']) ?></span>
                            <span class="text-[11px] text-slate-500"><?= e($t['category_name']) ?></span>
                        </td>
                        <td class="py-4 px-4 min-w-[220px]">
                            <p class="font-semibold text-slate-900 line-clamp-1"><?= e($t['title']) ?></p>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= e($t['location']) ?></p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-medium text-slate-900 text-xs"><?= e($t['applicant_name']) ?></p>
                            <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                <?= e($t['unit_short_name']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap text-xs">
                            <span class="font-medium text-slate-800 block"><?= e($t['formatted_start_date']) ?></span>
                            <span class="text-[11px] text-slate-500"><?= e($t['start_time']) ?> - <?= e($t['end_time']) ?></span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border ring-1 <?= $t['status_badge_class'] ?>">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                <?= e($t['status_label']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <a href="<?= url('/tickets/' . $t['id']) ?>" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-semibold rounded-lg border border-slate-200 hover:border-blue-200 transition-all">
                                <span>Papar</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
