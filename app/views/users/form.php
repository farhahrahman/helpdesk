<?php
$isEdit = !empty($user);
$actionUrl = $isEdit ? url("/users/{$user['id']}/update") : url('/users');
$standardPositions = app_config('positions.standard_positions', []);
?>

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                <?= $isEdit ? 'Kemaskini Maklumat Pegawai (Admin Sahaja)' : 'Daftar Pengguna / Staf Baru' ?>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                <?= $isEdit ? "Pentadbir sahaja dibenarkan menukar unit, peranan dan jawatan bagi {$user['name']}" : 'Daftarkan pegawai baru bagi 6 Unit BKP atau Pejabat TSUK' ?>
            </p>
        </div>
        <a href="<?= url('/users') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 bg-slate-100 rounded-lg">
            &larr; Kembali ke Senarai
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="<?= $actionUrl ?>" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">
                    Nama Penuh Pegawai <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" required 
                       value="<?= e($user['name'] ?? old('name')) ?>"
                       placeholder="Cth: Ahmad Razak bin Osman" 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs focus:bg-white focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">
                        Emel Rasmi Kerajaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" required 
                           value="<?= e($user['email'] ?? old('email')) ?>"
                           placeholder="nama@bkp.gov.my" 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">
                        Kata Laluan <?= $isEdit ? '(Biarkan kosong jika tidak tukar)' : '<span class="text-rose-500">*</span>' ?>
                    </label>
                    <input type="text" name="password" 
                           placeholder="<?= $isEdit ? 'Kekalkan kata laluan semasa' : 'Cth: password123' ?>"
                           value="<?= !$isEdit ? 'password123' : '' ?>"
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-mono text-xs focus:bg-white focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">
                        Unit / Bahagian (Admin Sahaja) <span class="text-rose-500">*</span>
                    </label>
                    <select name="unit" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                        <?php foreach ($units as $uKey => $u): ?>
                        <option value="<?= $uKey ?>" <?= (($user['unit'] ?? '') === $uKey) ? 'selected' : '' ?>>
                            <?= e($u['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">
                        Peranan (RBAC) <span class="text-rose-500">*</span>
                    </label>
                    <select name="role" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                        <?php foreach ($roles as $rKey => $r): ?>
                        <option value="<?= $rKey ?>" <?= (($user['role'] ?? '') === $rKey) ? 'selected' : '' ?>>
                            <?= e($r['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">
                        Gelaran Jawatan / Gred (Admin Sahaja) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="position" required list="standard-positions"
                           value="<?= e($user['position'] ?? old('position')) ?>"
                           placeholder="Pilih atau taip jawatan..." 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                    <datalist id="standard-positions">
                        <?php foreach ($standardPositions as $pos): ?>
                        <option value="<?= e($pos) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">No. Telefon Bimbit</label>
                    <input type="text" name="phone" 
                           value="<?= e($user['phone'] ?? old('phone')) ?>"
                           placeholder="01X-XXXXXXX" 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500">
                </div>
            </div>

            <?php if ($isEdit): ?>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Status Akaun</label>
                <select name="is_active" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs">
                    <option value="1" <?= (($user['is_active'] ?? true) == 1) ? 'selected' : '' ?>>Aktif (Boleh log masuk)</option>
                    <option value="0" <?= (($user['is_active'] ?? true) == 0) ? 'selected' : '' ?>>Tidak Aktif (Akses disekat)</option>
                </select>
            </div>
            <?php endif; ?>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <a href="<?= url('/users') ?>" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">
                    <?= $isEdit ? 'Kemaskini Maklumat' : 'Daftar Pengguna Baru' ?>
                </button>
            </div>
        </form>
    </div>
</div>
