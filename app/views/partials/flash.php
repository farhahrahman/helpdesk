<?php
use App\Core\Session;

$success = Session::getFlash('success');
$error = Session::getFlash('error');
$warning = Session::getFlash('warning');
$info = Session::getFlash('info');
?>

<?php if ($success): ?>
<div class="flash-alert mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 flex items-start gap-3 text-emerald-900 shadow-sm animate-fade-in">
    <div class="p-1 bg-emerald-100 text-emerald-600 rounded-lg shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <div class="text-sm leading-relaxed flex-1">
        <p class="font-semibold text-emerald-950">Berjaya</p>
        <p class="text-emerald-800"><?= e($success) ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="flash-alert mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200/80 flex items-start gap-3 text-rose-900 shadow-sm animate-fade-in">
    <div class="p-1 bg-rose-100 text-rose-600 rounded-lg shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="text-sm leading-relaxed flex-1">
        <p class="font-semibold text-rose-950">Ralat Perhatian</p>
        <p class="text-rose-800"><?= e($error) ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
<?php endif; ?>

<?php if ($warning): ?>
<div class="flash-alert mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200/80 flex items-start gap-3 text-amber-900 shadow-sm animate-fade-in">
    <div class="p-1 bg-amber-100 text-amber-600 rounded-lg shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    <div class="text-sm leading-relaxed flex-1">
        <p class="font-semibold text-amber-950">Peringatan</p>
        <p class="text-amber-800"><?= e($warning) ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-800 p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
<?php endif; ?>

<?php if ($info): ?>
<div class="flash-alert mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200/80 flex items-start gap-3 text-blue-900 shadow-sm animate-fade-in">
    <div class="p-1 bg-blue-100 text-blue-600 rounded-lg shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="text-sm leading-relaxed flex-1">
        <p class="font-semibold text-blue-950">Makluman</p>
        <p class="text-blue-800"><?= e($info) ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-800 p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
<?php endif; ?>
