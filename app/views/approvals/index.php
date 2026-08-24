<?php
use App\Core\Auth;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
?>

<div class="space-y-6">
    <!-- Header Context -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pusat Kelulusan & Pengesahan Aliran Kerja</h1>
            <p class="text-xs text-slate-500 mt-1">
                Urus tindakan perakuan Ketua Unit, kelulusan ICT BKP, serta serahan dan pemulangan aset
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200">
                Peranan Anda: <?= e($role) ?>
            </span>
        </div>
    </div>

    <!-- Section 1: Menunggu Perakuan Ketua Unit -->
    <?php if ($role === 'KETUA_UNIT' || $role === 'ADMIN'): ?>
    <div class="bg-white rounded-2xl border border-amber-200/80 shadow-sm overflow-hidden">
        <div class="p-5 bg-amber-50/50 border-b border-amber-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold text-xs">
                    1
                </div>
                <div>
                    <h2 class="text-sm font-bold text-amber-950">Menunggu Perakuan / Sokongan Ketua Unit</h2>
                    <p class="text-xs text-amber-800">Permohonan daripada staf yang memerlukan sokongan anda sebelum ke ICT</p>
                </div>
            </div>
            <span class="px-2.5 py-1 text-xs font-bold bg-amber-200 text-amber-900 rounded-full">
                <?= count($pendingUnit) ?> Menunggu
            </span>
        </div>

        <?php if (empty($pendingUnit)): ?>
        <div class="p-8 text-center text-xs text-slate-500">
            Tiada permohonan staf menunggu sokongan unit buat masa ini.
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-100">
            <?php foreach ($pendingUnit as $t): ?>
            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                <div class="space-y-1 min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-bold text-xs text-slate-900"><?= e($t['reference_no']) ?></span>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-700"><?= e($t['unit_short_name']) ?></span>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-blue-50 text-blue-700"><?= e($t['category_name']) ?></span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 truncate"><?= e($t['title']) ?></h3>
                    <p class="text-xs text-slate-500">
                        Pemohon: <strong><?= e($t['applicant_name']) ?></strong> &bull; Tarikh: <?= e($t['formatted_start_date']) ?> (<?= e($t['start_time']) ?>)
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-2">
                    <a href="<?= url('/tickets/' . $t['id']) ?>" 
                       class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg shadow-sm">
                        Semak & Luluskan &rarr;
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Section 2: Menunggu Kelulusan ICT BKP -->
    <?php if ($role === 'ADMIN'): ?>
    <div class="bg-white rounded-2xl border border-blue-200/80 shadow-sm overflow-hidden">
        <div class="p-5 bg-blue-50/50 border-b border-blue-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                    2
                </div>
                <div>
                    <h2 class="text-sm font-bold text-blue-950">Menunggu Kelulusan Rasmi & Peruntukan Unit ICT BKP</h2>
                    <p class="text-xs text-blue-800">Telah diperakukan Ketua Unit & sedia untuk diagihkan peralatan / juruteknik</p>
                </div>
            </div>
            <span class="px-2.5 py-1 text-xs font-bold bg-blue-200 text-blue-900 rounded-full">
                <?= count($pendingICT) ?> Menunggu
            </span>
        </div>

        <?php if (empty($pendingICT)): ?>
        <div class="p-8 text-center text-xs text-slate-500">
            Tiada permohonan menunggu kelulusan ICT.
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-100">
            <?php foreach ($pendingICT as $t): ?>
            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                <div class="space-y-1 min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-bold text-xs text-slate-900"><?= e($t['reference_no']) ?></span>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Disokong Unit</span>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-blue-50 text-blue-700"><?= e($t['category_name']) ?></span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 truncate"><?= e($t['title']) ?></h3>
                    <p class="text-xs text-slate-500">
                        Pemohon: <strong><?= e($t['applicant_name']) ?></strong> (<?= e($t['unit_short_name']) ?>) &bull; Acara: <?= e($t['formatted_start_date']) ?>
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-2">
                    <a href="<?= url('/tickets/' . $t['id']) ?>" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm">
                        Agih Aset & Luluskan &rarr;
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Section 3: Pinjaman Aktif & Penyerahan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                    3
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Pinjaman Aktif / Dalam Pelaksanaan</h2>
                    <p class="text-xs text-slate-500">Aset yang sedang digunakan atau sedia untuk diserahkan/dipulangkan</p>
                </div>
            </div>
            <span class="px-2.5 py-1 text-xs font-bold bg-slate-200 text-slate-800 rounded-full">
                <?= count($activeLoans) ?> Aktif
            </span>
        </div>

        <?php if (empty($activeLoans)): ?>
        <div class="p-8 text-center text-xs text-slate-500">
            Tiada pinjaman aset aktif pada masa ini.
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-100">
            <?php foreach ($activeLoans as $t): ?>
            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                <div class="space-y-1 min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-bold text-xs text-slate-900"><?= e($t['reference_no']) ?></span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-semibold rounded-full border <?= $t['status_badge_class'] ?>">
                            <?= e($t['status_label']) ?>
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 truncate"><?= e($t['title']) ?></h3>
                    <p class="text-xs text-slate-500">
                        Pemohon: <?= e($t['applicant_name']) ?> (<?= e($t['unit_short_name']) ?>) &bull; Lokasi: <?= e($t['location']) ?>
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-2">
                    <a href="<?= url('/tickets/' . $t['id']) ?>" 
                       class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm">
                        Urus Serahan / Pemulangan
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
