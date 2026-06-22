<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'لوحة التحكم') - ديكورات المصمم الذكي</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
        .sidebar-link { position: relative; overflow: hidden; }
        .sidebar-link::before { content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 0; background: linear-gradient(to bottom, #E07A5F, #EA967D); border-radius: 0 3px 3px 0; transition: height 0.3s ease; }
        .sidebar-link.active::before, .sidebar-link:hover::before { height: 60%; }
        .sidebar-link.active { background: linear-gradient(135deg, rgba(224,122,95,0.12), transparent); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-3px); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        .dark body { background: #0F1A2E; }
        .dark .bg-white { background-color: #111A2A; }
        .dark .bg-gray-50 { background-color: #0F1A2E; }
        .dark .border-gray-200 { border-color: rgba(255,255,255,0.08); }
        .dark .text-gray-800 { color: #f1f5f9; }
        .dark .text-gray-700 { color: #e2e8f0; }
        .dark .text-gray-600 { color: #cbd5e1; }
        .dark .text-gray-500 { color: #94a3b8; }
        .dark .text-gray-400 { color: #64748b; }
        .dark .hover\:bg-gray-50\/50:hover { background-color: rgba(11,22,51,0.5); }
        .dark .divide-gray-100 { border-color: rgba(255,255,255,0.06); }

        [x-cloak] { display: none !important; }

        .dark {
            --dark-bg: #080C18;
            --dark-card: #111A2A;
            --dark-border: #1A2235;
            --dark-text: #F0EDE8;
            --dark-text-secondary: #9C9C9C;
        }

        .admin-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .admin-table-wrap table { min-width: 650px; }
        .admin-table td, .admin-table th { white-space: nowrap; }

        @media (max-width: 768px) {
            .admin-table { font-size: 0.75rem; }
            .admin-table td, .admin-table th { padding-left: 0.5rem !important; padding-right: 0.5rem !important; white-space: nowrap; }
            .admin-sidebar { width: 100% !important; max-width: 320px !important; }
        }

        @media (max-width: 480px) {
            .admin-action-btn { width: 2rem !important; height: 2rem !important; }
            .admin-action-btn i { font-size: 0.625rem !important; }
            .admin-content { padding: 0.75rem !important; }
            .admin-card { padding: 1rem !important; }
            .admin-hide-mobile { display: none !important; }
        }
    </style>
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="font-cairo bg-gray-50">

<div x-data="{ sidebarOpen: window.innerWidth >= 1024, mobileSidebar: false }"
     @@resize.window="sidebarOpen = window.innerWidth >= 1024"
     class="flex h-screen overflow-hidden">

    {{-- Mobile overlay --}}
    <div x-show="mobileSidebar"
         @@click="mobileSidebar = false"
         x-transition.opacity
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"></div>

    {{-- Sidebar --}}
    <aside x-show="sidebarOpen || mobileSidebar"
           x-cloak
           :class="mobileSidebar ? 'translate-x-0 fixed' : ''"
           class="admin-sidebar fixed inset-y-0 right-0 z-50 w-72 bg-gradient-to-b from-[#0F1A2E] via-[#0F1A2E] to-[#070C14] text-white shadow-2xl lg:relative lg:translate-x-0 lg:flex lg:flex-col lg:shrink-0 transition-all duration-300">

        {{-- Brand --}}
        <div class="flex items-center justify-between h-14 sm:h-16 px-4 sm:px-5 border-b border-white/[0.06]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 sm:gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-[#E07A5F] to-[#D4694C] flex items-center justify-center shadow-lg shadow-[#E07A5F]/20 shrink-0">
                    <i class="fas fa-pen-ruler text-xs sm:text-sm text-white"></i>
                </div>
                <div>
                    <span class="text-sm sm:text-base font-bold text-white">المصمم الذكي</span>
                    <p class="text-[9px] sm:text-[10px] text-gray-400 -mt-0.5">لوحة الإدارة</p>
                </div>
            </a>
            <button @@click="mobileSidebar = false" class="p-1.5 sm:p-2 text-gray-400 hover:text-white lg:hidden rounded-lg hover:bg-white/5 transition-colors">
                <i class="fas fa-times text-base sm:text-lg"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.dashboard')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-chart-pie w-5 text-center text-base"></i>
                <span>لوحة التحكم</span>
            </a>

            <a href="{{ route('admin.homepage-sections.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.homepage-sections.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-home w-5 text-center text-base"></i>
                <span>الصفحة الرئيسية</span>
            </a>

            <p class="px-4 pt-5 pb-1 text-[10px] font-semibold text-gray-500 uppercase tracking-wider">المحتوى</p>

            @if(auth()->user()->is_super_admin)
            <a href="{{ route('admin.about.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.about.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-info-circle w-5 text-center text-base"></i>
                <span>عن الشركة</span>
            </a>
            @endif

            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.categories.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-layer-group w-5 text-center text-base"></i>
                <span>التصنيفات</span>
            </a>

            <a href="{{ route('admin.galleries.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.galleries.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-images w-5 text-center text-base"></i>
                <span>معرض الصور</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.reviews.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-star w-5 text-center text-base"></i>
                <span>التقييمات</span>
            </a>

            <a href="{{ route('admin.faqs.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.faqs.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-question-circle w-5 text-center text-base"></i>
                <span>الأسئلة الشائعة</span>
            </a>

            <a href="{{ route('admin.visitor-questions.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.visitor-questions.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-user-question w-5 text-center text-base"></i>
                <span>أسئلة الزوار</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.services.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-concierge-bell w-5 text-center text-base"></i>
                <span>الخدمات</span>
            </a>

            <a href="{{ route('admin.materials.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.materials.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-cubes w-5 text-center text-base"></i>
                <span>المواد</span>
            </a>

            <a href="{{ route('admin.projects.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.projects.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-briefcase w-5 text-center text-base"></i>
                <span>المشاريع</span>
            </a>

            <a href="{{ route('admin.blog-posts.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.blog-posts.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-newspaper w-5 text-center text-base"></i>
                <span>المقالات</span>
            </a>

            @if(auth()->user()->is_super_admin)
            <a href="{{ route('admin.admins.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.admins.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-users-cog w-5 text-center text-base"></i>
                <span>المشرفون</span>
            </a>
            @endif

            <p class="px-4 pt-5 pb-1 text-[10px] font-semibold text-gray-500 uppercase tracking-wider">الإعدادات</p>

            <a href="{{ route('admin.social-links.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.social-links.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-share-alt w-5 text-center text-base"></i>
                <span>الروابط الاجتماعية</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.contacts.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-address-card w-5 text-center text-base"></i>
                <span>معلومات الاتصال</span>
            </a>

            @if(auth()->user()->is_super_admin)
            <a href="{{ route('admin.settings') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.settings.*')) active text-[#E07A5F] bg-[#E07A5F]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-cog w-5 text-center text-base"></i>
                <span>الإعدادات العامة</span>
            </a>
            @endif
        </nav>

        {{-- Footer --}}
        <div class="p-3 sm:p-4 border-t border-white/[0.06]">
            <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-1.5 sm:py-2">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-[#E07A5F] to-[#D4694C] flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg shadow-[#E07A5F]/10">
                    {{ substr(Auth::user()->name ?? 'م', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0 hidden sm:block">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'المدير' }}</p>
                    <p class="text-[11px] text-gray-500">{{ auth()->user()->is_super_admin ? 'مدير النظام' : 'مشرف' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-1 sm:gap-2 px-3 sm:px-4 pt-2 sm:pt-3 border-t border-white/[0.06] mt-2 sm:mt-3">
                <a href="{{ url('/') }}" target="_blank" class="flex-1 flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-gray-400 hover:text-[#E07A5F] hover:bg-[#E07A5F]/10 transition-all text-xs sm:text-sm" title="زيارة الموقع">
                    <i class="fas fa-external-link-alt"></i>
                    <span class="sm:hidden">الموقع</span>
                    <span class="hidden sm:inline">زيارة الموقع</span>
                </a>
                <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="flex-1 flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-gray-400 hover:text-[#E07A5F] hover:bg-[#E07A5F]/10 transition-all text-xs sm:text-sm" title="الوضع الليلي">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <span>ليلي</span>
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all text-xs sm:text-sm" title="تسجيل خروج">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>خروج</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main content wrapper --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Top bar --}}
        <header class="admin-topbar h-14 sm:h-16 bg-white border-b border-gray-200 flex items-center justify-between px-3 sm:px-4 lg:px-6 shadow-sm">
            <div class="flex items-center gap-2 sm:gap-4">
                <button @@click="mobileSidebar = true" class="p-1.5 sm:p-2 text-gray-500 hover:text-gray-700 lg:hidden rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-lg sm:text-xl"></i>
                </button>
                <button @@click="sidebarOpen = !sidebarOpen" class="p-1.5 text-gray-400 hover:text-gray-600 hidden lg:block transition-colors rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bars" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
                <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-gray-400 truncate max-w-[140px] sm:max-w-none">
                    <i class="fas fa-home text-[#E07A5F] hidden sm:inline"></i>
                    <span class="hidden sm:inline">/</span>
                    <span class="text-gray-600 font-medium truncate">@yield('title', 'لوحة التحكم')</span>
                </div>
            </div>

            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                {{-- Search --}}
                <div x-data="{ open: false }" class="relative">
                    <button @@click="open = true" class="w-8 h-8 sm:w-9 sm:h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:border-[#E07A5F] transition-all" title="بحث">
                        <i class="fas fa-search text-xs sm:text-sm"></i>
                    </button>
                    <div x-show="open" @@click.outside="open = false" x-transition class="fixed inset-0 z-50 flex items-start justify-center pt-24">
                        <div @@click="open = false" class="absolute inset-0 bg-[#0F1A2E]/60 backdrop-blur-sm"></div>
                        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-xl p-6" @@click.stop>
                            <div class="flex items-center gap-3 mb-4">
                                <i class="fas fa-search text-gray-400"></i>
                                <input type="text" x-ref="searchInput" placeholder="ابحث عن..." class="flex-1 border-0 outline-none text-sm text-gray-700 placeholder-gray-400" autofocus>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Desktop-only buttons --}}
                <div class="hidden sm:flex items-center gap-1 sm:gap-2">
                    <a href="{{ url('/') }}" target="_blank" class="w-8 h-8 sm:w-9 sm:h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:border-[#E07A5F] hover:text-[#E07A5F] transition-all" title="زيارة الموقع">
                        <i class="fas fa-external-link-alt text-xs sm:text-sm"></i>
                    </a>

                    <button x-data="{ ar: true }" @@click="ar = !ar; document.documentElement.dir = ar ? 'rtl' : 'ltr'; document.documentElement.lang = ar ? 'ar' : 'en'" class="w-8 h-8 sm:w-9 sm:h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:border-[#E07A5F] transition-all" title="تغيير اللغة">
                        <span class="text-[10px] sm:text-[11px] font-bold" x-text="ar ? 'AR' : 'EN'">AR</span>
                    </button>

                    <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg text-[#E07A5F] hover:bg-gray-100 transition-all" title="الوضع الليلي">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                </div>

                {{-- User avatar --}}
                <div class="flex items-center gap-2 px-2 sm:px-3 py-1 sm:py-1.5 bg-gray-50 rounded-xl">
                    <div class="hidden sm:block text-left">
                        <p class="text-xs sm:text-sm font-medium text-gray-700 truncate max-w-[80px]">{{ Auth::user()->name ?? '' }}</p>
                    </div>
                    <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-gradient-to-br from-[#E07A5F] to-[#D4694C] flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-sm">
                        {{ substr(Auth::user()->name ?? 'م', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto admin-content p-4 lg:p-6 bg-gray-50">
            {{-- Alert messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button @@click="show = false" type="button" class="mr-auto text-emerald-400 hover:text-emerald-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button @@click="show = false" type="button" class="mr-auto text-red-400 hover:text-red-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>
