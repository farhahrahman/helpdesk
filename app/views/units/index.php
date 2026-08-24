<?php
use App\Core\Auth;

$user = Auth::user();
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pengurusan Nama Unit/Bahagian & Senarai Jawatan</h1>
            <p class="text-xs text-slate-500 mt-1">Kemaskini nama rasmi unit, nama ringkas, struktur organisasi BKP serta senarai piawai jawatan & gred</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="openModal('add-unit-modal')" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-colors">
                + Tambah Unit Baru
            </button>
            <button type="button" onclick="openModal('add-position-modal')" 
                    class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition-colors">
                + Tambah Jawatan Baru
            </button>
        </div>
    </div>

    <!-- Section 1: Pengurusan Unit / Bahagian -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900 tracking-tight">Struktur Unit BKP & Pejabat TSUK</h2>
                <p class="text-xs text-slate-500 mt-0.5">Nama unit ini diguna pakai secara langsung dalam borang permohonan, tapisan, dan slip cetakan</p>
            </div>
            <span class="px-3 py-1 text-xs font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-100">
                <?= count($units) ?> Unit Didaftarkan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200/80 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Kod Unit</th>
                        <th class="py-3.5 px-4">Nama Penuh Unit / Bahagian</th>
                        <th class="py-3.5 px-4">Nama Ringkas</th>
                        <th class="py-3.5 px-4">Keterangan / Fungsi</th>
                        <th class="py-3.5 px-4">Warna Lencana</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($units as $u): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 px-6 whitespace-nowrap font-mono font-bold text-slate-900">
                            <?= e($u['code']) ?>
                        </td>
                        <td class="py-4 px-4 font-bold text-slate-900">
                            <?= e($u['name']) ?>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-block px-2.5 py-1 text-[11px] font-semibold rounded bg-slate-100 text-slate-800 border border-slate-200">
                                <?= e($u['short_name']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-500 max-w-xs">
                            <?= e($u['description'] ?? '-') ?>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-<?= $u['badge_color'] ?? 'slate' ?>-50 text-<?= $u['badge_color'] ?? 'slate' ?>-700 border border-<?= $u['badge_color'] ?? 'slate' ?>-200">
                                <span class="w-2 h-2 rounded-full bg-<?= $u['badge_color'] ?? 'slate' ?>-500"></span>
                                <?= e($u['badge_color'] ?? 'slate') ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <button type="button" 
                                    onclick="openEditUnitModal('<?= e($u['code']) ?>', '<?= e(addslashes($u['name'])) ?>', '<?= e(addslashes($u['short_name'])) ?>', '<?= e(addslashes($u['description'] ?? '')) ?>', '<?= e($u['badge_color'] ?? 'blue') ?>')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-semibold rounded-lg border border-slate-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>Kemaskini</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Senarai Jawatan & Gred Perkhidmatan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900 tracking-tight">Senarai Jawatan & Gred Perkhidmatan BKP</h2>
                <p class="text-xs text-slate-500 mt-0.5">Katalog jawatan rasmi yang dipautkan ke profil staf dan borang pendaftaran</p>
            </div>
            <span class="px-3 py-1 text-xs font-bold bg-slate-100 text-slate-700 rounded-lg">
                <?= count($positions) ?> Jawatan
            </span>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <?php foreach ($positions as $pos): ?>
                <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-slate-50 transition-colors flex items-center justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <span class="font-bold text-slate-800 text-xs block truncate" title="<?= e($pos['title']) ?>">
                            <?= e($pos['title']) ?>
                        </span>
                        <span class="text-[10px] text-slate-400 font-mono"><?= e($pos['id'] ?? '') ?></span>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <!-- Edit Position -->
                        <button type="button" onclick="openEditPosModal('<?= e($pos['id']) ?>', '<?= e(addslashes($pos['title'])) ?>')" 
                                class="p-1 text-slate-400 hover:text-blue-600 rounded" title="Kemaskini Jawatan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <!-- Delete Position -->
                        <form action="<?= url('/settings/positions/' . $pos['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Padamkan jawatan ini?')" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded" title="Padam Jawatan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Unit -->
<div id="edit-unit-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-lg w-full rounded-2xl p-6 sm:p-8 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kemaskini Nama & Maklumat Unit</h3>
                <p class="text-[11px] text-slate-500">Kod Unit: <span id="edit-unit-code-badge" class="font-mono font-bold text-blue-600"></span></p>
            </div>
            <button type="button" onclick="closeModal('edit-unit-modal')" class="text-slate-400 hover:text-slate-700 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="edit-unit-form" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Penuh Unit / Bahagian <span class="text-rose-500">*</span></label>
                <input type="text" id="edit-unit-name" name="name" required 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs focus:bg-white focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Nama Ringkas (Short Name) <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-unit-short-name" name="short_name" required 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Warna Lencana (Badge Color)</label>
                    <select id="edit-unit-badge-color" name="badge_color" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs">
                        <option value="blue">Biru (Blue)</option>
                        <option value="indigo">Indigo</option>
                        <option value="emerald">Hijau (Emerald)</option>
                        <option value="amber">Kuning / Oren (Amber)</option>
                        <option value="purple">Ungu (Purple)</option>
                        <option value="rose">Merah (Rose)</option>
                        <option value="cyan">Cyan</option>
                        <option value="sky">Sky Blue</option>
                        <option value="slate">Kelabu (Slate)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Keterangan / Fungsi Utama Unit</label>
                <textarea id="edit-unit-desc" name="description" rows="2" 
                          class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs focus:bg-white focus:border-blue-500"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('edit-unit-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add New Unit -->
<div id="add-unit-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-lg w-full rounded-2xl p-6 sm:p-8 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <h3 class="text-base font-bold text-slate-900">Daftar Unit / Bahagian Baru</h3>
            <button type="button" onclick="closeModal('add-unit-modal')" class="text-slate-400 hover:text-slate-700 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= url('/settings/units/create') ?>" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Kod Unit (cth: INTEGRITI) <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" required placeholder="Cth: INTEGRITI" 
                           class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-mono font-bold uppercase text-xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Warna Lencana</label>
                    <select name="badge_color" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs">
                        <option value="blue">Biru (Blue)</option>
                        <option value="indigo">Indigo</option>
                        <option value="emerald">Hijau (Emerald)</option>
                        <option value="amber">Amber</option>
                        <option value="purple">Purple</option>
                        <option value="rose">Rose</option>
                        <option value="cyan">Cyan</option>
                        <option value="slate">Slate</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Penuh Unit / Bahagian <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Cth: Unit Integriti & Tadbir Urus" 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Ringkas (Short Name) <span class="text-rose-500">*</span></label>
                <input type="text" name="short_name" required placeholder="Cth: Unit Integriti" 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Keterangan / Skop Fungsi Unit</label>
                <textarea name="description" rows="2" placeholder="Fungsi dan tanggungjawab unit..."
                          class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none text-xs"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('add-unit-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">Daftar Unit</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Position -->
<div id="add-position-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-2xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-1">Tambah Gelaran Jawatan / Gred Baru</h3>
        <p class="text-xs text-slate-500 mb-4">Jawatan ini akan ditambah ke senarai pilihan standard staf.</p>
        <form action="<?= url('/settings/positions/create') ?>" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Gelaran Jawatan & Gred <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="Cth: Pegawai Keselamatan Gred KP41" 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs">
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('add-position-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">Tambah Jawatan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Position -->
<div id="edit-pos-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-2xl p-6 shadow-2xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-1">Kemaskini Gelaran Jawatan</h3>
        <p class="text-xs text-slate-500 mb-4">Pinda nama atau gred bagi jawatan ini.</p>
        <form id="edit-pos-form" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Gelaran Jawatan <span class="text-rose-500">*</span></label>
                <input type="text" id="edit-pos-title" name="title" required 
                       class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl outline-none font-medium text-xs">
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('edit-pos-modal')" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">Simpan Pindaan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditUnitModal(code, name, shortName, desc, color) {
    document.getElementById('edit-unit-code-badge').innerText = code;
    document.getElementById('edit-unit-name').value = name;
    document.getElementById('edit-unit-short-name').value = shortName;
    document.getElementById('edit-unit-desc').value = desc;
    document.getElementById('edit-unit-badge-color').value = color;
    document.getElementById('edit-unit-form').action = "<?= url('/settings/units') ?>/" + encodeURIComponent(code) + "/update";
    openModal('edit-unit-modal');
}

function openEditPosModal(id, title) {
    document.getElementById('edit-pos-title').value = title;
    document.getElementById('edit-pos-form').action = "<?= url('/settings/positions') ?>/" + encodeURIComponent(id) + "/update";
    openModal('edit-pos-modal');
}
</script>
