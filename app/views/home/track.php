<?php
use App\Core\Auth;

$ticketFound = !empty($ticket);
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Header Search Bar (Clean Light Corporate Theme) -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-md">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Semakan Status No. Tiket</h1>
                <p class="text-xs text-slate-500 mt-1">Status terkini kelulusan dan aliran kerja permohonan ICT BKP</p>
            </div>
            <a href="<?= url('/tickets/create') ?>" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                + Borang Permohonan Baru &rarr;
            </a>
        </div>

        <form action="<?= url('/track') ?>" method="GET" class="flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="ref" value="<?= e($refNo ?? '') ?>" required 
                       placeholder="Cth: ICTBKP/2026/08/0001 atau 0001" 
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-300 text-slate-900 rounded-2xl placeholder-slate-400 font-mono font-bold text-xs sm:text-sm outline-none focus:border-blue-500 focus:bg-white transition-all">
            </div>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-2xl shadow-md transition-all flex items-center justify-center gap-2">
                <span>Cari Status</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>
    </div>

    <?php if (!$ticketFound): ?>
    <!-- Not Found State -->
    <div class="bg-white rounded-3xl p-12 text-center text-slate-700 shadow-md border border-slate-200">
        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900">Rekod Permohonan Tidak Dijumpai</h2>
        <p class="text-xs text-slate-500 max-w-md mx-auto mt-2 leading-relaxed">
            Tiada permohonan yang sepadan dengan nombor rujukan <strong class="font-mono text-slate-900 font-bold"><?= e($refNo ?? '') ?></strong>. Sila semak semula No. Tiket anda atau buat permohonan baru.
        </p>
        <div class="mt-6 flex justify-center gap-3">
            <a href="<?= url('/tickets/create') ?>" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow">
                + Buat Permohonan Baru
            </a>
        </div>
    </div>
    <?php else: ?>
    <!-- Ticket Result Details Card -->
    <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-lg border border-slate-200 space-y-8">
        <!-- Top Status Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-mono font-extrabold text-sm sm:text-base text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                        <?= e($ticket['reference_no']) ?>
                    </span>
                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-slate-100 text-slate-700 border border-slate-200">
                        <?= e($ticket['category_name']) ?>
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    <?= e($ticket['title']) ?>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Dihantar pada <?= e($ticket['formatted_created_at'] ?? format_datetime($ticket['created_at'])) ?></p>
            </div>

            <div class="flex flex-col sm:items-end gap-2">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold ring-1 border <?= $ticket['status_badge_class'] ?>">
                    <span class="w-2 h-2 rounded-full bg-current"></span>
                    <?= e($ticket['status_label']) ?>
                </span>
                
                <a href="<?= url('/tickets/' . $ticket['id'] . '/print') ?>" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg border border-slate-300 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Cetak Slip Rasmi</span>
                </a>
            </div>
        </div>

        <!-- Stepper Timeline -->
        <div class="py-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6">Carta Alir Status & Kelulusan</h3>
            <div class="relative flex flex-col md:flex-row justify-between gap-4">
                <!-- Step 1: Dihantar -->
                <div class="flex-1 flex md:flex-col items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-md">
                        ✓
                    </div>
                    <div>
                        <p class="font-bold text-xs text-slate-900">1. Dihantar</p>
                        <p class="text-[11px] text-slate-500">Permohonan didaftarkan</p>
                    </div>
                </div>

                <!-- Step 2: Sokongan Ketua Unit -->
                <?php 
                $uStatus = $ticket['unit_approval']['status'] ?? 'PENDING';
                $uColor = ($uStatus === 'APPROVED') ? 'bg-emerald-600 text-white' : (($uStatus === 'REJECTED') ? 'bg-rose-600 text-white' : 'bg-amber-500 text-white');
                ?>
                <div class="flex-1 flex md:flex-col items-start gap-3">
                    <div class="w-9 h-9 rounded-full <?= $uColor ?> font-bold flex items-center justify-center text-xs shrink-0 shadow-md">
                        <?= ($uStatus === 'APPROVED') ? '✓' : (($uStatus === 'REJECTED') ? '✗' : '2') ?>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-slate-900">2. Perakuan Ketua Unit</p>
                        <p class="text-[11px] text-slate-500">
                            <?= ($uStatus === 'APPROVED') ? 'Disokong' : (($uStatus === 'REJECTED') ? 'Ditolak' : 'Menunggu Sokongan') ?>
                        </p>
                        <?php if (!empty($ticket['unit_approval']['approver_name'])): ?>
                        <p class="text-[10px] text-slate-400 mt-0.5"><?= e($ticket['unit_approval']['approver_name']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Step 3: Kelulusan ICT BKP -->
                <?php 
                $ictStatus = $ticket['ict_approval']['status'] ?? 'PENDING';
                $ictColor = ($ictStatus === 'APPROVED') ? 'bg-emerald-600 text-white' : (($ictStatus === 'REJECTED') ? 'bg-rose-600 text-white' : ($uStatus === 'APPROVED' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500'));
                ?>
                <div class="flex-1 flex md:flex-col items-start gap-3">
                    <div class="w-9 h-9 rounded-full <?= $ictColor ?> font-bold flex items-center justify-center text-xs shrink-0 shadow-md">
                        <?= ($ictStatus === 'APPROVED') ? '✓' : (($ictStatus === 'REJECTED') ? '✗' : '3') ?>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-slate-900">3. Kelulusan ICT BKP</p>
                        <p class="text-[11px] text-slate-500">
                            <?= ($ictStatus === 'APPROVED') ? 'Diluluskan' : (($ictStatus === 'REJECTED') ? 'Ditolak' : 'Menunggu Kelulusan') ?>
                        </p>
                        <?php if (!empty($ticket['ict_approval']['approver_name'])): ?>
                        <p class="text-[10px] text-blue-600 font-semibold mt-0.5"><?= e($ticket['ict_approval']['approver_name']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Step 4: Serahan & Selesai -->
                <?php 
                $isCompleted = in_array($ticket['status'], ['SELESAI', 'DIPULANGKAN']);
                $isOngoing = in_array($ticket['status'], ['SEDANG_BERLANGSUNG', 'DIPINJAM']);
                $step4Color = $isCompleted ? 'bg-emerald-600 text-white' : ($isOngoing ? 'bg-blue-600 text-white animate-pulse' : 'bg-slate-200 text-slate-500');
                ?>
                <div class="flex-1 flex md:flex-col items-start gap-3">
                    <div class="w-9 h-9 rounded-full <?= $step4Color ?> font-bold flex items-center justify-center text-xs shrink-0 shadow-md">
                        <?= $isCompleted ? '✓' : '4' ?>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-slate-900">4. Serahan & Selesai</p>
                        <p class="text-[11px] text-slate-500">
                            <?= $isCompleted ? 'Selesai / Dipulangkan' : ($isOngoing ? 'Sedang Digunakan' : 'Menunggu Serahan') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 text-xs">
            <!-- Left Info -->
            <div class="space-y-3 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Maklumat Pemohon & Acara</h4>
                <div class="space-y-2">
                    <div class="flex justify-between py-1 border-b border-slate-200">
                        <span class="text-slate-500">Nama Pemohon:</span>
                        <span class="font-bold text-slate-900"><?= e($ticket['applicant_name']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200">
                        <span class="text-slate-500">Unit / Bahagian:</span>
                        <span class="font-bold text-slate-900"><?= e($ticket['unit_short_name'] ?? $ticket['unit_name']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200">
                        <span class="text-slate-500">Jawatan:</span>
                        <span class="font-medium text-slate-900"><?= e($ticket['applicant_position'] ?? '-') ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200">
                        <span class="text-slate-500">Tarikh Program:</span>
                        <span class="font-bold text-slate-900"><?= e($ticket['formatted_start_date']) ?> - <?= e($ticket['formatted_end_date']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200">
                        <span class="text-slate-500">Masa Acara:</span>
                        <span class="font-bold text-slate-900"><?= e($ticket['start_time']) ?> - <?= e($ticket['end_time']) ?></span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Lokasi:</span>
                        <span class="font-bold text-slate-900"><?= e($ticket['location']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Right Info -->
            <div class="space-y-3 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Keperluan & Catatan</h4>
                <div>
                    <span class="text-slate-500 block mb-1">Tujuan / Catatan Permohonan:</span>
                    <p class="font-medium text-slate-800 leading-relaxed bg-white p-3 rounded-xl border border-slate-200">
                        <?= nl2br(e($ticket['purpose'] ?: 'Tiada catatan khusus.')) ?>
                    </p>
                </div>

                <?php if (!empty($ticket['assigned_asset_ids'])): ?>
                <div class="pt-2">
                    <span class="text-slate-500 block mb-1">Aset Fizikal Yang Diperuntukkan:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <?php foreach ($ticket['assigned_asset_ids'] as $astId): ?>
                        <span class="px-2.5 py-1 bg-blue-100 text-blue-800 font-mono font-bold rounded-lg text-[10px] border border-blue-200">
                            <?= e($astId) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($ticket['meeting_link'])): ?>
                <div class="pt-2">
                    <span class="text-slate-500 block mb-1">Pautan Mesyuarat:</span>
                    <a href="<?= e($ticket['meeting_link']) ?>" target="_blank" class="text-blue-600 underline font-semibold truncate block">
                        <?= e($ticket['meeting_link']) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
