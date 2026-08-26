<?php
use App\Core\Auth;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
?>

<div class="space-y-6">
    <!-- Header & Action Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Direktori Permohonan ICT</h1>
            <p class="text-xs text-slate-500 mt-1">Senarai lengkap permohonan peminjaman aset, sokongan mesyuarat dan media</p>
        </div>
        <a href="<?= url('/tickets/create') ?>" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>+ Permohonan Baru</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="GET" action="<?= url('/tickets') ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <input type="text" name="search" value="<?= e($filters['search'] ?? '') ?>" 
                       placeholder="Cari No. Rujukan, tajuk, atau nama pemohon..." 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs outline-none">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs outline-none">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $catKey => $cat): ?>
                    <option value="<?= $catKey ?>" <?= (($filters['category'] ?? '') === $catKey) ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs outline-none">
                    <option value="">Semua Status</option>
                    <?php foreach ($statuses as $stKey => $st): ?>
                    <option value="<?= $stKey ?>" <?= (($filters['status'] ?? '') === $stKey) ? 'selected' : '' ?>>
                        <?= e($st['label']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs rounded-xl shadow-sm transition-colors">
                    Tapis
                </button>
                <a href="<?= url('/tickets') ?>" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold" title="Set Semula">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <?php if (empty($paginated['data'])): ?>
        <div class="p-16 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Tiada Permohonan Dijumpai</h3>
            <p class="text-xs text-slate-500 mt-1">Cuba laraskan kata kunci atau tapisan carian anda di atas.</p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/90 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200/80 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">No. Rujukan & Tarikh</th>
                        <th class="py-3.5 px-4">Kategori & Butiran</th>
                        <th class="py-3.5 px-4">Pemohon & Unit</th>
                        <th class="py-3.5 px-4">Tarikh Tempahan</th>
                        <th class="py-3.5 px-4">Status Terkini</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($paginated['data'] as $t): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="font-mono font-bold text-xs text-slate-900 block"><?= e($t['reference_no']) ?></span>
                            <span class="text-[11px] text-slate-500"><?= e($t['formatted_created_at']) ?></span>
                        </td>
                        <td class="py-4 px-4 min-w-[240px]">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded bg-blue-50 text-blue-700 border border-blue-100 mb-1">
                                <?= e($t['category_name']) ?>
                            </span>
                            <p class="font-bold text-slate-900 line-clamp-1"><?= e($t['title']) ?></p>
                            <p class="text-xs text-slate-500 line-clamp-1"><?= e($t['location']) ?></p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-medium text-slate-900 text-xs"><?= e($t['applicant_name']) ?></p>
                            <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                <?= e($t['unit_short_name']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap text-xs">
                            <span class="font-semibold text-slate-900 block"><?= e($t['formatted_start_date']) ?></span>
                            <span class="text-[11px] text-slate-500"><?= e($t['start_time']) ?> - <?= e($t['end_time']) ?></span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border ring-1 <?= $t['status_badge_class'] ?>">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                <?= e($t['status_label']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="<?= url('/tickets/' . $t['id']) ?>" 
                                   class="px-3 py-1.5 bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-semibold rounded-lg border border-slate-200 hover:border-blue-200 transition-all">
                                    Papar
                                </a>
                                <a href="<?= url('/tickets/' . $t['id'] . '/print') ?>" target="_blank"
                                   class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg border border-slate-200 transition-all" title="Cetak Slip Rasmi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>
                                <?php if (($user['email'] ?? '') === 'farhah@johor.gov.my'): ?>
                                <form action="<?= url('/tickets/' . $t['id'] . '/delete') ?>" method="POST" class="inline" onsubmit="return confirm('AMARAN PENTADBIR: Adakah anda pasti ingin memadam permohonan <?= e($t['reference_no']) ?> secara kekal? Rekod ini tidak boleh diundur semula.');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-semibold rounded-lg border border-rose-200 hover:border-rose-600 transition-all" title="Padam Permohonan (Khusus Pentadbir Farhah)">
                                        Padam
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

        <!-- Pagination Controls -->
        <?php if ($paginated['last_page'] > 1): ?>
        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-500">
            <div>
                Menunjukkan <span class="font-semibold text-slate-800"><?= $paginated['from'] ?></span> hingga <span class="font-semibold text-slate-800"><?= $paginated['to'] ?></span> daripada <span class="font-semibold text-slate-800"><?= $paginated['total'] ?></span> permohonan
            </div>
            <div class="flex items-center gap-1.5">
                <?php for ($p = 1; $p <= $paginated['last_page']; $p++): ?>
                <a href="<?= url('/tickets?page=' . $p . '&search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($filters['category'] ?? '') . '&status=' . urlencode($filters['status'] ?? '')) ?>" 
                   class="px-3 py-1.5 rounded-lg border font-semibold text-xs <?= ($p === $paginated['current_page']) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' ?>">
                    <?= $p ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>
