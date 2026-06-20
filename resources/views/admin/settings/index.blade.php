@extends('layouts.admin')

@section('title', 'الإعدادات')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">الإعدادات العامة</h1>
        <p class="text-gray-500 text-sm mt-1">إعدادات الموقع الأساسية</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div>
                    <p class="font-medium mb-1">يوجد أخطاء في الإدخال:</p>
                    <ul class="list-disc mr-5 text-sm space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- General settings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-globe text-gold-600"></i>
                    الإعدادات العامة
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1.5">اسم الموقع</label>
                        <input type="text" name="site_name" id="site_name"
                               value="{{ old('site_name', $settings['site_name'] ?? 'ديكورات المصمم الذكي') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف الموقع</label>
                        <input type="text" name="site_description" id="site_description"
                               value="{{ old('site_description', $settings['site_description'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1.5">شعار الموقع</label>
                        <div class="flex items-center gap-4">
                            @if(!empty($settings['logo']))
                                <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" class="h-14 object-contain bg-gray-50 border border-gray-200 rounded-lg p-1">
                            @endif
                            <input type="file" name="logo" id="logo" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                        </div>
                    </div>
                    <div>
                        <label for="favicon" class="block text-sm font-medium text-gray-700 mb-1.5">أيقونة الموقع (Favicon)</label>
                        <div class="flex items-center gap-4">
                            @if(!empty($settings['favicon']))
                                <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="h-10 w-10 object-contain bg-gray-50 border border-gray-200 rounded-lg p-1">
                            @endif
                            <input type="file" name="favicon" id="favicon" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                        </div>
                    </div>
                </div>
                <div>
                    <label for="home_hero_bg" class="block text-sm font-medium text-gray-700 mb-1.5">صورة الخلفية الرئيسية (Hero Background)</label>
                    <div class="flex items-center gap-4">
                        @if(!empty($settings['home_hero_bg']))
                            <img src="{{ asset('storage/' . $settings['home_hero_bg']) }}" alt="Hero Background" class="h-20 w-36 object-cover bg-gray-50 border border-gray-200 rounded-lg">
                        @endif
                        <input type="file" name="home_hero_bg" id="home_hero_bg" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">تستخدم كصورة خلفية للشريط الرئيسي في الصفحة الرئيسية (يمكنك أيضاً تغييرها من أقسام الصفحة الرئيسية)</p>
                </div>
            </div>
        </div>

        {{-- Contact info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-address-card text-gold-600"></i>
                    معلومات الاتصال
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $settings['email'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $settings['phone'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان</label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $settings['address'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="map_url" class="block text-sm font-medium text-gray-700 mb-1.5">رابط الخريطة (Google Maps)</label>
                        <input type="url" name="map_url" id="map_url"
                               value="{{ old('map_url', $settings['map_url'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="https://maps.google.com/...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Social links status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-share-alt text-gold-600"></i>
                    إظهار الروابط الاجتماعية
                </h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-4">يمكنك إدارة الروابط الاجتماعية من <a href="{{ route('admin.social-links.index') }}" class="text-gold-600 hover:text-gold-700 font-medium">صفحة الروابط الاجتماعية</a></p>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="show_social_links" value="1"
                           {{ old('show_social_links', $settings['show_social_links'] ?? true) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                    <span class="mr-3 text-sm font-medium text-gray-700">إظهار الروابط الاجتماعية في الموقع</span>
                </label>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-code-branch text-gold-600"></i>
                    تذييل الموقع (Footer)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="copyright_text" class="block text-sm font-medium text-gray-700 mb-1.5">نص الحقوق المحفوظة</label>
                        <input type="text" name="copyright_text" id="copyright_text"
                               value="{{ old('copyright_text', $settings['copyright_text'] ?? 'جميع الحقوق محفوظة © ' . date('Y') . ' ديكورات المصمم الذكي') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="footer_description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف التذييل</label>
                        <textarea name="footer_description" id="footer_description" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('footer_description', $settings['footer_description'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fab fa-searchengin text-gold-600"></i>
                    بيانات تحسين محركات البحث (SEO)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                {{-- Home --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-home text-gold-600"></i> الصفحة الرئيسية</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="home_meta_title" placeholder="العنوان (Meta Title)"
                               value="{{ old('home_meta_title', $settings['home_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="home_meta_description" placeholder="الوصف (Meta Description)" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('home_meta_description', $settings['home_meta_description'] ?? '') }}</textarea>
                        <input type="text" name="home_meta_keywords" placeholder="الكلمات المفتاحية"
                               value="{{ old('home_meta_keywords', $settings['home_meta_keywords'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                {{-- About --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-info-circle text-gold-600"></i> عن الشركة</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="about_meta_title" placeholder="العنوان"
                               value="{{ old('about_meta_title', $settings['about_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="about_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_meta_description', $settings['about_meta_description'] ?? '') }}</textarea>
                        <input type="text" name="about_meta_keywords" placeholder="الكلمات المفتاحية"
                               value="{{ old('about_meta_keywords', $settings['about_meta_keywords'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                {{-- Contact --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-envelope text-gold-600"></i> اتصل بنا</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="contact_meta_title" placeholder="العنوان"
                               value="{{ old('contact_meta_title', $settings['contact_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="contact_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('contact_meta_description', $settings['contact_meta_description'] ?? '') }}</textarea>
                        <input type="text" name="contact_meta_keywords" placeholder="الكلمات المفتاحية"
                               value="{{ old('contact_meta_keywords', $settings['contact_meta_keywords'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                {{-- FAQ --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-question-circle text-gold-600"></i> الأسئلة الشائعة</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="faq_meta_title" placeholder="العنوان"
                               value="{{ old('faq_meta_title', $settings['faq_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="faq_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('faq_meta_description', $settings['faq_meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Privacy --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-shield-alt text-gold-600"></i> سياسة الخصوصية</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="privacy_meta_title" placeholder="العنوان"
                               value="{{ old('privacy_meta_title', $settings['privacy_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="privacy_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('privacy_meta_description', $settings['privacy_meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-file-contract text-gold-600"></i> الشروط والأحكام</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="terms_meta_title" placeholder="العنوان"
                               value="{{ old('terms_meta_title', $settings['terms_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="terms_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('terms_meta_description', $settings['terms_meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Jeddah --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-city text-gold-600"></i> ديكورات جدة</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="jeddah_meta_title" placeholder="العنوان"
                               value="{{ old('jeddah_meta_title', $settings['jeddah_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="jeddah_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('jeddah_meta_description', $settings['jeddah_meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Mecca --}}
                <div class="border-b border-gray-100 pb-5 mb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fas fa-kaaba text-gold-600"></i> ديكورات مكة</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="mecca_meta_title" placeholder="العنوان"
                               value="{{ old('mecca_meta_title', $settings['mecca_meta_title'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <textarea name="mecca_meta_description" placeholder="الوصف" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('mecca_meta_description', $settings['mecca_meta_description'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Google Search Console / Analytics --}}
                <div class="pb-3">
                    <h3 class="font-semibold text-gray-800 text-sm mb-4 flex items-center gap-2"><i class="fab fa-google text-gold-600"></i> Google Search Console & Analytics</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="google_search_console" placeholder="رمز التحقق من Google Search Console (مثال: abc123def456)"
                               value="{{ old('google_search_console', $settings['google_search_console'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <input type="text" name="google_analytics_id" placeholder="معرف Google Analytics (مثال: G-XXXXXXXXXX)"
                               value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <p class="text-xs text-gray-400">أدخل رمز التحقق من Search Console ومعرف Google Analytics 4 (GA4) لربط الموقع بخدمات Google</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Watermark settings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-watermark text-gold-600"></i>
                    العلامة المائية (Watermark)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="watermark_enabled" value="0">
                        <input type="checkbox" name="watermark_enabled" value="1" {{ old('watermark_enabled', $settings['watermark_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-500"></div>
                    </label>
                    <span class="text-sm text-gray-700">تفعيل العلامة المائية</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">نوع العلامة المائية</label>
                        <select name="watermark_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="text" {{ ($settings['watermark_type'] ?? 'text') == 'text' ? 'selected' : '' }}>نص فقط</option>
                            <option value="logo" {{ ($settings['watermark_type'] ?? '') == 'logo' ? 'selected' : '' }}>شعار فقط</option>
                            <option value="both" {{ ($settings['watermark_type'] ?? '') == 'both' ? 'selected' : '' }}>نص وشعار معاً</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">الشفافية (0-100)</label>
                        <div class="flex items-center gap-3">
                            <input type="range" name="watermark_opacity" min="5" max="100" value="{{ old('watermark_opacity', $settings['watermark_opacity'] ?? '40') }}" class="flex-1 accent-gold-500" oninput="document.getElementById('opacityVal').textContent = this.value">
                            <span id="opacityVal" class="text-sm font-bold text-gold-600 min-w-[3ch]">{{ $settings['watermark_opacity'] ?? '40' }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">الموضع</label>
                        <select name="watermark_position" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="top-left" {{ ($settings['watermark_position'] ?? '') == 'top-left' ? 'selected' : '' }}>أعلى يسار</option>
                            <option value="top-center" {{ ($settings['watermark_position'] ?? '') == 'top-center' ? 'selected' : '' }}>أعلى وسط</option>
                            <option value="top-right" {{ ($settings['watermark_position'] ?? '') == 'top-right' ? 'selected' : '' }}>أعلى يمين</option>
                            <option value="center" {{ ($settings['watermark_position'] ?? '') == 'center' ? 'selected' : '' }}>وسط</option>
                            <option value="bottom-left" {{ ($settings['watermark_position'] ?? '') == 'bottom-left' ? 'selected' : '' }}>أسفل يسار</option>
                            <option value="bottom-center" {{ ($settings['watermark_position'] ?? 'bottom-center') == 'bottom-center' ? 'selected' : '' }}>أسفل وسط</option>
                            <option value="bottom-right" {{ ($settings['watermark_position'] ?? '') == 'bottom-right' ? 'selected' : '' }}>أسفل يمين</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">الحجم</label>
                        <select name="watermark_size" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="small" {{ ($settings['watermark_size'] ?? '') == 'small' ? 'selected' : '' }}>صغير</option>
                            <option value="medium" {{ ($settings['watermark_size'] ?? 'medium') == 'medium' ? 'selected' : '' }}>متوسط</option>
                            <option value="large" {{ ($settings['watermark_size'] ?? '') == 'large' ? 'selected' : '' }}>كبير</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">نص العلامة المائية</label>
                        <input type="text" name="watermark_text" value="{{ old('watermark_text', $settings['watermark_text'] ?? 'ديكورات المصمم الذكي') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">شعار العلامة المائية (PNG)</label>
                        <input type="file" name="watermark_logo" accept="image/png" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100">
                        @if(!empty($settings['watermark_logo']))
                            <p class="text-xs text-gray-400 mt-1">الشعار الحالي: <a href="{{ asset('storage/'.$settings['watermark_logo']) }}" target="_blank" class="text-gold-600 hover:underline">عرض</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-white font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection