<!-- Official Printable Slip: Helpdesk ICT BKP -->
<div class="text-slate-900 space-y-6">
    <!-- Letterhead -->
    <div class="text-center border-b-2 border-slate-900 pb-4">
        <h1 class="text-base font-extrabold uppercase tracking-wider">BAHAGIAN KHIDMAT PENGURUSAN</h1>
        <h2 class="text-sm font-bold uppercase tracking-wide">PEJABAT SETIAUSAHA KERAJAAN NEGERI</h2>
        <h3 class="text-xs font-semibold text-slate-700 uppercase mt-0.5">BORANG PERMOHONAN & SERAHAN PERKHIDMATAN ICT (ICTBKP/AM/2026)</h3>
    </div>

    <!-- Metadata Grid -->
    <div class="grid grid-cols-2 gap-4 text-xs border border-slate-300 p-4 rounded-lg bg-slate-50/50">
        <div>
            <p><span class="font-bold text-slate-700">No. Rujukan:</span> <span class="font-mono font-bold text-sm text-slate-900"><?= e($ticket['reference_no']) ?></span></p>
            <p class="mt-1"><span class="font-bold text-slate-700">Kategori:</span> <?= e($ticket['category_name']) ?></p>
            <p class="mt-1"><span class="font-bold text-slate-700">Status Semasa:</span> <span class="font-bold uppercase"><?= e($ticket['status_label']) ?></span></p>
        </div>
        <div>
            <p><span class="font-bold text-slate-700">Tarikh Permohonan:</span> <?= e($ticket['formatted_created_at']) ?></p>
            <p class="mt-1"><span class="font-bold text-slate-700">Unit Pemohon:</span> <?= e($ticket['unit_short_name']) ?></p>
            <p class="mt-1"><span class="font-bold text-slate-700">No. Telefon:</span> <?= e($ticket['applicant_phone'] ?: '-') ?></p>
        </div>
    </div>

    <!-- Section A: Maklumat Pemohon & Acara -->
    <div class="space-y-2">
        <h4 class="text-xs font-bold uppercase tracking-wider bg-slate-200 px-3 py-1 text-slate-800">
            BAHAGIAN A: MAKLUMAT PEMOHON & PROGRAM / MESYUARAT
        </h4>
        <table class="w-full text-xs border border-slate-300">
            <tr>
                <td class="w-1/4 p-2 font-bold bg-slate-50 border border-slate-300">Nama Pemohon</td>
                <td class="p-2 border border-slate-300"><?= e($ticket['applicant_name']) ?></td>
                <td class="w-1/4 p-2 font-bold bg-slate-50 border border-slate-300">Jawatan</td>
                <td class="p-2 border border-slate-300"><?= e($ticket['applicant_position'] ?? 'Pegawai') ?></td>
            </tr>
            <tr>
                <td class="p-2 font-bold bg-slate-50 border border-slate-300">Tajuk Permohonan</td>
                <td colspan="3" class="p-2 border border-slate-300 font-semibold"><?= e($ticket['title']) ?></td>
            </tr>
            <tr>
                <td class="p-2 font-bold bg-slate-50 border border-slate-300">Tujuan / Justifikasi</td>
                <td colspan="3" class="p-2 border border-slate-300"><?= nl2br(e($ticket['purpose'])) ?></td>
            </tr>
            <tr>
                <td class="p-2 font-bold bg-slate-50 border border-slate-300">Lokasi / Bilik</td>
                <td class="p-2 border border-slate-300"><?= e($ticket['location']) ?></td>
                <td class="p-2 font-bold bg-slate-50 border border-slate-300">Tempoh Tarikh & Masa</td>
                <td class="p-2 border border-slate-300 font-medium">
                    <?= e($ticket['formatted_start_date']) ?> hingga <?= e($ticket['formatted_end_date']) ?><br>
                    (<?= e($ticket['start_time']) ?> - <?= e($ticket['end_time']) ?>)
                </td>
            </tr>
        </table>
    </div>

    <!-- Section B: Senarai Peralatan / Skop Perkhidmatan -->
    <div class="space-y-2">
        <h4 class="text-xs font-bold uppercase tracking-wider bg-slate-200 px-3 py-1 text-slate-800">
            BAHAGIAN B: SENARAI PERALATAN & BUTIRAN PERKHIDMATAN
        </h4>
        <?php if (!empty($assignedAssets)): ?>
        <table class="w-full text-xs border border-slate-300 text-left">
            <thead class="bg-slate-100 font-bold border-b border-slate-300">
                <tr>
                    <th class="p-2 border border-slate-300 w-12 text-center">Bil</th>
                    <th class="p-2 border border-slate-300">Perihal / Nama Aset</th>
                    <th class="p-2 border border-slate-300">No. Kod Aset / Siri</th>
                    <th class="p-2 border border-slate-300 w-28 text-center">Keadaan Serahan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignedAssets as $idx => $ast): ?>
                <tr>
                    <td class="p-2 border border-slate-300 text-center font-bold"><?= $idx + 1 ?></td>
                    <td class="p-2 border border-slate-300">
                        <span class="font-bold"><?= e($ast['name']) ?></span>
                        <span class="block text-[11px] text-slate-600"><?= e($ast['notes'] ?? '') ?></span>
                    </td>
                    <td class="p-2 border border-slate-300 font-mono font-bold">
                        <?= e($ast['asset_code']) ?><br>
                        <span class="text-[10px] text-slate-500 font-normal">S/N: <?= e($ast['serial_no'] ?: '-') ?></span>
                    </td>
                    <td class="p-2 border border-slate-300 text-center font-semibold text-emerald-800">
                        <?= e($ast['condition'] ?? 'BAIK') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="p-3 border border-slate-300 text-xs">
            <p><strong>Peralatan/Servis Dimohon:</strong> <?= implode(', ', $ticket['equipment_names'] ?: [$ticket['category_name']]) ?></p>
            <?php if (!empty($ticket['meeting_platform'])): ?>
            <p class="mt-1"><strong>Platform Mesyuarat:</strong> <?= e($ticket['meeting_platform']) ?> | <strong>Passcode:</strong> <?= e($ticket['meeting_passcode'] ?: '-') ?></p>
            <?php endif; ?>
            <?php if (!empty($ticket['media_scope'])): ?>
            <p class="mt-1"><strong>Skop Media:</strong> <?= e($ticket['media_scope']) ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Section C: Perakuan & Tandatangan Rasmi -->
    <div class="space-y-2 pt-2">
        <h4 class="text-xs font-bold uppercase tracking-wider bg-slate-200 px-3 py-1 text-slate-800">
            BAHAGIAN C: PERAKUAN, SOKONGAN & KELULUSAN RASMI
        </h4>
        <div class="grid grid-cols-3 gap-3 text-xs">
            <!-- Box 1: Pemohon -->
            <div class="border border-slate-300 p-3 flex flex-col justify-between h-40">
                <div>
                    <p class="font-bold text-[11px] uppercase">1. Pengesahan Pemohon</p>
                    <p class="text-[10px] text-slate-600 mt-1">Saya berjanji menjaga peralatan ini dengan selamat dan memulangkannya tepat pada masa.</p>
                </div>
                <div class="border-t border-slate-300 pt-1 text-[11px]">
                    <p class="font-bold"><?= e($ticket['applicant_name']) ?></p>
                    <p class="text-slate-600"><?= e($ticket['formatted_created_at']) ?></p>
                </div>
            </div>

            <!-- Box 2: Ketua Unit -->
            <div class="border border-slate-300 p-3 flex flex-col justify-between h-40">
                <div>
                    <p class="font-bold text-[11px] uppercase">2. Perakuan Ketua Unit</p>
                    <p class="text-[10px] text-slate-600 mt-1">Status: <strong><?= e($ticket['unit_approval']['status'] ?? 'MENUNGGU') ?></strong></p>
                    <?php if (!empty($ticket['unit_approval']['notes'])): ?>
                    <p class="text-[10px] italic text-slate-700 mt-0.5">"<?= e($ticket['unit_approval']['notes']) ?>"</p>
                    <?php endif; ?>
                </div>
                <div class="border-t border-slate-300 pt-1 text-[11px]">
                    <p class="font-bold"><?= e($ticket['unit_approval']['approver_name'] ?? 'Tandatangan & Cop') ?></p>
                    <p class="text-slate-600"><?= format_date($ticket['unit_approval']['action_at'] ?? '') ?></p>
                </div>
            </div>

            <!-- Box 3: Unit ICT BKP -->
            <div class="border border-slate-300 p-3 flex flex-col justify-between h-40">
                <div>
                    <p class="font-bold text-[11px] uppercase">3. Kelulusan Unit ICT BKP</p>
                    <p class="text-[10px] text-slate-600 mt-1">Status: <strong><?= e($ticket['ict_approval']['status'] ?? 'MENUNGGU') ?></strong></p>
                    <?php if (!empty($ticket['ict_approval']['assigned_technician_name'])): ?>
                    <p class="text-[10px] font-semibold text-slate-800">Petugas: <?= e($ticket['ict_approval']['assigned_technician_name']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="border-t border-slate-300 pt-1 text-[11px]">
                    <p class="font-bold"><?= e($ticket['ict_approval']['approver_name'] ?? 'Pegawai ICT BKP') ?></p>
                    <p class="text-slate-600"><?= format_date($ticket['ict_approval']['action_at'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Notice -->
    <div class="text-[10px] text-slate-500 border-t border-slate-300 pt-2 flex justify-between">
        <span>Cetakan Komputer Sistem Helpdesk ICT BKP &bull; Tidak memerlukan tandatangan basah jika telah diluluskan secara digital.</span>
        <span class="font-mono">Muka Surat 1/1</span>
    </div>
</div>
