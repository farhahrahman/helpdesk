<?php
$isEdit = !empty($asset);
$actionUrl = $isEdit ? url("/assets/{$asset['id']}/update") : url('/assets');
?>

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                <?= $isEdit ? 'Kemaskini Maklumat Aset' : 'Daftar Aset ICT Baru' ?>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                <?= $isEdit ? "Kemaskini butiran bagi kod pendaftaran {$asset['asset_code']}" : 'Daftarkan peranti atau peralatan baru ke dalam inventori ICT BKP' ?>
            </p>
        </div>
        <a href="<?= url('/assets') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 bg-slate-100 rounded-lg">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="<?= $actionUrl ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kod Pendaftaran Aset <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="asset_code" required 
                           value="<?= e($asset['asset_code'] ?? old('asset_code')) ?>"
                           placeholder="Cth: BKP/ICT/IPH/2026/03"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 font-mono text-xs font-bold uppercase rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kategori Jenis Peranti <span class="text-rose-500">*</span>
                    </label>
                    <select name="type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none">
                        <?php foreach ($equipmentTypes as $eqKey => $eq): ?>
                        <option value="<?= $eqKey ?>" <?= (($asset['type'] ?? '') === $eqKey) ? 'selected' : '' ?>>
                            <?= e($eq['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Nama Penuh Aset / Peranti <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" required 
                       value="<?= e($asset['name'] ?? old('name')) ?>"
                       placeholder="Cth: Apple iPhone 15 Pro 256GB"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenama</label>
                    <input type="text" name="brand" value="<?= e($asset['brand'] ?? old('brand')) ?>" placeholder="Cth: Apple"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Model</label>
                    <input type="text" name="model" value="<?= e($asset['model'] ?? old('model')) ?>" placeholder="Cth: iPhone 15 Pro"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Siri</label>
                    <input type="text" name="serial_no" value="<?= e($asset['serial_no'] ?? old('serial_no')) ?>" placeholder="Cth: SN-12345"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-xs font-mono rounded-xl outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Ketersediaan</label>
                    <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none">
                        <option value="TERSEDIA" <?= (($asset['status'] ?? '') === 'TERSEDIA') ? 'selected' : '' ?>>TERSEDIA (Boleh Dipinjam)</option>
                        <option value="DIPINJAM" <?= (($asset['status'] ?? '') === 'DIPINJAM') ? 'selected' : '' ?>>DIPINJAM (Sedang Digunakan)</option>
                        <option value="PENYELENGGARAAN" <?= (($asset['status'] ?? '') === 'PENYELENGGARAAN') ? 'selected' : '' ?>>PENYELENGGARAAN (Servis)</option>
                        <option value="ROSAK" <?= (($asset['status'] ?? '') === 'ROSAK') ? 'selected' : '' ?>>ROSAK</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keadaan Fizikal</label>
                    <select name="condition" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none">
                        <option value="BAIK" <?= (($asset['condition'] ?? '') === 'BAIK') ? 'selected' : '' ?>>BAIK (Sempurna)</option>
                        <option value="SEDERHANA" <?= (($asset['condition'] ?? '') === 'SEDERHANA') ? 'selected' : '' ?>>SEDERHANA (Ada Kesan Penggunaan)</option>
                        <option value="PERLU_SERVIS" <?= (($asset['condition'] ?? '') === 'PERLU_SERVIS') ? 'selected' : '' ?>>PERLU PENYELENGGARAAN</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pakej Aksesori / Catatan</label>
                <textarea name="notes" rows="3" placeholder="Senarai aksesori yang disertakan (cth: Pengecas, kabel USB-C, bateri tambahan, beg...)"
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none"><?= e($asset['notes'] ?? old('notes')) ?></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="<?= url('/assets') ?>" class="px-4 py-2.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm">
                    <?= $isEdit ? 'Kemaskini Aset' : 'Simpan & Daftar Aset' ?>
                </button>
            </div>
        </form>
    </div>
</div>
