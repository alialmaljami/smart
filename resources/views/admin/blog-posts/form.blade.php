<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">@if(isset($post)) تعديل مقال @else إضافة مقال جديد @endif</h1>
        <p class="text-gray-500 mt-1">@if(isset($post)) قم بتعديل بيانات المقال @else قم بإضافة مقال جديد للمدونة @endif</p>
    </div>

    <form action="{{ isset($post) ? route('admin.blog-posts.update', $post) : route('admin.blog-posts.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <div>
                    <p class="font-medium">هناك أخطاء في الحقول:</p>
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
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">العنوان <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $post->title ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">الرابط المختصر (Slug)</label>
                <input type="text" name="slug" id="slug"
                       value="{{ old('slug', $post->slug ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">المحتوى</label>
            <textarea name="content" id="content" rows="12"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('content', $post->content ?? '') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">المقتطف (Excerpt)</label>
            <textarea name="excerpt" id="excerpt" rows="3"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
            @error('excerpt')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="blog_category_id" class="block text-sm font-medium text-gray-700 mb-1">التصنيف</label>
                <select name="blog_category_id" id="blog_category_id"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                    <option value="">بدون تصنيف</option>
                    @foreach($blogCategories as $cat)
                        <option value="{{ $cat->id }}" {{ old('blog_category_id', $post->blog_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('blog_category_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">الصورة</label>
                <div class="mt-1 flex items-center gap-4">
                    @if(isset($post) && $post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">الكلمات المفتاحية (Tags)</label>
                <input type="text" name="tags" id="tags"
                       value="{{ old('tags', $post->tags ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       placeholder="tag1, tag2, tag3">
                @error('tags')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Gallery images --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">صور إضافية للمعرض</label>

            @if(isset($post) && is_array($post->images) && count($post->images))
                <div class="grid grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                    @foreach($post->images as $img)
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
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
            <p class="mt-1.5 text-xs text-gray-400">يمكنك اختيار عدة صور دفعة واحدة</p>
            @error('images.*')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $post->is_active ?? true) ? 'checked' : '' }}
                       class="w-5 h-5 text-gold-600 border-gray-300 rounded focus:ring-gold-500">
                <span class="text-sm font-medium text-gray-700">منشور (نعم)</span>
            </label>
        </div>

        {{-- SEO section --}}
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">إعدادات تحسين محركات البحث (SEO)</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">عنوان ميتا (Meta Title)</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $post->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">وصف ميتا (Meta Description)</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">الكلمات المفتاحية</label>
                    <input type="text" name="meta_keywords" id="meta_keywords"
                           value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                           placeholder="كلمة1, كلمة2, كلمة3">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-save ml-1"></i>
                @if(isset($post)) حفظ التعديلات @else نشر المقال @endif
            </button>
            <a href="{{ route('admin.blog-posts.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
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
