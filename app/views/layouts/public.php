<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>
<!DOCTYPE html>
<html lang="ms" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= e($pageTitle ?? 'Portal Permohonan & Khidmat Sokongan ICT - ' . app_config('app.name')) ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'xs': '420px',
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Top Corporate Header (Clean Modern Typography - Tanpa Icon Kotak ICT) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-3">
            <!-- Brand Logo (Pure Typography) -->
            <a href="<?= url('/') ?>" class="flex flex-col group shrink-0 min-w-0">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <span class="text-base sm:text-xl font-black text-slate-900 tracking-tight uppercase whitespace-nowrap">Helpdesk ICT</span>
                    <span class="px-2 py-0.5 text-[10px] sm:text-[11px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200 rounded-md font-mono shrink-0">BKP</span>
                </div>
                <p class="text-[10px] sm:text-xs text-slate-500 font-semibold tracking-wide leading-none mt-1 truncate">Bahagian Khidmat Pengurusan</p>
            </a>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-xs font-semibold text-slate-600">
                <a href="<?= url('/tickets/create') ?>" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">Borang Permohonan</a>
                <a href="<?= url('/#semak-status') ?>" class="hover:text-blue-600 transition-colors">Semak Status Tiket</a>
            </nav>

            <!-- Action Buttons (Responsive Compact) -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <?php if ($isLoggedIn): ?>
                <a href="<?= url('/tickets/create') ?>" 
                   class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl border border-blue-200 transition-all">
                    <span>+ Permohonan Baru</span>
                </a>
                <a href="<?= url('/dashboard') ?>" 
                   class="inline-flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-600/20 transition-all shrink-0">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="hidden sm:inline">Papan Pemuka (<?= e(explode(' ', $currentUser['name'] ?? 'User')[0]) ?>)</span>
                    <span class="sm:hidden">Dashboard</span>
                </a>
                <?php else: ?>
                <a href="<?= url('/tickets/create') ?>" 
                   class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl border border-blue-200 transition-all">
                    <span>+ Borang Permohonan</span>
                </a>
                <a href="<?= url('/login') ?>" 
                   class="inline-flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all shrink-0">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span class="hidden sm:inline">Log Masuk Staf / Admin</span>
                    <span class="sm:hidden">Log Masuk</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Public Content -->
    <main class="flex-1 flex flex-col justify-center">
        <!-- Flash Alert -->
        <?php if (!empty($flashMessage)): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
            <div class="p-3.5 rounded-xl text-xs font-semibold flex items-center justify-between <?= $flashType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm' : ($flashType === 'error' ? 'bg-rose-50 border border-rose-200 text-rose-800 shadow-sm' : 'bg-blue-50 border border-blue-200 text-blue-800 shadow-sm') ?>">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full <?= $flashType === 'success' ? 'bg-emerald-500' : ($flashType === 'error' ? 'bg-rose-500' : 'bg-blue-500') ?>"></span>
                    <span><?= e($flashMessage) ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <!-- Public Footer (Padat, Kemas & 1 Page) -->
    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 text-xs py-3 sm:py-4 px-4 sm:px-8 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5 text-[11px]">
            <p class="text-slate-400 font-medium text-center sm:text-left">
                &copy; <?= date('Y') ?> <strong class="text-slate-200">Seksyen ICT</strong>, Bahagian Khidmat Pengurusan, Pejabat SUK Negeri Johor.
            </p>
            <div class="flex items-center gap-4 text-slate-300">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Talian ICT: <strong>010-5528875</strong>
                </span>
                <span class="hidden sm:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    farhah@johor.gov.my
                </span>
            </div>
        </div>
    </footer>

    <!-- App JS -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
