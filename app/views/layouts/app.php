<!DOCTYPE html>
<html lang="ms" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Helpdesk ICTBKP') ?></title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: {
                            850: '#151f32',
                            950: '#090e1a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
</head>
<body class="h-full flex flex-row overflow-x-hidden text-slate-700 bg-slate-50 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Sidebar Navigation -->
    <?php \App\Core\View::partial('sidebar', get_defined_vars()); ?>

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto">
        <!-- Topbar -->
        <?php \App\Core\View::partial('header', get_defined_vars()); ?>

        <!-- Main Body Page Container -->
        <main class="flex-1 p-6 sm:p-8 max-w-7xl w-full mx-auto">
            <!-- Global Flash Messages -->
            <?php \App\Core\View::partial('flash'); ?>

            <!-- View Specific Body -->
            <?= $content ?>
        </main>

        <!-- Footer -->
        <?php \App\Core\View::partial('footer'); ?>
    </div>

    <!-- Application JS Scripts -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
