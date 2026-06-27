<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($project)) تعديل مشروع @else إضافة مشروع جديد @endif</h1>
            <p class="text-gray-500 text-sm mt-1">@if(isset($project)) تعديل بيانات المشروع @else إضافة مشروع ديكور جديد @endif</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>

    <form action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if(isset($project))
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

        {{-- Main info card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-info-circle text-gold-600"></i>
                    المعلومات الأساسية
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title', $project->title ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               required>
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط المختصر</label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug', $project->slug ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        @error('slug')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">الوصف</label>
                    <textarea name="description" id="description" rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('description', $project->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">تصنيف المشروع</label>
                        <select name="category_id" id="category_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="">بدون تصنيف</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $project->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">ترتيب العرض</label>
                        <input type="number" name="sort_order" id="sort_order" min="0"
                               value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-1.5">الوسوم (tags)</label>
                        <input type="text" name="tags" id="tags"
                               value="{{ old('tags', isset($project) && is_array($project->tags) ? implode(', ', $project->tags) : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="وسم1, وسم2, وسم3">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="service_ids" class="block text-sm font-medium text-gray-700 mb-1.5">الخدمات</label>
                        <select name="service_ids[]" id="service_ids" multiple
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm h-32">
                            @foreach($services ?? [] as $svc)
                                <option value="{{ $svc->id }}"
                                    {{ (old('service_ids') && in_array($svc->id, old('service_ids'))) || (isset($project) && $project->services->contains($svc->id)) ? 'selected' : '' }}>
                                    {{ $svc->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">اضغط Ctrl (أو Cmd) لاختيار متعدد</p>
                    </div>

                    <div>
                        <label for="material_category_ids" class="block text-sm font-medium text-gray-700 mb-1.5">تصنيفات المواد</label>
                        <select name="material_category_ids[]" id="material_category_ids" multiple
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm h-32">
                            @foreach($materialCategories ?? [] as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ (old('material_category_ids') && in_array($cat->id, old('material_category_ids'))) || (isset($project) && $project->materialCategories->contains($cat->id)) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">اضغط Ctrl (أو Cmd) لاختيار متعدد</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-images text-gold-600"></i>
                    معرض الصور
                </h2>
            </div>
            <div class="p-6 space-y-5">
                {{-- Main image --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">الصورة الرئيسية</label>
                    @if(isset($project) && $project->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-32 h-24 rounded-lg object-cover border border-gray-200 shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                </div>

                {{-- Gallery images --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">صور إضافية للمعرض</label>

                    @if(isset($project) && is_array($project->images) && count($project->images))
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                            @foreach($project->images as $img)
                                <div class="relative group rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-20 object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" class="text-white text-xs bg-red-500 w-6 h-6 rounded-full flex items-center justify-center" onclick="this.closest('div').remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                    <p class="mt-1.5 text-xs text-gray-400">يمكنك اختيار عدة صور دفعة واحدة</p>
                    @error('images.*')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Videos --}}
                <div>
                    <label for="videos" class="block text-sm font-medium text-gray-700 mb-1.5">روابط الفيديو</label>
                    <textarea name="videos" id="videos" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                              placeholder="رابط واحد لكل سطر">{{ old('videos', is_array($project->videos ?? null) ? implode("\n", $project->videos) : ($project->videos ?? '')) }}</textarea>
                    @error('videos')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Settings card --}}
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
                           {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                    <span class="mr-3 text-sm font-medium text-gray-700">الحالة (نشط)</span>
                </label>
            </div>
        </div>

        {{-- SEO card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fab fa-searchengin text-gold-600"></i>
                    بيانات تحسين محركات البحث (SEO)
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">عنوان الصفحة</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $project->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف الصفحة</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('meta_description', $project->meta_description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1.5">الكلمات المفتاحية</label>
                    <input type="text" name="meta_keywords" id="meta_keywords"
                           value="{{ old('meta_keywords', $project->meta_keywords ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                           placeholder="كلمة1, كلمة2, كلمة3">
                </div>
                <div>
                    <label for="canonical_url" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط الأصلي (Canonical URL)</label>
                    <input type="url" name="canonical_url" id="canonical_url"
                           value="{{ old('canonical_url', $project->canonical_url ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                           placeholder="https://example.com/...">
                </div>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_indexed" value="1"
                               {{ old('is_indexed', $project->is_indexed ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                        <span class="mr-3 text-sm font-medium text-gray-700">أرشفة الصفحة في محركات البحث</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                @if(isset($project)) حفظ التغييرات @else إضافة المشروع @endif
            </button>
            <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg text-sm font-medium transition-colors hover:bg-gray-50">
                إلغاء
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('title')?.addEventListener('input', function() {
        const slug = document.getElementById('slug');
        if (slug && !slug.dataset.manuallyEdited) {
            slug.value = this.value.trim().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        }
    });
    document.getElementById('slug')?.addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });
</script>
@endpush