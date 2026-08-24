<?php
use App\Core\Auth;

$user = Auth::user();
?>

<div class="space-y-6">
    <!-- Header with Export CTA -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Eksekutif & Analitis Perkhidmatan</h1>
            <p class="text-xs text-slate-500 mt-1">Analisis utilisasi peralatan ICT, kekerapan sokongan mesyuarat dan agihan 6 Unit BKP</p>
        </div>
        <a href="<?= url('/reports/export?unit=' . urlencode($filters['unit'] ?? '') . '&category=' . urlencode($filters['category'] ?? '') . '&status=' . urlencode($filters['status'] ?? '')) ?>" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Muat Turun Laporan CSV</span>
        </a>
    </div>

    <!-- 6 Unit Breakdown Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php foreach ($statsByUnit as $uCode => $u): ?>
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="truncate">
                <p class="text-xs font-bold text-slate-800 truncate"><?= e($u['name']) ?></p>
                <p class="text-[11px] text-slate-500 font-mono"><?= e($uCode) ?></p>
            </div>
            <span class="text-xl font-extrabold text-blue-600 pl-2 shrink-0">
                <?= $u['count'] ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="GET" action="<?= url('/reports') ?>" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <select name="unit" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                    <option value="">Semua Unit & Pejabat</option>
                    <?php foreach ($units as $uKey => $u): ?>
                    <option value="<?= $uKey ?>" <?= (($filters['unit'] ?? '') === $uKey) ? 'selected' : '' ?>><?= e($u['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cKey => $c): ?>
                    <option value="<?= $cKey ?>" <?= (($filters['category'] ?? '') === $cKey) ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                    <option value="">Semua Status</option>
                    <?php foreach ($statuses as $sKey => $s): ?>
                    <option value="<?= $sKey ?>" <?= (($filters['status'] ?? '') === $sKey) ? 'selected' : '' ?>><?= e($s['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full py-2 bg-slate-900 text-white font-medium text-xs rounded-xl shadow-sm">
                    Tapis Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Report Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-6">No. Rujukan</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Tajuk Permohonan</th>
                        <th class="py-3.5 px-4">Pemohon</th>
                        <th class="py-3.5 px-4">Unit</th>
                        <th class="py-3.5 px-4">Tarikh Tempahan</th>
                        <th class="py-3.5 px-4">Status Semasa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    <?php if (empty($tickets)): ?>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">Tiada rekod laporan mengikut tapisan ini.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($tickets as $t): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-6 font-mono font-bold text-slate-900"><?= e($t['reference_no']) ?></td>
                        <td class="py-3.5 px-4"><?= e($t['category_name']) ?></td>
                        <td class="py-3.5 px-4 font-semibold text-slate-900 max-w-xs truncate"><?= e($t['title']) ?></td>
                        <td class="py-3.5 px-4"><?= e($t['applicant_name']) ?></td>
                        <td class="py-3.5 px-4 font-medium text-slate-700"><?= e($t['unit_short_name']) ?></td>
                        <td class="py-3.5 px-4"><?= e($t['formatted_start_date']) ?></td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold border <?= $t['status_badge_class'] ?>">
                                <?= e($t['status_label']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
