<?php
use App\Core\Auth;

$currentUser = Auth::user();
$standardPositions = app_config('positions.standard_positions', []);
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">SENARAI PENGGUNA</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar pengguna baru, kemaskini maklumat jawatan, unit, peranan (RBAC), dan kawalan akses sistem</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="openModal('add-user-modal')" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-xl shadow-sm transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span>+ Tambah Pengguna Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="GET" action="<?= url('/users') ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <input type="text" name="search" value="<?= e($search ?? '') ?>" 
                       placeholder="Cari nama pegawai, emel, atau jawatan..." 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-500 rounded-xl text-xs outline-none">
            </div>

            <!-- Unit Filter -->
            <div>
                <select name="unit" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs outline-none font-medium">
                    <option value="">Semua Unit & Pejabat</option>
                    <?php foreach ($units as $uKey => $u): ?>
                    <option value="<?= $uKey ?>" <?= (($unitFilter ?? '') === $uKey) ? 'selected' : '' ?>><?= e($u['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs rounded-xl shadow-sm transition-colors">
                    Tapis
                </button>
                <a href="<?= url('/users') ?>" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold" title="Set Semula">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table Card (Optimized Compact Responsive Width) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/90 text-slate-700 uppercase font-bold text-[11px] border-b border-slate-200/80 tracking-wider">
                    <tr>
                        <th class="py-3 px-4 min-w-[220px]">Nama Pegawai / Emel</th>
                        <th class="py-3 px-3 min-w-[160px]">Jawatan & Gred</th>
                        <th class="py-3 px-3 min-w-[130px]">Unit / Bahagian</th>
                        <th class="py-3 px-3 min-w-[90px]">Peranan</th>
                        <th class="py-3 px-3 min-w-[100px]">No. Telefon</th>
                        <th class="py-3 px-3 min-w-[80px]">Status</th>
                        <th class="py-3 px-4 text-center min-w-[140px] bg-slate-50">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-xs text-slate-400">
                            Tiada rekod pengguna dijumpai mengikut kriteria carian.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $u): ?>
                    <?php 
                    $isActive = $u['is_active'] ?? true; 
                    $roleCode = $u['role'] ?? 'STAF';
                    $roleLabel = ($roleCode === 'ADMIN') ? 'Admin' : (($roleCode === 'KETUA_UNIT') ? 'Ketua Unit' : 'Staf');
                    $roleBadgeClass = ($roleCode === 'ADMIN') ? 'bg-blue-50 text-blue-700 border-blue-200' : (($roleCode === 'KETUA_UNIT') ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-slate-100 text-slate-700 border-slate-200');
                    ?>
                    <tr class="hover:bg-blue-50/30 transition-colors <?= !$isActive ? 'opacity-60 bg-slate-50/40' : '' ?>">
                        <!-- Nama & Emel -->
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-[11px] ring-2 ring-slate-100 shrink-0">
                                    <?= strtoupper(substr($u['name'] ?? 'U', 0, 2)) ?>
                                </div>
                                <div class="min-w-0 max-w-[200px]">
                                    <span class="font-bold text-slate-900 block truncate" title="<?= e($u['name']) ?>"><?= e($u['name']) ?></span>
                                    <span class="text-slate-400 text-[11px] truncate block" title="<?= e($u['email']) ?>"><?= e($u['email']) ?></span>
                                </div>
                            </div>
                        </td>

                        <!-- Jawatan & Gred -->
                        <td class="py-3 px-3 font-medium text-slate-800">
                            <div class="line-clamp-2 leading-snug">
                                <?= e($u['position'] ?? 'Pegawai') ?>
                            </div>
                        </td>

                        <!-- Unit -->
                        <td class="py-3 px-3 whitespace-nowrap">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                <?= e($units[$u['unit']]['short_name'] ?? $u['unit']) ?>
                            </span>
                        </td>

                        <!-- Peranan RBAC (Shortened Tag) -->
                        <td class="py-3 px-3 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border <?= $roleBadgeClass ?>">
                                <?= e($roleLabel) ?>
                            </span>
                        </td>

                        <!-- Telefon -->
                        <td class="py-3 px-3 whitespace-nowrap font-mono text-[11px] text-slate-600">
                            <?= e($u['phone'] ?: '-') ?>
                        </td>

                        <!-- Status -->
                        <td class="py-3 px-3 whitespace-nowrap">
                            <?php if ($isActive): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                            <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Nyahaktif
                            </span>
                            <?php endif; ?>
                        </td>

                        <!-- Tindakan (Always 100% Visible with Compact Actions Bar) -->
                        <td class="py-3 px-4 text-center whitespace-nowrap bg-slate-50/40">
                            <div class="inline-flex items-center justify-center gap-1">
                                <!-- Edit Button -->
                                <a href="<?= url('/users/' . $u['id'] . '/edit') ?>" 
                                   class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg border border-blue-200 transition-colors" 
                                   title="Kemaskini Profil & Jawatan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <!-- Reset Password Button -->
                                <button type="button" onclick="openResetModal('<?= e($u['id']) ?>', '<?= e($u['name']) ?>')" 
                                        class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg border border-amber-200 transition-colors" 
                                        title="Set Semula Kata Laluan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                </button>

                                <?php if ($u['id'] !== $currentUser['id']): ?>
                                <!-- Toggle Status Button -->
                                <form action="<?= url('/users/' . $u['id'] . '/toggle-status') ?>" method="POST" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" 
                                            class="p-1.5 <?= $isActive ? 'bg-slate-100 hover:bg-slate-200 text-slate-700 border-slate-300' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border-emerald-200' ?> rounded-lg border transition-colors" 
                                            title="<?= $isActive ? 'Nyahaktifkan Akaun' : 'Aktifkan Semula Akaun' ?>">
                                        <?php if ($isActive): ?>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        <?php else: ?>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <?php endif; ?>
                                    </button>
                                </form>

                                <!-- Delete Button -->
                                <button type="button" onclick="openDeleteModal('<?= e($u['id']) ?>', '<?= e($u['name']) ?>')" 
                                        class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg border border-rose-200 transition-colors" 
                                        title="Padam Pengguna">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Add New User (Admin Only) -->
<div id="add-user-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-lg w-full rounded-2xl p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Pengguna Baru</h3>
                <p class="text-[11px] text-slate-500">Hanya Pentadbir dibenarkan menentukan Unit dan Jawatan pengguna</p>
            </div>
            <button type="button" onclick="closeModal('add-user-modal')" class="text-slate-400 hover:text-slate-700 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= url('/users') ?>" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Penuh Pegawai <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Cth: Ahmad Razak bin Osman" 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs focus:bg-white focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Emel Rasmi <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="nama@johor.gov.my" 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Kata Laluan Awal</label>
                    <input type="text" name="password" value="123456" 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-mono text-xs focus:bg-white focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Unit / Bahagian (Admin Sahaja) <span class="text-rose-500">*</span></label>
                    <select name="unit" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                        <?php foreach ($units as $uKey => $u): ?>
                        <option value="<?= $uKey ?>"><?= e($u['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Peranan (RBAC) <span class="text-rose-500">*</span></label>
                    <select name="role" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                        <?php foreach ($roles as $rKey => $r): ?>
                        <option value="<?= $rKey ?>" <?= ($rKey === 'STAF') ? 'selected' : '' ?>><?= e($r['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Gelaran Jawatan & Gred <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" required list="standard-positions" placeholder="Pilih atau taip jawatan..." 
                            class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500 font-medium">
                    <datalist id="standard-positions">
                        <?php foreach ($standardPositions as $pos): ?>
                        <option value="<?= e($pos) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">No. Telefon Bimbit / VoIP</label>
                    <input type="text" name="phone" placeholder="01X-XXXXXXX atau VoIP" 
                            class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('add-user-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg text-xs">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs shadow-sm">Daftar Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reset Password -->
<div id="reset-password-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-1">Set Semula Kata Laluan</h3>
        <p class="text-xs text-slate-600 mb-4">Set semula kata laluan bagi pengguna <strong id="reset-user-name" class="text-slate-900"></strong>.</p>
        <form id="reset-password-form" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Kata Laluan Baru</label>
                <input type="text" name="new_password" value="123456" required 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-mono text-xs">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('reset-password-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg shadow-sm">Set Semula</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="delete-user-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-xl border border-slate-200">
        <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Padam Pengguna</h3>
        <p class="text-xs text-slate-600 mb-4">Adakah anda pasti ingin memadamkan rekod pengguna <strong id="delete-user-name" class="text-slate-900"></strong>? Tindakan ini tidak boleh diundur semula.</p>
        <form id="delete-user-form" method="POST" class="flex justify-end gap-2">
            <?= csrf_field() ?>
            <button type="button" onclick="closeModal('delete-user-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">Batal</button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg shadow-sm">Ya, Padam</button>
        </form>
    </div>
</div>

<script>
function openResetModal(userId, userName) {
    document.getElementById('reset-user-name').innerText = userName;
    document.getElementById('reset-password-form').action = "<?= url('/users/') ?>/" + encodeURIComponent(userId) + "/reset-password";
    openModal('reset-password-modal');
}

function openDeleteModal(userId, userName) {
    document.getElementById('delete-user-name').innerText = userName;
    document.getElementById('delete-user-form').action = "<?= url('/users/') ?>/" + encodeURIComponent(userId) + "/delete";
    openModal('delete-user-modal');
}
</script>
