<!DOCTYPE html>
<html lang="ms" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Log Masuk - Helpdesk ICTBKP') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
</head>
<body class="min-h-full flex items-center justify-center p-4 bg-slate-100 bg-cover bg-center bg-no-repeat antialiased selection:bg-blue-600 selection:text-white" style="background-image: url('<?= asset('images/bg-helpdesk.png') ?>');">
    <div class="w-full max-w-lg my-auto py-6">
        <?= $content ?>
    </div>
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
