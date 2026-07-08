@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
    $settings = [
        'email' => App\Models\Setting::getValue('contact_email', 'Smartdecorat1@gmail.com'),
        'phone' => App\Models\Setting::getValue('contact_phone', '+966 54 123 2717'),
        'address' => App\Models\Setting::getValue('contact_address', 'الزاهر 1 – الضيافة، مكة المكرمة'),
        'copyright' => App\Models\Setting::getValue('copyright_text', '© 2026 ديكورات المصمم الذكي. جميع الحقوق محفوظة.'),
        'map_url' => App\Models\Setting::getValue('map_url', 'https://maps.app.goo.gl/w8TwGiDcEgCCXHmL9'),
    ];
    $services = App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
    $materialCategories = App\Models\Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
    $latestPosts = App\Models\BlogPost::where('is_active', true)->latest()->take(3)->get();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'ar' ? 'ar' : 'en' }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Smart Designer Decorations'))</title>
    <meta name="description" content="@yield('description', __('Smart Designer Decorations - Professional interior design and decoration services in Saudi Arabia'))" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

    {{-- Canonical (strip _locale query param) --}}
    @php
        $canonicalQuery = array_diff_key(request()->query(), ['_locale' => '']);
        $canonicalUrl = url()->current() . ($canonicalQuery ? '?' . http_build_query($canonicalQuery) : '');
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}" />

    {{-- Hreflang --}}
    @php
        $locale = app()->getLocale();
        $otherLocale = $locale === 'ar' ? 'en' : 'ar';
        $route = request()->route();
        $routeName = $route?->getName();
        $routeParams = $route?->parameters() ?? [];
        $otherUrl = $canonicalUrl;
        if ($routeName && !str_contains($routeName, 'admin.')) {
            try {
                $otherUrl = route($routeName, array_merge($routeParams, ['_locale' => $otherLocale]));
            } catch (\Exception $e) {}
        }
    @endphp
    <link rel="alternate" hreflang="ar" href="{{ $locale === 'ar' ? $canonicalUrl : $otherUrl }}" />
    <link rel="alternate" hreflang="en" href="{{ $locale === 'en' ? $canonicalUrl : $otherUrl }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}" />

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ __('Smart Designer Decorations') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="@yield('title', __('Smart Designer Decorations'))" />
    <meta property="og:description" content="@yield('description', __('Smart Designer Decorations - Professional interior design and decoration services in Saudi Arabia'))" />
    <meta property="og:image" content="@yield('image', url('/storage/settings/og-default.jpg'))" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:locale" content="{{ $locale === 'ar' ? 'ar_AR' : 'en_US' }}" />

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title', __('Smart Designer Decorations'))" />
    <meta name="twitter:description" content="@yield('description', __('Smart Designer Decorations - Professional interior design and decoration services in Saudi Arabia'))" />
    <meta name="twitter:image" content="@yield('image', url('/storage/settings/og-default.jpg'))" />

    {{-- Preload hero image (early for LCP) --}}
    @if(request()->routeIs('home'))
        @isset($heroImages)
            @foreach(array_slice($heroImages, 0, 1) as $hero)
                <link rel="preload" as="image" href="{{ $hero }}" fetchpriority="high" />
            @endforeach
        @endisset
    @endif

    {{-- Font Awesome (non-blocking) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">

    {{-- Google Fonts (non-blocking) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet"></noscript>

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Google Search Console --}}
    @php $gsc = App\Models\Setting::getValue('google_search_console', ''); @endphp
    @if($gsc)
        <meta name="google-site-verification" content="{{ $gsc }}" />
    @endif

    {{-- Schema.org structured data --}}
    @include('partials.schemas')
    @stack('schema')
    <script>
        // Force dark mode for Cyber-Glassmorphism unless explicitly disabled
        if (localStorage.getItem('darkMode') === 'false') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
    </script>

    @stack('styles')

    <style>
        :root {
            --navy-dark: #F8FAFC;
            --navy: #FFFFFF;
            --gold: #EAB308;
            --gold-glow: rgba(234, 179, 8, 0.2);
            --gold-light: #FEF08A;
            --white: #F1F5F9;
            --text-heading: #0F172A;
            --text-secondary: #334155;
            --text-muted: #64748B;
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(0, 0, 0, 0.08);
            --glass-border-hover: rgba(234, 179, 8, 0.4);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --cream: var(--navy-dark);
            --stone: rgba(0, 0, 0, 0.05);
            --text-light: var(--text-secondary);
        }

        .dark {
            --navy-dark: #030712;
            --navy: #0F172A;
            --gold: #EAB308;
            --gold-glow: rgba(234, 179, 8, 0.4);
            --gold-light: #FEF08A;
            --white: #1E293B;
            --text-heading: #F8FAFC;
            --text-secondary: #CBD5E1;
            --text-muted: #94A3B8;
            --glass-bg: rgba(255, 255, 255, 0.02);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-border-hover: rgba(234, 179, 8, 0.4);
            --cream: var(--navy-dark);
            --stone: rgba(255, 255, 255, 0.05);
            --text-light: var(--text-secondary);
        }

        /* Light Mode Overrides for Hardcoded White Classes on light backgrounds */
        html:not(.dark) .bg-white\/5,
        html:not(.dark) .bg-white\/\[0\.02\],
        html:not(.dark) .bg-white\/\[0\.03\],
        html:not(.dark) .bg-white\/\[0\.04\] { background-color: rgba(0, 0, 0, 0.05) !important; }
        html:not(.dark) .bg-white\/10,
        html:not(.dark) .bg-white\/20 { background-color: rgba(0, 0, 0, 0.1) !important; }
        
        html:not(.dark) .border-white,
        html:not(.dark) .border-white\/5,
        html:not(.dark) .border-white\/10,
        html:not(.dark) .border-white\/20 { border-color: rgba(0, 0, 0, 0.1) !important; }

        /* Light mode footer text — footer bg is light, so white text is invisible */
        html:not(.dark) .footer { color: var(--text-secondary) !important; }
        html:not(.dark) .footer .text-white\/20,
        html:not(.dark) .footer .text-white\/30,
        html:not(.dark) .footer .text-white\/40,
        html:not(.dark) .footer .text-white\/50,
        html:not(.dark) .footer .text-white\/80 { color: inherit !important; }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Tajawal', 'Outfit', sans-serif;
            background-color: var(--navy-dark);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(234, 179, 8, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(234, 179, 8, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, var(--navy) 0%, var(--navy-dark) 100%);
            background-attachment: fixed;
            color: var(--text-secondary);
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Tajawal', 'Playfair Display', serif;
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-heading);
            letter-spacing: -0.01em;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--navy-dark); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold); }

        /* Neon Glass Buttons */
        .btn-primary {
            background: rgba(234, 179, 8, 0.1);
            color: var(--gold);
            padding: 0.875rem 2.5rem;
            border-radius: var(--radius-lg);
            font-weight: 800;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            border: 1px solid rgba(234, 179, 8, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .btn-primary:hover::before {
            transform: translateX(100%);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: rgba(234, 179, 8, 0.2);
            border-color: var(--gold);
            box-shadow: 0 0 25px rgba(234, 179, 8, 0.3), inset 0 0 10px rgba(234, 179, 8, 0.2);
            color: var(--gold-light);
        }

        .btn-outline {
            border: 1px solid var(--glass-border);
            color: var(--text-heading);
            padding: 0.875rem 2.5rem;
            border-radius: var(--radius-lg);
            font-weight: 800;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.15);
            background: rgba(234, 179, 8, 0.05);
        }

        .btn-light {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-heading);
            padding: 0.875rem 2.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.8125rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .btn-light:hover {
            background: rgba(255,255,255,0.05);
            border-color: var(--gold);
            color: var(--gold);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.2);
        }

        /* Glassmorphism Cards */
        .card-elegant {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid var(--glass-border);
            position: relative;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .card-elegant::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-lg);
            padding: 1px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent, transparent, rgba(234, 179, 8, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.5;
            transition: opacity 0.5s ease, background 0.5s ease;
            pointer-events: none;
        }

        .card-elegant:hover::before {
            opacity: 1;
            background: linear-gradient(135deg, var(--gold), transparent, transparent, var(--gold));
        }

        .card-elegant:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4), 0 0 20px rgba(234, 179, 8, 0.1);
            background: rgba(255, 255, 255, 0.04);
        }

        .img-zoom { overflow: hidden; }
        .img-zoom img { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .img-zoom:hover img { transform: scale(1.06); }

        .overlay-gradient {
            background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 60%);
        }

        .navy-gradient {
            background: linear-gradient(135deg, rgba(3,7,18,0.9) 0%, rgba(15,23,42,0.8) 50%, rgba(3,7,18,0.9) 100%);
        }

        .section-label {
            display: inline-block;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.75rem;
            text-shadow: 0 0 10px rgba(234, 179, 8, 0.3);
        }

        .section-title {
            font-size: 2.75rem;
            margin-bottom: 1rem;
            color: var(--text-heading);
            text-shadow: 0 0 30px rgba(255,255,255,0.1);
        }

        @media (max-width: 768px) {
            .section-title { font-size: 1.875rem; }
            .hero-section { padding-top: 5rem !important; padding-bottom: 5rem !important; }
            .section-padding { padding-top: 4rem !important; padding-bottom: 4rem !important; }
            .container-wide { padding-left: 1rem; padding-right: 1rem; }
            section[class*="py-32"] { padding-top: 5rem !important; padding-bottom: 5rem !important; }
            section[class*="py-20"]:not(.hero-section) { padding-top: 4rem !important; padding-bottom: 4rem !important; }
        }

        @media (max-width: 480px) {
            .hero-section { padding-top: 4rem !important; padding-bottom: 4rem !important; }
            section[class*="py-32"] { padding-top: 4rem !important; padding-bottom: 4rem !important; }
            section[class*="py-24"] { padding-top: 3rem !important; padding-bottom: 3rem !important; }
        }

        /* Ensure cards stack properly on very small screens */
        @media (max-width: 360px) {
            .card-elegant .p-6 { padding: 1rem !important; }
            .grid { gap: 0.75rem !important; }
        }

        /* Mobile-friendly header: reduce height on small screens */
        @media (max-width: 480px) {
            header .h-20 { height: 3.5rem !important; }
            main { padding-top: 3.5rem !important; }
            header .logo-inner .text-xl { font-size: 1rem; }
            header .logo-inner .text-[10px] { font-size: 8px; }
            .sidebar-menu { width: 100%; right: -100%; }
            .sticky.top-20 { top: 56px !important; }
        }

        @media (max-width: 640px) {
            .sticky.top-20 { top: 56px !important; }
        }

        /* Blog card image optimization for mobile */
        @media (max-width: 480px) {
            .card-elegant .h-52 { height: 11rem !important; }
        }

        .section-divider {
            width: 48px;
            height: 2px;
            background: var(--gold);
            margin: 1.25rem auto;
            box-shadow: 0 0 10px var(--gold);
        }

        .section-divider-start {
            width: 48px;
            height: 2px;
            background: var(--gold);
            margin: 1.25rem 0;
            box-shadow: 0 0 10px var(--gold);
        }

/* Glass Header */
.sticky-header { transition: all 0.4s ease; }

@keyframes logo-spin {
    to { transform: rotate(360deg); }
}

@property --logo-angle {
    syntax: '<angle>';
    initial-value: 0deg;
    inherits: false;
}

@keyframes logo-spin-angle {
    to { --logo-angle: 360deg; }
}

@keyframes logo-glow {
    0%, 100% { box-shadow: 0 0 14px rgba(234, 179, 8, 0.05); }
    50% { box-shadow: 0 0 28px rgba(234, 179, 8, 0.3); }
}

.logo-frame {
    position: relative;
    border-radius: 60px;
    padding: 2px;
    isolation: isolate;
    animation: logo-glow 2.6s ease-in-out infinite;
}

.logo-frame::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 60px;
    padding: 2px;
    background: conic-gradient(from var(--logo-angle, 0deg), var(--gold) 0%, var(--gold) 100%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    animation: logo-spin-angle 4s linear infinite;
}

.logo-inner {
    position: relative;
    border-radius: 58px;
    background: var(--navy);
    z-index: 0;
}

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
            color: var(--text-heading);
            text-shadow: 0 0 8px rgba(255,255,255,0.3);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 0 10px var(--gold);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }

        /* Glass Inputs */
        .input-elegant {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            background: rgba(0,0,0,0.2);
            color: var(--text-heading);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            outline: none;
            backdrop-filter: blur(10px);
        }

        .input-elegant:focus {
            border-color: var(--gold);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.2);
            background: rgba(0,0,0,0.4);
        }

        .input-elegant::placeholder {
            color: var(--text-muted);
        }

        .stat-number {
            font-size: 3.25rem;
            font-weight: 800;
            color: var(--text-heading);
            font-family: 'Playfair Display', serif;
            line-height: 1;
            text-shadow: 0 0 20px rgba(255,255,255,0.2);
        }

        @media (max-width: 768px) {
            .stat-number { font-size: 2.5rem; }
        }

        .whatsapp-float,
        .call-float,
        .search-float {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .whatsapp-float {
            background: rgba(37, 211, 102, 0.2);
            border: 1px solid rgba(37, 211, 102, 0.4);
            color: #25D366;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            background: rgba(37, 211, 102, 0.9);
            color: white;
            box-shadow: 0 0 30px rgba(37, 211, 102, 0.5);
            border-color: transparent;
        }
        .call-float {
            background: rgba(52, 168, 83, 0.2);
            border: 1px solid rgba(52, 168, 83, 0.4);
            color: #34A853;
        }
        .call-float:hover {
            transform: scale(1.1);
            background: rgba(52, 168, 83, 0.9);
            color: white;
            box-shadow: 0 0 30px rgba(52, 168, 83, 0.5);
            border-color: transparent;
        }
        .search-float {
            background: rgba(234, 179, 8, 0.15);
            border: 1px solid rgba(234, 179, 8, 0.3);
            color: var(--gold);
        }
        .search-float:hover {
            transform: scale(1.1);
            background: rgba(234, 179, 8, 0.9);
            color: white;
            box-shadow: 0 0 30px rgba(234, 179, 8, 0.4);
            border-color: transparent;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes goldPulse {
            0%, 100% { box-shadow: 0 0 15px rgba(234, 179, 8, 0.2); }
            50% { box-shadow: 0 0 30px rgba(234, 179, 8, 0.4); }
        }

        .gold-pulse { animation: goldPulse 2s infinite; }

        .gold-text-gradient {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(234, 179, 8, 0.2);
        }

        [x-cloak] { display: none !important; }

        .sidebar-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80vw;
            max-width: 320px;
            height: 100vh;
            background: rgba(3, 7, 18, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-left: 1px solid var(--glass-border);
            z-index: 9999;
            transition: right 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow-y: auto;
            visibility: hidden;
        }

        .sidebar-menu.open { right: 0; visibility: visible; }

        .sidebar-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
            backdrop-filter: blur(6px);
        }

        .sidebar-overlay.open { opacity: 1; visibility: visible; }

        .footer {
            background: var(--navy-dark);
            border-top: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 100%; height: 1px;
            background: radial-gradient(circle, var(--gold-glow), transparent 60%);
        }

        .footer a { transition: all 0.3s ease; }
        .footer a:hover { color: var(--gold) !important; text-shadow: 0 0 10px rgba(234, 179, 8, 0.3); }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
            line-height: 1.08;
            text-shadow: 0 0 40px rgba(255,255,255,0.1);
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
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.15);
        }

        .gold-border-bottom {
            border-bottom: 1px solid var(--gold);
            box-shadow: 0 2px 10px rgba(234, 179, 8, 0.2);
        }

        @keyframes heroProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        .hero-zoom {
            transform: scale(1.08);
            transition: transform 8s ease-out;
        }
        .hero-zoom-active {
            transform: scale(1);
        }
        .progress-bar {
            animation: heroProgress 6s linear infinite;
        }
    </style>
    {{-- Google Analytics --}}
    @php $gaId = App\Models\Setting::getValue('google_analytics_id', ''); @endphp
    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif
</head>
<body>

    <div x-data="{
        mobileMenu: false,
        searchOpen: false,
        favorites: JSON.parse(localStorage.getItem('sm_favorites') || '{}'),
        saveFavs() {
            localStorage.setItem('sm_favorites', JSON.stringify(this.favorites));
        },
        toggleFavorite(type, id) {
            if (!this.favorites[type]) this.favorites[type] = [];
            const idx = this.favorites[type].indexOf(id);
            if (idx > -1) {
                this.favorites[type].splice(idx, 1);
                if (this.favorites[type].length === 0) delete this.favorites[type];
            } else {
                this.favorites[type].push(id);
            }
            this.saveFavs();
        },
        isFavorite(type, id) {
            return this.favorites[type] && this.favorites[type].includes(id);
        },
        favCount() {
            return Object.values(this.favorites).reduce((a, b) => a + (b ? b.length : 0), 0);
        }
    }" @fav-updated.window="favorites = JSON.parse(localStorage.getItem('sm_favorites') || '{}')">

        {{-- Mobile Sidebar Overlay --}}
        <div class="sidebar-overlay" :class="{ 'open': mobileMenu }" @click="mobileMenu = false" aria-label="{{ __('Close menu') }}" role="button" tabindex="0"></div>

        {{-- Mobile Sidebar --}}
        <div class="sidebar-menu" :class="{ 'open': mobileMenu }">
            <div class="p-8">
                <div class="flex justify-between items-center mb-10">
                    <span class="text-lg font-bold text-[var(--gold)]" style="font-family: 'Playfair Display', serif;">{{ __('Smart Designer') }}</span>
                    <button @click="mobileMenu = false" class="w-8 h-8 flex items-center justify-center text-white/40 hover:text-[var(--gold)] transition-colors rounded-lg hover:bg-white/5" aria-label="{{ __('Close menu') }}">
                        <x-icon name="times" class="w-4 h-4" />
                    </button>
                </div>
                <nav class="flex flex-col space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('About Us') }}</a>
                    <a href="{{ route('services') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Our Services') }}</a>
                    <a href="{{ route('projects') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Our Projects') }}</a>
                    <a href="{{ route('gallery') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Gallery') }}</a>
                    <a href="{{ route('materials') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Decoration Materials') }}</a>
                    <a href="{{ route('blog') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Blog') }}</a>
                    <a href="{{ route('contact') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Contact Us') }}</a>
                    <a href="{{ route('faq') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('FAQ') }}</a>
                    <a href="{{ route('most-viewed') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Most Viewed') }}</a>
                    <a href="{{ route('questions') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Questions & Answers') }}</a>
                    <a href="{{ route('areas.we.serve') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">{{ __('Areas We Serve') }}</a>
                    <a href="{{ route('favorites') }}" class="flex items-center gap-3 text-white/60 hover:text-[var(--gold)] transition-colors px-4 py-3 rounded-lg hover:bg-white/[0.03] text-sm font-medium border-r-2 border-transparent hover:border-[var(--gold)]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        {{ __('Favorites') }}
                        <span x-show="favCount() > 0" x-cloak class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full" x-text="favCount()"></span>
                    </a>
                </nav>
                <div class="mt-8 pt-6 border-t border-white/5 space-y-4">
                    {{-- Lang & Dark mode in sidebar --}}
                    <div class="flex items-center gap-3 px-4">
                        <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/60 hover:text-[var(--gold)] hover:bg-white/5 transition-colors border border-white/10">
                            <x-icon name="globe" class="w-4 h-4" />
                            {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
                        </a>
                        <button @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/60 hover:text-[var(--gold)] hover:bg-white/5 transition-colors border border-white/10">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <span>{{ __('Dark Mode') }}</span>
                        </button>
                    </div>
                    @auth
                    <div class="px-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/60 hover:text-[var(--gold)] hover:bg-white/5 transition-colors border border-white/10">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ __('Admin Panel') }}
                        </a>
                    </div>
                    @else
                    <div class="px-4">
                        <a href="{{ route('admin.login') }}" class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/60 hover:text-[var(--gold)] hover:bg-white/5 transition-colors border border-white/10">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            {{ __('Login') }}
                        </a>
                    </div>
                    @endauth
                    <div class="px-4">
                        <p class="text-white/30 text-xs mb-3 tracking-wider uppercase">{{ __('Follow Us') }}</p>
                        <div class="flex flex-wrap gap-2" dir="ltr">
                            @include('partials.social-icons', ['socialLinks' => $socialLinks])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <header class="sticky-header fixed w-full top-0 z-50 transition-all duration-500" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 60)">
            <div class="bg-[var(--navy)]/60 backdrop-blur-xl border-b border-[var(--glass-border)]" :class="{ 'shadow-[0_4px_30px_rgba(0,0,0,0.5)]': scrolled }">
                <div class="container-wide">
                    <div class="flex items-center justify-between h-20 lg:h-24">
                        {{-- Logo --}}
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="logo-frame">
                                <div class="logo-inner text-right px-3 py-2">
                                    <span class="block text-xl font-black text-[var(--text-heading)] leading-tight" style="font-family: 'Playfair Display', serif;">{{ __('Smart Designer') }}</span>
                                    <span class="block text-[10px] font-medium tracking-[0.25em] text-[var(--gold)]">SMART DESIGNER</span>
                                </div>
                            </div>
                        </a>

                        {{-- Desktop Nav --}}
                        <nav class="hidden lg:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="nav-link">{{ __('Home') }}</a>
                            <a href="{{ route('about') }}" class="nav-link">{{ __('About Us') }}</a>
                            <a href="{{ route('services') }}" class="nav-link">{{ __('Our Services') }}</a>
                            <a href="{{ route('projects') }}" class="nav-link">{{ __('Our Projects') }}</a>
                            <a href="{{ route('gallery') }}" class="nav-link">{{ __('Gallery') }}</a>
                            <a href="{{ route('materials') }}" class="nav-link">{{ __('Decoration Materials') }}</a>
                            <a href="{{ route('blog') }}" class="nav-link">{{ __('Blog') }}</a>
                            <a href="{{ route('faq') }}" class="nav-link">{{ __('FAQ') }}</a>
                            <a href="{{ route('favorites') }}" class="nav-link relative">
                                {{ __('Favorites') }}
                                <span x-show="favCount() > 0" x-cloak class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-[9px] flex items-center justify-center text-white font-bold" x-text="favCount()"></span>
                            </a>
                        </nav>

                        <div class="flex items-center gap-1.5 sm:gap-4">
                            {{-- Social icons (md+) --}}
                            <div class="hidden md:flex items-center gap-2" dir="ltr">
                                @include('partials.social-icons', ['socialLinks' => $socialLinks])
                            </div>
                            {{-- Lang, Dark, Admin (sm+) --}}
                            <div class="hidden sm:flex items-center gap-1 md:gap-2" dir="ltr">
                                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-lg text-[var(--text-muted)] hover:text-[var(--gold)] hover:bg-[var(--stone)] transition-all text-[10px] md:text-xs font-bold" title="{{ app()->getLocale() === 'ar' ? __('English') : __('Arabic') }}">
                                    {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
                                </a>
                                <button type="button" @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-lg text-[var(--text-muted)] hover:text-[var(--gold)] hover:bg-[var(--stone)] transition-all" aria-label="{{ __('Dark Mode') }}" title="{{ __('Dark Mode') }}">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                                </button>
                                @auth
                                <a href="{{ route('admin.dashboard') }}" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-lg text-[var(--text-muted)] hover:text-[var(--gold)] hover:bg-[var(--stone)] transition-all" title="لوحة التحكم">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </a>
                                @else
                                <a href="{{ route('admin.login') }}" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-lg text-[var(--text-muted)] hover:text-[var(--gold)] hover:bg-[var(--stone)] transition-all" title="{{ __('Login') }}">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                </a>
                                @endauth
                            </div>

                            <div class="w-px h-5 sm:h-6 bg-[var(--glass-border)] hidden sm:block"></div>

                            {{-- Favorites --}}
                            <a href="{{ route('favorites') }}" class="relative w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center text-[var(--text-secondary)] hover:text-red-400 hover:bg-[var(--cream)] rounded-lg sm:rounded-xl transition-all" title="{{ __('Favorites') }}">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                <span x-show="favCount() > 0" x-cloak class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-red-500 rounded-full text-[8px] flex items-center justify-center text-white font-bold" x-text="favCount()"></span>
                            </a>
                            {{-- Search --}}
                            <button type="button" @@click="searchOpen = true" class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center text-[var(--text-secondary)] hover:text-[var(--gold)] hover:bg-[var(--cream)] rounded-lg sm:rounded-xl transition-all" aria-label="{{ __('Search') }}" title="{{ __('Search') }}">
                                <x-icon name="search" class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4" />
                            </button>
                            {{-- Contact Button (sm+) --}}
                            <a href="{{ route('contact') }}" class="btn-primary hidden sm:inline-flex px-3 md:px-5 py-1.5 md:py-2.5 text-[10px] md:text-xs whitespace-nowrap">
                                {{ __('Contact Us') }}
                            </a>
                            {{-- Mobile Toggle --}}
                            <button @click="mobileMenu = !mobileMenu" class="lg:hidden w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center text-[var(--text-secondary)] hover:text-[var(--text-heading)] hover:bg-[var(--stone)] rounded-lg sm:rounded-xl transition-all" aria-label="{{ __('Toggle menu') }}" :aria-expanded="mobileMenu">
                                <x-icon name="bars" class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-5 md:h-5" />
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
                    <form action="{{ route('search') }}" method="GET" class="relative"
                          toolname="searchSite"
                          tooldescription="Search the Smart Designer Decorations website. Accepts: q (search query). Returns: search results page with matching services, projects, materials, and articles.">
                        <input type="text" name="q" x-model="query" placeholder="{{ __('Search for services, projects, materials, articles...') }}"
                               class="input-elegant w-full px-6 py-4 pr-14 text-base shadow-[0_0_30px_rgba(234,179,8,0.1)]"
                               toolparamdescription="Search query text">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[var(--gold)] hover:text-[var(--text-heading)] transition-colors" aria-label="{{ __('Search') }}">
                            <x-icon name="search" class="w-5 h-5" />
                        </button>
                        <button type="button" @@click="searchOpen = false" class="absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] hover:text-[var(--text-heading)] transition-colors" aria-label="{{ __('Close search') }}">
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
                            <span class="block text-2xl font-black text-[var(--gold)] leading-tight" style="font-family: 'Playfair Display', serif;">{{ __('Smart Designer') }}</span>
                            <span class="block text-[11px] font-medium text-white/30 tracking-[0.25em] mt-1">SMART DESIGNER</span>
                        </div>
                        <p class="text-white/40 text-sm leading-relaxed mb-6 max-w-xs">
                            {{ __('We are a leading interior design and decoration company, combining modern elegance with authentic Arabic touches.') }}
                        </p>
                        <div class="flex gap-2" dir="ltr">
                            @include('partials.social-icons', ['socialLinks' => $socialLinks])
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">{{ __('Quick Links') }}</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('about') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('services') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Our Services') }}</a></li>
                            <li><a href="{{ route('projects') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Our Projects') }}</a></li>
                            <li><a href="{{ route('gallery') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Gallery') }}</a></li>
                            <li><a href="{{ route('materials') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Decoration Materials') }}</a></li>
                            <li><a href="{{ route('blog') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Blog') }}</a></li>
                            <li><a href="{{ route('contact') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Contact Us') }}</a></li>
                            <li><a href="{{ route('faq') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('FAQ') }}</a></li>
                            <li><a href="{{ route('most-viewed') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Most Viewed') }}</a></li>
                            <li><a href="{{ route('privacy') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Privacy Policy') }}</a></li>
                            <li><a href="{{ route('terms') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Terms & Conditions') }}</a></li>
                            <li><a href="{{ route('city.jeddah') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Jeddah Decorations') }}</a></li>
                            <li><a href="{{ route('city.mecca') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Mecca Decorations') }}</a></li>
                            <li><a href="{{ route('questions') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Questions & Answers') }}</a></li>
                            <li><a href="{{ route('areas.we.serve') }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ __('Areas We Serve') }}</a></li>
                        </ul>
                    </div>

                    {{-- Column 3 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">{{ __('Our Services') }}</h3>
                        <ul class="space-y-3">
                            @foreach($services as $service)
                                <li><a href="{{ route('service.show', $service->slug) }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ $service->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Column 4 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">{{ __('Decoration Materials') }}</h3>
                        <ul class="space-y-3">
                            @foreach($materialCategories as $category)
                                <li><a href="{{ route('material.category.show', $category->slug) }}" class="text-white/40 hover:text-[var(--gold)] text-sm transition-colors">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Column 5 --}}
                    <div>
                        <h3 class="text-xs font-bold mb-6 text-white/50 tracking-[0.2em] uppercase">{{ __('Contact Us') }}</h3>
                        <div class="text-sm text-white/40 space-y-3">
                            <p class="text-white/60 font-semibold">{{ __('Smart Designer Decorations team is at your service') }}</p>
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style="background: #E07A5F; color: white;"><x-icon name="location" class="w-3.5 h-3.5" /></span>
                                <a href="https://maps.google.com/?q=الزاهر+1+الضيافة+مكة+المكرمة" target="_blank" rel="noopener noreferrer" class="hover:text-[var(--gold)] transition-colors">الزاهر 1 – الضيافة، مكة المكرمة، المملكة العربية السعودية</a>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style="background: #E07A5F; color: white;"><x-icon name="clock" class="w-3.5 h-3.5" /></span>
                                <span>{{ __('Working hours: 24/7') }}</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style="background: #E07A5F; color: white;"><x-icon name="location" class="w-3.5 h-3.5" /></span>
                                <span>{{ __('Our addresses: Mecca, Jeddah') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="tel:0541232717" class="flex items-center gap-3 hover:text-[var(--gold)] transition-colors group w-full">
                                    <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background: #34A853; color: white;"><x-icon name="phone" class="w-3.5 h-3.5" /></span>
                                    <span dir="ltr">054 123 2717</span>
                                </a>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="https://wa.me/966541232717" target="_blank" class="flex items-center gap-3 hover:text-[var(--gold)] transition-colors group w-full">
                                    <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background: #25D366; color: white;"><x-icon name="whatsapp" class="w-3.5 h-3.5" /></span>
                                    <span dir="ltr">+966 54 123 2717</span>
                                </a>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="mailto:Smartdecorat1@gmail.com" class="flex items-center gap-3 hover:text-[var(--gold)] transition-colors group w-full">
                                    <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background: #EA4335; color: white;"><x-icon name="email" class="w-3.5 h-3.5" /></span>
                                    <span>Smartdecorat1@gmail.com</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Articles Strip --}}
                @if($latestPosts->isNotEmpty())
                <div class="border-t border-white/[0.04] pt-10 pb-10 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-bold text-white/50 tracking-[0.2em] uppercase">{{ __('Latest Articles') }}</h3>
                        <a href="{{ route('blog') }}" class="text-[var(--gold)] text-xs hover:underline">{{ __('View All') }}</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($latestPosts as $post)
                        <a href="{{ route('blog.post', $post->slug) }}" class="group flex items-center gap-4 p-3 rounded-xl transition-all duration-300 hover:bg-white/[0.03] hover:scale-[1.02]">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                @if($post->image)
                                    {!! \App\Services\ImageService::picture($post->image, $post->title, 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500') !!}
                                @else
                                    <div class="w-full h-full bg-white/5 flex items-center justify-center text-white/20"><i class="fas fa-newspaper"></i></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm text-white/70 group-hover:text-[var(--gold)] transition-colors line-clamp-2 leading-relaxed">{{ $post->title }}</h4>
                                <p class="text-[11px] text-white/30 mt-1">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="border-t border-white/[0.04] pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-white/30 text-xs">{{ $settings['copyright'] }}</p>
                <div class="mt-2 text-center">
                    <p class="text-white/20 text-[10px]">تم تصميم الموقع بواسطة <a href="https://wa.me/967773981857" target="_blank" class="text-[var(--gold)] hover:underline">دكتور ويب</a> +967773981857</p>
                </div>
            </div>
        </footer>

        {{-- Floating Buttons --}}
        <div class="fixed bottom-6 left-6 z-[1000] flex flex-col gap-3">
            {{-- Call --}}
            <a href="tel:0541232717"
               class="call-float flex items-center justify-center" aria-label="اتصال هاتفي">
                <x-icon name="phone" class="w-6 h-6" />
            </a>
            {{-- WhatsApp --}}
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['phone']) }}" target="_blank" rel="noopener noreferrer"
               class="whatsapp-float flex items-center justify-center" aria-label="واتساب">
                <x-icon name="whatsapp" class="w-6 h-6" />
            </a>
            {{-- Search --}}
            <button type="button" @@click="searchOpen = true"
                    class="search-float flex items-center justify-center" aria-label="بحث">
                <x-icon name="search" class="w-5 h-5" />
            </button>
        </div>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 80,
                easing: 'ease-out-cubic',
            });
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
