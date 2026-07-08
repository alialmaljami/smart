<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($tag)) تعديل وسم @else إضافة وسم جديد @endif</h1>
            <p class="text-gray-500 text-sm mt-1">@if(isset($tag)) تعديل بيانات الوسم @else أضف وسماً جديداً @endif</p>
        </div>
        <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>

    <form action="{{ isset($tag) ? route('admin.tags.update', $tag) : route('admin.tags.store') }}"
          method="POST"
          class="space-y-6">
        @csrf
        @if(isset($tag))
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
                    <i class="fas fa-tag text-gold-600"></i>
                    معلومات الوسم
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">الاسم <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $tag->name ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">الرابط المختصر</label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug', $tag->slug ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm">
                        @error('slug')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                @if(isset($tag)) حفظ التغييرات @else إضافة الوسم @endif
            </button>
            <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg text-sm font-medium transition-colors hover:bg-gray-50">
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
            slug.value = this.value.trim().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        }
    });
    document.getElementById('slug')?.addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });
</script>
@endpush
