<?php
use App\Core\Auth;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
$rolesConfig = app_config('roles.roles', []);
$roleBadgeColor = $rolesConfig[$role]['badge_color'] ?? 'slate';
$roleName = $rolesConfig[$role]['name'] ?? $role;

$unitsConfig = app_config('units', []);
$userUnitCode = $user['unit'] ?? 'PENTADBIRAN';
$userUnitName = $unitsConfig[$userUnitCode]['name'] ?? $userUnitCode;
?>

<!-- Header Topbar -->
<header class="h-20 bg-white border-b border-slate-200/80 sticky top-0 z-30 px-6 sm:px-8 flex items-center justify-between shadow-sm">
    <!-- Left: Page Title / Breadcrumb Context -->
    <div class="flex items-center gap-4 min-w-0">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                <span>BKP Helpdesk</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-slate-800 font-semibold truncate"><?= e($pageTitle ?? 'Papan Pemuka') ?></span>
            </div>
            <h2 class="text-lg font-bold text-slate-900 tracking-tight truncate mt-0.5">
                <?= e($pageTitle ?? 'Papan Pemuka') ?>
            </h2>
        </div>
    </div>

    <!-- Right Actions -->
    <div class="flex items-center gap-3.5 shrink-0">
        <!-- Unit Badge -->
        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200/80 text-xs">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span class="font-medium text-slate-700 truncate max-w-[200px]" title="<?= e($userUnitName) ?>">
                <?= e($userUnitName) ?>
            </span>
        </div>

        <!-- Role Badge -->
        <span class="px-2.5 py-1 text-xs font-semibold rounded-md uppercase tracking-wider bg-<?= $roleBadgeColor ?>-50 text-<?= $roleBadgeColor ?>-700 border border-<?= $roleBadgeColor ?>-200/80">
            <?= e($role) ?>
        </span>

        <!-- New Ticket CTA Button -->
        <a href="<?= url('/tickets/create') ?>" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs sm:text-sm font-medium rounded-lg transition-all shadow-sm hover:shadow focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="hidden sm:inline">Permohonan Baru</span>
            <span class="sm:hidden">Baru</span>
        </a>
    </div>
</header>
