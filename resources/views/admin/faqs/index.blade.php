@extends('layouts.admin')

@section('title', 'الأسئلة الشائعة')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">الأسئلة الشائعة</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة الأسئلة الشائعة FAQ</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md shrink-0">
            <i class="fas fa-plus"></i>
            إضافة سؤال جديد
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($faqs->count())
            <div class="divide-y divide-gray-100">
                @foreach($faqs as $faq)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gold-100 text-gold-700">{{ $faq->category ?: 'عام' }}</span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $faq->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $faq->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ $faq->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-1">{{ $faq->question }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $faq->answer }}</p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.faqs.toggle-active', $faq) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $faq->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-200' }} transition-all" title="{{ $faq->is_active ? 'إيقاف' : 'تفعيل' }}">
                                        <i class="fas {{ $faq->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السؤال؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-4 py-12 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <i class="fas fa-question-circle text-4xl"></i>
                    <p class="text-sm">لا توجد أسئلة شائعة مضافة بعد</p>
                    <a href="{{ route('admin.faqs.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول سؤال</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
