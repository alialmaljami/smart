<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">@if(isset($material)) تعديل مادة @else إضافة مادة جديدة @endif</h1>
        <p class="text-gray-500 mt-1">@if(isset($material)) تعديل بيانات المادة @else إضافة مادة ديكور جديدة @endif</p>
    </div>

    <form action="{{ isset($material) ? route('admin.materials.update', $material) : route('admin.materials.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if(isset($material))
            @method('PUT')
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <div>
                    <p class="font-medium">يوجد أخطاء في الإدخال:</p>
                    <ul class="list-disc mr-5 mt-1 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $material->name ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="material_category_id" class="block text-sm font-medium text-gray-700 mb-1">التصنيف <span class="text-red-500">*</span></label>
                <select name="material_category_id" id="material_category_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none text-sm">
                    <option value="">اختر التصنيف</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ old('material_category_id', $material->material_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('material_category_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط المختصر</label>
                <input type="text" name="slug" id="slug"
                       value="{{ old('slug', $material->slug ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm @error('slug') border-red-400 bg-red-50 @enderror"
                       placeholder="auto-generated-slug">
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('description', $material->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">الصورة</label>
                <div class="mt-1 flex items-center gap-4">
                    @if(isset($material) && $material->image)
                        <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="material_images" class="block text-sm font-medium text-gray-700 mb-1">معرض الصور</label>
                <input type="file" name="images[]" id="material_images" multiple accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
                @error('images.*')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">السعر (ريال)</label>
                <input type="number" step="0.01" name="price" id="price"
                       value="{{ old('price', $material->price ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">العلامات (Tags)</label>
                <input type="text" name="tags" id="tags"
                       value="{{ old('tags', isset($material) && is_array($material->tags) ? implode(', ', $material->tags) : ($material->tags ?? '')) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       placeholder="tag1, tag2, tag3">
                @error('tags')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="specifications" class="block text-sm font-medium text-gray-700 mb-1">المواصفات</label>
            <textarea name="specifications" id="specifications" rows="4"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('specifications', $material->specifications ?? '') }}</textarea>
            <p class="text-xs text-gray-400 mt-1">أدخل المواصفات كـ JSON أو نص عادي</p>
            @error('specifications')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $material->is_active ?? true) ? 'checked' : '' }}
                       class="w-5 h-5 text-gold-600 border-gray-300 rounded focus:ring-gold-500">
                <span class="text-sm font-medium text-gray-700">الحالة (نشط)</span>
            </label>
        </div>

        {{-- SEO section --}}
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">بيانات تحسين محركات البحث (SEO)</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">عنوان الصفحة (Meta Title)</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $material->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">وصف الصفحة (Meta Description)</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('meta_description', $material->meta_description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">الكلمات المفتاحية</label>
                    <input type="text" name="meta_keywords" id="meta_keywords"
                           value="{{ old('meta_keywords', $material->meta_keywords ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                           placeholder="كلمة1, كلمة2, كلمة3">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-save ml-1"></i>
                @if(isset($material)) حفظ التغييرات @else إضافة المادة @endif
            </button>
            <a href="{{ route('admin.materials.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
                إلغاء
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('name')?.addEventListener('input', function() {
        const slug = document.getElementById('slug');
        if (slug && !slug.dataset.manuallyEdited) {
            slug.value = this.value
                .trim()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }
    });
    document.getElementById('slug')?.addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });
</script>
@endpush
