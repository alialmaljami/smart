@extends('layouts.admin')

@section('title', 'التقييمات')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">التقييمات</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة تقييمات ومراجعات العملاء</p>
        </div>
        <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md shrink-0">
            <i class="fas fa-plus"></i>
            إضافة تقييم جديد
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($reviews ?? [] as $review)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 card-hover">
                <div class="flex items-start gap-4">
                    @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-gold-200 shrink-0">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white font-bold text-xl shrink-0 shadow-sm">
                            {{ mb_substr($review->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h3 class="font-bold text-gray-800 truncate">{{ $review->name }}</h3>
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm {{ $i <= $review->stars ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">{{ $review->text }}</p>
                        @if($review->reply)
                            <div class="mt-2 p-3 bg-blue-50 rounded-lg border-r-2 border-blue-400">
                                <p class="text-xs font-medium text-blue-700 mb-1">رد الإدارة:</p>
                                <p class="text-sm text-blue-600">{{ $review->reply }}</p>
                            </div>
                        @endif
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $review->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $review->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $review->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.reviews.toggle-active', $review) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $review->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-200' }} transition-all" title="{{ $review->is_active ? 'إيقاف' : 'تفعيل' }}">
                                        <i class="fas {{ $review->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-star text-3xl text-gray-300"></i>
                        </div>
                        <p class="text-gray-500 font-medium">لا توجد تقييمات مضافة بعد</p>
                        <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-plus"></i>
                            إضافة أول تقييم
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection