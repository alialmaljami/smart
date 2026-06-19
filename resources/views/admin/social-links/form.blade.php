<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">@if(isset($socialLink)) تعديل رابط اجتماعي @else إضافة رابط اجتماعي جديد @endif</h1>
        <p class="text-gray-500 mt-1">@if(isset($socialLink)) تعديل بيانات رابط التواصل @else إضافة رابط منصة تواصل جديدة @endif</p>
    </div>

    <form action="{{ isset($socialLink) ? route('admin.social-links.update', $socialLink) : route('admin.social-links.store') }}"
          method="POST"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if(isset($socialLink))
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
                <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">المنصة <span class="text-red-500">*</span></label>
                <select name="platform" id="platform" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none text-sm">
                    <option value="">اختر المنصة</option>
                    <option value="whatsapp" {{ old('platform', $socialLink->platform ?? '') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="telegram" {{ old('platform', $socialLink->platform ?? '') == 'telegram' ? 'selected' : '' }}>Telegram</option>
                    <option value="instagram" {{ old('platform', $socialLink->platform ?? '') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="tiktok" {{ old('platform', $socialLink->platform ?? '') == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                    <option value="pinterest" {{ old('platform', $socialLink->platform ?? '') == 'pinterest' ? 'selected' : '' }}>Pinterest</option>
                    <option value="google_maps" {{ old('platform', $socialLink->platform ?? '') == 'google_maps' ? 'selected' : '' }}>Google Maps</option>
                    <option value="x_twitter" {{ old('platform', $socialLink->platform ?? '') == 'x_twitter' ? 'selected' : '' }}>X (Twitter)</option>
                    <option value="linkedin" {{ old('platform', $socialLink->platform ?? '') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                    <option value="youtube" {{ old('platform', $socialLink->platform ?? '') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="facebook" {{ old('platform', $socialLink->platform ?? '') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="snapchat" {{ old('platform', $socialLink->platform ?? '') == 'snapchat' ? 'selected' : '' }}>Snapchat</option>
                    <option value="website" {{ old('platform', $socialLink->platform ?? '') == 'website' ? 'selected' : '' }}>Website</option>
                    <option value="email" {{ old('platform', $socialLink->platform ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ old('platform', $socialLink->platform ?? '') == 'phone' ? 'selected' : '' }}>Phone</option>
                </select>
                @error('platform')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 mb-1">الرابط <span class="text-red-500">*</span></label>
                <input type="url" name="url" id="url"
                       value="{{ old('url', $socialLink->url ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       placeholder="https://"
                       required>
                @error('url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">الترتيب</label>
                <input type="number" name="sort_order" id="sort_order"
                       value="{{ old('sort_order', $socialLink->sort_order ?? 0) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm">
                @error('sort_order')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end pb-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $socialLink->is_active ?? true) ? 'checked' : '' }}
                           class="w-5 h-5 text-gold-600 border-gray-300 rounded focus:ring-gold-500">
                    <span class="text-sm font-medium text-gray-700">الحالة (نشط)</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-save ml-1"></i>
                @if(isset($socialLink)) حفظ التغييرات @else إضافة الرابط @endif
            </button>
            <a href="{{ route('admin.social-links.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
                إلغاء
            </a>
        </div>
    </form>
</div>
