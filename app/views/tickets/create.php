<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$user = Auth::user();
$today = date('Y-m-d');
$selectedCategory = (string)($_GET['category'] ?? 'PEMINJAMAN_ASET');
$unitsList = $units ?? app_config('units', []);
?>

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Borang Permohonan Perkhidmatan ICT</h1>
            <p class="text-xs text-slate-500 mt-1">Sila lengkapkan butiran permohonan di bawah untuk semakan Ketua Unit dan Seksyen ICT BKP</p>
        </div>
        <a href="<?= $isLoggedIn ? url('/tickets') : url('/') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3.5 py-2 bg-slate-100 rounded-xl transition-colors">
            &larr; Kembali
        </a>
    </div>

    <!-- Main Form -->
    <form action="<?= url('/tickets') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <!-- STEP 1: Pilih Kategori Perkhidmatan -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Langkah 1</span>
                <h2 class="text-base font-bold text-slate-900">Pilih Kategori Permohonan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Peminjaman Aset -->
                <label class="category-card relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50 <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200' ?>">
                    <input type="radio" name="category" value="PEMINJAMAN_ASET" <?= ($selectedCategory === 'PEMINJAMAN_ASET') ? 'checked' : '' ?> onchange="switchCategoryView('PEMINJAMAN_ASET')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-900 block">Peminjaman Aset</span>
                    <span class="text-xs text-slate-500 mt-1 leading-relaxed">Pinjaman Laptop Dell, iPhone 15, Lenovo Tab, Kamera & Aksesori</span>
                </label>

                <!-- Sokongan Mesyuarat -->
                <label class="category-card relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50 <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'border-indigo-600 bg-indigo-50/40' : 'border-slate-200' ?>">
                    <input type="radio" name="category" value="SOKONGAN_MESYUARAT" <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? 'checked' : '' ?> onchange="switchCategoryView('SOKONGAN_MESYUARAT')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-900 block">Sokongan Mesyuarat</span>
                    <span class="text-xs text-slate-500 mt-1 leading-relaxed">Penyediaan link Cisco Webex/Zoom & bantuan teknikal bilik</span>
                </label>

                <!-- Media & Jurukamera -->
                <label class="category-card relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50 <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'border-purple-600 bg-purple-50/40' : 'border-slate-200' ?>">
                    <input type="radio" name="category" value="MEDIA_JURUKAMERA" <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? 'checked' : '' ?> onchange="switchCategoryView('MEDIA_JURUKAMERA')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-900 block">Khidmat Media</span>
                    <span class="text-xs text-slate-500 mt-1 leading-relaxed">Jurugambar & Juruvideo bagi majlis rasmi</span>
                </label>

                <!-- Lain-lain -->
                <label class="category-card relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50 <?= ($selectedCategory === 'LAIN_LAIN') ? 'border-emerald-600 bg-emerald-50/40' : 'border-slate-200' ?>">
                    <input type="radio" name="category" value="LAIN_LAIN" <?= ($selectedCategory === 'LAIN_LAIN') ? 'checked' : '' ?> onchange="switchCategoryView('LAIN_LAIN')" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-900 block">Bantuan ICT</span>
                    <span class="text-xs text-slate-500 mt-1 leading-relaxed">Konfigurasi, siar raya & aduan teknikal am</span>
                </label>
            </div>
        </div>

        <!-- STEP 2: Butiran Khusus Kategori (Dynamic Display) -->

        <!-- Section: Peminjaman Aset (Checklist Rasmi Peralatan ICT Tanpa Projektor) -->
        <div id="section-equipment" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4 <?= in_array($selectedCategory, ['PEMINJAMAN_ASET', 'LAIN_LAIN']) ? '' : 'hidden' ?>">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Langkah 2</span>
                <h2 class="text-base font-bold text-slate-900">PERALATAN ICT <span class="text-rose-500">*</span></h2>
                <p class="text-xs text-slate-500 mt-0.5">Tandakan satu atau lebih peralatan yang hendak dipinjam bagi acara anda</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                <?php foreach ($equipmentTypes as $eqKey => $eq): ?>
                <label class="flex items-start gap-3 p-3.5 rounded-xl border border-slate-200 hover:bg-blue-50/40 hover:border-blue-300 cursor-pointer transition-colors">
                    <input type="checkbox" name="requested_equipment_types[]" value="<?= $eqKey ?>" 
                           class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-slate-900 block"><?= e($eq['name']) ?></span>
                        <span class="text-[11px] text-slate-500 block leading-tight mt-0.5"><?= e($eq['description']) ?></span>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>

            <!-- Other Custom Equipment Write-in Field -->
            <div id="other-equipment-box" class="pt-2">
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Nyatakan Peralatan Lain (Jika ada)
                </label>
                <input type="text" name="other_equipment_description" placeholder="Cth: Kabel sambungan khas HDMI 20m, Tripod tambahan, dll." 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 rounded-xl text-xs outline-none">
            </div>
        </div>

        <!-- Section: Sokongan Mesyuarat (Cisco Webex Meetings Teratas) -->
        <div id="section-meeting" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5 <?= ($selectedCategory === 'SOKONGAN_MESYUARAT') ? '' : 'hidden' ?>">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Langkah 2</span>
                <h2 class="text-base font-bold text-slate-900">Senarai Konfigurasi Sokongan Mesyuarat</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jenis / Mod Sokongan Mesyuarat
                    </label>
                    <select name="meeting_type" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                        <?php foreach ($meetingTypes as $mKey => $m): ?>
                        <option value="<?= $mKey ?>"><?= e($m['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Platform Mesyuarat Online
                    </label>
                    <select name="meeting_platform" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none font-medium">
                        <?php foreach ($meetingPlatforms as $pKey => $p): ?>
                        <option value="<?= $pKey ?>"><?= e($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pautan Mesyuarat (Jika sudah ada)
                    </label>
                    <input type="url" name="meeting_link" placeholder="https://johor.webex.com/..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Passcode / Kata Laluan Bilik
                    </label>
                    <input type="text" name="meeting_passcode" placeholder="Cth: BKP2026" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                </div>
            </div>
        </div>

        <!-- Section: Khidmat Media -->
        <div id="section-media" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5 <?= ($selectedCategory === 'MEDIA_JURUKAMERA') ? '' : 'hidden' ?>">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-bold text-purple-600 uppercase tracking-wider">Langkah 2</span>
                <h2 class="text-base font-bold text-slate-900">Skop Liputan Media & Dokumentasi</h2>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Skop Perkhidmatan Jurukamera
                </label>
                <select name="media_scope" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                    <?php foreach ($mediaScopes as $scKey => $sc): ?>
                    <option value="<?= $scKey ?>"><?= e($sc) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Tentatif / Agenda Ringkas Majlis
                </label>
                <textarea name="event_agenda" rows="3" placeholder="Sila nyatakan susunan majlis, masa ketibaan tetamu utama..." 
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none"></textarea>
            </div>
        </div>

        <!-- STEP 3: Maklumat Program & Jadual Acara (Dengan Ruangan Pengerusi & Masa Mula Sahaja) -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Langkah 3</span>
                <h2 class="text-base font-bold text-slate-900">Maklumat Acara & Jadual Masa</h2>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Tajuk Permohonan / Nama Program <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" required 
                       placeholder="Cth: Peminjaman Laptop Dell, Kamera & Pointer Logitech bagi Taklimat Sistem BKP" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 rounded-xl text-sm font-medium outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pengerusi Mesyuarat / Majlis
                    </label>
                    <input type="text" name="vip_attendees" 
                           placeholder="Cth: YB Setiausaha Kerajaan Negeri / Timbalan SUK / Ketua Bahagian..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Lokasi / Bilik Mesyuarat / Tempat Acara <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="location" required 
                           placeholder="Cth: Bilik Mesyuarat Utama BKP (Aras 3)" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Tujuan Permohonan & Justifikasi Rasmi <span class="text-rose-500">*</span>
                </label>
                <textarea name="purpose" rows="3" required
                          placeholder="Nyatakan tujuan rasmi dan keperluan khidmat ICT/peralatan ini..." 
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 rounded-xl text-xs outline-none"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    No. Telefon Pemohon untuk Dihubungi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="applicant_phone" required value="<?= e($isLoggedIn ? ($user['phone'] ?? '') : '') ?>" 
                       placeholder="01X-XXXXXXX atau VoIP" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none">
            </div>

            <!-- Date & Time Range (Masa Mula Sahaja) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tarikh Mula <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="start_date" required value="<?= $today ?>" min="<?= $today ?>"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs font-medium outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tarikh Tamat <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="end_date" required value="<?= $today ?>" min="<?= $today ?>"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs font-medium outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Masa Mula <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" name="start_time" required value="09:00" 
                            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs font-medium outline-none">
                </div>
            </div>

            <?php if (!$isLoggedIn): ?>
            <!-- Applicant Details for Guests -->
            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-200 space-y-4">
                <div class="border-b border-blue-200/80 pb-2">
                    <span class="text-[11px] font-bold text-blue-800 uppercase tracking-wider">Maklumat Pegawai Pemohon</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Unit / Bahagian BKP <span class="text-rose-500">*</span>
                        </label>
                        <select name="unit" required class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs outline-none font-medium">
                            <?php foreach ($unitsList as $uKey => $u): ?>
                            <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Penuh Pegawai <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="applicant_name" required placeholder="Cth: Ahmad Faiz bin Khairuddin"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Emel Rasmi Kerajaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="applicant_email" required placeholder="nama@johor.gov.my"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jawatan & Gred
                        </label>
                        <input type="text" name="applicant_position" placeholder="Cth: Penolong Pegawai Tadbir (N29)"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs outline-none font-medium">
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Compliance & Submission Box -->
        <div class="bg-blue-50/60 p-6 rounded-2xl border border-blue-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-blue-950 space-y-1">
                <p class="font-bold flex items-center gap-1.5 text-blue-900">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pematuhan Aliran Kerja Rasmi BKP
                </p>
                <p class="text-blue-800">
                    Permohonan ini akan disalurkan secara automatik kepada <strong>Ketua Unit</strong> anda untuk perakuan sebelum dinilai dan diluluskan oleh <strong>Seksyen ICT BKP</strong>. Anda boleh menyemak status permohonan dengan No. Tiket, atau log masuk (kata laluan asas: 123456) untuk melihat sejarah penuh.
                </p>
            </div>

            <button type="submit" 
                    class="px-7 py-3.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all shrink-0 focus:ring-4 focus:ring-blue-300 flex items-center gap-2">
                <span>Hantar Permohonan Rasmi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
</div>

<script>
function switchCategoryView(cat) {
    document.querySelectorAll('.category-card').forEach(el => {
        el.className = 'category-card relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50 border-slate-200';
    });

    const eqSec = document.getElementById('section-equipment');
    const meetSec = document.getElementById('section-meeting');
    const mediaSec = document.getElementById('section-media');

    if (cat === 'PEMINJAMAN_ASET') {
        eqSec.classList.remove('hidden');
        meetSec.classList.add('hidden');
        mediaSec.classList.add('hidden');
    } else if (cat === 'SOKONGAN_MESYUARAT') {
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
</script>
