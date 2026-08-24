<?php
use App\Core\Auth;

$user = Auth::user();
$isAdmin = Auth::isAdmin();
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Inventori Peralatan & Aset ICT</h1>
            <p class="text-xs text-slate-500 mt-1">Pengurusan peranti rasmi: iPhone, Kamera DSLR, Mikrofon Wireless & Komputer Riba</p>
        </div>
        <?php if ($isAdmin): ?>
        <a href="<?= url('/assets/create') ?>" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>+ Daftar Aset Baru</span>
        </a>
        <?php endif; ?>
    </div>

    <!-- Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
        <a href="<?= url('/assets') ?>" 
           class="px-3.5 py-2 rounded-xl font-semibold transition-colors shrink-0 <?= empty($typeFilter) ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' ?>">
            Semua Jenis
        </a>
        <?php foreach ($equipmentTypes as $tKey => $eq): ?>
        <a href="<?= url('/assets?type=' . $tKey) ?>" 
           class="px-3.5 py-2 rounded-xl font-semibold transition-colors shrink-0 <?= ($typeFilter === $tKey) ? 'bg-blue-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' ?>">
            <?= e($eq['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Assets Grid / Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200/80 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Kod Aset / Siri</th>
                        <th class="py-3.5 px-4">Nama & Model Aset</th>
                        <th class="py-3.5 px-4">Jenis Peranti</th>
                        <th class="py-3.5 px-4">Keadaan Fizikal</th>
                        <th class="py-3.5 px-4">Status Ketersediaan</th>
                        <?php if ($isAdmin): ?>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($assets as $ast): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="font-mono font-bold text-xs text-slate-900 block"><?= e($ast['asset_code']) ?></span>
                            <span class="text-[11px] text-slate-400 font-mono">S/N: <?= e($ast['serial_no'] ?: '-') ?></span>
                        </td>
                        <td class="py-4 px-4 min-w-[220px]">
                            <p class="font-bold text-slate-900"><?= e($ast['name']) ?></p>
                            <p class="text-xs text-slate-500"><?= e($ast['brand'] ?? '') ?> <?= e($ast['model'] ?? '') ?></p>
                            <?php if (!empty($ast['notes'])): ?>
                            <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-1 italic"><?= e($ast['notes']) ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-lg bg-slate-100 text-slate-700 border border-slate-200">
                                <?= e($ast['type_name']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded <?= $ast['condition_badge_class'] ?>">
                                <?= e($ast['condition'] ?? 'BAIK') ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border ring-1 <?= $ast['status_badge_class'] ?>">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                <?= e($ast['status']) ?>
                            </span>
                        </td>
                        <?php if ($isAdmin): ?>
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="<?= url('/assets/' . $ast['id'] . '/edit') ?>" 
                                   class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold" title="Kemaskini">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
