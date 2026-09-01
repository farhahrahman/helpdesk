<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$user = Auth::user();
$today = date('Y-m-d');
$selectedCategory = (string)($_GET['category'] ?? 'PEMINJAMAN_ASET');
$unitsList = $units ?? app_config('units', []);
$techSupportList = $technicalSupportTypes ?? app_config('services.technical_support_types', []);

// Color palette for alternating equipment checklist cards
$colorThemes = [
    ['bg' => 'bg-blue-50/70', 'border' => 'border-blue-200', 'hover' => 'hover:border-blue-400 hover:bg-blue-100/60', 'text' => 'text-blue-950', 'desc' => 'text-blue-700/90', 'ring' => 'focus:ring-blue-500'],
    ['bg' => 'bg-purple-50/70', 'border' => 'border-purple-200', 'hover' => 'hover:border-purple-400 hover:bg-purple-100/60', 'text' => 'text-purple-950', 'desc' => 'text-purple-700/90', 'ring' => 'focus:ring-purple-500'],
    ['bg' => 'bg-emerald-50/70', 'border' => 'border-emerald-200', 'hover' => 'hover:border-emerald-400 hover:bg-emerald-100/60', 'text' => 'text-emerald-950', 'desc' => 'text-emerald-700/90', 'ring' => 'focus:ring-emerald-500'],
    ['bg' => 'bg-amber-50/70', 'border' => 'border-amber-200', 'hover' => 'hover:border-amber-400 hover:bg-amber-100/60', 'text' => 'text-amber-950', 'desc' => 'text-amber-700/90', 'ring' => 'focus:ring-amber-500'],
    ['bg' => 'bg-rose-50/70', 'border' => 'border-rose-200', 'hover' => 'hover:border-rose-400 hover:bg-rose-100/60', 'text' => 'text-rose-950', 'desc' => 'text-rose-700/90', 'ring' => 'focus:ring-rose-500'],
    ['bg' => 'bg-cyan-50/70', 'border' => 'border-cyan-200', 'hover' => 'hover:border-cyan-400 hover:bg-cyan-100/60', 'text' => 'text-cyan-950', 'desc' => 'text-cyan-700/90', 'ring' => 'focus:ring-cyan-500'],
    ['bg' => 'bg-indigo-50/70', 'border' => 'border-indigo-200', 'hover' => 'hover:border-indigo-400 hover:bg-indigo-100/60', 'text' => 'text-indigo-950', 'desc' => 'text-indigo-700/90', 'ring' => 'focus:ring-indigo-500'],
    ['bg' => 'bg-teal-50/70', 'border' => 'border-teal-200', 'hover' => 'hover:border-teal-400 hover:bg-teal-100/60', 'text' => 'text-teal-950', 'desc' => 'text-teal-700/90', 'ring' => 'focus:ring-teal-500'],
];
?>

<div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 w-full py-2 my-auto">
    <!-- Master Unified Container (1 Page Clean View) -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden p-4 sm:p-6 lg:p-6 space-y-4">
        
        <!-- Top Compact Bar: Title & Category Tabs -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-extrabold bg-blue-100 text-blue-800 rounded font-mono uppercase">Borang Rasmi</span>
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">Permohonan Perkhidmatan ICT & Aset BKP</span>
                </div>
                <p class="text-[11px] text-slate-500">Sila pilih kategori di bawah dan lengkapkan butiran khusus mengikut keperluan permohonan anda</p>
            </div>

            <!-- Action / Back -->
            <a href="<?= $isLoggedIn ? url('/tickets') : url('/') ?>" class="self-start lg:self-auto text-xs font-bold text-slate-700 hover:text-slate-900 px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all shadow-sm">
                &larr; Kembali
            </a>
        </div>

        <!-- Main Form -->
        <form action="<?= url('/tickets') ?>" method="POST" id="ticket-application-form" class="space-y-4">
            <?= csrf_field() ?>

            <!-- LANGKAH 1: Kategori Ribbon (Horizontal Tabs Bar) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                <!-- 1. Peminjaman Aset -->
                <label data-cat="PEMINJAMAN_ASET" class="category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'border-blue-600 bg-blue-50/80 ring-2 ring-blue-500/20' : 'border-slate-200 bg-slate-50/60 hover:bg-blue-50/40' ?>">
                    <input type="radio" name="category" value="PEMINJAMAN_ASET" <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'checked' : '' ?> onchange="switchCategoryView('PEMINJAMAN_ASET')" class="sr-only">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm text-sm">
                        💻
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-black text-slate-900 block truncate">Peminjaman Aset</span>
                        <span class="text-[10px] font-bold text-blue-700 block truncate">Format KEW.PA-9</span>
                    </div>
                </label>

                <!-- 2. Sokongan Mesyuarat -->
                <label data-cat="SOKONGAN_MESYUARAT" class="category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'border-indigo-600 bg-indigo-50/80 ring-2 ring-indigo-500/20' : 'border-slate-200 bg-slate-50/60 hover:bg-indigo-50/40' ?>">
                    <input type="radio" name="category" value="SOKONGAN_MESYUARAT" <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'checked' : '' ?> onchange="switchCategoryView('SOKONGAN_MESYUARAT')" class="sr-only">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm text-sm">
                        🌐
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-black text-slate-900 block truncate">Sokongan Mesyuarat</span>
                        <span class="text-[10px] font-bold text-indigo-700 block truncate">Cisco Webex / Bilik</span>
                    </div>
                </label>

                <!-- 3. Khidmat Media -->
                <label data-cat="MEDIA_JURUKAMERA" class="category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'border-purple-600 bg-purple-50/80 ring-2 ring-purple-500/20' : 'border-slate-200 bg-slate-50/60 hover:bg-purple-50/40' ?>">
                    <input type="radio" name="category" value="MEDIA_JURUKAMERA" <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'checked' : '' ?> onchange="switchCategoryView('MEDIA_JURUKAMERA')" class="sr-only">
                    <div class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-sm text-sm">
                        📸
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-black text-slate-900 block truncate">Khidmat Media</span>
                        <span class="text-[10px] font-bold text-purple-700 block truncate">Jurugambar & Video</span>
                    </div>
                </label>

                <!-- 4. Bantuan ICT -->
                <label data-cat="LAIN_LAIN" class="category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm <?= ($selectedCategory === 'LAIN_LAIN') ? 'border-emerald-600 bg-emerald-50/80 ring-2 ring-emerald-500/20' : 'border-slate-200 bg-slate-50/60 hover:bg-emerald-50/40' ?>">
                    <input type="radio" name="category" value="LAIN_LAIN" <?= ($selectedCategory === 'LAIN_LAIN') ? 'checked' : '' ?> onchange="switchCategoryView('LAIN_LAIN')" class="sr-only">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm text-sm">
                        🛠️
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-black text-slate-900 block truncate">Bantuan ICT</span>
                        <span class="text-[10px] font-bold text-emerald-700 block truncate">Teknikal & Aduan</span>
                    </div>
                </label>
            </div>

            <!-- 2-COLUMN UNIFIED WORKSPACE (Left: Langkah 2 | Right: Langkah 3) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
                
                <!-- ========================================================================= -->
                <!-- LEFT COLUMN (6 of 12): LANGKAH 2 (Checklist / Konfigurasi / Skop / Kerosakan) -->
                <!-- ========================================================================= -->
                <div class="lg:col-span-6 space-y-3">
                    
                    <!-- 1. Langkah 2: Peminjaman Aset (Checklist Peralatan) -->
                    <div id="section-equipment" class="p-3.5 sm:p-4 rounded-2xl border-2 border-blue-200 bg-blue-50/30 space-y-2.5 <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-blue-200 pb-2">
                            <span class="text-xs font-black text-blue-950 uppercase tracking-wide">Pilih Peralatan ICT Yang Ingin Dipinjam <span class="text-rose-500">*</span></span>
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold">Langkah 2</span>
                        </div>

                        <!-- Compact 2-column checklist -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-[380px] overflow-y-auto pr-1">
                            <?php 
                            $i = 0;
                            foreach ($equipmentTypes as $eqKey => $eq): 
                                $theme = $colorThemes[$i % count($colorThemes)];
                                $i++;
                            ?>
                            <label class="flex items-start gap-2 p-2.5 rounded-xl border <?= $theme['border'] ?> <?= $theme['bg'] ?> <?= $theme['hover'] ?> cursor-pointer transition-all hover:scale-[1.01] shadow-xs">
                                <input type="checkbox" name="requested_equipment_types[]" value="<?= $eqKey ?>" 
                                       class="mt-1 w-3.5 h-3.5 text-blue-600 rounded border-slate-300 <?= $theme['ring'] ?>">
                                
                                <div class="w-7 h-7 rounded-lg bg-white/90 border border-slate-200 shadow-xs flex items-center justify-center text-sm shrink-0">
                                    <?= $eq['icon'] ?? '💻' ?>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <span class="text-[11px] font-black <?= $theme['text'] ?> block leading-tight truncate"><?= e($eq['name']) ?></span>
                                    <span class="block text-[9px] font-mono text-slate-600 truncate mt-0.5"><?= e($eq['sample_serial'] ?? '') ?></span>
                                    <span class="text-[10px] <?= $theme['desc'] ?> block leading-tight line-clamp-1 mt-0.5"><?= e($eq['description']) ?></span>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- Other Custom Equipment -->
                        <div class="pt-1">
                            <input type="text" name="other_equipment_description" placeholder="Peralatan lain (Cth: Kabel HDMI 20m, Tripod tambahan, dll.)" 
                                   class="w-full px-3 py-1.5 bg-white border border-slate-300 focus:border-blue-500 rounded-xl text-xs outline-none">
                        </div>
                    </div>

                    <!-- 2. Langkah 2: Sokongan Mesyuarat (Konfigurasi Teknikal) -->
                    <div id="section-meeting" class="p-3.5 sm:p-4 rounded-2xl border-2 border-indigo-200 bg-indigo-50/30 space-y-3 <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-indigo-200 pb-2">
                            <span class="text-xs font-black text-indigo-950 uppercase tracking-wide">Konfigurasi Sokongan Mesyuarat</span>
                            <span class="text-[10px] bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded font-bold">Langkah 2</span>
                        </div>

                        <div class="space-y-2.5">
                            <div>
                                <label class="block text-[11px] font-bold text-indigo-950 uppercase mb-1">Mod Sokongan Mesyuarat</label>
                                <select name="meeting_type" class="w-full px-3 py-2 bg-white border border-indigo-200 rounded-xl text-xs outline-none">
                                    <?php foreach ($meetingTypes as $mKey => $m): ?>
                                    <option value="<?= $mKey ?>"><?= e($m['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-indigo-950 uppercase mb-1">Platform Mesyuarat Online</label>
                                <select name="meeting_platform" class="w-full px-3 py-2 bg-white border border-indigo-200 rounded-xl text-xs outline-none font-bold text-indigo-900">
                                    <?php foreach ($meetingPlatforms as $pKey => $p): ?>
                                    <option value="<?= $pKey ?>"><?= e($p) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-indigo-950 uppercase mb-1">Pautan Mesyuarat (Jika Ada)</label>
                                    <input type="url" name="meeting_link" placeholder="https://johor.webex.com/..." class="w-full px-3 py-2 bg-white border border-indigo-200 rounded-xl text-xs outline-none font-mono">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-indigo-950 uppercase mb-1">Passcode / Kata Laluan Bilik</label>
                                    <input type="text" name="meeting_passcode" placeholder="Cth: BKP2026" class="w-full px-3 py-2 bg-white border border-indigo-200 rounded-xl text-xs outline-none font-mono font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Langkah 2: Khidmat Media (Skop & Tentatif Majlis) -->
                    <div id="section-media" class="p-3.5 sm:p-4 rounded-2xl border-2 border-purple-200 bg-purple-50/30 space-y-3 <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-purple-200 pb-2">
                            <span class="text-xs font-black text-purple-950 uppercase tracking-wide">Skop Liputan Media & Dokumentasi</span>
                            <span class="text-[10px] bg-purple-100 text-purple-800 px-2 py-0.5 rounded font-bold">Langkah 2</span>
                        </div>

                        <div class="space-y-2.5">
                            <div>
                                <label class="block text-[11px] font-bold text-purple-950 uppercase mb-1">Skop Perkhidmatan Jurukamera <span class="text-rose-500">*</span></label>
                                <select name="media_scope" class="w-full px-3 py-2 bg-white border border-purple-200 rounded-xl text-xs outline-none font-medium">
                                    <?php foreach ($mediaScopes as $scKey => $sc): ?>
                                    <option value="<?= $scKey ?>"><?= e($sc) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-purple-950 uppercase mb-1">Tentatif & Susunan Acara Majlis <span class="text-rose-500">*</span></label>
                                <textarea name="event_agenda" id="event_agenda" rows="3" placeholder="Sila nyatakan masa ketibaan tetamu kehormat, susunan acara, gimik perasmian, sesi bergambar..." class="w-full px-3 py-2 bg-white border border-purple-200 rounded-xl text-xs outline-none leading-relaxed"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Langkah 2: Bantuan ICT (Kategori Aduan & Kerosakan) -->
                    <div id="section-technical" class="p-3.5 sm:p-4 rounded-2xl border-2 border-emerald-200 bg-emerald-50/30 space-y-3 <?= ($selectedCategory === 'LAIN_LAIN') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-emerald-200 pb-2">
                            <span class="text-xs font-black text-emerald-950 uppercase tracking-wide">Skop Bantuan & Kategori Aduan ICT</span>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Langkah 2</span>
                        </div>

                        <div class="space-y-2.5">
                            <div>
                                <label class="block text-[11px] font-bold text-emerald-950 uppercase mb-1">
                                    Jenis Masalah / Kategori Bantuan <span class="text-rose-500">*</span>
                                </label>
                                <select name="technical_type" id="technical_type" class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-xs font-bold text-emerald-900 outline-none">
                                    <?php foreach ($techSupportList as $tKey => $t): ?>
                                    <option value="<?= $tKey ?>"><?= $t['icon'] ?? '🛠️' ?> <?= e($t['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-emerald-950 uppercase mb-1">
                                    Tahap Keutamaan / Urgensi
                                </label>
                                <select name="priority" class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-xs outline-none font-medium">
                                    <option value="BIASA">Biasa (Tindakan dalam 24 Jam)</option>
                                    <option value="SEGERA">Segera (Tindakan Hari Ini / Menjejaskan Tugasan)</option>
                                    <option value="KRITIKAL">Kritikal (Kecemasan / Mesyuarat Penting)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-emerald-950 uppercase mb-1">
                                    Penerangan Kerosakan / Gejala Masalah <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="technical_problem_description" id="technical_problem_description" rows="3"
                                          placeholder="Sila nyatakan kerosakan yang dialami secara ringkas (Cth: Komputer tidak dapat dihidupkan, printer tidak menyambung, kata laluan emel disekat dll.)..." 
                                          class="w-full px-3 py-2 bg-white border border-emerald-300 focus:border-emerald-600 rounded-xl text-xs outline-none leading-relaxed"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================================================= -->
                <!-- RIGHT COLUMN (6 of 12): LANGKAH 3 (Khusus Mengikut Kategori) & BUTANG HANTAR -->
                <!-- ========================================================================= -->
                <div class="lg:col-span-6 space-y-3">
                    
                    <!-- 1. Langkah 3: Peminjaman Aset (Format Rasmi KEW.PA-9) -->
                    <div id="step3-asset-loan" class="p-3.5 sm:p-4 rounded-2xl border-2 border-blue-300 bg-white space-y-3 <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-blue-100 pb-1.5">
                            <span class="text-xs font-black text-blue-950 uppercase tracking-wide">Butiran Pinjaman Aset Alih (Format KEW.PA-9)</span>
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold">Langkah 3</span>
                        </div>

                        <!-- 1. Tujuan Permohonan & Justifikasi -->
                        <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-200">
                            <label class="block text-[11px] font-black text-blue-950 uppercase mb-1">
                                Tujuan Permohonan & Justifikasi Rasmi <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="purpose_loan" id="purpose_loan" rows="2"
                                      placeholder="Nyatakan tujuan rasmi pinjaman aset (Cth: Menyediakan laporan taskforce / pembentangan / mesyuarat luar)..." 
                                      class="w-full px-3 py-1.5 bg-white border border-blue-300 focus:border-blue-600 rounded-lg text-xs outline-none leading-relaxed"></textarea>
                        </div>

                        <!-- 2. Tempat Digunakan & No Telefon -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[11px] font-bold text-amber-950 uppercase mb-1">
                                    Tempat Digunakan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="location_loan" id="location_loan" 
                                       placeholder="Cth: Pejabat BKP Aras 3 / Luar Pejabat" 
                                       class="w-full px-3 py-1.5 bg-white border border-amber-300 rounded-lg text-xs outline-none">
                            </div>

                            <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-200">
                                <label class="block text-[11px] font-bold text-purple-950 uppercase mb-1">
                                    No. Telefon Pemohon <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="applicant_phone_loan" id="applicant_phone_loan" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                                       placeholder="01X-XXXXXXX atau VoIP" 
                                       class="w-full px-3 py-1.5 bg-white border border-purple-300 rounded-lg text-xs font-bold text-purple-900 outline-none">
                            </div>
                        </div>

                        <!-- 3. Tarikh Pinjam & Tarikh Dijangka Pulang -->
                        <div class="p-2.5 rounded-xl bg-cyan-50/70 border border-cyan-200">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">
                                        Tarikh Pinjam <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="date" name="start_date_loan" id="start_date_loan" value="<?= $today ?>" min="<?= $today ?>"
                                           class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">
                                        Tarikh Dijangka Pulang <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="date" name="end_date_loan" id="end_date_loan" value="<?= $today ?>" min="<?= $today ?>"
                                           class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-cyan-950 outline-none">
                                </div>
                            </div>
                        </div>

                        <?php if (!$isLoggedIn): ?>
                        <!-- 4. Maklumat Pemohon (Untuk Tetamu) -->
                        <div class="p-2.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-2">
                            <span class="text-[10px] font-black text-indigo-950 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <select name="unit_loan" class="w-full px-2 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none font-bold text-indigo-900">
                                        <?php foreach ($unitsList as $uKey => $u): ?>
                                        <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="text" name="applicant_name_loan" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="email" name="applicant_email_loan" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="text" name="applicant_position_loan" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- 2. Langkah 3: Sokongan Mesyuarat (Maklumat Mesyuarat & Jadual) -->
                    <div id="step3-meeting" class="p-3.5 sm:p-4 rounded-2xl border-2 border-indigo-200 bg-white space-y-3 <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-indigo-100 pb-1.5">
                            <span class="text-xs font-black text-slate-900 uppercase tracking-wide">Maklumat Mesyuarat & Jadual Masa</span>
                            <span class="text-[10px] bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded font-bold">Langkah 3</span>
                        </div>

                        <!-- 1. Tajuk Mesyuarat -->
                        <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-200">
                            <label class="block text-[11px] font-black text-blue-950 uppercase mb-1">
                                Nama / Tajuk Mesyuarat <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="meeting_title" id="meeting_title"
                                   placeholder="Cth: Mesyuarat Penyelarasan Pembangunan Sistem ICT BKP Bil. 2/2026" 
                                   class="w-full px-3 py-1.5 bg-white border border-blue-300 focus:border-blue-600 rounded-lg text-xs font-semibold outline-none">
                        </div>

                        <!-- 2. Pengerusi & Lokasi Bilik -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[10px] font-bold text-amber-950 uppercase mb-0.5">Pengerusi Mesyuarat</label>
                                <input type="text" name="meeting_vip" placeholder="Cth: YB SUK / Timbalan SUK / Ketua Bahagian" class="w-full px-2.5 py-1 bg-white border border-amber-300 rounded-md text-xs outline-none">
                            </div>
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[10px] font-bold text-amber-950 uppercase mb-0.5">Lokasi / Bilik Mesyuarat <span class="text-rose-500">*</span></label>
                                <input type="text" name="meeting_location" id="meeting_location" placeholder="Cth: Bilik Mesyuarat Utama BKP (Aras 3)" class="w-full px-2.5 py-1 bg-white border border-amber-300 rounded-md text-xs outline-none">
                            </div>
                        </div>

                        <!-- 3. Jadual Tarikh & Masa Mula -->
                        <div class="p-2.5 rounded-xl bg-cyan-50/70 border border-cyan-200">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">Tarikh Mesyuarat <span class="text-rose-500">*</span></label>
                                    <input type="date" name="meeting_date" id="meeting_date" value="<?= $today ?>" min="<?= $today ?>" class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">Masa Mula <span class="text-rose-500">*</span></label>
                                    <input type="time" name="meeting_time" id="meeting_time" value="09:00" class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-cyan-950 outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- 4. Tujuan & No Telefon -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-200">
                                <label class="block text-[10px] font-black text-emerald-950 uppercase mb-0.5">Tujuan / Keperluan Khas <span class="text-rose-500">*</span></label>
                                <textarea name="meeting_purpose" id="meeting_purpose" rows="1" placeholder="Nyatakan tujuan ringkas mesyuarat..." class="w-full px-2.5 py-1 bg-white border border-emerald-300 rounded-md text-xs outline-none"></textarea>
                            </div>
                            <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-200">
                                <label class="block text-[10px] font-bold text-purple-950 uppercase mb-0.5">No. Telefon Urus Setia <span class="text-rose-500">*</span></label>
                                <input type="text" name="meeting_phone" id="meeting_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" placeholder="01X-XXXXXXX" class="w-full px-2.5 py-1 bg-white border border-purple-300 rounded-md text-xs font-bold text-purple-900 outline-none">
                            </div>
                        </div>

                        <?php if (!$isLoggedIn): ?>
                        <!-- 5. Maklumat Pemohon (Untuk Tetamu) -->
                        <div class="p-2.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-2">
                            <span class="text-[10px] font-black text-indigo-950 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <select name="meeting_unit" class="w-full px-2 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none font-bold text-indigo-900">
                                        <?php foreach ($unitsList as $uKey => $u): ?>
                                        <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="text" name="meeting_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="email" name="meeting_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="text" name="meeting_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Langkah 3: Khidmat Media (Maklumat Majlis / Acara Rasmi) -->
                    <div id="step3-media" class="p-3.5 sm:p-4 rounded-2xl border-2 border-purple-200 bg-white space-y-3 <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-purple-100 pb-1.5">
                            <span class="text-xs font-black text-purple-950 uppercase tracking-wide">Maklumat Majlis / Acara Rasmi</span>
                            <span class="text-[10px] bg-purple-100 text-purple-800 px-2 py-0.5 rounded font-bold">Langkah 3</span>
                        </div>

                        <!-- 1. Nama Majlis -->
                        <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-200">
                            <label class="block text-[11px] font-black text-purple-950 uppercase mb-1">
                                Nama Acara / Majlis Rasmi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="media_title" id="media_title"
                                   placeholder="Cth: Majlis Perhimpunan Bulanan BKP Bersama YB Setiausaha Kerajaan Negeri" 
                                   class="w-full px-3 py-1.5 bg-white border border-purple-300 focus:border-purple-600 rounded-lg text-xs font-semibold outline-none">
                        </div>

                        <!-- 2. Tetamu Utama & Lokasi Majlis -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[10px] font-bold text-amber-950 uppercase mb-0.5">Tetamu Utama / Perasmi</label>
                                <input type="text" name="media_vip" placeholder="Cth: YB SUK Johor / Pegawai Khas" class="w-full px-2.5 py-1 bg-white border border-amber-300 rounded-md text-xs outline-none">
                            </div>
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[10px] font-bold text-amber-950 uppercase mb-0.5">Tempat / Lokasi Majlis <span class="text-rose-500">*</span></label>
                                <input type="text" name="media_location" id="media_location" placeholder="Cth: Dewan Serbaguna Kompleks Kerajaan" class="w-full px-2.5 py-1 bg-white border border-amber-300 rounded-md text-xs outline-none">
                            </div>
                        </div>

                        <!-- 3. Jadual Tarikh & Masa Majlis -->
                        <div class="p-2.5 rounded-xl bg-cyan-50/70 border border-cyan-200">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">Tarikh Majlis <span class="text-rose-500">*</span></label>
                                    <input type="date" name="media_date" id="media_date" value="<?= $today ?>" min="<?= $today ?>" class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">Masa Ketibaan / Mula <span class="text-rose-500">*</span></label>
                                    <input type="time" name="media_time" id="media_time" value="09:00" class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-cyan-950 outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- 4. No Telefon Penyelaras -->
                        <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-200">
                            <label class="block text-[10px] font-bold text-purple-950 uppercase mb-0.5">No. Telefon Pegawai Penyelaras Majlis <span class="text-rose-500">*</span></label>
                            <input type="text" name="media_phone" id="media_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" placeholder="01X-XXXXXXX" class="w-full px-2.5 py-1 bg-white border border-purple-300 rounded-md text-xs font-bold text-purple-900 outline-none">
                        </div>

                        <?php if (!$isLoggedIn): ?>
                        <!-- 5. Maklumat Pegawai Pemohon (Untuk Tetamu) -->
                        <div class="p-2.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-2">
                            <span class="text-[10px] font-black text-indigo-950 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <select name="media_unit" class="w-full px-2 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none font-bold text-indigo-900">
                                        <?php foreach ($unitsList as $uKey => $u): ?>
                                        <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="text" name="media_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="email" name="media_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="text" name="media_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- 4. Langkah 3: Bantuan ICT & Aduan (Maklumat Lokasi & Pegawai Pengadu) -->
                    <div id="step3-technical" class="p-3.5 sm:p-4 rounded-2xl border-2 border-emerald-300 bg-white space-y-3 <?= ($selectedCategory === 'LAIN_LAIN') ? '' : 'hidden' ?>">
                        <div class="flex items-center justify-between border-b border-emerald-100 pb-1.5">
                            <span class="text-xs font-black text-emerald-950 uppercase tracking-wide">Maklumat Lokasi & Pegawai Pengadu</span>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Langkah 3</span>
                        </div>

                        <!-- 1. Tajuk Ringkas Permohonan / Masalah -->
                        <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-200">
                            <label class="block text-[11px] font-black text-blue-950 uppercase mb-1">
                                Tajuk Permohonan / Aduan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="technical_title" id="technical_title"
                                   placeholder="Cth: Masalah Capaian Internet & Sambungan Pencetak Unit Pentadbiran" 
                                   class="w-full px-3 py-1.5 bg-white border border-blue-300 focus:border-blue-600 rounded-lg text-xs font-semibold outline-none">
                        </div>

                        <!-- 2. Lokasi Meja & No Telefon -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200">
                                <label class="block text-[11px] font-bold text-amber-950 uppercase mb-1">
                                    Lokasi / Aras / Meja Pegawai <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="technical_location" id="technical_location" 
                                       placeholder="Cth: Pejabat BKP Aras 3 (Meja Pentadbiran)" 
                                       class="w-full px-3 py-1.5 bg-white border border-amber-300 rounded-lg text-xs outline-none">
                            </div>

                            <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-200">
                                <label class="block text-[11px] font-bold text-purple-950 uppercase mb-1">
                                    No. Telefon / Sambungan VoIP <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="technical_phone" id="technical_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                                       placeholder="01X-XXXXXXX atau Sambungan VoIP" 
                                       class="w-full px-3 py-1.5 bg-white border border-purple-300 rounded-lg text-xs font-bold text-purple-900 outline-none">
                            </div>
                        </div>

                        <!-- 3. Tarikh Diperlukan -->
                        <div class="p-2.5 rounded-xl bg-cyan-50/70 border border-cyan-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-0.5">
                                Tarikh Aduan / Bantuan Diperlukan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="technical_date" id="technical_date" value="<?= $today ?>" min="<?= $today ?>"
                                   class="w-full px-2 py-1 bg-white border border-cyan-300 rounded-md text-xs font-bold text-slate-900 outline-none">
                        </div>

                        <?php if (!$isLoggedIn): ?>
                        <!-- 4. Maklumat Pegawai Pemohon (Untuk Tetamu) -->
                        <div class="p-2.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-2">
                            <span class="text-[10px] font-black text-indigo-950 uppercase block">Maklumat Pegawai Pengadu (BKP)</span>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <select name="technical_unit" class="w-full px-2 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none font-bold text-indigo-900">
                                        <?php foreach ($unitsList as $uKey => $u): ?>
                                        <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="text" name="technical_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="email" name="technical_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                                <div>
                                    <input type="text" name="technical_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-indigo-300 rounded-lg text-[11px] outline-none">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Submission Action Button -->
                    <div class="pt-1">
                        <button type="submit" 
                                class="w-full py-3.5 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 active:scale-[0.99] text-white font-black text-sm rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 transition-all flex items-center justify-center gap-2">
                            <span>🚀 Hantar Permohonan Rasmi Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                        <p class="text-[10px] text-center text-slate-500 mt-1.5">
                            Permohonan akan disalurkan secara automatik kepada <strong>Ketua Unit</strong> dan <strong>Seksyen ICT BKP</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function switchCategoryView(cat) {
    // Reset all category cards
    document.querySelectorAll('.category-card').forEach(el => {
        el.className = 'category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm border-slate-200 bg-slate-50/60 hover:bg-slate-100/70';
    });

    // Highlight selected card
    const activeLabel = document.querySelector(`.category-card[data-cat="${cat}"]`);
    if (activeLabel) {
        if (cat === 'PEMINJAMAN_ASET') {
            activeLabel.className = 'category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm border-blue-600 bg-blue-50/80 ring-2 ring-blue-500/20';
        } else if (cat === 'SOKONGAN_MESYUARAT') {
            activeLabel.className = 'category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm border-indigo-600 bg-indigo-50/80 ring-2 ring-indigo-500/20';
        } else if (cat === 'MEDIA_JURUKAMERA') {
            activeLabel.className = 'category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm border-purple-600 bg-purple-50/80 ring-2 ring-purple-500/20';
        } else if (cat === 'LAIN_LAIN') {
            activeLabel.className = 'category-card relative flex items-center gap-2.5 p-2.5 sm:p-3 rounded-xl border-2 cursor-pointer transition-all hover:scale-[1.01] shadow-sm border-emerald-600 bg-emerald-50/80 ring-2 ring-emerald-500/20';
        }
    }

    // Left Column Sections (Langkah 2)
    const eqSec = document.getElementById('section-equipment');
    const meetSec = document.getElementById('section-meeting');
    const mediaSec = document.getElementById('section-media');
    const techSec = document.getElementById('section-technical');

    // Right Column Sections (Langkah 3)
    const step3Loan = document.getElementById('step3-asset-loan');
    const step3Meeting = document.getElementById('step3-meeting');
    const step3Media = document.getElementById('step3-media');
    const step3Tech = document.getElementById('step3-technical');

    // 1. Inputs for Loan (KEW.PA-9)
    const purposeLoan = document.getElementById('purpose_loan');
    const locationLoan = document.getElementById('location_loan');
    const startLoan = document.getElementById('start_date_loan');
    const endLoan = document.getElementById('end_date_loan');
    const phoneLoan = document.getElementById('applicant_phone_loan');

    // 2. Inputs for Meeting
    const meetTitle = document.getElementById('meeting_title');
    const meetLoc = document.getElementById('meeting_location');
    const meetDate = document.getElementById('meeting_date');
    const meetPurpose = document.getElementById('meeting_purpose');
    const meetPhone = document.getElementById('meeting_phone');

    // 3. Inputs for Media
    const mediaTitle = document.getElementById('media_title');
    const mediaLoc = document.getElementById('media_location');
    const mediaDate = document.getElementById('media_date');
    const mediaPhone = document.getElementById('media_phone');
    const eventAgenda = document.getElementById('event_agenda');

    // 4. Inputs for Technical Help
    const techTitle = document.getElementById('technical_title');
    const techProb = document.getElementById('technical_problem_description');
    const techLoc = document.getElementById('technical_location');
    const techPhone = document.getElementById('technical_phone');
    const techDate = document.getElementById('technical_date');

    // Reset visibility (Langkah 2)
    eqSec.classList.add('hidden');
    meetSec.classList.add('hidden');
    mediaSec.classList.add('hidden');
    techSec.classList.add('hidden');

    // Reset visibility (Langkah 3)
    step3Loan.classList.add('hidden');
    step3Meeting.classList.add('hidden');
    step3Media.classList.add('hidden');
    step3Tech.classList.add('hidden');

    // Disable all required first
    if (purposeLoan) purposeLoan.required = false;
    if (locationLoan) locationLoan.required = false;
    if (startLoan) startLoan.required = false;
    if (endLoan) endLoan.required = false;
    if (phoneLoan) phoneLoan.required = false;

    if (meetTitle) meetTitle.required = false;
    if (meetLoc) meetLoc.required = false;
    if (meetDate) meetDate.required = false;
    if (meetPurpose) meetPurpose.required = false;
    if (meetPhone) meetPhone.required = false;

    if (mediaTitle) mediaTitle.required = false;
    if (mediaLoc) mediaLoc.required = false;
    if (mediaDate) mediaDate.required = false;
    if (mediaPhone) mediaPhone.required = false;
    if (eventAgenda) eventAgenda.required = false;

    if (techTitle) techTitle.required = false;
    if (techProb) techProb.required = false;
    if (techLoc) techLoc.required = false;
    if (techPhone) techPhone.required = false;
    if (techDate) techDate.required = false;

    // Activate specific category
    if (cat === 'PEMINJAMAN_ASET') {
        eqSec.classList.remove('hidden');
        step3Loan.classList.remove('hidden');

        if (purposeLoan) purposeLoan.required = true;
        if (locationLoan) locationLoan.required = true;
        if (startLoan) startLoan.required = true;
        if (endLoan) endLoan.required = true;
        if (phoneLoan) phoneLoan.required = true;
    } else if (cat === 'SOKONGAN_MESYUARAT') {
        meetSec.classList.remove('hidden');
        step3Meeting.classList.remove('hidden');

        if (meetTitle) meetTitle.required = true;
        if (meetLoc) meetLoc.required = true;
        if (meetDate) meetDate.required = true;
        if (meetPurpose) meetPurpose.required = true;
        if (meetPhone) meetPhone.required = true;
    } else if (cat === 'MEDIA_JURUKAMERA') {
        mediaSec.classList.remove('hidden');
        step3Media.classList.remove('hidden');

        if (mediaTitle) mediaTitle.required = true;
        if (mediaLoc) mediaLoc.required = true;
        if (mediaDate) mediaDate.required = true;
        if (mediaPhone) mediaPhone.required = true;
        if (eventAgenda) eventAgenda.required = true;
    } else if (cat === 'LAIN_LAIN') {
        techSec.classList.remove('hidden');
        step3Tech.classList.remove('hidden');

        if (techTitle) techTitle.required = true;
        if (techProb) techProb.required = true;
        if (techLoc) techLoc.required = true;
        if (techPhone) techPhone.required = true;
        if (techDate) techDate.required = true;
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
