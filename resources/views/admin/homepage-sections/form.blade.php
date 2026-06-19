<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($homepageSection)) تعديل القسم @else إضافة قسم جديد @endif</h1>
            <p class="text-gray-500 text-sm mt-1">@if(isset($homepageSection)) تعديل بيانات القسم @else إضافة قسم جديد للصفحة الرئيسية @endif</p>
        </div>
        <a href="{{ route('admin.homepage-sections.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>

    <form action="{{ isset($homepageSection) ? route('admin.homepage-sections.update', $homepageSection) : route('admin.homepage-sections.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if(isset($homepageSection))
            @method('PUT')
        @endif

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

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-info-circle text-gold-600"></i>
                    المعلومات الأساسية
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-1.5">المفتاح (Key) <span class="text-red-500">*</span></label>
                        <input type="text" name="key" id="key"
                               value="{{ old('key', $homepageSection->key ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm @error('key') border-red-400 bg-red-50 @enderror"
                               required>
                        @error('key')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">النوع <span class="text-red-500">*</span></label>
                        <select name="type" id="type"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm @error('type') border-red-400 bg-red-50 @enderror"
                                required>
                            <option value="hero" {{ old('type', $homepageSection->type ?? '') == 'hero' ? 'selected' : '' }}>Hero (الشريط الرئيسي)</option>
                            <option value="section_header" {{ old('type', $homepageSection->type ?? '') == 'section_header' ? 'selected' : '' }}>Section Header (عنوان قسم)</option>
                            <option value="why_us" {{ old('type', $homepageSection->type ?? '') == 'why_us' ? 'selected' : '' }}>Why Us (لماذا نحن)</option>
                            <option value="stats" {{ old('type', $homepageSection->type ?? '') == 'stats' ? 'selected' : '' }}>Stats (الإحصائيات)</option>
                            <option value="cta" {{ old('type', $homepageSection->type ?? '') == 'cta' ? 'selected' : '' }}>CTA (دعوة للإجراء)</option>
                            <option value="text" {{ old('type', $homepageSection->type ?? '') == 'text' ? 'selected' : '' }}>Text (نص)</option>
                        </select>
                        @error('type')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">ترتيب العرض</label>
                        <input type="number" name="sort_order" id="sort_order"
                               value="{{ old('sort_order', $homepageSection->sort_order ?? 0) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان</label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title', $homepageSection->title ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان الفرعي</label>
                        <input type="text" name="subtitle" id="subtitle"
                               value="{{ old('subtitle', $homepageSection->subtitle ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">المحتوى</label>
                    <textarea name="content" id="content" rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('content', $homepageSection->content ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-image text-gold-600"></i>
                    الوسائط والأيقونات
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">الصورة</label>
                        @if(isset($homepageSection) && $homepageSection->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $homepageSection->image) }}" alt="{{ $homepageSection->title }}" class="w-24 h-24 rounded-lg object-cover border border-gray-200 shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1.5">أيقونة (Font Awesome)</label>
                        <input type="text" name="icon" id="icon"
                               value="{{ old('icon', $homepageSection->icon ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="مثال: fas fa-star">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-link text-gold-600"></i>
                    الأزرار والروابط
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1.5">نص الزر الأول</label>
                        <input type="text" name="button_text" id="button_text"
                               value="{{ old('button_text', $homepageSection->button_text ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="button_url" class="block text-sm font-medium text-gray-700 mb-1.5">رابط الزر الأول</label>
                        <input type="text" name="button_url" id="button_url"
                               value="{{ old('button_url', $homepageSection->button_url ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="/services">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="button_text_2" class="block text-sm font-medium text-gray-700 mb-1.5">نص الزر الثاني</label>
                        <input type="text" name="button_text_2" id="button_text_2"
                               value="{{ old('button_text_2', $homepageSection->button_text_2 ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="button_url_2" class="block text-sm font-medium text-gray-700 mb-1.5">رابط الزر الثاني</label>
                        <input type="text" name="button_url_2" id="button_url_2"
                               value="{{ old('button_url_2', $homepageSection->button_url_2 ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="/contact">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-gold-600"></i>
                    الإعدادات
                </h2>
            </div>
            <div class="p-6">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $homepageSection->is_active ?? true) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                    <span class="mr-3 text-sm font-medium text-gray-700">القسم نشط</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                @if(isset($homepageSection)) حفظ التغييرات @else إضافة القسم @endif
            </button>
            <a href="{{ route('admin.homepage-sections.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg text-sm font-medium transition-colors hover:bg-gray-50">
                إلغاء
            </a>
        </div>
    </form>
</div>
