<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($neighborhood)) تعديل الحي @else إضافة حي جديد @endif</h1>
            <p class="text-gray-500 text-sm mt-1">صفحة مستقلة لكل حي في مكة وجدة لتحسين SEO</p>
        </div>
        <a href="{{ route('admin.neighborhoods.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i> العودة
        </a>
    </div>

    <form action="{{ isset($neighborhood) ? route('admin.neighborhoods.update', $neighborhood) : route('admin.neighborhoods.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($neighborhood)) @method('PUT') @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-1"><i class="fas fa-exclamation-circle text-red-500"></i><p class="font-medium">يوجد أخطاء:</p></div>
                <ul class="list-disc mr-5 text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-map-marker-alt text-gold-600"></i> معلومات الحي</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">اسم الحي <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $neighborhood->name ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm" required>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">المدينة <span class="text-red-500">*</span></label>
                        <select name="city" id="city" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-sm">
                            <option value="mecca" {{ old('city', $neighborhood->city ?? '') == 'mecca' ? 'selected' : '' }}>مكة المكرمة</option>
                            <option value="jeddah" {{ old('city', $neighborhood->city ?? '') == 'jeddah' ? 'selected' : '' }}>جدة</option>
                        </select>
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط المختصر</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $neighborhood->slug ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm" placeholder="يُملأ تلقائياً">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">الوصف القصير</label>
                    <textarea name="description" id="description" rows="2"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">{{ old('description', $neighborhood->description ?? '') }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">المحتوى التفصيلي</label>
                    <textarea name="content" id="content" rows="6"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">{{ old('content', $neighborhood->content ?? '') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">محتوى HTML عن الحي - خدمات التشطيب والديكور المتوفرة فيه</p>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">صورة الحي</label>
                    @if(isset($neighborhood) && $neighborhood->image)
                        <div class="mb-3"><img src="{{ asset('storage/' . $neighborhood->image) }}" class="w-48 h-28 rounded-lg object-cover border border-gray-200 shadow-sm"></div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-search text-gold-600"></i> SEO</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $neighborhood->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">{{ old('meta_description', $neighborhood->meta_description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $neighborhood->meta_keywords ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm"
                           placeholder="تشطيب, ديكور, حي العزيزية, مكة">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <label class="relative inline-flex items-center cursor-pointer ml-6">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $neighborhood->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600 rounded-full peer"></div>
                <span class="mr-3 text-sm font-medium text-gray-700">نشط</span>
            </label>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i> @if(isset($neighborhood)) حفظ التغييرات @else إضافة @endif
            </button>
            <a href="{{ route('admin.neighborhoods.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">إلغاء</a>
        </div>
    </form>
</div>
