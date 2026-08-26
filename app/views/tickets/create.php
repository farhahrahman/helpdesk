<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$user = Auth::user();
$today = date('Y-m-d');
$selectedCategory = (string)($_GET['category'] ?? 'PEMINJAMAN_ASET');
$unitsList = $units ?? app_config('units', []);

// Color palette for alternating equipment checklist cards
$colorThemes = [
    ['bg' => 'bg-blue-50/60', 'border' => 'border-blue-200', 'hover' => 'hover:bg-blue-100/70 hover:border-blue-300', 'text' => 'text-blue-950', 'desc' => 'text-blue-700/80', 'ring' => 'focus:ring-blue-500'],
    ['bg' => 'bg-purple-50/60', 'border' => 'border-purple-200', 'hover' => 'hover:bg-purple-100/70 hover:border-purple-300', 'text' => 'text-purple-950', 'desc' => 'text-purple-700/80', 'ring' => 'focus:ring-purple-500'],
    ['bg' => 'bg-emerald-50/60', 'border' => 'border-emerald-200', 'hover' => 'hover:bg-emerald-100/70 hover:border-emerald-300', 'text' => 'text-emerald-950', 'desc' => 'text-emerald-700/80', 'ring' => 'focus:ring-emerald-500'],
    ['bg' => 'bg-amber-50/60', 'border' => 'border-amber-200', 'hover' => 'hover:bg-amber-100/70 hover:border-amber-300', 'text' => 'text-amber-950', 'desc' => 'text-amber-700/80', 'ring' => 'focus:ring-amber-500'],
    ['bg' => 'bg-rose-50/60', 'border' => 'border-rose-200', 'hover' => 'hover:bg-rose-100/70 hover:border-rose-300', 'text' => 'text-rose-950', 'desc' => 'text-rose-700/80', 'ring' => 'focus:ring-rose-500'],
    ['bg' => 'bg-cyan-50/60', 'border' => 'border-cyan-200', 'hover' => 'hover:bg-cyan-100/70 hover:border-cyan-300', 'text' => 'text-cyan-950', 'desc' => 'text-cyan-700/80', 'ring' => 'focus:ring-cyan-500'],
    ['bg' => 'bg-indigo-50/60', 'border' => 'border-indigo-200', 'hover' => 'hover:bg-indigo-100/70 hover:border-indigo-300', 'text' => 'text-indigo-950', 'desc' => 'text-indigo-700/80', 'ring' => 'focus:ring-indigo-500'],
    ['bg' => 'bg-teal-50/60', 'border' => 'border-teal-200', 'hover' => 'hover:bg-teal-100/70 hover:border-teal-300', 'text' => 'text-teal-950', 'desc' => 'text-teal-700/80', 'ring' => 'focus:ring-teal-500'],
];
?>

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white p-6 rounded-2xl border-2 border-blue-100 shadow-sm flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-800 rounded-md font-mono uppercase">Borang Rasmi</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Seksyen ICT BKP</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Borang Permohonan Perkhidmatan ICT</h1>
            <p class="text-xs text-slate-500 mt-1">Sila lengkapkan butiran mengikut kategori dan kotak bahagian berwarna di bawah</p>
        </div>
        <a href="<?= $isLoggedIn ? url('/tickets') : url('/') ?>" class="text-xs font-bold text-slate-700 hover:text-slate-900 px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all shadow-sm">
            &larr; Kembali
        </a>
    </div>

    <!-- Main Form -->
    <form action="<?= url('/tickets') ?>" method="POST" class="space-y-6" id="ticket-application-form">
        <?= csrf_field() ?>

        <!-- STEP 1: Pilih Kategori Perkhidmatan (Kotak Berwarna Selang-Seli) -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-blue-200 shadow-sm space-y-4">
            <div class="border-b border-blue-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="px-2.5 py-1 text-xs font-bold text-blue-700 bg-blue-100 rounded-lg uppercase tracking-wider">Langkah 1</span>
                    <h2 class="text-base font-bold text-slate-900 mt-1.5">Pilih Kategori Permohonan</h2>
                </div>
                <span class="text-xs text-blue-600 font-medium hidden sm:block">Sila klik salah satu kotak kategori</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- 1. Peminjaman Aset (Format Rasmi KEW.PA-9) -->
                <label class="category-card relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:scale-[1.02] shadow-sm <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'border-blue-600 bg-blue-50/80 ring-2 ring-blue-500/20' : 'border-blue-200/80 bg-blue-50/30 hover:bg-blue-50/60' ?>">
                    <input type="radio" name="category" value="PEMINJAMAN_ASET" <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'checked' : '' ?> onchange="switchCategoryView('PEMINJAMAN_ASET')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center mb-3 shadow-md shadow-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-blue-950 block">Peminjaman Aset</span>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wide">Format KEW.PA-9</span>
                    <span class="text-[11px] text-blue-800/80 mt-1 leading-relaxed">Pinjaman Laptop Dell, iPhone 15, Lenovo Tab, Kamera DSLR & Aksesori</span>
                </label>

                <!-- 2. Sokongan Mesyuarat (Tema Indigo) -->
                <label class="category-card relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:scale-[1.02] shadow-sm <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'border-indigo-600 bg-indigo-50/80 ring-2 ring-indigo-500/20' : 'border-indigo-200/80 bg-indigo-50/30 hover:bg-indigo-50/60' ?>">
                    <input type="radio" name="category" value="SOKONGAN_MESYUARAT" <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'checked' : '' ?> onchange="switchCategoryView('SOKONGAN_MESYUARAT')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center mb-3 shadow-md shadow-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-indigo-950 block">Sokongan Mesyuarat</span>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wide">Cisco Webex / Bilik</span>
                    <span class="text-[11px] text-indigo-800/80 mt-1 leading-relaxed">Penyediaan link Cisco Webex/Zoom & bantuan teknikal bilik</span>
                </label>

                <!-- 3. Khidmat Media (Tema Ungu / Purple) -->
                <label class="category-card relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:scale-[1.02] shadow-sm <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'border-purple-600 bg-purple-50/80 ring-2 ring-purple-500/20' : 'border-purple-200/80 bg-purple-50/30 hover:bg-purple-50/60' ?>">
                    <input type="radio" name="category" value="MEDIA_JURUKAMERA" <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'checked' : '' ?> onchange="switchCategoryView('MEDIA_JURUKAMERA')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center mb-3 shadow-md shadow-purple-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-purple-950 block">Khidmat Media</span>
                    <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wide">Liputan Majlis</span>
                    <span class="text-[11px] text-purple-800/80 mt-1 leading-relaxed">Jurugambar & Juruvideo bagi majlis rasmi</span>
                </label>

                <!-- 4. Bantuan ICT (Tema Emerald / Hijau) -->
                <label class="category-card relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:scale-[1.02] shadow-sm <?= ($selectedCategory === 'LAIN_LAIN') ? 'border-emerald-600 bg-emerald-50/80 ring-2 ring-emerald-500/20' : 'border-emerald-200/80 bg-emerald-50/30 hover:bg-emerald-50/60' ?>">
                    <input type="radio" name="category" value="LAIN_LAIN" <?= ($selectedCategory === 'LAIN_LAIN') ? 'checked' : '' ?> onchange="switchCategoryView('LAIN_LAIN')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center mb-3 shadow-md shadow-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-emerald-950 block">Bantuan ICT</span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide">Teknikal & Aduan</span>
                    <span class="text-[11px] text-emerald-800/80 mt-1 leading-relaxed">Konfigurasi, siar raya & aduan teknikal am</span>
                </label>
            </div>
        </div>

        <!-- STEP 2: Butiran Khusus Kategori (Dynamic Display) -->

        <!-- Section: Peminjaman Aset (Checklist Peralatan ICT Selang-Seli Berwarna) -->
        <div id="section-equipment" class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-blue-200 shadow-sm space-y-4 <?= in_array($selectedCategory, ['PEMINJAMAN_ASET', 'LAIN_LAIN']) ? '' : 'hidden' ?>">
            <div class="border-b border-blue-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="px-2.5 py-1 text-xs font-bold text-blue-700 bg-blue-100 rounded-lg uppercase tracking-wider">Langkah 2</span>
                    <h2 class="text-base font-bold text-slate-900 mt-1.5">Senarai Peralatan ICT Yang Ingin Dipinjam <span class="text-rose-500">*</span></h2>
                </div>
                <span class="text-xs text-blue-600 font-medium hidden sm:block">Tandakan kotak peralatan yang diperlukan</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                <?php 
                $i = 0;
                foreach ($equipmentTypes as $eqKey => $eq): 
                    $theme = $colorThemes[$i % count($colorThemes)];
                    $i++;
                ?>
                <label class="flex items-start gap-3 p-4 rounded-2xl border-2 <?= $theme['border'] ?> <?= $theme['bg'] ?> <?= $theme['hover'] ?> cursor-pointer transition-all hover:scale-[1.01] shadow-sm">
                    <input type="checkbox" name="requested_equipment_types[]" value="<?= $eqKey ?>" 
                           class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 <?= $theme['ring'] ?>">
                    <div class="min-w-0">
                        <span class="text-xs font-black <?= $theme['text'] ?> block"><?= e($eq['name']) ?></span>
                        <span class="text-[11px] <?= $theme['desc'] ?> block leading-tight mt-1"><?= e($eq['description']) ?></span>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>

            <!-- Other Custom Equipment Write-in Field -->
            <div id="other-equipment-box" class="p-4 rounded-2xl bg-slate-50 border-2 border-slate-200 space-y-1.5 mt-2">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Nyatakan Peralatan Lain (Jika Ada Keperluan Khas)
                </label>
                <input type="text" name="other_equipment_description" placeholder="Cth: Kabel sambungan khas HDMI 20m, Tripod tambahan, dll." 
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 rounded-xl text-xs outline-none">
            </div>
        </div>

        <!-- Section: Sokongan Mesyuarat (Kotak Berwarna Selang-Seli) -->
        <div id="section-meeting" class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-indigo-200 shadow-sm space-y-5 <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
            <div class="border-b border-indigo-100 pb-3">
                <span class="px-2.5 py-1 text-xs font-bold text-indigo-700 bg-indigo-100 rounded-lg uppercase tracking-wider">Langkah 2</span>
                <h2 class="text-base font-bold text-slate-900 mt-1.5">Senarai Konfigurasi Sokongan Mesyuarat</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-indigo-50/60 border-2 border-indigo-200">
                    <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                        Jenis / Mod Sokongan Mesyuarat
                    </label>
                    <select name="meeting_type" class="w-full px-3.5 py-2.5 bg-white border border-indigo-200 rounded-xl text-xs outline-none font-medium">
                        <?php foreach ($meetingTypes as $mKey => $m): ?>
                        <option value="<?= $mKey ?>"><?= e($m['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="p-4 rounded-2xl bg-blue-50/60 border-2 border-blue-200">
                    <label class="block text-xs font-bold text-blue-950 uppercase tracking-wider mb-1.5">
                        Platform Mesyuarat Online
                    </label>
                    <select name="meeting_platform" class="w-full px-3.5 py-2.5 bg-white border border-blue-200 rounded-xl text-xs outline-none font-bold text-blue-900">
                        <?php foreach ($meetingPlatforms as $pKey => $p): ?>
                        <option value="<?= $pKey ?>"><?= e($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-emerald-50/60 border-2 border-emerald-200">
                    <label class="block text-xs font-bold text-emerald-950 uppercase tracking-wider mb-1.5">
                        Pautan Mesyuarat (Jika sudah ada)
                    </label>
                    <input type="url" name="meeting_link" placeholder="https://johor.webex.com/..." 
                           class="w-full px-3.5 py-2.5 bg-white border border-emerald-200 rounded-xl text-xs outline-none font-mono">
                </div>

                <div class="p-4 rounded-2xl bg-amber-50/60 border-2 border-amber-200">
                    <label class="block text-xs font-bold text-amber-950 uppercase tracking-wider mb-1.5">
                        Passcode / Kata Laluan Bilik
                    </label>
                    <input type="text" name="meeting_passcode" placeholder="Cth: BKP2026" 
                           class="w-full px-3.5 py-2.5 bg-white border border-amber-200 rounded-xl text-xs outline-none font-mono font-bold">
                </div>
            </div>
        </div>

        <!-- Section: Khidmat Media (Kotak Berwarna Selang-Seli) -->
        <div id="section-media" class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-purple-200 shadow-sm space-y-5 <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
            <div class="border-b border-purple-100 pb-3">
                <span class="px-2.5 py-1 text-xs font-bold text-purple-700 bg-purple-100 rounded-lg uppercase tracking-wider">Langkah 2</span>
                <h2 class="text-base font-bold text-slate-900 mt-1.5">Skop Liputan Media & Dokumentasi</h2>
            </div>

            <div class="p-4 rounded-2xl bg-purple-50/60 border-2 border-purple-200">
                <label class="block text-xs font-bold text-purple-950 uppercase tracking-wider mb-1.5">
                    Skop Perkhidmatan Jurukamera
                </label>
                <select name="media_scope" class="w-full px-3.5 py-2.5 bg-white border border-purple-200 rounded-xl text-xs outline-none font-medium">
                    <?php foreach ($mediaScopes as $scKey => $sc): ?>
                    <option value="<?= $scKey ?>"><?= e($sc) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="p-4 rounded-2xl bg-pink-50/50 border-2 border-pink-200">
                <label class="block text-xs font-bold text-pink-950 uppercase tracking-wider mb-1.5">
                    Tentatif / Agenda Ringkas Majlis
                </label>
                <textarea name="event_agenda" rows="3" placeholder="Sila nyatakan susunan majlis, masa ketibaan tetamu utama..." 
                          class="w-full px-3.5 py-2.5 bg-white border border-pink-200 rounded-xl text-xs outline-none"></textarea>
            </div>
        </div>

        <!-- STEP 3A: Maklumat Pinjaman Aset (Format Khusus KEW.PA-9) -->
        <div id="step3-asset-loan" class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-blue-300 shadow-sm space-y-5 <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
            <div class="border-b border-blue-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="px-2.5 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-lg uppercase tracking-wider">Langkah 3</span>
                    <h2 class="text-base font-bold text-slate-900 mt-1.5">Maklumat Pinjaman Aset Alih (Format KEW.PA-9)</h2>
                </div>
                <span class="text-xs text-blue-700 font-bold hidden sm:block">Pekeliling Perbendaharaan AM 2.4 Lampiran A</span>
            </div>

            <!-- Kotak 1: Tujuan Permohonan & Justifikasi Rasmi (Warna Biru Lembut) -->
            <div class="p-4 rounded-2xl bg-blue-50/70 border-2 border-blue-200 space-y-1.5">
                <label class="block text-xs font-black text-blue-950 uppercase tracking-wider">
                    Tujuan Permohonan & Justifikasi Rasmi <span class="text-rose-500">*</span>
                </label>
                <textarea name="purpose_loan" id="purpose_loan" rows="3" required
                          placeholder="Nyatakan tujuan rasmi pinjaman aset (Cth: Kegunaan menyediakan dokumen laporan taskforce / mesyuarat luar / pembentangan)..." 
                          class="w-full px-3.5 py-2.5 bg-white border border-blue-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs outline-none leading-relaxed"></textarea>
            </div>

            <!-- Kotak 2: Tempat Digunakan (Warna Amber Lembut) -->
            <div class="p-4 rounded-2xl bg-amber-50/70 border-2 border-amber-200 space-y-1.5">
                <label class="block text-xs font-bold text-amber-950 uppercase tracking-wider">
                    Tempat Digunakan / Lokasi Penggunaan <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="location_loan" id="location_loan" required 
                       placeholder="Cth: Pejabat BKP Aras 3 / Bilik Mesyuarat Tender / Program Luar Pejabat" 
                       class="w-full px-3.5 py-2.5 bg-white border border-amber-300 focus:border-amber-500 rounded-xl text-xs outline-none font-medium">
            </div>

            <!-- Kotak 3: Jadual Tarikh Pinjam & Tarikh Dijangka Pulang (Warna Cyan / Biru Lautan Lembut) -->
            <div class="p-5 rounded-2xl bg-cyan-50/70 border-2 border-cyan-200 space-y-3">
                <span class="text-xs font-black text-cyan-950 uppercase tracking-wider block">
                    Tempoh Pinjaman Aset (Tarikh Pinjam & Tarikh Dijangka Pulang)
                </span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3.5 bg-white rounded-xl border border-cyan-200">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Tarikh Pinjam (Tarikh Mula) <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="start_date_loan" id="start_date_loan" required value="<?= $today ?>" min="<?= $today ?>"
                               class="w-full px-2 py-1.5 bg-transparent border-0 text-xs font-bold text-slate-900 outline-none">
                    </div>
                    <div class="p-3.5 bg-white rounded-xl border border-cyan-200">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Tarikh Dijangka Pulang <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="end_date_loan" id="end_date_loan" required value="<?= $today ?>" min="<?= $today ?>"
                               class="w-full px-2 py-1.5 bg-transparent border-0 text-xs font-bold text-cyan-950 outline-none">
                    </div>
                </div>
            </div>

            <!-- Kotak 4: No. Telefon Pemohon (Warna Ungu Lembut) -->
            <div class="p-4 rounded-2xl bg-purple-50/70 border-2 border-purple-200 space-y-1.5">
                <label class="block text-xs font-bold text-purple-950 uppercase tracking-wider">
                    No. Telefon Pemohon untuk Dihubungi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="applicant_phone_loan" id="applicant_phone_loan" required value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                       placeholder="01X-XXXXXXX atau VoIP" 
                       class="w-full px-3.5 py-2.5 bg-white border border-purple-300 focus:border-purple-500 rounded-xl text-xs outline-none font-bold text-purple-900">
            </div>

            <?php if (!$isLoggedIn): ?>
            <!-- Kotak 5: Maklumat Pemohon untuk Tetamu / Awam (Warna Indigo Lembut) -->
            <div class="p-5 rounded-2xl bg-indigo-50/70 border-2 border-indigo-200 space-y-4">
                <div class="border-b border-indigo-200/80 pb-2 flex items-center justify-between">
                    <span class="text-xs font-black text-indigo-950 uppercase tracking-wider">Maklumat Pegawai Pemohon (BKP)</span>
                    <span class="text-[10px] bg-indigo-200 text-indigo-900 px-2 py-0.5 rounded-full font-bold">Staf / Pegawai</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Unit / Bahagian BKP <span class="text-rose-500">*</span>
                        </label>
                        <select name="unit_loan" class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-bold text-indigo-900">
                            <?php foreach ($unitsList as $uKey => $u): ?>
                            <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Nama Penuh Pegawai <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="applicant_name_loan" placeholder="Cth: Ahmad Faiz bin Khairuddin"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Emel Rasmi Kerajaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="applicant_email_loan" placeholder="nama@johor.gov.my"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Jawatan & Gred
                        </label>
                        <input type="text" name="applicant_position_loan" placeholder="Cth: Penolong Pegawai Tadbir (N29)"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- STEP 3B: Maklumat Acara & Jadual Masa (Bagi Kategori Mesyuarat, Media & Khidmat ICT) -->
        <div id="step3-event-service" class="bg-white p-6 sm:p-8 rounded-2xl border-2 border-emerald-200 shadow-sm space-y-5 <?= ($selectedCategory !== 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
            <div class="border-b border-emerald-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-lg uppercase tracking-wider">Langkah 3</span>
                    <h2 class="text-base font-bold text-slate-900 mt-1.5">Maklumat Acara & Jadual Masa</h2>
                </div>
                <span class="text-xs text-emerald-600 font-medium hidden sm:block">Sila isi butiran acara / mesyuarat anda</span>
            </div>

            <!-- Kotak 1: Tajuk Program (Warna Biru Lembut) -->
            <div class="p-4 rounded-2xl bg-blue-50/70 border-2 border-blue-200 space-y-1.5">
                <label class="block text-xs font-black text-blue-950 uppercase tracking-wider">
                    Tajuk Permohonan / Nama Program <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" id="event_title"
                       placeholder="Cth: Mesyuarat Penyelarasan Pembangunan Sistem ICT BKP Bil. 2/2026" 
                       class="w-full px-3.5 py-2.5 bg-white border border-blue-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-sm font-semibold text-slate-900 outline-none">
            </div>

            <!-- Kotak 2: Pengerusi & Lokasi (Warna Amber Lembut) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-amber-50/70 border-2 border-amber-200 space-y-1.5">
                    <label class="block text-xs font-bold text-amber-950 uppercase tracking-wider">
                        Pengerusi Mesyuarat / Tetamu Kehormat (VIP)
                    </label>
                    <input type="text" name="vip_attendees" 
                           placeholder="Cth: YB SUK / Timbalan SUK / Ketua Bahagian..." 
                           class="w-full px-3.5 py-2.5 bg-white border border-amber-300 focus:border-amber-500 rounded-xl text-xs outline-none">
                </div>

                <div class="p-4 rounded-2xl bg-amber-50/70 border-2 border-amber-200 space-y-1.5">
                    <label class="block text-xs font-bold text-amber-950 uppercase tracking-wider">
                        Lokasi / Bilik Mesyuarat / Tempat Acara <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="location" id="event_location"
                           placeholder="Cth: Bilik Mesyuarat Utama BKP (Aras 3)" 
                           class="w-full px-3.5 py-2.5 bg-white border border-amber-300 focus:border-amber-500 rounded-xl text-xs outline-none font-medium">
                </div>
            </div>

            <!-- Kotak 3: Tujuan & Justifikasi (Warna Hijau Emerald Lembut) -->
            <div class="p-4 rounded-2xl bg-emerald-50/70 border-2 border-emerald-200 space-y-1.5">
                <label class="block text-xs font-black text-emerald-950 uppercase tracking-wider">
                    Tujuan Permohonan & Justifikasi Rasmi <span class="text-rose-500">*</span>
                </label>
                <textarea name="purpose" id="event_purpose" rows="3"
                          placeholder="Nyatakan tujuan rasmi dan keperluan khidmat ini..." 
                          class="w-full px-3.5 py-2.5 bg-white border border-emerald-300 focus:border-emerald-500 rounded-xl text-xs outline-none leading-relaxed"></textarea>
            </div>

            <!-- Kotak 4: No. Telefon (Warna Ungu Lembut) -->
            <div class="p-4 rounded-2xl bg-purple-50/70 border-2 border-purple-200 space-y-1.5">
                <label class="block text-xs font-bold text-purple-950 uppercase tracking-wider">
                    No. Telefon Pemohon untuk Dihubungi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="applicant_phone" id="event_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                       placeholder="01X-XXXXXXX atau VoIP" 
                       class="w-full px-3.5 py-2.5 bg-white border border-purple-300 focus:border-purple-500 rounded-xl text-xs outline-none font-bold text-purple-900">
            </div>

            <!-- Kotak 5: Tarikh Acara & Masa Mula (Warna Cyan / Biru Lautan Lembut) -->
            <div class="p-5 rounded-2xl bg-cyan-50/70 border-2 border-cyan-200 space-y-3">
                <span class="text-xs font-black text-cyan-950 uppercase tracking-wider block">
                    Jadual Tarikh & Masa Mula Acara
                </span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3 bg-white rounded-xl border border-cyan-200">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Tarikh Acara / Program <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="event_start_date" value="<?= $today ?>" min="<?= $today ?>"
                               class="w-full px-2 py-1.5 bg-transparent border-0 text-xs font-bold text-slate-900 outline-none">
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-cyan-200">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Masa Mula <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="start_time" id="event_start_time" value="09:00" 
                                class="w-full px-2 py-1.5 bg-transparent border-0 text-xs font-bold text-cyan-950 outline-none">
                    </div>
                </div>
            </div>

            <?php if (!$isLoggedIn): ?>
            <!-- Kotak 6: Maklumat Pegawai Pemohon untuk Tetamu (Warna Indigo Lembut) -->
            <div class="p-5 rounded-2xl bg-indigo-50/70 border-2 border-indigo-200 space-y-4">
                <div class="border-b border-indigo-200/80 pb-2 flex items-center justify-between">
                    <span class="text-xs font-black text-indigo-950 uppercase tracking-wider">Maklumat Pegawai Pemohon (BKP)</span>
                    <span class="text-[10px] bg-indigo-200 text-indigo-900 px-2 py-0.5 rounded-full font-bold">Staf / Pegawai</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Unit / Bahagian BKP <span class="text-rose-500">*</span>
                        </label>
                        <select name="unit" class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-bold text-indigo-900">
                            <?php foreach ($unitsList as $uKey => $u): ?>
                            <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Nama Penuh Pegawai <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="applicant_name" placeholder="Cth: Ahmad Faiz bin Khairuddin"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Emel Rasmi Kerajaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="applicant_email" placeholder="nama@johor.gov.my"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1.5">
                            Jawatan & Gred
                        </label>
                        <input type="text" name="applicant_position" placeholder="Cth: Penolong Pegawai Tadbir (N29)"
                               class="w-full px-3.5 py-2.5 bg-white border border-indigo-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Compliance & Submission Box (Kotak Akhir Berwarna Gelap Eksklusif) -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-6 sm:p-7 rounded-2xl border-2 border-blue-700/60 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4 text-white">
            <div class="text-xs space-y-1.5">
                <p class="font-bold flex items-center gap-2 text-blue-300 text-sm">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Pematuhan Aliran Kerja Rasmi BKP
                </p>
                <p class="text-blue-100/80 leading-relaxed text-[11px]">
                    Permohonan ini akan disalurkan secara automatik kepada <strong>Ketua Unit</strong> anda untuk perakuan sebelum dinilai dan diluluskan oleh <strong>Seksyen ICT BKP</strong>.
                </p>
            </div>

            <button type="submit" 
                    class="px-8 py-3.5 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-black text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-600/40 hover:shadow-blue-500/50 hover:scale-[1.02] transition-all shrink-0 focus:ring-4 focus:ring-blue-300 flex items-center gap-2">
                <span>Hantar Permohonan Rasmi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
</div>

<script>
function switchCategoryView(cat) {
    document.querySelectorAll('.category-card').forEach(el => {
        el.className = 'category-card relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:scale-[1.02] shadow-sm border-slate-200 bg-slate-50/50';
    });

    const eqSec = document.getElementById('section-equipment');
    const meetSec = document.getElementById('section-meeting');
    const mediaSec = document.getElementById('section-media');
    const step3Loan = document.getElementById('step3-asset-loan');
    const step3Event = document.getElementById('step3-event-service');

    const purposeLoan = document.getElementById('purpose_loan');
    const locationLoan = document.getElementById('location_loan');
    const startLoan = document.getElementById('start_date_loan');
    const endLoan = document.getElementById('end_date_loan');
    const phoneLoan = document.getElementById('applicant_phone_loan');

    const eventTitle = document.getElementById('event_title');
    const eventLoc = document.getElementById('event_location');
    const eventPurpose = document.getElementById('event_purpose');
    const eventPhone = document.getElementById('event_phone');
    const eventStart = document.getElementById('event_start_date');

    if (cat === 'PEMINJAMAN_ASET') {
        eqSec.classList.remove('hidden');
        meetSec.classList.add('hidden');
        mediaSec.classList.add('hidden');
        step3Loan.classList.remove('hidden');
        step3Event.classList.add('hidden');

        // Toggle required attributes
        if (purposeLoan) purposeLoan.required = true;
        if (locationLoan) locationLoan.required = true;
        if (startLoan) startLoan.required = true;
        if (endLoan) endLoan.required = true;
        if (phoneLoan) phoneLoan.required = true;

        if (eventTitle) eventTitle.required = false;
        if (eventLoc) eventLoc.required = false;
        if (eventPurpose) eventPurpose.required = false;
        if (eventPhone) eventPhone.required = false;
        if (eventStart) eventStart.required = false;
    } else {
        step3Loan.classList.add('hidden');
        step3Event.classList.remove('hidden');

        if (purposeLoan) purposeLoan.required = false;
        if (locationLoan) locationLoan.required = false;
        if (startLoan) startLoan.required = false;
        if (endLoan) endLoan.required = false;
        if (phoneLoan) phoneLoan.required = false;

        if (eventTitle) eventTitle.required = true;
        if (eventLoc) eventLoc.required = true;
        if (eventPurpose) eventPurpose.required = true;
        if (eventPhone) eventPhone.required = true;
        if (eventStart) eventStart.required = true;

        if (cat === 'SOKONGAN_MESYUARAT') {
            eqSec.classList.add('hidden');
            meetSec.classList.remove('hidden');
            mediaSec.classList.add('hidden');
        } else if (cat === 'MEDIA_JURUKAMERA') {
            eqSec.classList.add('hidden');
            meetSec.classList.add('hidden');
            mediaSec.classList.remove('hidden');
        } else {
            eqSec.classList.remove('hidden');
            meetSec.classList.add('hidden');
            mediaSec.classList.add('hidden');
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[name="category"]:checked');
    if (checkedRadio) {
        switchCategoryView(checkedRadio.value);
    }
});
</script>
