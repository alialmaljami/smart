<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($gallery)) تعديل {{ $config['title_single'] }} @else إضافة {{ $config['title_single'] }} جديدة @endif</h1>
            <p class="text-gray-500 text-sm mt-1">صور قبل وبعد التنفيذ لإظهار جودة العمل</p>
        </div>
        <a href="{{ route($config['route_prefix'] . '.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i> العودة
        </a>
    </div>

    <form action="{{ isset($gallery) ? route($config['route_prefix'] . '.update', [$type, $gallery]) : route($config['route_prefix'] . '.store', $type) }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($gallery)) @method('PUT') @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div>
                    <p class="font-medium mb-1">يوجد أخطاء:</p>
                    <ul class="list-disc mr-5 text-sm space-y-0.5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-not-equal text-gold-600"></i> الصور</h2>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">العنوان <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $gallery->title ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="before_image" class="block text-sm font-medium text-gray-700 mb-1.5">صورة قبل التنفيذ <span class="text-red-500">*</span></label>
                        @if(isset($gallery) && $gallery->before_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ asset('storage/' . $gallery->before_image) }}" class="w-48 h-32 rounded-lg object-cover border-2 border-red-300 shadow-sm">
                                <span class="absolute top-1 right-1 px-1.5 py-0.5 bg-red-500 text-white text-[10px] rounded font-bold">قبل</span>
                            </div>
                        @endif
                        <input type="file" name="before_image" id="before_image" accept="image/*" {{ isset($gallery) ? '' : 'required' }}
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors cursor-pointer">
                    </div>
                    <div>
                        <label for="after_image" class="block text-sm font-medium text-gray-700 mb-1.5">صورة بعد التنفيذ <span class="text-red-500">*</span></label>
                        @if(isset($gallery) && $gallery->after_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ asset('storage/' . $gallery->after_image) }}" class="w-48 h-32 rounded-lg object-cover border-2 border-emerald-300 shadow-sm">
                                <span class="absolute top-1 left-1 px-1.5 py-0.5 bg-emerald-500 text-white text-[10px] rounded font-bold">بعد</span>
                            </div>
                        @endif
                        <input type="file" name="after_image" id="after_image" accept="image/*" {{ isset($gallery) ? '' : 'required' }}
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_comparison" value="1" {{ old('show_comparison', $gallery->show_comparison ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                        <span class="mr-3 text-sm font-medium text-gray-700">إظهار خاصية المقارنة التفاعلية (سحب للمقارنة)</span>
                    </label>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">الوصف</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">{{ old('description', $gallery->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-l from-gray-50 to-white">
                <h2 class="font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-link text-gold-600"></i> الربط</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">التصنيف</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-sm">
                            <option value="">بدون</option>
                            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $gallery->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1.5">الخدمة</label>
                        <select name="service_id" id="service_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-sm">
                            <option value="">بدون</option>
                            @foreach($services as $service)<option value="{{ $service->id }}" {{ old('service_id', $gallery->service_id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1.5">المشروع</label>
                        <select name="project_id" id="project_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-sm">
                            <option value="">بدون</option>
                            @foreach($projects as $project)<option value="{{ $project->id }}" {{ old('project_id', $gallery->project_id ?? '') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="tag_ids" class="block text-sm font-medium text-gray-700 mb-1.5">الوسوم</label>
                    <select name="tag_ids[]" id="tag_ids" multiple
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-sm h-32">
                        @foreach($allTags ?? [] as $t)
                            <option value="{{ $t->id }}"
                                {{ (old('tag_ids') && in_array($t->id, old('tag_ids'))) || (isset($gallery) && $gallery->tagItems->contains($t->id)) ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">اضغط Ctrl (أو Cmd) لاختيار متعدد</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <label class="relative inline-flex items-center cursor-pointer ml-6">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                <span class="mr-3 text-sm font-medium text-gray-700">نشط</span>
            </label>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i> @if(isset($gallery)) حفظ @else إضافة @endif
            </button>
            <a href="{{ route($config['route_prefix'] . '.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">إلغاء</a>
        </div>
    </form>
</div>
