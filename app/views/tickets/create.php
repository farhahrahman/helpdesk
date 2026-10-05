<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$user = Auth::user();
$today = date('Y-m-d');
$selectedCategory = (string)($_GET['category'] ?? 'PEMINJAMAN_ASET');
$unitsList = $units ?? app_config('units', []);
$techSupportList = $technicalSupportTypes ?? app_config('services.technical_support_types', []);
$kuartersComplaintList = $kuartersComplaintTypes ?? app_config('services.kuarters_complaint_types', []);
$kuartersComplexesList = $kuartersComplexes ?? app_config('services.kuarters_complexes', []);
?>

<div class="bg-slate-50/60 py-6 sm:py-10 border-b border-slate-200/80 flex-1 flex flex-col justify-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- Page Intro Header (Matching Frontpage Theme) -->
        <div class="mb-5 sm:mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 mb-1.5">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">
                        Borang Permohonan
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span class="px-2 py-0.5 text-[10px] font-extrabold bg-blue-100 text-[#1d3d75] rounded font-mono uppercase">
                        BKP SUKJ
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Permohonan Perkhidmatan ICT <span class="text-amber-500">& Fasiliti.</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 font-normal max-w-2xl">
                    Pilih kategori perkhidmatan di bawah dan lengkapkan maklumat yang diperlukan dalam satu paparan mudah tanpa perlu login.
                </p>
            </div>
            <div class="shrink-0">
                <a href="<?= $isLoggedIn ? url('/tickets') : url('/') ?>" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200/90 shadow-sm transition-all hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Laman Utama</span>
                </a>
            </div>
        </div>

        <!-- Master Unified Container (Frontpage Card Theme) -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-900/5 p-4 sm:p-6 lg:p-7 space-y-5">
            
            <!-- Main Form -->
            <form action="<?= url('/tickets') ?>" method="POST" enctype="multipart/form-data" id="ticket-application-form" class="space-y-5">
                <?= csrf_field() ?>

                <!-- LANGKAH 1: Kategori Ribbon (Horizontal Tabs Bar - 5 Kategori) -->
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Langkah 1: Pilih Kategori Perkhidmatan</span>
                        <span class="text-[11px] text-slate-500 font-medium hidden sm:inline">Pilih salah satu perkhidmatan di bawah</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                        <!-- 1. Peminjaman Aset -->
                        <label data-cat="PEMINJAMAN_ASET" class="category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15' : 'bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs' ?>">
                            <input type="radio" name="category" value="PEMINJAMAN_ASET" <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'checked' : '' ?> onchange="switchCategoryView('PEMINJAMAN_ASET')" class="sr-only">
                            <div class="card-icon w-8 h-8 rounded-xl <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' ?> flex items-center justify-center shrink-0 text-sm">
                                💻
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="card-title text-xs font-bold <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'text-white' : 'text-slate-900' ?> block leading-tight truncate">Peminjaman Aset</span>
                                <span class="card-sub text-[10px] <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'text-blue-100/80' : 'text-slate-500' ?> block truncate font-medium mt-0.5">Format KEW.PA-9</span>
                            </div>
                        </label>

                        <!-- 2. Sokongan Mesyuarat -->
                        <label data-cat="SOKONGAN_MESYUARAT" class="category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15' : 'bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs' ?>">
                            <input type="radio" name="category" value="SOKONGAN_MESYUARAT" <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'checked' : '' ?> onchange="switchCategoryView('SOKONGAN_MESYUARAT')" class="sr-only">
                            <div class="card-icon w-8 h-8 rounded-xl <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' ?> flex items-center justify-center shrink-0 text-sm">
                                🌐
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="card-title text-xs font-bold <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'text-white' : 'text-slate-900' ?> block leading-tight truncate">Sokongan Mesyuarat</span>
                                <span class="card-sub text-[10px] <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'text-blue-100/80' : 'text-slate-500' ?> block truncate font-medium mt-0.5">Webex / Bilik</span>
                            </div>
                        </label>

                        <!-- 3. Khidmat Media -->
                        <label data-cat="MEDIA_JURUKAMERA" class="category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15' : 'bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs' ?>">
                            <input type="radio" name="category" value="MEDIA_JURUKAMERA" <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'checked' : '' ?> onchange="switchCategoryView('MEDIA_JURUKAMERA')" class="sr-only">
                            <div class="card-icon w-8 h-8 rounded-xl <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' ?> flex items-center justify-center shrink-0 text-sm">
                                📸
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="card-title text-xs font-bold <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'text-white' : 'text-slate-900' ?> block leading-tight truncate">Khidmat Media</span>
                                <span class="card-sub text-[10px] <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'text-blue-100/80' : 'text-slate-500' ?> block truncate font-medium mt-0.5">Foto & Video</span>
                            </div>
                        </label>

                        <!-- 4. Bantuan ICT -->
                        <label data-cat="LAIN_LAIN" class="category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all <?= ($selectedCategory === 'LAIN_LAIN') ? 'bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15' : 'bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs' ?>">
                            <input type="radio" name="category" value="LAIN_LAIN" <?= ($selectedCategory === 'LAIN_LAIN') ? 'checked' : '' ?> onchange="switchCategoryView('LAIN_LAIN')" class="sr-only">
                            <div class="card-icon w-8 h-8 rounded-xl <?= ($selectedCategory === 'LAIN_LAIN') ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' ?> flex items-center justify-center shrink-0 text-sm">
                                🛠️
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="card-title text-xs font-bold <?= ($selectedCategory === 'LAIN_LAIN') ? 'text-white' : 'text-slate-900' ?> block leading-tight truncate">Bantuan ICT</span>
                                <span class="card-sub text-[10px] <?= ($selectedCategory === 'LAIN_LAIN') ? 'text-blue-100/80' : 'text-slate-500' ?> block truncate font-medium mt-0.5">Teknikal & Aduan</span>
                            </div>
                        </label>

                        <!-- 5. Isu Sistem e-Kuarters -->
                        <label data-cat="ADUAN_KUARTERS" class="category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all <?= ($selectedCategory === 'ADUAN_KUARTERS') ? 'bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15' : 'bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs' ?>">
                            <input type="radio" name="category" value="ADUAN_KUARTERS" <?= ($selectedCategory === 'ADUAN_KUARTERS') ? 'checked' : '' ?> onchange="switchCategoryView('ADUAN_KUARTERS')" class="sr-only">
                            <div class="card-icon w-8 h-8 rounded-xl <?= ($selectedCategory === 'ADUAN_KUARTERS') ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' ?> flex items-center justify-center shrink-0 text-sm">
                                🏢
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="card-title text-xs font-bold <?= ($selectedCategory === 'ADUAN_KUARTERS') ? 'text-white' : 'text-slate-900' ?> block leading-tight truncate">Isu Sistem e-Kuarters</span>
                                <span class="card-sub text-[10px] <?= ($selectedCategory === 'ADUAN_KUARTERS') ? 'text-blue-100/80' : 'text-slate-500' ?> block truncate font-medium mt-0.5">Permohonan & Ralat Sistem</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 2-COLUMN UNIFIED WORKSPACE (Left: Langkah 2 | Right: Langkah 3) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                    
                    <!-- ========================================================================= -->
                    <!-- LEFT COLUMN (6 of 12): LANGKAH 2 (Checklist / Konfigurasi / Skop / Aduan) -->
                    <!-- ========================================================================= -->
                    <div class="lg:col-span-6 space-y-4">
                        
                        <!-- 1. Langkah 2: Peminjaman Aset (Checklist Peralatan) -->
                        <div id="section-equipment" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">2</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Pilih Peralatan ICT Yang Ingin Dipinjam <span class="text-rose-500">*</span></span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 2</span>
                            </div>

                            <!-- 2-column checklist with uniform clean cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-[380px] overflow-y-auto pr-1">
                                <?php foreach ($equipmentTypes as $eqKey => $eq): ?>
                                <label class="flex items-start gap-2.5 p-3 rounded-xl border border-slate-200/90 bg-slate-50/50 hover:bg-slate-100/70 hover:border-slate-300 cursor-pointer transition-all has-[:checked]:border-[#1d3d75] has-[:checked]:bg-blue-50/40 has-[:checked]:ring-1 has-[:checked]:ring-[#1d3d75] shadow-2xs">
                                    <input type="checkbox" name="requested_equipment_types[]" value="<?= $eqKey ?>" 
                                           class="mt-1 w-3.5 h-3.5 text-[#1d3d75] rounded border-slate-300 focus:ring-[#1d3d75]">
                                    
                                    <div class="w-7 h-7 rounded-lg bg-white border border-slate-200/80 shadow-xs flex items-center justify-center text-sm shrink-0">
                                        <?= $eq['icon'] ?? '💻' ?>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <span class="text-[11px] font-bold text-slate-900 block leading-tight truncate"><?= e($eq['name']) ?></span>
                                        <span class="block text-[9px] font-mono text-slate-500 truncate mt-0.5"><?= e($eq['sample_serial'] ?? '') ?></span>
                                        <span class="text-[10px] text-slate-500 block leading-tight line-clamp-1 mt-0.5"><?= e($eq['description']) ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Other Custom Equipment -->
                            <div class="pt-1">
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Peralatan Tambahan Lain (Jika Ada)</label>
                                <input type="text" name="other_equipment_description" placeholder="Cth: Kabel HDMI 20m, Tripod tambahan, extension wire dll." 
                                       class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none transition-all placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- 2. Langkah 2: Sokongan Mesyuarat (Konfigurasi Teknikal) -->
                        <div id="section-meeting" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">2</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Konfigurasi Sokongan Mesyuarat</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 2</span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mod Sokongan Mesyuarat <span class="text-rose-500">*</span></label>
                                    <select name="meeting_type" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                        <?php foreach ($meetingTypes as $mKey => $m): ?>
                                        <option value="<?= $mKey ?>"><?= e($m['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Platform Mesyuarat Online <span class="text-rose-500">*</span></label>
                                    <select name="meeting_platform" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-bold text-slate-900">
                                        <?php foreach ($meetingPlatforms as $pKey => $p): ?>
                                        <option value="<?= $pKey ?>"><?= e($p) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pautan Mesyuarat (Jika Ada)</label>
                                        <input type="url" name="meeting_link" placeholder="https://johor.webex.com/..." class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-mono">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Passcode / Kata Laluan</label>
                                        <input type="text" name="meeting_passcode" placeholder="Cth: BKP2026" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-mono font-bold">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Langkah 2: Khidmat Media (Skop & Tentatif Majlis) -->
                        <div id="section-media" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">2</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Skop Liputan Media & Dokumentasi</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 2</span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Skop Perkhidmatan Jurukamera <span class="text-rose-500">*</span></label>
                                    <select name="media_scope" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-medium">
                                        <?php foreach ($mediaScopes as $scKey => $sc): ?>
                                        <option value="<?= $scKey ?>"><?= e($sc) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tentatif & Susunan Acara Majlis <span class="text-rose-500">*</span></label>
                                    <textarea name="event_agenda" id="event_agenda" rows="3" placeholder="Sila nyatakan masa ketibaan tetamu kehormat, susunan acara, gimik perasmian, sesi bergambar..." class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none leading-relaxed placeholder:text-slate-400"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Langkah 2: Bantuan ICT (Kategori Aduan & Kerosakan) -->
                        <div id="section-technical" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'LAIN_LAIN') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">2</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Skop Bantuan & Kategori Aduan ICT</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 2</span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Jenis Masalah / Kategori Bantuan <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="technical_type" id="technical_type" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                        <?php foreach ($techSupportList as $tKey => $t): ?>
                                        <option value="<?= $tKey ?>"><?= $t['icon'] ?? '•' ?> <?= e($t['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tahap Keutamaan / Urgensi <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="priority" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-medium">
                                        <option value="BIASA">Biasa</option>
                                        <option value="SEGERA">Segera</option>
                                        <option value="KRITIKAL">Kritikal</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        No. Siri Aset / Peranti Bermasalah (Pilihan)
                                    </label>
                                    <input type="text" name="technical_asset_tag" placeholder="Cth: BKP/ICT/LAP/2026/01 atau tinggalkan kosong" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-mono outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- 5. Langkah 2: Isu Sistem e-Kuarters (Maklumat Pemohon & Akaun e-Kuarters) -->
                        <div id="section-kuarters" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'ADUAN_KUARTERS') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">2</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Maklumat Pemohon & Akaun e-Kuarters</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 2</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Pilihan Status: Pemohon Kuarters atau Penghuni Sedia Ada -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Status Pemohon / Pengadu <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2.5">
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-slate-100 cursor-pointer transition-all has-[:checked]:border-[#1d3d75] has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-[#1d3d75]">
                                            <input type="radio" name="kuarters_resident_status" id="status_pemohon" value="PEMOHON" checked onchange="toggleKuartersAddress(this.value)" class="text-[#1d3d75] focus:ring-[#1d3d75]">
                                            <div class="min-w-0">
                                                <span class="text-xs font-bold text-slate-900 block leading-tight">Pemohon Kuarters</span>
                                                <span class="text-[10px] text-slate-500 block leading-tight mt-0.5">Sedang memohon / Belum menduduki</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-slate-100 cursor-pointer transition-all has-[:checked]:border-[#1d3d75] has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-[#1d3d75]">
                                            <input type="radio" name="kuarters_resident_status" id="status_penghuni" value="PENGHUNI_SEDIA_ADA" onchange="toggleKuartersAddress(this.value)" class="text-[#1d3d75] focus:ring-[#1d3d75]">
                                            <div class="min-w-0">
                                                <span class="text-xs font-bold text-slate-900 block leading-tight">Penghuni Sedia Ada</span>
                                                <span class="text-[10px] text-slate-500 block leading-tight mt-0.5">Sedang menduduki kuarters</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- 2. Alamat Rumah Kuarters (Hanya Jika Penghuni Sedia Ada) -->
                                <div id="kuarters-address-box" class="hidden space-y-2.5 p-3 rounded-xl bg-slate-50/80 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-800 block">🏠 No. Alamat Rumah / Unit Kuarters Sedia Ada</span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">
                                                Kompleks Kuarters <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="kuarters_complex" id="kuarters_complex" list="kuarters_complex_list"
                                                   placeholder="Pilih atau taip kompleks..."
                                                   class="w-full px-3 py-2 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-xs outline-none">
                                            <datalist id="kuarters_complex_list">
                                                <?php foreach ($kuartersComplexesList as $cName): ?>
                                                <option value="<?= e($cName) ?>"></option>
                                                <?php endforeach; ?>
                                            </datalist>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">
                                                No. Rumah / Blok / Tingkat <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="kuarters_unit_no" id="kuarters_unit_no" 
                                                   placeholder="Cth: Blok B, No. 03-05" 
                                                   class="w-full px-3 py-2 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-xs outline-none">
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Nama Pemohon -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nama Pemohon <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="kuarters_applicant_name" id="kuarters_applicant_name" 
                                           value="<?= e($isLoggedIn ? $user['name'] : '') ?>" 
                                           placeholder="Nama penuh pemohon" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-medium text-slate-900">
                                </div>

                                <!-- 4. No. Kad Pengenalan & No. Telefon -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            No. Kad Pengenalan (No. KP) <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="kuarters_ic_no" id="kuarters_ic_no" 
                                               placeholder="Cth: 880101-01-XXXX" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-mono outline-none text-slate-900">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            No. Telefon / WhatsApp <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="kuarters_phone" id="kuarters_phone" 
                                               value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                                               placeholder="01X-XXXXXXX" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-bold text-slate-900">
                                    </div>
                                </div>

                                <!-- 5. Alamat Emel & Jabatan / Unit Bertugas -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Alamat Emel Rasmi
                                        </label>
                                        <input type="email" name="kuarters_email" id="kuarters_email" 
                                               value="<?= e($isLoggedIn ? $user['email'] : '') ?>" 
                                               placeholder="nama@johor.gov.my" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none text-slate-900">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Jabatan / Unit Bertugas
                                        </label>
                                        <select name="kuarters_unit" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-medium text-slate-900">
                                            <?php foreach ($unitsList as $uKey => $u): ?>
                                            <option value="<?= $uKey ?>" <?= (($user['unit'] ?? '') === $uKey) ? 'selected' : '' ?>><?= e($u['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- RIGHT COLUMN (6 of 12): LANGKAH 3 (Butiran & Pengesahan) & BUTANG HANTAR   -->
                    <!-- ========================================================================= -->
                    <div class="lg:col-span-6 space-y-4">
                        
                        <!-- 1. Langkah 3: Peminjaman Aset (Format Rasmi KEW.PA-9) -->
                        <div id="step3-asset-loan" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">3</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Butiran Pinjaman Aset Alih (Format KEW.PA-9)</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 3</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Tujuan Permohonan & Justifikasi -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tujuan Permohonan & Justifikasi Rasmi <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="purpose_loan" id="purpose_loan" rows="2"
                                              placeholder="Nyatakan tujuan rasmi pinjaman aset (Cth: Menyediakan laporan taskforce / pembentangan / mesyuarat luar)..." 
                                              class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none leading-relaxed placeholder:text-slate-400"></textarea>
                                </div>

                                <!-- 2. Tempat Digunakan & No Telefon -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Tempat Digunakan <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="location_loan" id="location_loan" 
                                               placeholder="Cth: Pejabat BKP Aras 3 / Luar Pejabat" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none placeholder:text-slate-400">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            No. Telefon Pemohon <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="applicant_phone_loan" id="applicant_phone_loan" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                                               placeholder="01X-XXXXXXX atau VoIP" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none placeholder:text-slate-400">
                                    </div>
                                </div>

                                <!-- 3. Tarikh Pinjam & Tarikh Dijangka Pulang -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Tarikh Pinjam <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="date" name="start_date_loan" id="start_date_loan" value="<?= $today ?>" min="<?= $today ?>"
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Tarikh Dijangka Pulang <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="date" name="end_date_loan" id="end_date_loan" value="<?= $today ?>" min="<?= $today ?>"
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <?php if (!$isLoggedIn): ?>
                                <!-- 4. Maklumat Pemohon (Untuk Tetamu) -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span class="text-[10px] font-bold text-slate-700 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select name="unit_loan" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none font-bold text-slate-900">
                                                <?php foreach ($unitsList as $uKey => $u): ?>
                                                <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" name="applicant_name_loan" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="email" name="applicant_email_loan" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="text" name="applicant_position_loan" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 2. Langkah 3: Sokongan Mesyuarat (Maklumat Mesyuarat) -->
                        <div id="step3-meeting" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">3</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Maklumat Program / Acara Mesyuarat</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 3</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Nama Mesyuarat -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nama / Tajuk Mesyuarat Rasmi <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="meeting_title" id="meeting_title"
                                           placeholder="Cth: Mesyuarat Penyelarasan Pembangunan Sistem ICT BKP Bil. 2/2026" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-medium outline-none">
                                </div>

                                <!-- 2. Pengerusi & Lokasi Bilik -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pengerusi Mesyuarat</label>
                                        <input type="text" name="meeting_vip" placeholder="Cth: YB SUK / Timbalan SUK / Ketua Bahagian" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi / Bilik Mesyuarat <span class="text-rose-500">*</span></label>
                                        <input type="text" name="meeting_location" id="meeting_location" placeholder="Cth: Bilik Mesyuarat Utama BKP (Aras 3)" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                    </div>
                                </div>

                                <!-- 3. Jadual Tarikh & Masa Mula -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tarikh Mesyuarat <span class="text-rose-500">*</span></label>
                                        <input type="date" name="meeting_date" id="meeting_date" value="<?= $today ?>" min="<?= $today ?>" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Masa Mula <span class="text-rose-500">*</span></label>
                                        <input type="time" name="meeting_time" id="meeting_time" value="09:00" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <!-- 4. Tujuan & No Telefon -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tujuan / Keperluan Khas <span class="text-rose-500">*</span></label>
                                        <textarea name="meeting_purpose" id="meeting_purpose" rows="1" placeholder="Nyatakan tujuan ringkas..." class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telefon Urus Setia <span class="text-rose-500">*</span></label>
                                        <input type="text" name="meeting_phone" id="meeting_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" placeholder="01X-XXXXXXX" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <?php if (!$isLoggedIn): ?>
                                <!-- 5. Maklumat Pemohon (Untuk Tetamu) -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span class="text-[10px] font-bold text-slate-700 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select name="meeting_unit" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none font-bold text-slate-900">
                                                <?php foreach ($unitsList as $uKey => $u): ?>
                                                <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" name="meeting_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="email" name="meeting_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="text" name="meeting_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 3. Langkah 3: Khidmat Media (Maklumat Majlis / Acara Rasmi) -->
                        <div id="step3-media" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">3</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Maklumat Majlis / Acara Rasmi</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 3</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Nama Majlis -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nama Acara / Majlis Rasmi <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="media_title" id="media_title"
                                           placeholder="Cth: Majlis Perhimpunan Bulanan BKP Bersama YB Setiausaha Kerajaan Negeri" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-medium outline-none">
                                </div>

                                <!-- 2. Tetamu Utama & Lokasi Majlis -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tetamu Utama / Perasmi</label>
                                        <input type="text" name="media_vip" placeholder="Cth: YB SUK Johor / Pegawai Khas" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tempat / Lokasi Majlis <span class="text-rose-500">*</span></label>
                                        <input type="text" name="media_location" id="media_location" placeholder="Cth: Dewan Serbaguna Kompleks Kerajaan" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                    </div>
                                </div>

                                <!-- 3. Jadual Tarikh & Masa Majlis -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tarikh Majlis <span class="text-rose-500">*</span></label>
                                        <input type="date" name="media_date" id="media_date" value="<?= $today ?>" min="<?= $today ?>" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Masa Ketibaan / Mula <span class="text-rose-500">*</span></label>
                                        <input type="time" name="media_time" id="media_time" value="09:00" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <!-- 4. No Telefon Penyelaras -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telefon Pegawai Penyelaras Majlis <span class="text-rose-500">*</span></label>
                                    <input type="text" name="media_phone" id="media_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" placeholder="01X-XXXXXXX" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                </div>

                                <?php if (!$isLoggedIn): ?>
                                <!-- 5. Maklumat Pegawai Pemohon (Untuk Tetamu) -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span class="text-[10px] font-bold text-slate-700 uppercase block">Maklumat Pegawai Pemohon (BKP)</span>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select name="media_unit" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none font-bold text-slate-900">
                                                <?php foreach ($unitsList as $uKey => $u): ?>
                                                <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" name="media_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="email" name="media_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="text" name="media_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 4. Langkah 3: Bantuan ICT & Aduan (Maklumat Lokasi & Pegawai Pengadu) -->
                        <div id="step3-technical" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'LAIN_LAIN') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">3</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Maklumat Lokasi & Pegawai Pengadu</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 3</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Tajuk Ringkas Permohonan / Masalah -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tajuk Permohonan / Aduan <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="technical_title" id="technical_title"
                                           placeholder="Cth: Masalah Capaian Internet & Sambungan Pencetak Unit Pentadbiran" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-medium outline-none">
                                </div>

                                <!-- 2. Keterangan Masalah / Aduan -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Keterangan Terperinci Masalah / Isu Teknikal <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="technical_problem_description" id="technical_problem_description" rows="2"
                                              placeholder="Sila nyatakan butiran terperinci masalah teknikal atau keperluan yang dialami..." 
                                              class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none leading-relaxed placeholder:text-slate-400"></textarea>
                                </div>

                                <!-- 3. Lokasi Meja & No Telefon -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Lokasi / Aras / Meja Pegawai <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="technical_location" id="technical_location" 
                                               placeholder="Cth: Pejabat BKP Aras 3 (Meja Pentadbiran)" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            No. Telefon / VoIP <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="technical_phone" id="technical_phone" value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                                               placeholder="01X-XXXXXXX atau Sambungan VoIP" 
                                               class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <!-- 4. Tarikh Diperlukan -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tarikh Aduan / Bantuan Diperlukan <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="date" name="technical_date" id="technical_date" value="<?= $today ?>" min="<?= $today ?>"
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                </div>

                                <?php if (!$isLoggedIn): ?>
                                <!-- 5. Maklumat Pegawai Pemohon (Untuk Tetamu) -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span class="text-[10px] font-bold text-slate-700 uppercase block">Maklumat Pegawai Pengadu (BKP)</span>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select name="technical_unit" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none font-bold text-slate-900">
                                                <?php foreach ($unitsList as $uKey => $u): ?>
                                                <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" name="technical_applicant_name" placeholder="Nama Penuh Pegawai" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="email" name="technical_applicant_email" placeholder="emel@johor.gov.my" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                        <div>
                                            <input type="text" name="technical_applicant_position" placeholder="Jawatan & Gred" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 focus:border-[#1d3d75] rounded-lg text-[11px] outline-none">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 5. Langkah 3: Aduan Sistem e-Kuarters (Keterangan Isu & Ralat Sistem) -->
                        <div id="step3-kuarters" class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white space-y-3.5 shadow-2xs <?= ($selectedCategory === 'ADUAN_KUARTERS') ? '' : 'hidden' ?>">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#1d3d75] text-white text-[11px] font-black flex items-center justify-center shadow-xs">3</span>
                                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wide">Keterangan Isu & Ralat Sistem e-Kuarters</span>
                                </div>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold border border-slate-200/60">Langkah 3</span>
                            </div>

                            <div class="space-y-3">
                                <!-- 1. Tajuk Ringkas Aduan Kuarters -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tajuk Ringkas Masalah Sistem e-Kuarters <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="kuarters_title" id="kuarters_title"
                                           placeholder="Cth: Ralat muat naik lampiran dokumen / Borang tidak boleh submit" 
                                           class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-medium outline-none">
                                </div>

                                <!-- 2. Kategori Isu / Ralat Sistem & Tarikh Aduan -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Jenis Ralat / Kategori Masalah Sistem <span class="text-rose-500">*</span>
                                        </label>
                                        <select name="kuarters_complaint_type" id="kuarters_complaint_type" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-medium outline-none">
                                            <?php foreach ($kuartersComplaintList as $kKey => $k): ?>
                                            <option value="<?= $kKey ?>"><?= $k['icon'] ?? '•' ?> <?= e($k['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Tarikh Isu / Ralat Berlaku <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="date" name="kuarters_date" id="kuarters_date" value="<?= $today ?>" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs font-bold text-slate-900 outline-none">
                                    </div>
                                </div>

                                <!-- 3. Tahap Keutamaan / Urgensi -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Tahap Urgensi / Keutamaan Tindakan
                                    </label>
                                    <select name="kuarters_urgency" id="kuarters_urgency" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none font-medium">
                                        <option value="BIASA">Biasa</option>
                                        <option value="SEGERA">Segera</option>
                                        <option value="KECEMASAN">Kritikal</option>
                                    </select>
                                </div>

                                <!-- 4. Keterangan Terperinci Masalah -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Keterangan Terperinci Ralat / Masalah Sistem <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="kuarters_problem_description" id="kuarters_problem_description" rows="3"
                                              placeholder="Sila terangkan mesej ralat (error message) yang dipaparkan, modul terlibat (cth: modul permohonan, muat naik fail), atau tindakan yang cuba dibuat semasa ralat berlaku..." 
                                              class="w-full px-3 py-2 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#1d3d75] rounded-xl text-xs outline-none leading-relaxed placeholder:text-slate-400"></textarea>
                                </div>

                                <!-- 5. Upload Tangkapan Skrin Ralat (Clean Neutral Box) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Upload Tangkapan Skrin Ralat (Screenshot Error / Mesej Sistem) (Pilihan)
                                    </label>
                                    <div class="relative border-2 border-dashed border-slate-300 hover:border-[#1d3d75] rounded-xl p-3.5 bg-slate-50/50 hover:bg-white text-center transition-all cursor-pointer" onclick="document.getElementById('kuarters_photo').click()">
                                        <input type="file" name="kuarters_photo" id="kuarters_photo" accept="image/jpeg,image/png,image/webp,image/jpg" class="hidden" onchange="previewKuartersImage(this)">
                                        
                                        <div id="kuarters_upload_prompt" class="space-y-1">
                                            <div class="w-8 h-8 mx-auto rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-sm shadow-2xs">
                                                📸
                                            </div>
                                            <p class="text-xs font-bold text-slate-800">Klik untuk Pilih Tangkapan Skrin Ralat (Screenshot)</p>
                                            <p class="text-[10px] text-slate-500">Format disokong: JPG, PNG, WebP (Maksimum 10MB)</p>
                                        </div>

                                        <!-- Image Live Preview Container -->
                                        <div id="kuarters_preview_box" class="hidden space-y-2">
                                            <div class="relative inline-block mx-auto">
                                                <img id="kuarters_img_preview" src="" alt="Preview Gambar Ralat" class="max-h-28 rounded-lg border border-slate-300 shadow-sm mx-auto object-cover">
                                                <button type="button" onclick="event.stopPropagation(); removeKuartersImage();" class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-rose-600 text-white font-bold text-xs flex items-center justify-center shadow hover:bg-rose-700">
                                                    &times;
                                                </button>
                                            </div>
                                            <p id="kuarters_file_name" class="text-[10px] font-mono text-slate-600 truncate"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submission Action Button (Frontpage Corporate Theme) -->
                        <div class="pt-1">
                            <button type="submit" 
                                    class="w-full py-3.5 bg-[#1d3d75] hover:bg-[#163060] active:scale-[0.99] text-white font-bold text-sm rounded-xl shadow-xl shadow-blue-950/15 hover:shadow-2xl transition-all duration-300 flex items-center justify-center gap-3 group">
                                <span>Hantar Permohonan Rasmi Sekarang</span>
                                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white group-hover:text-[#1d3d75] transition-all">
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            </button>
                            <p class="text-[11px] text-center text-slate-500 mt-2 font-medium">
                                Permohonan akan disalurkan secara automatik kepada <strong>Bahagian Khidmat Pengurusan (BKP)</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle address box for kuarters resident vs applicant
function toggleKuartersAddress(status) {
    const box = document.getElementById('kuarters-address-box');
    const complex = document.getElementById('kuarters_complex');
    const unitNo = document.getElementById('kuarters_unit_no');
    if (status === 'PENGHUNI_SEDIA_ADA') {
        if (box) box.classList.remove('hidden');
        if (complex) complex.required = true;
        if (unitNo) unitNo.required = true;
    } else {
        if (box) box.classList.add('hidden');
        if (complex) { complex.required = false; complex.value = ''; }
        if (unitNo) { unitNo.required = false; unitNo.value = ''; }
    }
}

// Function to handle switching category views
function switchCategoryView(cat) {
    // Reset all category cards to inactive theme
    document.querySelectorAll('.category-card').forEach(el => {
        el.className = 'category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all bg-white border-slate-200/90 text-slate-700 hover:border-slate-300 hover:bg-slate-50/80 shadow-xs';
        const icon = el.querySelector('.card-icon');
        if (icon) icon.className = 'card-icon w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 text-sm';
        const title = el.querySelector('.card-title');
        if (title) title.className = 'card-title text-xs font-bold text-slate-900 block leading-tight truncate';
        const sub = el.querySelector('.card-sub');
        if (sub) sub.className = 'card-sub text-[10px] text-slate-500 block truncate font-medium mt-0.5';
    });

    // Highlight selected card to frontpage primary navy theme
    const activeLabel = document.querySelector(`.category-card[data-cat="${cat}"]`);
    if (activeLabel) {
        activeLabel.className = 'category-card group relative flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all bg-[#1d3d75] border-[#1d3d75] text-white shadow-lg shadow-blue-950/15';
        const icon = activeLabel.querySelector('.card-icon');
        if (icon) icon.className = 'card-icon w-8 h-8 rounded-xl bg-white/15 text-white flex items-center justify-center shrink-0 text-sm';
        const title = activeLabel.querySelector('.card-title');
        if (title) title.className = 'card-title text-xs font-bold text-white block leading-tight truncate';
        const sub = activeLabel.querySelector('.card-sub');
        if (sub) sub.className = 'card-sub text-[10px] text-blue-100/80 block truncate font-medium mt-0.5';
    }

    // Left Column Sections (Langkah 2)
    const eqSec = document.getElementById('section-equipment');
    const meetSec = document.getElementById('section-meeting');
    const mediaSec = document.getElementById('section-media');
    const techSec = document.getElementById('section-technical');
    const kuartersSec = document.getElementById('section-kuarters');

    // Right Column Sections (Langkah 3)
    const step3Loan = document.getElementById('step3-asset-loan');
    const step3Meeting = document.getElementById('step3-meeting');
    const step3Media = document.getElementById('step3-media');
    const step3Tech = document.getElementById('step3-technical');
    const step3Kuarters = document.getElementById('step3-kuarters');

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

    // 5. Inputs for Kuarters
    const kuartersApplicant = document.getElementById('kuarters_applicant_name');
    const kuartersIc = document.getElementById('kuarters_ic_no');
    const kuartersPhone = document.getElementById('kuarters_phone');
    const kuartersTitle = document.getElementById('kuarters_title');
    const kuartersProb = document.getElementById('kuarters_problem_description');
    const kuartersDate = document.getElementById('kuarters_date');

    // Reset visibility (Langkah 2)
    if (eqSec) eqSec.classList.add('hidden');
    if (meetSec) meetSec.classList.add('hidden');
    if (mediaSec) mediaSec.classList.add('hidden');
    if (techSec) techSec.classList.add('hidden');
    if (kuartersSec) kuartersSec.classList.add('hidden');

    // Reset visibility (Langkah 3)
    if (step3Loan) step3Loan.classList.add('hidden');
    if (step3Meeting) step3Meeting.classList.add('hidden');
    if (step3Media) step3Media.classList.add('hidden');
    if (step3Tech) step3Tech.classList.add('hidden');
    if (step3Kuarters) step3Kuarters.classList.add('hidden');

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

    if (kuartersApplicant) kuartersApplicant.required = false;
    if (kuartersIc) kuartersIc.required = false;
    if (kuartersPhone) kuartersPhone.required = false;
    if (kuartersTitle) kuartersTitle.required = false;
    if (kuartersProb) kuartersProb.required = false;
    if (kuartersDate) kuartersDate.required = false;

    // Activate specific category
    if (cat === 'PEMINJAMAN_ASET') {
        if (eqSec) eqSec.classList.remove('hidden');
        if (step3Loan) step3Loan.classList.remove('hidden');

        if (purposeLoan) purposeLoan.required = true;
        if (locationLoan) locationLoan.required = true;
        if (startLoan) startLoan.required = true;
        if (endLoan) endLoan.required = true;
        if (phoneLoan) phoneLoan.required = true;
    } else if (cat === 'SOKONGAN_MESYUARAT') {
        if (meetSec) meetSec.classList.remove('hidden');
        if (step3Meeting) step3Meeting.classList.remove('hidden');

        if (meetTitle) meetTitle.required = true;
        if (meetLoc) meetLoc.required = true;
        if (meetDate) meetDate.required = true;
        if (meetPurpose) meetPurpose.required = true;
        if (meetPhone) meetPhone.required = true;
    } else if (cat === 'MEDIA_JURUKAMERA') {
        if (mediaSec) mediaSec.classList.remove('hidden');
        if (step3Media) step3Media.classList.remove('hidden');

        if (mediaTitle) mediaTitle.required = true;
        if (mediaLoc) mediaLoc.required = true;
        if (mediaDate) mediaDate.required = true;
        if (mediaPhone) mediaPhone.required = true;
        if (eventAgenda) eventAgenda.required = true;
    } else if (cat === 'LAIN_LAIN') {
        if (techSec) techSec.classList.remove('hidden');
        if (step3Tech) step3Tech.classList.remove('hidden');

        if (techTitle) techTitle.required = true;
        if (techProb) techProb.required = true;
        if (techLoc) techLoc.required = true;
        if (techPhone) techPhone.required = true;
        if (techDate) techDate.required = true;
    } else if (cat === 'ADUAN_KUARTERS') {
        if (kuartersSec) kuartersSec.classList.remove('hidden');
        if (step3Kuarters) step3Kuarters.classList.remove('hidden');

        if (kuartersApplicant) kuartersApplicant.required = true;
        if (kuartersIc) kuartersIc.required = true;
        if (kuartersPhone) kuartersPhone.required = true;
        if (kuartersTitle) kuartersTitle.required = true;
        if (kuartersProb) kuartersProb.required = true;
        if (kuartersDate) kuartersDate.required = true;

        const currentStatus = document.querySelector('input[name="kuarters_resident_status"]:checked');
        toggleKuartersAddress(currentStatus ? currentStatus.value : 'PEMOHON');
    }
}

// Preview uploaded kuarters image
function previewKuartersImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('kuarters_img_preview').src = e.target.result;
            document.getElementById('kuarters_file_name').innerText = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            document.getElementById('kuarters_upload_prompt').classList.add('hidden');
            document.getElementById('kuarters_preview_box').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeKuartersImage() {
    const input = document.getElementById('kuarters_photo');
    if (input) input.value = '';
    const preview = document.getElementById('kuarters_img_preview');
    if (preview) preview.src = '';
    const fn = document.getElementById('kuarters_file_name');
    if (fn) fn.innerText = '';
    const box = document.getElementById('kuarters_preview_box');
    if (box) box.classList.add('hidden');
    const prompt = document.getElementById('kuarters_upload_prompt');
    if (prompt) prompt.classList.remove('hidden');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[name="category"]:checked');
    if (checkedRadio) {
        switchCategoryView(checkedRadio.value);
    }
});
</script>
