<?php
use App\Core\Auth;

$user = Auth::user();
$isAdmin = Auth::isAdmin();
$unitName = $units[$user['unit']]['name'] ?? $user['unit'];
?>

<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Profil Pengguna & Keselamatan</h1>
            <p class="text-xs text-slate-500 mt-1">Kemaskini maklumat peribadi, nombor telefon dan kata laluan anda</p>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="<?= url('/profile') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Basic Info -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Maklumat Pegawai</h3>
                    <?php if (!$isAdmin): ?>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-semibold bg-amber-50 text-amber-800 rounded-lg border border-amber-200">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Jawatan & Unit dikawal oleh Pentadbir
                    </span>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Penuh</label>
                    <input type="text" name="name" value="<?= e($user['name'] ?? '') ?>" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Emel Rasmi Kerajaan</label>
                        <input type="email" value="<?= e($user['email'] ?? '') ?>" disabled
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 text-xs text-slate-500 rounded-xl outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Unit / Bahagian <?= !$isAdmin ? '<span class="text-amber-600 font-normal text-[10px]">(Kekal)</span>' : '' ?>
                        </label>
                        <?php if ($isAdmin): ?>
                        <select name="unit" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none">
                            <?php foreach ($units as $uKey => $u): ?>
                            <option value="<?= $uKey ?>" <?= (($user['unit'] ?? '') === $uKey) ? 'selected' : '' ?>><?= e($u['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php else: ?>
                        <input type="text" value="<?= e($unitName) ?>" disabled
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 text-xs text-slate-600 font-medium rounded-xl outline-none cursor-not-allowed">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Gelaran Jawatan / Gred <?= !$isAdmin ? '<span class="text-amber-600 font-normal text-[10px]">(Kekal)</span>' : '' ?>
                        </label>
                        <?php if ($isAdmin): ?>
                        <input type="text" name="position" value="<?= e($user['position'] ?? '') ?>" list="positions-list"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none">
                        <datalist id="positions-list">
                            <?php foreach (app_config('positions.standard_positions', []) as $pos): ?>
                            <option value="<?= e($pos) ?>"></option>
                            <?php endforeach; ?>
                        </datalist>
                        <?php else: ?>
                        <input type="text" value="<?= e($user['position'] ?? 'Pegawai') ?>" disabled
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 text-xs text-slate-600 font-medium rounded-xl outline-none cursor-not-allowed">
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Telefon Bimbit</label>
                        <input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-medium rounded-xl outline-none focus:bg-white focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Tukar Kata Laluan (Pilihan)</h3>
                <p class="text-xs text-slate-500">Biarkan kosong sekiranya tidak ingin menukar kata laluan semasa.</p>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Laluan Baru</label>
                    <input type="password" name="password" placeholder="Masukkan kata laluan baru jika ingin menukar..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs rounded-xl outline-none focus:bg-white focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
