<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@if(isset($review)) تعديل تقييم @else إضافة تقييم جديد @endif</h1>
            <p class="text-gray-500 text-sm mt-1">@if(isset($review)) تعديل بيانات التقييم @else إضافة تقييم عميل جديد @endif</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>

    <form action="{{ isset($review) ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if(isset($review))
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
                    <i class="fas fa-star text-gold-600"></i>
                    بيانات التقييم
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">الاسم <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $review->name ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                               required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stars" class="block text-sm font-medium text-gray-700 mb-1.5">عدد النجوم <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-3">
                            <select name="stars" id="stars"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('stars', $review->stars ?? 5) == $i ? 'selected' : '' }}>{{ $i }} نجم{{ $i > 1 ? 'ة' : '' }}</option>
                                @endfor
                            </select>
                            <div class="flex items-center gap-0.5 text-xl shrink-0" id="starsPreview">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= (old('stars', $review->stars ?? 5)) ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @error('stars')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="text" class="block text-sm font-medium text-gray-700 mb-1.5">نص التقييم <span class="text-red-500">*</span></label>
                    <textarea name="text" id="text" rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none transition-all duration-200 text-sm"
                              required>{{ old('text', $review->text ?? '') }}</textarea>
                    @error('text')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">صورة العميل</label>
                    @if(isset($review) && $review->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gold-200 shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors cursor-pointer">
                </div>

                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $review->is_active ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gold-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                        <span class="mr-3 text-sm font-medium text-gray-700">الحالة (نشط)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-save"></i>
                @if(isset($review)) حفظ التغييرات @else إضافة التقييم @endif
            </button>
            <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg text-sm font-medium transition-colors hover:bg-gray-50">
                إلغاء
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('stars')?.addEventListener('change', function() {
        const preview = document.getElementById('starsPreview');
        const val = parseInt(this.value);
        preview.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('i');
            star.className = 'fas fa-star ' + (i <= val ? 'text-amber-400' : 'text-gray-200');
            preview.appendChild(star);
        }
    });
</script>
@endpush