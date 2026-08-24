<?php
use App\Core\Auth;
use App\Repositories\TicketRepository;

$user = Auth::user();
$role = $user['role'] ?? 'STAF';
$unit = $user['unit'] ?? 'PENTADBIRAN';

$ticketRepo = new TicketRepository();
$pendingApprovalsCount = 0;

if ($role === 'KETUA_UNIT') {
    $pendingApprovalsCount = count($ticketRepo->getPendingUnitApprovals($unit));
} elseif ($role === 'ADMIN') {
    $pendingApprovalsCount = count($ticketRepo->getPendingICTApprovals()) + count($ticketRepo->query()->where('status', 'MENUNGGU_SOKONGAN_UNIT')->get());
}

$unitsConfig = app_config('units', []);
$currentUnitName = $unitsConfig[$unit]['short_name'] ?? $unit;
?>

<!-- Sidebar Container -->
<aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800 shadow-xl select-none min-h-screen">
    <!-- Brand Header -->
    <div class="h-20 flex items-center px-6 bg-slate-950/60 border-b border-slate-800/80 gap-3.5">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20 font-bold text-lg tracking-wider ring-2 ring-white/10">
            ICT
        </div>
        <div class="overflow-hidden">
            <h1 class="text-sm font-bold text-white tracking-tight uppercase flex items-center gap-1.5 truncate">
                Helpdesk BKP
                <span class="px-1.5 py-0.5 text-[10px] bg-blue-500/20 text-blue-300 border border-blue-400/30 rounded font-mono font-medium">v3</span>
            </h1>
            <p class="text-[11px] text-slate-400 truncate tracking-wide">Bahagian Khidmat Pengurusan</p>
        </div>
    </div>

    <!-- Navigation Area -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-7">
        <!-- Section: Menu Utama -->
        <div>
            <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2.5">Menu Utama</p>
            <nav class="space-y-1">
                <a href="<?= url('/dashboard') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= ($currentUri === '/dashboard') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Papan Pemuka</span>
                </a>

                <a href="<?= url('/tickets/create') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= ($currentUri === '/tickets/create') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Permohonan Baru</span>
                </a>

                <a href="<?= url('/tickets') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= ($currentUri === '/tickets' && $currentUri !== '/tickets/create') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Senarai Permohonan</span>
                </a>

                <a href="<?= url('/calendar') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= ($currentUri === '/calendar') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Kalendar Tempahan</span>
                </a>
            </nav>
        </div>

        <!-- Section: Pengurusan & Aliran Kerja -->
        <div>
            <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2.5">Aliran Kerja & Aset</p>
            <nav class="space-y-1">
                <?php if ($role === 'ADMIN' || $role === 'KETUA_UNIT'): ?>
                <a href="<?= url('/approvals') ?>" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= ($currentUri === '/approvals') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Pusat Kelulusan</span>
                    </div>
                    <?php if ($pendingApprovalsCount > 0): ?>
                    <span class="px-2 py-0.5 text-xs font-bold bg-amber-500 text-slate-950 rounded-full animate-pulse">
                        <?= $pendingApprovalsCount ?>
                    </span>
                    <?php endif; ?>
                </a>
                <?php endif; ?>

                <a href="<?= url('/assets') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= (str_starts_with($currentUri, '/assets')) ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Inventori Aset ICT</span>
                </a>

                <a href="<?= url('/reports') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= (str_starts_with($currentUri, '/reports')) ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Laporan & Analitis</span>
                </a>

                <?php if ($role === 'ADMIN'): ?>
                <a href="<?= url('/users') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= (str_starts_with($currentUri, '/users')) ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Senarai Pengguna</span>
                </a>

                <a href="<?= url('/units') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?= (str_starts_with($currentUri, '/units') || str_starts_with($currentUri, '/settings/units')) ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' ?>">
                    <svg class="w-5 h-5 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Senarai Jawatan</span>
                </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <!-- User Card Footer -->
    <div class="p-4 bg-slate-950/80 border-t border-slate-800/80">
        <div class="flex items-center justify-between gap-3">
            <a href="<?= url('/profile') ?>" class="flex items-center gap-3 group flex-1 min-w-0">
                <div class="w-9 h-9 rounded-full bg-slate-800 ring-2 ring-blue-500/40 text-blue-300 flex items-center justify-center font-bold text-xs shrink-0 group-hover:ring-blue-400 transition-all">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate group-hover:text-blue-300 transition-colors">
                        <?= e($user['name'] ?? 'Pengguna') ?>
                    </p>
                    <p class="text-[11px] text-slate-400 truncate">
                        <?= e($currentUnitName) ?>
                    </p>
                </div>
            </a>
            <a href="<?= url('/logout') ?>" title="Log Keluar" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </div>
    </div>
</aside>
