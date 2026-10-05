<?php
use App\Core\Auth;

$isLoggedIn = Auth::check();
$currentUser = Auth::user();
?>
<!DOCTYPE html>
<html lang="ms" class="h-full bg-slate-50 scroll-smooth">
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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-white text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Top Corporate Header (Matching Mockup) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo (Pure Typography with BKP badge) -->
            <a href="<?= url('/') ?>" class="flex flex-col group shrink-0 min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-base sm:text-xl font-black text-slate-900 tracking-tight uppercase whitespace-nowrap">
                        Helpdesk ICT
                    </span>
                    <span class="px-2 py-0.5 text-[10px] sm:text-[11px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200/90 rounded font-mono shrink-0">
                        BKP
                    </span>
                </div>
                <span class="text-[10px] sm:text-[11px] text-slate-500 font-bold tracking-wider uppercase leading-none mt-1 truncate">
                    Bahagian Khidmat Pengurusan
                </span>
            </a>

            <!-- Center Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="<?= url('/') ?>" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= (isset($_SERVER['REQUEST_URI']) && (rtrim($_SERVER['REQUEST_URI'], '/') === rtrim(url('/'), '/') || $_SERVER['REQUEST_URI'] === '/')) ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
                    Utama
                </a>
                <a href="<?= url('/#perkhidmatan') ?>" 
                   class="px-3.5 py-2 rounded-full text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    Perkhidmatan
                </a>
                <a href="<?= url('/#panduan') ?>" 
                   class="px-3.5 py-2 rounded-full text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    Panduan
                </a>
                <a href="<?= url('/#faq') ?>" 
                   class="px-3.5 py-2 rounded-full text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    Soalan Lazim
                </a>
                <a href="<?= url('/#hubungi') ?>" 
                   class="px-3.5 py-2 rounded-full text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    Hubungi
                </a>
            </nav>

            <!-- Action Button (Log Masuk Pill Button) -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <?php if ($isLoggedIn): ?>
                <a href="<?= url('/dashboard') ?>" 
                   class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-full shadow-md shadow-blue-600/20 transition-all shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="hidden sm:inline">Papan Pemuka (<?= e(explode(' ', $currentUser['name'] ?? 'User')[0]) ?>)</span>
                    <span class="sm:hidden">Dashboard</span>
                </a>
                <?php else: ?>
                <a href="<?= url('/login') ?>" 
                   class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-slate-900 hover:bg-slate-800 active:bg-black text-white text-xs font-bold rounded-full shadow-sm hover:shadow transition-all shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Log Masuk</span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Navigation Menu (Scrollable Bar) -->
        <div class="md:hidden flex items-center gap-1 px-4 py-2 border-t border-slate-100 overflow-x-auto text-xs bg-slate-50/90 no-scrollbar">
            <a href="<?= url('/') ?>" class="px-3 py-1 rounded-full font-bold whitespace-nowrap bg-slate-900 text-white">Utama</a>
            <a href="<?= url('/#perkhidmatan') ?>" class="px-3 py-1 rounded-full font-medium text-slate-600 whitespace-nowrap hover:text-slate-900">Perkhidmatan</a>
            <a href="<?= url('/#panduan') ?>" class="px-3 py-1 rounded-full font-medium text-slate-600 whitespace-nowrap hover:text-slate-900">Panduan</a>
            <a href="<?= url('/#faq') ?>" class="px-3 py-1 rounded-full font-medium text-slate-600 whitespace-nowrap hover:text-slate-900">Soalan Lazim</a>
            <a href="<?= url('/#hubungi') ?>" class="px-3 py-1 rounded-full font-medium text-slate-600 whitespace-nowrap hover:text-slate-900">Hubungi</a>
        </div>
    </header>

    <!-- Main Public Content -->
    <main class="flex-1 flex flex-col">
        <!-- Flash Alert -->
        <?php if (!empty($flashMessage)): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 rounded-2xl text-xs font-semibold flex items-center justify-between <?= $flashType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm' : ($flashType === 'error' ? 'bg-rose-50 border border-rose-200 text-rose-800 shadow-sm' : 'bg-blue-50 border border-blue-200 text-blue-800 shadow-sm') ?>">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full <?= $flashType === 'success' ? 'bg-emerald-500' : ($flashType === 'error' ? 'bg-rose-500' : 'bg-blue-500') ?>"></span>
                    <span><?= e($flashMessage) ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <!-- Corporate Footer (Sesuai Mockup) -->
    <footer class="bg-white border-t border-slate-200 text-slate-500 text-xs py-6 sm:py-8 px-4 sm:px-8 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-extrabold text-slate-900 tracking-tight">HELPDESK ICT BKP</span>
                <span class="text-slate-300">|</span>
                <span class="text-slate-500 font-medium">Memacu Perkhidmatan · Memperkasa Digital</span>
            </div>
            <div class="text-[11px] text-slate-500 text-center sm:text-right">
                &copy; <?= date('Y') ?> Seksyen ICT, Bahagian Khidmat Pengurusan, Pejabat Setiausaha Kerajaan Johor.
            </div>
        </div>
    </footer>

    <!-- App JS -->
    <script src="<?= asset('js/app.js') ?>"></script>

    <!-- Floating Chatbot Widget Helpdesk ICT -->
    <?php \App\Core\View::partial('chatbot'); ?>
</body>
</html>
