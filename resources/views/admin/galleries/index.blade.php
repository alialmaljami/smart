@extends('layouts.admin')

@section('title', 'معرض الصور')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">معرض الصور</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة صور المعرض</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($galleries->count())
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($galleries as $gallery)
                        <div class="group relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="absolute bottom-0 right-0 left-0 p-4">
                                    <h3 class="text-white font-bold text-sm truncate">{{ $gallery->title }}</h3>
                                    @if($gallery->category)
                                        <span class="text-xs text-gold-400">{{ $gallery->category }}</span>
                                    @endif
                                </div>
                                <div class="absolute top-2 left-2 flex gap-1.5">
                                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="w-9 h-9 bg-white/95 border border-white/50 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 shadow-sm transition-all" title="تعديل">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.galleries.toggle-active', $gallery) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-9 h-9 bg-white/95 border border-white/50 rounded-lg flex items-center justify-center {{ $gallery->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} shadow-sm transition-all" title="{{ $gallery->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $gallery->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white/95 border border-white/50 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 shadow-sm transition-all">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if(!$gallery->is_active)
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">غير نشط</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="px-4 py-12 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <i class="fas fa-images text-4xl"></i>
                    <p class="text-sm">لا توجد صور في المعرض بعد</p>
                    <a href="{{ route('admin.galleries.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول صورة</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection