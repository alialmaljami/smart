<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'تسجيل الدخول')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#F0F1F5', 100: '#D6D8E0', 200: '#ADB1C2', 300: '#8490A3',
                            400: '#5B6B84', 500: '#0D1B3D', 600: '#0B1633', 700: '#091228',
                            800: '#070D1E', 900: '#040913',
                        },
                        gold: {
                            50: '#FBF6EA', 100: '#F5E8C5', 200: '#EDD696', 300: '#E4C467',
                            400: '#D4AF37', 500: '#C9A22F', 600: '#B08C28', 700: '#967521',
                            800: '#7D5F1A', 900: '#634813',
                        }
                    },
                    fontFamily: { cairo: ['Cairo', 'sans-serif'] }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
    <style>
        .auth-bg {
            background: linear-gradient(135deg, #0D1B3D 0%, #091228 50%, #040913 100%);
        }
        .auth-pattern {
            background-image: radial-gradient(circle at 20% 50%, rgba(212,175,55,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 80% 50%, rgba(212,175,55,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 50% 0%, rgba(212,175,55,0.05) 0%, transparent 30%);
        }
        .auth-card {
            backdrop-filter: blur(20px);
            background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        }
    </style>
</head>
<body class="font-cairo auth-bg auth-pattern min-h-screen flex items-center justify-center p-4">

    {{-- Decorative elements --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full border border-gold-300/10"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full border border-gold-300/5"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
