<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($gallery)) تعديل الصورة @else إضافة صورة جديدة @endif</h1>
            <p class="text-gray-500 text-sm mt-1">@if(isset($gallery)) تعديل بيانات الصورة @else إضافة صورة إلى المعرض @endif</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i>
            العودة للمعرض
        </a>
    </div>

    <form action="{{ isset($gallery) ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if(isset($gallery))
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

        {{-- Basic Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-info-circle text-gold-600"></i>
                    معلومات الصورة
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">اسم الصورة <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title', $gallery->title ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               required>
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط المختصر</label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug', $gallery->slug ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               placeholder="اختياري - short-url">
                        @error('slug')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">التصنيف</label>
                        <select name="category_id" id="category_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="">بدون تصنيف</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $gallery->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tag_ids" class="block text-sm font-medium text-gray-700 mb-1.5">الوسوم Tags</label>
                        <select name="tag_ids[]" id="tag_ids" multiple
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm h-32">
                            @foreach($allTags ?? [] as $t)
                                <option value="{{ $t->id }}"
                                    {{ (old('tag_ids') && in_array($t->id, old('tag_ids'))) || (isset($gallery) && $gallery->tagItems->contains($t->id)) ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">اضغط Ctrl (أو Cmd) لاختيار متعدد</p>
                        @error('tag_ids')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-1.5">Alt Text (نص بديل)</label>
                    <input type="text" name="alt_text" id="alt_text"
                           value="{{ old('alt_text', $gallery->alt_text ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    @error('alt_text')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">وصف الصورة</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('description', $gallery->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">الصورة <span class="text-red-500">*</span></label>
                        @if(isset($gallery) && $gallery->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-48 h-36 rounded-lg object-cover border border-gray-200 shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" {{ isset($gallery) ? '' : 'required' }}
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                        @error('image')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">ترتيب العرض</label>
                        <input type="number" name="sort_order" id="sort_order"
                               value="{{ old('sort_order', $gallery->sort_order ?? 0) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        @error('sort_order')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Linking --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-link text-gold-600"></i>
                    الربط
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1.5">الخدمة المرتبطة</label>
                        <select name="service_id" id="service_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="">بدون خدمة</option>
                            @foreach($services ?? [] as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $gallery->service_id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1.5">المشروع المرتبط</label>
                        <select name="project_id" id="project_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                            <option value="">بدون مشروع</option>
                            @foreach($projects ?? [] as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $gallery->project_id ?? '') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-search text-gold-600"></i>
                    تحسين محركات البحث SEO
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $gallery->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                    @error('meta_title')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('meta_description', $gallery->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}
                       class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                <span class="mr-3 text-sm font-medium text-gray-700">الحالة (نشط)</span>
            </label>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                @if(isset($gallery)) حفظ التغييرات @else إضافة @endif
            </button>
            <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg text-sm font-medium transition-colors hover:bg-gray-50">
                إلغاء
            </a>
        </div>
    </form>
</div>
