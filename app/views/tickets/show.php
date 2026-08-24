<?php
use App\Core\Auth;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
$statusKey = $ticket['status'] ?? '';
?>

<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Banner -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2.5 flex-wrap mb-2">
                <span class="px-3 py-1 rounded-lg bg-slate-900 text-white font-mono font-bold text-xs tracking-wider">
                    <?= e($ticket['reference_no']) ?>
                </span>
                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold">
                    <?= e($ticket['category_name']) ?>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border ring-1 <?= $ticket['status_badge_class'] ?>">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    <?= e($ticket['status_label']) ?>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug">
                <?= e($ticket['title']) ?>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Dihantar pada <?= e($ticket['formatted_created_at']) ?> oleh <strong class="text-slate-800"><?= e($ticket['applicant_name']) ?></strong> (<?= e($ticket['unit_short_name']) ?>)
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            <a href="<?= url('/tickets/' . $ticket['id'] . '/print') ?>" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-300 shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Slip Rasmi</span>
            </a>

            <?php if ($ticket['can_cancel']): ?>
            <button onclick="openModal('cancel-modal')" 
                    class="px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold rounded-xl transition-colors">
                Batalkan Permohonan
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stepper Pipeline Progress -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-5">Aliran Kerja & Peringkat Kelulusan</h2>
        
        <?php
        $steps = [
            ['id' => 'SUBMITTED', 'title' => 'Permohonan Dihantar', 'desc' => 'Staf / Pemohon'],
            ['id' => 'UNIT_REVIEW', 'title' => 'Perakuan Unit', 'desc' => 'Ketua Unit'],
            ['id' => 'ICT_REVIEW', 'title' => 'Kelulusan ICT', 'desc' => 'Unit ICT BKP'],
            ['id' => 'EXECUTION', 'title' => 'Penyerahan / Acara', 'desc' => 'Aset Digunakan'],
            ['id' => 'COMPLETED', 'title' => 'Selesai', 'desc' => 'Tamat & Dipulangkan'],
        ];

        // Determine active step index
        $activeIndex = 0;
        if ($statusKey === 'MENUNGGU_SOKONGAN_UNIT') $activeIndex = 1;
        elseif ($statusKey === 'MENUNGGU_KELULUSAN_ICT') $activeIndex = 2;
        elseif ($statusKey === 'DILULUSKAN') $activeIndex = 3;
        elseif ($statusKey === 'SEDANG_BERLANGSUNG') $activeIndex = 3;
        elseif ($statusKey === 'SELESAI') $activeIndex = 4;
        ?>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <?php foreach ($steps as $idx => $step): ?>
            <?php 
                $isDone = ($idx < $activeIndex) || ($statusKey === 'SELESAI');
                $isCurrent = ($idx === $activeIndex) && ($statusKey !== 'SELESAI') && ($statusKey !== 'DITOLAK') && ($statusKey !== 'DIBATALKAN');
            ?>
            <div class="p-3 rounded-xl border <?= $isCurrent ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20' : ($isDone ? 'border-emerald-300 bg-emerald-50/40' : 'border-slate-200 bg-slate-50/60') ?>">
                <div class="flex items-center gap-2 mb-1">
                    <?php if ($isDone): ?>
                    <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shrink-0">&check;</span>
                    <?php elseif ($isCurrent): ?>
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shrink-0 animate-pulse"><?= $idx + 1 ?></span>
                    <?php else: ?>
                    <span class="w-5 h-5 rounded-full bg-slate-300 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0"><?= $idx + 1 ?></span>
                    <?php endif; ?>
                    <p class="text-xs font-bold text-slate-800 truncate"><?= e($step['title']) ?></p>
                </div>
                <p class="text-[11px] text-slate-500 pl-7"><?= e($step['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Main Content Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left 2 Cols: Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event & General Information Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Butiran Acara & Permohonan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-semibold uppercase tracking-wider block mb-1">Lokasi / Tempat</span>
                        <span class="font-bold text-slate-800 text-sm"><?= e($ticket['location']) ?></span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold uppercase tracking-wider block mb-1">Tempoh Tarikh & Masa</span>
                        <span class="font-bold text-slate-800 text-sm block"><?= e($ticket['formatted_start_date']) ?> <?= ($ticket['start_date'] !== $ticket['end_date']) ? ' hingga ' . e($ticket['formatted_end_date']) : '' ?></span>
                        <span class="text-slate-500 font-medium"><?= e($ticket['start_time']) ?> - <?= e($ticket['end_time']) ?></span>
                    </div>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-xs block mb-1">Tujuan & Justifikasi</span>
                    <p class="text-xs text-slate-700 bg-slate-50 p-3.5 rounded-xl border border-slate-100 leading-relaxed">
                        <?= nl2br(e($ticket['purpose'])) ?>
                    </p>
                </div>

                <?php if (!empty($ticket['remarks'])): ?>
                <div>
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-xs block mb-1">Catatan Tambahan</span>
                    <p class="text-xs text-slate-600 italic"><?= e($ticket['remarks']) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Category Specific Card: Equipment, Meeting or Media -->
            <?php if ($ticket['category'] === 'PEMINJAMAN_ASET'): ?>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Peralatan Yang Dimohon & Diperuntukkan</h2>
                    <span class="px-2.5 py-0.5 text-xs bg-blue-50 text-blue-700 font-semibold rounded-lg">Inventori ICT</span>
                </div>

                <div class="space-y-3">
                    <p class="text-xs text-slate-500 font-medium">Jenis Peralatan Dimohon:</p>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($ticket['equipment_names'] as $eqName): ?>
                        <span class="px-3 py-1 bg-slate-100 text-slate-800 text-xs font-semibold rounded-lg border border-slate-200">
                            <?= e($eqName) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($assignedAssets)): ?>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs text-emerald-800 font-bold uppercase tracking-wider mb-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Aset Fizikal Yang Telah Diperuntukkan Rasmi:
                        </p>
                        <div class="space-y-2">
                            <?php foreach ($assignedAssets as $asset): ?>
                            <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-200 flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-slate-900 block"><?= e($asset['name']) ?></span>
                                    <span class="font-mono text-emerald-700 font-semibold text-[11px]"><?= e($asset['asset_code']) ?></span>
                                    <span class="text-slate-500 text-[11px]"> &bull; S/N: <?= e($asset['serial_no'] ?: 'N/A') ?></span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-white text-emerald-700 border border-emerald-300">
                                    <?= e($asset['status']) ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($ticket['category'] === 'SOKONGAN_MESYUARAT'): ?>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Konfigurasi Mesyuarat Online & Teknikal</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Mod Mesyuarat</span>
                        <span class="font-bold text-slate-800"><?= e($ticket['meeting_type'] ?? '-') ?></span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Platform Digunakan</span>
                        <span class="font-bold text-slate-800"><?= e($ticket['meeting_platform'] ?? '-') ?></span>
                    </div>
                    <?php if (!empty($ticket['meeting_link'])): ?>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Pautan Jemputan Mesyuarat</span>
                        <a href="<?= e($ticket['meeting_link']) ?>" target="_blank" class="text-blue-600 font-mono text-xs hover:underline break-all">
                            <?= e($ticket['meeting_link']) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($ticket['meeting_passcode'])): ?>
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Passcode Bilik</span>
                        <span class="font-mono font-bold text-slate-800"><?= e($ticket['meeting_passcode']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($ticket['vip_attendees'])): ?>
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Tetamu VIP / Kenamaan</span>
                        <span class="font-medium text-slate-800"><?= e($ticket['vip_attendees']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($ticket['category'] === 'MEDIA_JURUKAMERA'): ?>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Skop Liputan Media & Fotografi</h2>
                </div>
                <div class="text-xs space-y-3">
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Skop Perkhidmatan</span>
                        <span class="font-bold text-slate-800 text-sm"><?= e($ticket['media_scope'] ?? '-') ?></span>
                    </div>
                    <?php if (!empty($ticket['event_agenda'])): ?>
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Tentatif Program</span>
                        <p class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-slate-700 leading-relaxed">
                            <?= nl2br(e($ticket['event_agenda'])) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Audit Trail & Action Timeline -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Jejak Audit & Rekod Tindakan</h2>
                
                <div class="relative pl-6 space-y-5 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    <?php foreach ($auditTrail as $audit): ?>
                    <div class="relative text-xs">
                        <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-blue-600 border-2 border-white ring-2 ring-blue-100"></div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-bold text-slate-800"><?= e($audit['user_name']) ?></span>
                            <span class="text-[11px] text-slate-400"><?= format_datetime($audit['created_at']) ?></span>
                        </div>
                        <p class="text-slate-600 mt-0.5"><?= e($audit['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Applicant Details & Workflow Actions -->
        <div class="space-y-6">
            <!-- Applicant Info Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Maklumat Pemohon</h3>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-sm ring-4 ring-slate-100">
                        <?= strtoupper(substr($ticket['applicant_name'] ?? 'U', 0, 2)) ?>
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-slate-900 text-sm truncate"><?= e($ticket['applicant_name']) ?></p>
                        <p class="text-xs text-slate-500 truncate"><?= e($ticket['applicant_position'] ?? 'Pegawai') ?></p>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Unit / Bahagian:</span>
                        <span class="font-semibold text-slate-800"><?= e($ticket['unit_short_name']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Emel:</span>
                        <span class="font-medium text-slate-800 truncate max-w-[170px]"><?= e($ticket['applicant_email']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Telefon:</span>
                        <span class="font-semibold text-slate-800"><?= e($ticket['applicant_phone'] ?: '-') ?></span>
                    </div>
                </div>
            </div>

            <!-- Approval Status Summary -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4 text-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Perakuan & Kelulusan</h3>

                <!-- Unit Level -->
                <div class="p-3.5 rounded-xl border <?= ($ticket['unit_approval']['status'] === 'APPROVED') ? 'border-emerald-200 bg-emerald-50/50' : (($ticket['unit_approval']['status'] === 'REJECTED') ? 'border-rose-200 bg-rose-50/50' : 'border-amber-200 bg-amber-50/50') ?>">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-bold text-slate-800">1. Perakuan Ketua Unit</span>
                        <span class="font-bold <?= ($ticket['unit_approval']['status'] === 'APPROVED') ? 'text-emerald-700' : (($ticket['unit_approval']['status'] === 'REJECTED') ? 'text-rose-700' : 'text-amber-700') ?>">
                            <?= e($ticket['unit_approval']['status']) ?>
                        </span>
                    </div>
                    <?php if (!empty($ticket['unit_approval']['approver_name'])): ?>
                    <p class="text-slate-600 text-[11px]">Oleh: <?= e($ticket['unit_approval']['approver_name']) ?></p>
                    <p class="text-slate-500 text-[10px] mt-0.5">Masa: <?= format_datetime($ticket['unit_approval']['action_at']) ?></p>
                    <?php if (!empty($ticket['unit_approval']['notes'])): ?>
                    <p class="mt-1 text-slate-700 italic bg-white/70 p-1.5 rounded">"<?= e($ticket['unit_approval']['notes']) ?>"</p>
                    <?php endif; ?>
                    <?php else: ?>
                    <p class="text-slate-500 text-[11px]">Menunggu perakuan rasmi Ketua Unit.</p>
                    <?php endif; ?>
                </div>

                <!-- ICT Level -->
                <div class="p-3.5 rounded-xl border <?= ($ticket['ict_approval']['status'] === 'APPROVED') ? 'border-emerald-200 bg-emerald-50/50' : (($ticket['ict_approval']['status'] === 'REJECTED') ? 'border-rose-200 bg-rose-50/50' : 'border-blue-200 bg-blue-50/50') ?>">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-bold text-slate-800">2. Kelulusan ICT BKP</span>
                        <span class="font-bold <?= ($ticket['ict_approval']['status'] === 'APPROVED') ? 'text-emerald-700' : (($ticket['ict_approval']['status'] === 'REJECTED') ? 'text-rose-700' : 'text-blue-700') ?>">
                            <?= e($ticket['ict_approval']['status']) ?>
                        </span>
                    </div>
                    <?php if (!empty($ticket['ict_approval']['approver_name'])): ?>
                    <p class="text-slate-600 text-[11px]">Oleh: <?= e($ticket['ict_approval']['approver_name']) ?></p>
                    <?php if (!empty($ticket['ict_approval']['assigned_technician_name'])): ?>
                    <p class="text-slate-700 font-semibold text-[11px]">Petugas ICT: <?= e($ticket['ict_approval']['assigned_technician_name']) ?></p>
                    <?php endif; ?>
                    <p class="text-slate-500 text-[10px] mt-0.5">Masa: <?= format_datetime($ticket['ict_approval']['action_at']) ?></p>
                    <?php if (!empty($ticket['ict_approval']['notes'])): ?>
                    <p class="mt-1 text-slate-700 italic bg-white/70 p-1.5 rounded">"<?= e($ticket['ict_approval']['notes']) ?>"</p>
                    <?php endif; ?>
                    <?php else: ?>
                    <p class="text-slate-500 text-[11px]">Menunggu kelulusan Unit ICT BKP.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ACTION AREA 1: Ketua Unit Review -->
            <?php if ($ticket['can_approve_unit']): ?>
            <div class="bg-amber-50 rounded-2xl border-2 border-amber-300 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2 text-amber-900">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h3 class="text-sm font-bold">Tindakan Ketua Unit / Penyelia</h3>
                </div>
                <p class="text-xs text-amber-800">
                    Sila buat semakan dan berikan sokongan sebelum permohonan dimajukan ke Unit ICT BKP.
                </p>

                <!-- Approve Unit Form -->
                <form action="<?= url("/approvals/{$ticket['id']}/unit-approve") ?>" method="POST" class="space-y-3">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-[11px] font-bold text-amber-950 uppercase mb-1">Catatan Sokongan</label>
                        <textarea name="notes" rows="2" placeholder="Cth: Permohonan disokong untuk majlis rasmi unit."
                                  class="w-full p-2.5 text-xs bg-white border border-amber-300 rounded-xl outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm">
                        &check; Sokong / Perakukan Permohonan
                    </button>
                </form>

                <!-- Reject Unit Form -->
                <form action="<?= url("/approvals/{$ticket['id']}/unit-reject") ?>" method="POST" class="pt-2 border-t border-amber-200">
                    <?= csrf_field() ?>
                    <button type="button" onclick="openModal('reject-unit-modal')" class="w-full py-2 bg-rose-100 hover:bg-rose-200 text-rose-800 font-semibold text-xs rounded-xl transition-colors">
                        &times; Tolak Permohonan
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- ACTION AREA 2: ICT BKP Approval & Asset Assignment -->
            <?php if ($ticket['can_approve_ict']): ?>
            <div class="bg-blue-50 rounded-2xl border-2 border-blue-300 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2 text-blue-900">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <h3 class="text-sm font-bold">Kelulusan & Peruntukan ICT BKP</h3>
                </div>

                <form action="<?= url("/approvals/{$ticket['id']}/ict-approve") ?>" method="POST" class="space-y-4 text-xs">
                    <?= csrf_field() ?>

                    <?php if ($ticket['category'] === 'PEMINJAMAN_ASET'): ?>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1.5 uppercase tracking-wider text-[11px]">
                            Peruntukkan Aset Fizikal:
                        </label>
                        <div class="space-y-1.5 max-h-48 overflow-y-auto p-2 bg-white rounded-xl border border-blue-200">
                            <?php foreach ($availableAssets as $asset): ?>
                            <label class="flex items-center gap-2 p-1.5 hover:bg-slate-50 rounded text-[11px] cursor-pointer">
                                <input type="checkbox" name="assigned_asset_ids[]" value="<?= $asset['id'] ?>" class="rounded text-blue-600">
                                <div>
                                    <span class="font-bold text-slate-900"><?= e($asset['name']) ?></span>
                                    <span class="font-mono text-blue-700">(<?= e($asset['asset_code']) ?>)</span>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="block font-bold text-slate-800 mb-1 uppercase tracking-wider text-[11px]">
                            Petugas ICT Yang Ditugaskan:
                        </label>
                        <select name="assigned_technician_id" class="w-full p-2 bg-white border border-blue-200 rounded-xl outline-none">
                            <option value="">-- Tiada Petugas Khas / Pengambilan Sendiri --</option>
                            <?php foreach ($ictStaff as $staff): ?>
                            <option value="<?= $staff['id'] ?>"><?= e($staff['name']) ?> (<?= e($staff['position']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 mb-1 uppercase tracking-wider text-[11px]">Catatan Kelulusan</label>
                        <textarea name="notes" rows="2" placeholder="Cth: Diluluskan. Sila ambil di Kaunter ICT." 
                                  class="w-full p-2 bg-white border border-blue-200 rounded-xl outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm">
                        &check; Sah & Luluskan Permohonan
                    </button>
                </form>

                <form action="<?= url("/approvals/{$ticket['id']}/ict-reject") ?>" method="POST" class="pt-2 border-t border-blue-200">
                    <?= csrf_field() ?>
                    <button type="button" onclick="openModal('reject-ict-modal')" class="w-full py-2 bg-rose-100 hover:bg-rose-200 text-rose-800 font-semibold text-xs rounded-xl">
                        &times; Tolak Permohonan ICT
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- ACTION AREA 3: Handover & Return -->
            <?php if ($ticket['can_handover']): ?>
            <div class="bg-indigo-50 rounded-2xl border-2 border-indigo-300 p-6 shadow-sm space-y-3 text-xs">
                <h3 class="text-sm font-bold text-indigo-950">Serahan Peralatan Kepada Pemohon</h3>
                <p class="text-indigo-800">Sahkan bahawa peralatan telah diserahkan dan diterima oleh pemohon.</p>
                <form action="<?= url("/approvals/{$ticket['id']}/handover") ?>" method="POST" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="text" name="handover_notes" placeholder="Catatan serahan (cth: Diambil oleh En Faiz)" 
                           class="w-full p-2 bg-white border border-indigo-200 rounded-xl outline-none text-xs">
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl">
                        Sahkan Penyerahan Aset
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <?php if ($ticket['can_return']): ?>
            <div class="bg-teal-50 rounded-2xl border-2 border-teal-300 p-6 shadow-sm space-y-3 text-xs">
                <h3 class="text-sm font-bold text-teal-950">Pengesahan Pemulangan & Penutupan</h3>
                <p class="text-teal-800">Sahkan pemulangan peralatan dan keadaan fizikal aset ke dalam inventori.</p>
                <form action="<?= url("/approvals/{$ticket['id']}/return") ?>" method="POST" class="space-y-3">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block font-bold text-teal-950 mb-1">Keadaan Aset Dipulangkan:</label>
                        <select name="condition" class="w-full p-2 bg-white border border-teal-200 rounded-xl outline-none">
                            <option value="BAIK">BAIK (Sempurna & Berfungsi)</option>
                            <option value="SEDERHANA">SEDERHANA (Terdapat Calar/Kotor)</option>
                            <option value="PERLU_SERVIS">PERLU PENYELENGGARAAN / ROSAK</option>
                        </select>
                    </div>
                    <input type="text" name="return_notes" placeholder="Catatan pemeriksaan fizikal..." 
                           class="w-full p-2 bg-white border border-teal-200 rounded-xl outline-none text-xs">
                    <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl">
                        &check; Sahkan Pemulangan & Tutup Rekod
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal: Cancel Ticket -->
<div id="cancel-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-2">Batalkan Permohonan</h3>
        <p class="text-xs text-slate-600 mb-4">Adakah anda pasti ingin membatalkan permohonan ini? Tindakan ini tidak boleh diundur semula.</p>
        <form action="<?= url("/tickets/{$ticket['id']}/cancel") ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="text" name="reason" required placeholder="Nyatakan sebab pembatalan..." 
                   class="w-full p-2.5 text-xs bg-slate-50 border border-slate-300 rounded-xl outline-none">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('cancel-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg">Sahkan Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reject Unit -->
<div id="reject-unit-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-2">Tolak Permohonan (Peringkat Unit)</h3>
        <p class="text-xs text-slate-600 mb-4">Sila masukkan ulasan atau justifikasi mengapa permohonan ini tidak disokong.</p>
        <form action="<?= url("/approvals/{$ticket['id']}/unit-reject") ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <textarea name="notes" required rows="3" placeholder="Sebab penolakan..." 
                      class="w-full p-2.5 text-xs bg-slate-50 border border-slate-300 rounded-xl outline-none"></textarea>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('reject-unit-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg">Sahkan Tolak</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reject ICT -->
<div id="reject-ict-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-2">Tolak Permohonan (Unit ICT BKP)</h3>
        <p class="text-xs text-slate-600 mb-4">Sila nyatakan justifikasi rasmi penolakan oleh Unit ICT.</p>
        <form action="<?= url("/approvals/{$ticket['id']}/ict-reject") ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <textarea name="notes" required rows="3" placeholder="Sebab penolakan..." 
                      class="w-full p-2.5 text-xs bg-slate-50 border border-slate-300 rounded-xl outline-none"></textarea>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('reject-ict-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg">Sahkan Tolak</button>
            </div>
        </form>
    </div>
</div>
