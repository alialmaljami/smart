@extends('layouts.admin')

@section('title', 'الرد على السؤال')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.visitor-questions.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">
            <i class="fas fa-arrow-right ml-1"></i>
            العودة إلى الأسئلة
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-2">الرد على السؤال</h1>

        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">السؤال:</p>
            <p class="font-bold text-gray-800">{{ $visitorQuestion->question }}</p>
            @if($visitorQuestion->asked_by)
                <p class="text-xs text-gray-400 mt-1">— {{ $visitorQuestion->asked_by }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-1">{{ $visitorQuestion->created_at->format('Y-m-d H:i') }}</p>
            <a href="{{ route('q.show', $visitorQuestion->slug) }}" target="_blank" class="text-xs text-[#E07A5F] hover:underline mt-2 inline-block">
                <i class="fas fa-external-link-alt ml-1"></i>
                عرض الصفحة العامة
            </a>
        </div>

        <form action="{{ route('admin.visitor-questions.update', $visitorQuestion) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">الإجابة</label>
                <textarea name="answer" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:border-[#E07A5F] focus:ring-1 focus:ring-[#E07A5F] outline-none transition-colors" placeholder="اكتب الإجابة هنا...">{{ old('answer', $visitorQuestion->answer) }}</textarea>
                @error('answer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $visitorQuestion->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-[#E07A5F] focus:ring-[#E07A5F]">
                    <span class="text-sm text-gray-700">نشر السؤال والإجابة على الموقع</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-l from-[#E07A5F] to-[#D4694C] text-white font-bold rounded-lg text-sm hover:shadow-lg transition-all">
                    <i class="fas fa-save ml-2"></i>
                    حفظ الإجابة
                </button>
                <a href="{{ route('admin.visitor-questions.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg text-sm hover:bg-gray-50 transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
