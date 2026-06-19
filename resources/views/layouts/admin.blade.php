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
        .sidebar-link { position: relative; overflow: hidden; }
        .sidebar-link::before { content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 0; background: linear-gradient(to bottom, #D4AF37, #EDD696); border-radius: 0 3px 3px 0; transition: height 0.3s ease; }
        .sidebar-link.active::before, .sidebar-link:hover::before { height: 60%; }
        .sidebar-link.active { background: linear-gradient(135deg, rgba(212,175,55,0.12), transparent); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-3px); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        .dark body { background: #0D1B3D; }
        .dark .bg-white { background-color: #0B1633; }
        .dark .bg-gray-50 { background-color: #0D1B3D; }
        .dark .border-gray-200 { border-color: rgba(255,255,255,0.08); }
        .dark .text-gray-800 { color: #f1f5f9; }
        .dark .text-gray-700 { color: #e2e8f0; }
        .dark .text-gray-600 { color: #cbd5e1; }
        .dark .text-gray-500 { color: #94a3b8; }
        .dark .text-gray-400 { color: #64748b; }
        .dark .hover\:bg-gray-50\/50:hover { background-color: rgba(11,22,51,0.5); }
        .dark .divide-gray-100 { border-color: rgba(255,255,255,0.06); }

        .dark {
            --dark-bg: #0A0F1E;
            --dark-card: #131B2E;
            --dark-border: #1E2744;
            --dark-text: #E8E6E1;
            --dark-text-secondary: #9C9C9C;
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
           class="fixed inset-y-0 right-0 z-50 w-72 bg-gradient-to-b from-[#0D1B3D] via-[#0D1B3D] to-[#070D1E] text-white shadow-2xl lg:relative lg:translate-x-0 lg:flex lg:flex-col lg:shrink-0 transition-all duration-300">

        {{-- Brand --}}
        <div class="flex items-center justify-between h-16 px-5 border-b border-white/[0.06]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#D4AF37] to-[#C9A22F] flex items-center justify-center shadow-lg shadow-[#D4AF37]/20">
                    <i class="fas fa-pen-ruler text-sm text-white"></i>
                </div>
                <div>
                    <span class="text-base font-bold text-white">المصمم الذكي</span>
                    <p class="text-[10px] text-gray-400 -mt-0.5">لوحة الإدارة</p>
                </div>
            </a>
            <button @@click="mobileSidebar = false" class="text-gray-400 hover:text-white lg:hidden">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.dashboard')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-chart-pie w-5 text-center text-base"></i>
                <span>لوحة التحكم</span>
            </a>

            <a href="{{ route('admin.homepage-sections.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.homepage-sections.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-home w-5 text-center text-base"></i>
                <span>الصفحة الرئيسية</span>
            </a>

            <p class="px-4 pt-5 pb-1 text-[10px] font-semibold text-gray-500 uppercase tracking-wider">المحتوى</p>

            <a href="{{ route('admin.about.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.about.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-info-circle w-5 text-center text-base"></i>
                <span>عن الشركة</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.categories.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-layer-group w-5 text-center text-base"></i>
                <span>التصنيفات</span>
            </a>

            <a href="{{ route('admin.galleries.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.galleries.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-images w-5 text-center text-base"></i>
                <span>معرض الصور</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.reviews.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-star w-5 text-center text-base"></i>
                <span>التقييمات</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.services.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-concierge-bell w-5 text-center text-base"></i>
                <span>الخدمات</span>
            </a>

            <a href="{{ route('admin.materials.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.materials.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-cubes w-5 text-center text-base"></i>
                <span>المواد</span>
            </a>

            <a href="{{ route('admin.projects.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.projects.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-briefcase w-5 text-center text-base"></i>
                <span>المشاريع</span>
            </a>

            <a href="{{ route('admin.blog-posts.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.blog-posts.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-newspaper w-5 text-center text-base"></i>
                <span>المقالات</span>
            </a>

            <p class="px-4 pt-5 pb-1 text-[10px] font-semibold text-gray-500 uppercase tracking-wider">الإعدادات</p>

            <a href="{{ route('admin.social-links.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.social-links.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-share-alt w-5 text-center text-base"></i>
                <span>الروابط الاجتماعية</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.contacts.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-address-card w-5 text-center text-base"></i>
                <span>معلومات الاتصال</span>
            </a>

            <a href="{{ route('admin.settings') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 @if(request()->routeIs('admin.settings.*')) active text-[#D4AF37] bg-[#D4AF37]/10 @else text-gray-300 hover:text-white hover:bg-white/5 @endif">
                <i class="fas fa-cog w-5 text-center text-base"></i>
                <span>الإعدادات العامة</span>
            </a>
        </nav>

        {{-- Footer --}}
        <div class="p-4 border-t border-white/[0.06]">
            <div class="flex items-center gap-3 px-4 py-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#C9A22F] flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-[#D4AF37]/10">
                    {{ substr(Auth::user()->name ?? 'م', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'المدير' }}</p>
                    <p class="text-[11px] text-gray-500">مدير النظام</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-gray-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors" title="تسجيل خروج">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main content wrapper --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Top bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 shadow-sm">
            <div class="flex items-center gap-4">
                <button @@click="mobileSidebar = true" class="text-gray-500 hover:text-gray-700 lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <button @@click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-gray-600 hidden lg:block transition-colors">
                    <i class="fas fa-bars text-sm" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
                <div class="hidden md:flex items-center gap-2 text-sm text-gray-400">
                    <i class="fas fa-home text-[#D4AF37] text-xs"></i>
                    <span>/</span>
                    <span class="text-gray-600 font-medium">@yield('title', 'لوحة التحكم')</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Search --}}
                <div x-data="{ open: false }" class="relative">
                    <button @@click="open = true" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:border-[#D4AF37] transition-all" title="بحث">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                    <div x-show="open" @@click.outside="open = false" x-transition class="fixed inset-0 z-50 flex items-start justify-center pt-24">
                        <div @@click="open = false" class="absolute inset-0 bg-[#0D1B3D]/60 backdrop-blur-sm"></div>
                        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-xl p-6" @@click.stop>
                            <div class="flex items-center gap-3 mb-4">
                                <i class="fas fa-search text-gray-400"></i>
                                <input type="text" x-ref="searchInput" placeholder="ابحث عن خدمات، مشاريع، مواد، مقالات..." class="flex-1 border-0 outline-none text-sm text-gray-700 placeholder-gray-400" autofocus>
                                <button @@click="open = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                            </div>
                            <p class="text-xs text-gray-400">اكتب كلمة مفتاحية للبحث في جميع المحتويات</p>
                        </div>
                    </div>
                </div>

                {{-- Language toggle --}}
                <button x-data="{ ar: true }" @@click="ar = !ar; document.documentElement.dir = ar ? 'rtl' : 'ltr'; document.documentElement.lang = ar ? 'ar' : 'en'" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:border-[#D4AF37] transition-all" title="تغيير اللغة">
                    <span class="text-[11px] font-bold" x-text="ar ? 'AR' : 'EN'">AR</span>
                </button>

                {{-- Dark mode toggle --}}
                <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))" class="w-9 h-9 flex items-center justify-center rounded-lg text-[#D4AF37] hover:text-gold-400 hover:bg-white/5 transition-all" title="الوضع الليلي">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3 px-3 py-1.5 bg-gray-50 rounded-xl">
                    <div class="text-left">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'المدير' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#C9A22F] flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        {{ substr(Auth::user()->name ?? 'م', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6 bg-gray-50">
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
