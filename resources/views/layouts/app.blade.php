@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
    $settings = [
        'email' => App\Models\Setting::getValue('contact_email', 'Smartdecorat1@gmail.com'),
        'phone' => App\Models\Setting::getValue('contact_phone', '+966 50 000 0000'),
        'address' => App\Models\Setting::getValue('contact_address', 'الرياض، المملكة العربية السعودية'),
        'copyright' => App\Models\Setting::getValue('copyright_text', '© 2026 ديكورات المصمم الذكي. جميع الحقوق محفوظة.'),
        'map_url' => App\Models\Setting::getValue('map_url', 'https://maps.app.goo.gl/w8TwGiDcEgCCXHmL9'),
    ];
    $services = App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
    $materialCategories = App\Models\Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')
    <title>@yield('title', 'ديكورات المصمم الذكي')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    @stack('styles')

    <style>
        :root {
            --cream: #F7F3E9;
            --navy: #0D1B3D;
            --gold: #D4AF37;
            --stone: #E8E6E1;
            --white: #FFFFFF;
            --text-secondary: #4A4A4A;
            --text-muted: #9C9C9C;
            --text-heading: var(--navy);
            --shadow-sm: 0 2px 16px rgba(13,27,61,0.04);
            --shadow-md: 0 8px 32px rgba(13,27,61,0.06);
            --shadow-lg: 0 16px 48px rgba(13,27,61,0.08);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        .dark {
            --cream: #0A0F1E;
            --navy: #0D1B3D;
            --gold: #D4AF37;
            --stone: #1E2744;
            --white: #131B2E;
            --text-secondary: #9C9C9C;
            --text-muted: #6B7280;
            --text-heading: #E8E6E1;
            --shadow-sm: 0 2px 16px rgba(0,0,0,0.2);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.3);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.4);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Poppins', 'Cairo', sans-serif;
            background: var(--cream);
            color: var(--text-secondary);
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', 'Cairo', serif;
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-heading);
            letter-spacing: -0.02em;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--stone); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold); }

        .btn-primary {
            background: var(--gold);
            color: var(--text-heading);
            padding: 0.875rem 2.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.8125rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            border: none;
        }

        .btn-primary:hover {
            background: #C9A22F;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212, 175, 55, 0.35);
        }

        .btn-outline {
            border: 1.5px solid var(--gold);
            color: var(--gold);
            padding: 0.875rem 2.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.8125rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--gold);
            color: var(--text-heading);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212, 175, 55, 0.25);
        }

        .btn-light {
            background: var(--white);
            color: var(--text-heading);
            padding: 0.875rem 2.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.8125rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
        }

        .btn-light:hover {
            background: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(13, 27, 61, 0.1);
        }

        .card-elegant {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--stone);
        }

        .card-elegant:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .img-zoom { overflow: hidden; }
        .img-zoom img { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .img-zoom:hover img { transform: scale(1.06); }

        .overlay-gradient {
            background: linear-gradient(to top, rgba(13,27,61,0.9) 0%, rgba(13,27,61,0.05) 60%, transparent 100%);
        }

        .navy-gradient {
            background: linear-gradient(135deg, rgba(13,27,61,0.95) 0%, rgba(13,27,61,0.7) 50%, rgba(13,27,61,0.9) 100%);
        }

        .section-label {
            display: inline-block;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 2.75rem;
            margin-bottom: 1rem;
            color: var(--text-heading);
        }

        @media (max-width: 768px) {
            .section-title { font-size: 1.875rem; }
        }

        .section-divider {
            width: 48px;
            height: 2px;
            background: var(--gold);
            margin: 1.25rem auto;
        }

        .section-divider-start {
            width: 48px;
            height: 2px;
            background: var(--gold);
            margin: 1.25rem 0;
        }

        .sticky-header { transition: all 0.4s ease; }

        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.8125rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--gold);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 0;
            height: 1.5px;
            background: var(--gold);
            transition: width 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }

        .input-elegant {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 1px solid var(--stone);
            border-radius: var(--radius-md);
            background: var(--white);
            color: var(--text-heading);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-elegant:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .input-elegant::placeholder {
            color: var(--text-muted);
        }

        .stat-number {
            font-size: 3.25rem;
            font-weight: 800;
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        @media (max-width: 768px) {
            .stat-number { font-size: 2.5rem; }
        }

        .whatsapp-float {
            position: fixed;
            bottom: 28px;
            left: 28px;
            z-index: 1000;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #25D366;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 24px rgba(37, 211, 102, 0.35);
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 36px rgba(37, 211, 102, 0.45);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes goldPulse {
            0%, 100% { box-shadow: 0 0 20px rgba(212, 175, 55, 0.2); }
            50% { box-shadow: 0 0 40px rgba(212, 175, 55, 0.4); }
        }

        .gold-pulse { animation: goldPulse 2s infinite; }

        .gold-text-gradient {
            background: linear-gradient(135deg, var(--gold), #E8C84A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        [x-cloak] { display: none !important; }

        .sidebar-menu {
            position: fixed;
            top: 0;
            right: -320px;
            width: 320px;
            height: 100vh;
            background: var(--navy);
            z-index: 9999;
            transition: right 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow-y: auto;
        }

        .sidebar-menu.open { right: 0; }

        .sidebar-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(13, 27, 61, 0.7);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
            backdrop-filter: blur(6px);
        }

        .sidebar-overlay.open { opacity: 1; visibility: visible; }

        .footer {
            background: var(--navy);
        }

        .footer a { transition: all 0.3s ease; }
        .footer a:hover { color: var(--gold) !important; }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
            line-height: 1.08;
        }

        .container-wide {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        @media (min-width: 1280px) {
            .container-wide { padding: 0 3rem; }
        }

        .gold-shadow {
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.15);
        }

        .gold-border-bottom {
            border-bottom: 2px solid var(--gold);
        }
    </style>
</head>
<body>

    <div x-data="{ mobileMenu: false, searchOpen: false }">

        {{-- Mobile Sidebar Overlay --}}
        <div class="sidebar-overlay" :class="{ 'open': mobileMenu }" @click="mobileMenu = false"></div>

        {{-- Mobile Sidebar --}}
        <div class="sidebar-menu" :class="{ 'open': mobileMenu }">
            <div class="p-10">
                <div class="flex justify-between items-center mb-12">
                    <span class="text-xl font-bold text-[var(--gold)]" style="font-family: 'Playfair Display', serif;">المصمم الذكي</span>
                    <button @click="mobileMenu = false" class="text-white/40 hover:text-[var(--gold)] transition-colors">
                        <x-icon name="times" class="w-5 h-5" />
                    </button>
                </div>
                <nav class="flex flex-col space-y-1">
                    <a href="{{ route('home') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">الرئيسية</a>
                    <a href="{{ route('about') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">عن الشركة</a>
                    <a href="{{ route('services') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">خدماتنا</a>
                    <a href="{{ route('projects') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">مشاريعنا</a>
                    <a href="{{ route('gallery') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">معرض الصور</a>
                    <a href="{{ route('materials') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">مواد الديكور</a>
                    <a href="{{ route('blog') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">المدونة</a>
                    <a href="{{ route('contact') }}" class="text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-base font-medium border-r-2 border-transparent hover:border-[var(--gold)]">اتصل بنا</a>
                </nav>
                <div class="mt-12 pt-8 border-t border-white/5">
                    <p class="text-white/30 text-xs mb-4 tracking-wider uppercase">تابعنا على</p>
                    <div class="flex space-x-3 space-x-reverse" dir="ltr">
                        @include('partials.social-icons', ['socialLinks' => $socialLinks])
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Bar --}}
        <div class="hidden lg:block bg-[var(--cream)] border-b border-[var(--stone)]">
            <div class="container-wide">
                <div class="flex items-center justify-between h-9">
                    <div class="flex items-center gap-4">
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['phone']) }}" class="flex items-center gap-1.5 text-[var(--text-muted)] hover:text-[var(--gold)] text-[11px] transition-colors">
                            <x-icon name="phone" class="w-3 h-3" />
                            <span dir="ltr">{{ $settings['phone'] }}</span>
                        </a>
                        <span class="text-[var(--stone)]">|</span>
                        <a href="mailto:{{ $settings['email'] }}" class="flex items-center gap-1.5 text-[var(--text-muted)] hover:text-[var(--gold)] text-[11px] transition-colors">
                            <x-icon name="email" class="w-3 h-3" />
                            <span>{{ $settings['email'] }}</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-2" dir="ltr">
                        @include('partials.social-icons', ['socialLinks' => $socialLinks])
                        <button type="button" @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="mr-3 w-7 h-7 flex items-center justify-center rounded-lg text-[var(--text-muted)] hover:text-[var(--gold)] hover:bg-[var(--stone)] transition-all" title="الوضع الليلي">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <header class="sticky-header fixed w-full top-0 lg:top-9 z-50 transition-all duration-500" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 60)">
            <div class="bg-[var(--white)]/95 backdrop-blur-md border-b border-[var(--stone)]/30" :class="{ 'shadow-sm shadow-[var(--navy)]/[0.05]': scrolled }">
                <div class="container-wide">
                    <div class="flex items-center justify-between h-20 lg:h-24">
                        {{-- Logo --}}
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="block text-xl font-black text-[var(--text-heading)] leading-tight" style="font-family: 'Playfair Display', serif;">المصمم الذكي</span>
                                <span class="block text-[10px] font-medium tracking-[0.25em] text-[var(--gold)]">SMART DESIGNER</span>
                            </div>
                        </a>

                        {{-- Desktop Nav --}}
                        <nav class="hidden lg:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                            <a href="{{ route('about') }}" class="nav-link">عن الشركة</a>
                            <a href="{{ route('services') }}" class="nav-link">خدماتنا</a>
                            <a href="{{ route('projects') }}" class="nav-link">مشاريعنا</a>
                            <a href="{{ route('gallery') }}" class="nav-link">معرض الصور</a>
                            <a href="{{ route('materials') }}" class="nav-link">مواد الديكور</a>
                            <a href="{{ route('blog') }}" class="nav-link">المدونة</a>
                        </nav>

                        <div class="flex items-center gap-4">
                            {{-- Search --}}
                            <button type="button" @@click="searchOpen = true" class="w-9 h-9 flex items-center justify-center text-[var(--text-secondary)] hover:text-[var(--gold)] hover:bg-[var(--cream)] rounded-xl transition-all" title="بحث">
                                <x-icon name="search" class="w-4 h-4" />
                            </button>
                            {{-- Contact Button --}}
                            <a href="{{ route('contact') }}" class="btn-primary hidden sm:inline-flex px-5 py-2.5 text-xs">
                                اتصل بنا
                            </a>
                            {{-- Mobile Toggle --}}
                            <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-[var(--text-secondary)] hover:text-[var(--text-heading)] p-2 transition-colors">
                                <x-icon name="bars" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Search Modal --}}
        <div x-show="searchOpen" class="fixed inset-0 z-[10000]" x-cloak>
            <div class="absolute inset-0 bg-[var(--navy)]/60 backdrop-blur-sm" @@click="searchOpen = false"></div>
            <div class="relative h-full flex items-start justify-center pt-32 px-4">
                <div class="w-full max-w-xl" @@click.outside="searchOpen = false" x-data="{ query: '' }">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" x-model="query" placeholder="ابحث عن خدمات، مشاريع، مواد، مقالات..."
                               class="w-full px-6 py-4 pr-14 text-base bg-[var(--white)] rounded-2xl shadow-xl border border-[var(--stone)] outline-none text-[var(--text-heading)] placeholder-[var(--text-muted)]">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[var(--gold)] hover:text-[var(--text-heading)] transition-colors">
                            <x-icon name="search" class="w-5 h-5" />
                        </button>
                        <button type="button" @@click="searchOpen = false" class="absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] hover:text-[var(--text-heading)] transition-colors">
                            <x-icon name="times" class="w-5 h-5" />
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="pt-20 lg:pt-[132px]">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="footer text-white/80 py-20 pb-8">
            <div class="container-wide">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-14">
                    {{-- Column 1 --}}
                    <div class="lg:col-span-1">
                        <div class="mb-6">
                            <span class="block text-2xl font-black text-[var(--gold)] leading-tight" style="font-family: 'Playfair Display', serif;">المصمم الذكي</span>
                            <span class="block text-[11px] font-medium text-white/30 tracking-[0.25em] mt-1">SMART DESIGNER</span>
                        </div>
                        <p class="text-white/40 text-sm leading-relaxed mb-6 max-w-xs">
                            شركة رائدة في التصميم الداخلي والديكور، نجمع بين الأناقة العصرية واللمسات العربية الأصيلة.
                        </p>
                        <div class="flex gap-2" dir="ltr">
                            @include('partials.social-icons', ['socialLinks' => $socialLinks])
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">روابط سريعة</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">الرئيسية</a></li>
                            <li><a href="{{ route('about') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">عن الشركة</a></li>
                            <li><a href="{{ route('services') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">خدماتنا</a></li>
                            <li><a href="{{ route('projects') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">مشاريعنا</a></li>
                            <li><a href="{{ route('materials') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">مواد الديكور</a></li>
                            <li><a href="{{ route('blog') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">المدونة</a></li>
                            <li><a href="{{ route('contact') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">اتصل بنا</a></li>
                        </ul>
                    </div>

                    {{-- Column 3 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">خدماتنا</h3>
                        <ul class="space-y-3">
                            @foreach($services as $service)
                                <li><a href="{{ route('service.show', $service->slug) }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ $service->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Column 4 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">مواد الديكور</h3>
                        <ul class="space-y-3">
                            @foreach($materialCategories as $category)
                                <li><a href="{{ route('material.category.show', $category->slug) }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Column 5 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">اتصل بنا</h3>
                        <ul class="space-y-4 text-sm text-white/40">
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/[0.04] flex items-center justify-center"><x-icon name="location" class="w-4 h-4 text-[var(--gold)]" /></span>
                                <span class="mt-1.5">{{ $settings['address'] }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/[0.04] flex items-center justify-center"><x-icon name="phone" class="w-4 h-4 text-[var(--gold)]" /></span>
                                <span dir="ltr">{{ $settings['phone'] }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/[0.04] flex items-center justify-center"><x-icon name="email" class="w-4 h-4 text-[var(--gold)]" /></span>
                                <span>{{ $settings['email'] }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-white/[0.04] pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-white/30 text-xs">{{ $settings['copyright'] }}</p>
                    <div class="flex items-center gap-4 text-xs text-white/30">
                        <span>تصميم بواسطة <span class="text-[var(--gold)]">المصمم الذكي</span></span>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['phone']) }}" target="_blank" rel="noopener noreferrer"
       class="whatsapp-float">
        <x-icon name="whatsapp" class="w-6 h-6" />
    </a>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 80,
            easing: 'ease-out-cubic',
        });
    </script>

    {{-- Global Lightbox --}}
    <div id="lightbox-overlay" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/90 backdrop-blur-sm" onclick="lightboxClose(event)">
        <button onclick="lightboxClose()" class="absolute top-4 left-4 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10 text-xl">
            <i class="fas fa-times"></i>
        </button>
        <button onclick="lightboxNav(-1)" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10 text-xl">
            <i class="fas fa-chevron-right"></i>
        </button>
        <button onclick="lightboxNav(1)" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10 text-xl">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="max-w-6xl max-h-[85vh] p-4">
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] mx-auto object-contain rounded-2xl shadow-2xl">
        </div>
    </div>

    <script>
        let lightboxImages = [];
        let lightboxIndex = 0;

        function initLightbox() {
            lightboxImages = [];
            document.querySelectorAll('img[src*="/storage/"]').forEach((el, i) => {
                const src = el.dataset.src || el.src;
                const isUI = el.closest('.whatsapp-float, .logo, nav, header, footer, button, .no-lightbox');
                if (isUI) return;
                el.style.cursor = 'pointer';
                el.addEventListener('click', (e) => {
                    if (el.closest('[onclick]')) return;
                    e.stopPropagation();
                    const idx = lightboxImages.indexOf(src);
                    openLightbox(src, idx >= 0 ? idx : i);
                });
                if (!lightboxImages.includes(src)) {
                    lightboxImages.push(src);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', initLightbox);

        function openLightbox(src, index) {
            lightboxIndex = index !== undefined ? index : lightboxImages.indexOf(src);
            if (lightboxIndex < 0) lightboxIndex = 0;
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-overlay').classList.remove('hidden');
            document.getElementById('lightbox-overlay').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function lightboxClose(e) {
            if (e && e.target !== e.currentTarget) return;
            document.getElementById('lightbox-overlay').classList.add('hidden');
            document.getElementById('lightbox-overlay').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function lightboxNav(dir) {
            if (!lightboxImages.length) return;
            lightboxIndex = (lightboxIndex + dir + lightboxImages.length) % lightboxImages.length;
            document.getElementById('lightbox-img').src = lightboxImages[lightboxIndex];
        }

        document.addEventListener('keydown', (e) => {
            const ov = document.getElementById('lightbox-overlay');
            if (ov.classList.contains('hidden')) return;
            if (e.key === 'Escape') lightboxClose();
            if (e.key === 'ArrowLeft') lightboxNav(1);
            if (e.key === 'ArrowRight') lightboxNav(-1);
        });
    </script>
    @stack('scripts')
</body>
</html>
