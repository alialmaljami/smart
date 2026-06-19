@extends('layouts.admin')

@section('title', 'صفحة عن الشركة')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">صفحة عن الشركة</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة محتوى صفحة "عن الشركة"</p>
        </div>
    </div>

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

        {{-- Hero Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-header text-gold-600"></i>
                    القسم الرئيسي (Hero)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="about_title" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان الرئيسي</label>
                        <input type="text" name="about_title" id="about_title"
                               value="{{ old('about_title', $settings['about_title'] ?? 'عن الشركة') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_subtitle" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان الفرعي</label>
                        <input type="text" name="about_subtitle" id="about_subtitle"
                               value="{{ old('about_subtitle', $settings['about_subtitle'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>
                <div>
                    <label for="about_description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف القسم الرئيسي</label>
                    <textarea name="about_description" id="about_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Company Story --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-book-open text-gold-600"></i>
                    قصة الشركة
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="about_story_1" class="block text-sm font-medium text-gray-700 mb-1.5">الفقرة الأولى</label>
                    <textarea name="about_story_1" id="about_story_1" rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_story_1', $settings['about_story_1'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_story_2" class="block text-sm font-medium text-gray-700 mb-1.5">الفقرة الثانية</label>
                    <textarea name="about_story_2" id="about_story_2" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_story_2', $settings['about_story_2'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_story_3" class="block text-sm font-medium text-gray-700 mb-1.5">الفقرة الثالثة</label>
                    <textarea name="about_story_3" id="about_story_3" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_story_3', $settings['about_story_3'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_image" class="block text-sm font-medium text-gray-700 mb-1.5">صورة القصة</label>
                    <div class="flex items-center gap-4">
                        @if(!empty($settings['about_image']))
                            <img src="{{ asset('storage/' . $settings['about_image']) }}" alt="About" class="h-24 w-36 object-cover bg-gray-50 border border-gray-200 rounded-lg">
                        @endif
                        <input type="file" name="about_image" id="about_image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        {{-- Vision, Mission, Values --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-bullseye text-gold-600"></i>
                    الرؤية والرسالة والقيم
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="about_vision_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان الرؤية</label>
                        <input type="text" name="about_vision_title" id="about_vision_title"
                               value="{{ old('about_vision_title', $settings['about_vision_title'] ?? 'رؤيتنا') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_vision_text" class="block text-sm font-medium text-gray-700 mt-3 mb-1.5">نص الرؤية</label>
                        <textarea name="about_vision_text" id="about_vision_text" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_vision_text', $settings['about_vision_text'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="about_mission_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان الرسالة</label>
                        <input type="text" name="about_mission_title" id="about_mission_title"
                               value="{{ old('about_mission_title', $settings['about_mission_title'] ?? 'رسالتنا') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_mission_text" class="block text-sm font-medium text-gray-700 mt-3 mb-1.5">نص الرسالة</label>
                        <textarea name="about_mission_text" id="about_mission_text" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_mission_text', $settings['about_mission_text'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="about_values_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان القيم</label>
                        <input type="text" name="about_values_title" id="about_values_title"
                               value="{{ old('about_values_title', $settings['about_values_title'] ?? 'قيمنا') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_values_text" class="block text-sm font-medium text-gray-700 mt-3 mb-1.5">نص القيم</label>
                        <textarea name="about_values_text" id="about_values_text" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_values_text', $settings['about_values_text'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-gold-600"></i>
                    الإحصائيات
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    <div>
                        <label for="about_stat_years" class="block text-sm font-medium text-gray-700 mb-1.5">عدد سنوات الخبرة</label>
                        <input type="text" name="about_stat_years" id="about_stat_years"
                               value="{{ old('about_stat_years', $settings['about_stat_years'] ?? '10+') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_stat_years_label" class="block text-sm font-medium text-gray-700 mt-2 mb-1.5">التسمية</label>
                        <input type="text" name="about_stat_years_label" id="about_stat_years_label"
                               value="{{ old('about_stat_years_label', $settings['about_stat_years_label'] ?? 'سنوات خبرة') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_stat_projects" class="block text-sm font-medium text-gray-700 mb-1.5">عدد المشاريع</label>
                        <input type="text" name="about_stat_projects" id="about_stat_projects"
                               value="{{ old('about_stat_projects', $settings['about_stat_projects'] ?? '100+') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_stat_projects_label" class="block text-sm font-medium text-gray-700 mt-2 mb-1.5">التسمية</label>
                        <input type="text" name="about_stat_projects_label" id="about_stat_projects_label"
                               value="{{ old('about_stat_projects_label', $settings['about_stat_projects_label'] ?? 'مشروع مكتمل') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_stat_clients" class="block text-sm font-medium text-gray-700 mb-1.5">عدد العملاء</label>
                        <input type="text" name="about_stat_clients" id="about_stat_clients"
                               value="{{ old('about_stat_clients', $settings['about_stat_clients'] ?? '50+') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_stat_clients_label" class="block text-sm font-medium text-gray-700 mt-2 mb-1.5">التسمية</label>
                        <input type="text" name="about_stat_clients_label" id="about_stat_clients_label"
                               value="{{ old('about_stat_clients_label', $settings['about_stat_clients_label'] ?? 'عميل سعيد') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_stat_awards" class="block text-sm font-medium text-gray-700 mb-1.5">عدد الجوائز</label>
                        <input type="text" name="about_stat_awards" id="about_stat_awards"
                               value="{{ old('about_stat_awards', $settings['about_stat_awards'] ?? '20+') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        <label for="about_stat_awards_label" class="block text-sm font-medium text-gray-700 mt-2 mb-1.5">التسمية</label>
                        <input type="text" name="about_stat_awards_label" id="about_stat_awards_label"
                               value="{{ old('about_stat_awards_label', $settings['about_stat_awards_label'] ?? 'جائزة وتكريم') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-hand-pointer text-gold-600"></i>
                    قسم الدعوة للإجراء (CTA)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="about_cta_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان CTA</label>
                        <input type="text" name="about_cta_title" id="about_cta_title"
                               value="{{ old('about_cta_title', $settings['about_cta_title'] ?? 'هل أنت مستعد للبدء؟') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_cta_text" class="block text-sm font-medium text-gray-700 mb-1.5">نص CTA</label>
                        <input type="text" name="about_cta_text" id="about_cta_text"
                               value="{{ old('about_cta_text', $settings['about_cta_text'] ?? 'دعنا نحول مساحتك إلى تحفة فنية') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="about_cta_button" class="block text-sm font-medium text-gray-700 mb-1.5">نص الزر</label>
                        <input type="text" name="about_cta_button" id="about_cta_button"
                               value="{{ old('about_cta_button', $settings['about_cta_button'] ?? 'تواصل معنا اليوم') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fab fa-searchengin text-gold-600"></i>
                    تحسين محركات البحث (SEO)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="about_meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان SEO</label>
                    <input type="text" name="about_meta_title" id="about_meta_title"
                           value="{{ old('about_meta_title', $settings['about_meta_title'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                </div>
                <div>
                    <label for="about_meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف SEO</label>
                    <textarea name="about_meta_description" id="about_meta_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('about_meta_description', $settings['about_meta_description'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_meta_keywords" class="block text-sm font-medium text-gray-700 mb-1.5">الكلمات المفتاحية</label>
                    <input type="text" name="about_meta_keywords" id="about_meta_keywords"
                           value="{{ old('about_meta_keywords', $settings['about_meta_keywords'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                           placeholder="كلمة1, كلمة2, كلمة3">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-white font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
