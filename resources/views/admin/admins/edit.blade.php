@extends('layouts.admin')

@section('title', 'تعديل مشرف')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">تعديل بيانات المشرف</h1>
        <p class="text-gray-500 mt-1">تعديل بيانات حساب المشرف</p>
    </div>

    <form action="{{ route('admin.admins.update', $admin) }}" method="POST"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                <ul class="list-disc mr-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm" required>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm" required>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
            <input type="password" name="password" id="password"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none transition-colors text-sm" minlength="8">
            <p class="mt-1 text-xs text-gray-400">اتركه فارغاً إذا لم ترد تغيير كلمة المرور</p>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-save ml-1"></i>
                حفظ التعديلات
            </button>
            <a href="{{ route('admin.admins.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
