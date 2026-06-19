<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">@if(isset($contact)) تعديل معلومات اتصال @else إضافة معلومات اتصال جديدة @endif</h1>
        <p class="text-gray-500 mt-1">@if(isset($contact)) تعديل بيانات الاتصال @else إضافة وسيلة اتصال جديدة @endif</p>
    </div>

    <form action="{{ isset($contact) ? route('admin.contacts.update', $contact) : route('admin.contacts.store') }}"
          method="POST"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if(isset($contact))
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
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">النوع <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none text-sm">
                    <option value="">اختر النوع</option>
                    <option value="email" {{ old('type', $contact->type ?? '') == 'email' ? 'selected' : '' }}>بريد إلكتروني</option>
                    <option value="phone" {{ old('type', $contact->type ?? '') == 'phone' ? 'selected' : '' }}>هاتف</option>
                    <option value="address" {{ old('type', $contact->type ?? '') == 'address' ? 'selected' : '' }}>عنوان</option>
                    <option value="map_url" {{ old('type', $contact->type ?? '') == 'map_url' ? 'selected' : '' }}>رابط خريطة</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="value" class="block text-sm font-medium text-gray-700 mb-1">القيمة <span class="text-red-500">*</span></label>
                <input type="text" name="value" id="value"
                       value="{{ old('value', $contact->value ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       required>
                @error('value')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="label" class="block text-sm font-medium text-gray-700 mb-1">التصنيف</label>
                <input type="text" name="label" id="label"
                       value="{{ old('label', $contact->label ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm"
                       placeholder="مثال: رقم الهاتف الرئيسي">
                @error('label')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end pb-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $contact->is_active ?? true) ? 'checked' : '' }}
                           class="w-5 h-5 text-gold-600 border-gray-300 rounded focus:ring-gold-500">
                    <span class="text-sm font-medium text-gray-700">الحالة (نشط)</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-save ml-1"></i>
                @if(isset($contact)) حفظ التغييرات @else إضافة @endif
            </button>
            <a href="{{ route('admin.contacts.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
                إلغاء
            </a>
        </div>
    </form>
</div>
