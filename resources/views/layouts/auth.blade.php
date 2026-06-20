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
                            50: '#F0F2F5', 100: '#D6DAE0', 200: '#ADB4C2', 300: '#8490A3',
                            400: '#5B6A84', 500: '#0F1A2E', 600: '#0C1525', 700: '#0A101C',
                            800: '#070C14', 900: '#05080D',
                        },
                        gold: {
                            50: '#FDF2EF', 100: '#F9DCD4', 200: '#F2B9A8', 300: '#EA967D',
                            400: '#E07A5F', 500: '#D4694C', 600: '#B8573D', 700: '#9C452E',
                            800: '#80341F', 900: '#642311',
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
            background: linear-gradient(135deg, #0F1A2E 0%, #0A101C 50%, #05080D 100%);
        }
        .auth-pattern {
            background-image: radial-gradient(circle at 20% 50%, rgba(224,122,95,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 80% 50%, rgba(224,122,95,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 50% 0%, rgba(224,122,95,0.05) 0%, transparent 30%);
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
