<!-- Official Printable Slip: Helpdesk ICT BKP -->
<?php if ($ticket['category'] === 'PEMINJAMAN_ASET'): ?>
<!-- ========================================================================= -->
<!-- FORMAT RASMI KEW.PA-9 (Pekeliling Perbendaharaan Malaysia AM 2.4 Lampiran A) -->
<!-- ========================================================================= -->
<div class="text-slate-900 space-y-4 font-sans text-xs">
    <!-- Header Kew.PA-9 -->
    <div class="flex justify-between items-start text-[11px]">
        <div class="font-normal text-slate-700">
            Pekeliling Perbendaharaan Malaysia
        </div>
        <div class="text-right">
            <span>AM 2.4 Lampiran A</span>
            <strong class="text-sm font-bold block mt-0.5 text-slate-900">KEW.PA-9</strong>
        </div>
    </div>

    <div class="text-right text-[11px] pt-1">
        No. Permohonan: <span class="font-mono font-bold text-slate-900"><?= e($ticket['reference_no']) ?></span>
    </div>

    <!-- Title -->
    <div class="text-center py-1">
        <h1 class="text-sm font-black uppercase tracking-wide text-slate-900">BORANG PERMOHONAN PERGERAKAN/ PINJAMAN ASET ALIH</h1>
    </div>

    <!-- Header Table: Nama Pemohon, Tujuan, Tempat Digunakan, dsb. -->
    <table class="w-full border-collapse border border-slate-900 text-xs">
        <tr>
            <td class="border border-slate-900 p-2.5 w-32 font-semibold bg-slate-50">Nama Pemohon:</td>
            <td class="border border-slate-900 p-2.5 font-bold w-[35%]"><?= e($ticket['applicant_name']) ?></td>
            <td class="border border-slate-900 p-2.5 w-32 font-semibold bg-slate-50">Tujuan:</td>
            <td class="border border-slate-900 p-2.5"><?= nl2br(e($ticket['purpose'])) ?></td>
        </tr>
        <tr>
            <td class="border border-slate-900 p-2.5 font-semibold bg-slate-50">Jawatan:</td>
            <td class="border border-slate-900 p-2.5"><?= e($ticket['applicant_position'] ?? 'Pegawai') ?></td>
            <td class="border border-slate-900 p-2.5 font-semibold bg-slate-50">Tempat Digunakan:</td>
            <td class="border border-slate-900 p-2.5 font-bold"><?= e($ticket['location']) ?></td>
        </tr>
        <tr>
            <td class="border border-slate-900 p-2.5 font-semibold bg-slate-50">Bahagian:</td>
            <td class="border border-slate-900 p-2.5"><?= e($ticket['unit_name']) ?></td>
            <td class="border border-slate-900 p-2.5 font-semibold bg-slate-50">Nama Pengeluar:</td>
            <td class="border border-slate-900 p-2.5"><?= e($ticket['ict_approval']['approver_name'] ?? 'Seksyen ICT BKP') ?></td>
        </tr>
    </table>

    <!-- Table of Assets (Format KEW.PA-9) -->
    <table class="w-full border-collapse border border-slate-900 text-[11px] text-center mt-2">
        <thead class="bg-slate-100 font-bold">
            <tr>
                <th rowspan="2" class="border border-slate-900 p-1.5 w-8">Bil</th>
                <th rowspan="2" class="border border-slate-900 p-1.5 w-36">No. Siri Pendaftaran</th>
                <th rowspan="2" class="border border-slate-900 p-1.5">Keterangan Aset</th>
                <th colspan="2" class="border border-slate-900 p-1">Tarikh</th>
                <th rowspan="2" class="border border-slate-900 p-1 w-20">(Lulus / Tidak Lulus)</th>
                <th colspan="2" class="border border-slate-900 p-1">Tarikh</th>
                <th rowspan="2" class="border border-slate-900 p-1.5 w-24">Catatan</th>
            </tr>
            <tr>
                <th class="border border-slate-900 p-1 w-20 font-medium">Peminjam</th>
                <th class="border border-slate-900 p-1 w-20 font-medium">Dijangka Pulang</th>
                <th class="border border-slate-900 p-1 w-20 font-medium">Dipulangkan</th>
                <th class="border border-slate-900 p-1 w-20 font-medium">Diterima</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($assignedAssets)): ?>
                <?php foreach ($assignedAssets as $idx => $ast): ?>
                <tr>
                    <td class="border border-slate-900 p-2 font-bold"><?= $idx + 1 ?></td>
                    <td class="border border-slate-900 p-2 font-mono text-[10px] text-left">
                        <strong><?= e($ast['asset_code']) ?></strong><br>
                        <span class="text-slate-600 font-normal">S/N: <?= e($ast['serial_no'] ?: '-') ?></span>
                    </td>
                    <td class="border border-slate-900 p-2 text-left">
                        <strong class="text-xs"><?= e($ast['name']) ?></strong>
                        <span class="block text-[10px] text-slate-600"><?= e($ast['notes'] ?? '') ?></span>
                    </td>
                    <td class="border border-slate-900 p-2"><?= e($ticket['formatted_start_date']) ?></td>
                    <td class="border border-slate-900 p-2 font-semibold"><?= e($ticket['formatted_end_date']) ?></td>
                    <td class="border border-slate-900 p-2 font-bold <?= ($ticket['status'] === 'DITOLAK') ? 'text-rose-600' : 'text-emerald-700' ?>">
                        <?= in_array($ticket['status'], ['DILULUSKAN', 'SEDANG_BERLANGSUNG', 'SELESAI']) ? 'LULUS' : (in_array($ticket['status'], ['DITOLAK']) ? 'TIDAK LULUS' : 'MENUNGGU') ?>
                    </td>
                    <td class="border border-slate-900 p-2"><?= ($ticket['status'] === 'SELESAI') ? e($ticket['formatted_end_date']) : '-' ?></td>
                    <td class="border border-slate-900 p-2"><?= ($ticket['status'] === 'SELESAI') ? e($ticket['formatted_end_date']) : '-' ?></td>
                    <td class="border border-slate-900 p-2 text-[10px] text-left"><?= e($ast['condition'] ?? 'BAIK') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($ticket['equipment_names'] ?: ['Peralatan ICT'] as $idx => $eqName): ?>
                <tr>
                    <td class="border border-slate-900 p-2.5 font-bold"><?= $idx + 1 ?></td>
                    <td class="border border-slate-900 p-2.5 font-mono text-[10px]">-</td>
                    <td class="border border-slate-900 p-2.5 text-left font-bold"><?= e($eqName) ?></td>
                    <td class="border border-slate-900 p-2.5"><?= e($ticket['formatted_start_date']) ?></td>
                    <td class="border border-slate-900 p-2.5 font-semibold"><?= e($ticket['formatted_end_date']) ?></td>
                    <td class="border border-slate-900 p-2.5 font-bold text-slate-600">MENUNGGU</td>
                    <td class="border border-slate-900 p-2.5">-</td>
                    <td class="border border-slate-900 p-2.5">-</td>
                    <td class="border border-slate-900 p-2.5 text-[10px] text-left">Permohonan Pinjaman</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Blank Rows to match authentic standard document height -->
            <?php for ($r = count($assignedAssets ?: $ticket['equipment_names'] ?: [1]); $r < 4; $r++): ?>
            <tr>
                <td class="border border-slate-900 p-2 text-slate-400"><?= $r + 1 ?></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
                <td class="border border-slate-900 p-2"></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <!-- Signature Boxes (KEW.PA-9 Format) -->
    <div class="grid grid-cols-2 gap-12 pt-6">
        <!-- Peminjam -->
        <div class="space-y-1">
            <p class="font-bold text-xs">..................................................</p>
            <p class="text-xs font-bold">(Tandatangan Peminjam)</p>
            <p class="text-xs mt-3"><span class="w-16 inline-block font-medium">Nama:</span> <strong class="uppercase"><?= e($ticket['applicant_name']) ?></strong></p>
            <p class="text-xs"><span class="w-16 inline-block font-medium">Jawatan:</span> <?= e($ticket['applicant_position'] ?? 'Pegawai') ?></p>
            <p class="text-xs"><span class="w-16 inline-block font-medium">Tarikh:</span> <?= e($ticket['formatted_created_at']) ?></p>
        </div>

        <!-- Pelulus -->
        <div class="space-y-1">
            <p class="font-bold text-xs">..................................................</p>
            <p class="text-xs font-bold">(Tandatangan Pelulus)</p>
            <p class="text-xs mt-3"><span class="w-16 inline-block font-medium">Nama:</span> <strong class="uppercase"><?= e($ticket['ict_approval']['approver_name'] ?? $ticket['unit_approval']['approver_name'] ?? 'Pegawai Pelulus Seksyen ICT') ?></strong></p>
            <p class="text-xs"><span class="w-16 inline-block font-medium">Jawatan:</span> Seksyen ICT BKP</p>
            <p class="text-xs"><span class="w-16 inline-block font-medium">Tarikh:</span> <?= format_date($ticket['ict_approval']['action_at'] ?? $ticket['unit_approval']['action_at'] ?? '') ?></p>
        </div>
    </div>

    <!-- Footer Notice -->
    <div class="text-[10px] text-slate-500 border-t border-slate-300 pt-3 flex justify-between mt-8">
        <span>Cetakan Komputer Sistem Helpdesk ICT BKP mengikut standard Pekeliling Perbendaharaan Malaysia KEW.PA-9.</span>
        <span class="font-mono">Muka Surat 1/1</span>
    </div>
</div>

<?php else: ?>

<!-- ========================================================================= -->
<!-- FORMAT BORANG PERMOHONAN & SERAHAN PERKHIDMATAN ICT UMUM / MESYUARAT / MEDIA -->
<!-- ========================================================================= -->
<div class="text-slate-900 space-y-6">
    <!-- Letterhead -->
    <div class="text-center border-b-2 border-slate-900 pb-4">
        <h1 class="text-base font-extrabold uppercase tracking-wider">BAHAGIAN KHIDMAT PENGURUSAN</h1>
        <h2 class="text-sm font-bold uppercase tracking-wide">PEJABAT SETIAUSAHA KERAJAAN NEGERI JOHOR</h2>
        <h3 class="text-xs font-semibold text-slate-700 uppercase mt-0.5">BORANG PERMOHONAN & SERAHAN PERKHIDMATAN ICT</h3>
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
                <td class="p-2 font-bold bg-slate-50 border border-slate-300">Tarikh & Masa Acara</td>
                <td class="p-2 border border-slate-300 font-medium">
                    <?= e($ticket['formatted_start_date']) ?><br>
                    (Masa Mula: <?= e($ticket['start_time']) ?>)
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
            <?php if ($ticket['category'] === 'ADUAN_KUARTERS'): ?>
            <div class="mt-2 p-2 bg-slate-50 border border-slate-300 rounded text-xs space-y-1">
                <p><strong>Kompleks Kuarters:</strong> <?= e($ticket['kuarters_complex'] ?? $ticket['location']) ?> <?= !empty($ticket['kuarters_unit_no']) ? ('(Unit/Blok: ' . e($ticket['kuarters_unit_no']) . ')') : '' ?></p>
                <?php if (!empty($ticket['kuarters_ic_no'])): ?>
                <p><strong>No. Kad Pengenalan Penghuni:</strong> <?= e($ticket['kuarters_ic_no']) ?></p>
                <?php endif; ?>
                <?php if (!empty($ticket['attachment_url'])): ?>
                <div class="mt-2 pt-1 border-t border-slate-200">
                    <p class="font-bold text-[11px] mb-1">Lampiran Gambar Bukti Kerosakan:</p>
                    <img src="<?= e(url($ticket['attachment_url'])) ?>" alt="Bukti Kerosakan" class="max-h-44 border border-slate-300 rounded object-contain">
                </div>
                <?php endif; ?>
            </div>
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
                    <p class="text-[10px] text-slate-600 mt-1">Saya berjanji mematuhi syarat perkhidmatan yang ditetapkan.</p>
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

            <!-- Box 3: Seksyen ICT BKP -->
            <div class="border border-slate-300 p-3 flex flex-col justify-between h-40">
                <div>
                    <p class="font-bold text-[11px] uppercase">3. Kelulusan Seksyen ICT BKP</p>
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
<?php endif; ?>
