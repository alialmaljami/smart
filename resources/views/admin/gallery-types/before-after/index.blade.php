@extends('layouts.admin')

@section('title', $config['label'])

@section('content')
<div class="space-y-6">
    {{-- Gallery Type Tabs --}}
    @php $galleryTypes = [['route' => 'admin.galleries.index', 'label' => 'الكل', 'icon' => 'fa-th-large'], ['route' => 'admin.videos.index', 'label' => 'الفيديوهات', 'icon' => 'fa-video'], ['route' => 'admin.tours.index', 'label' => 'جولات 360', 'icon' => 'fa-vr-cardboard'], ['route' => 'admin.before-after.index', 'label' => 'قبل وبعد', 'icon' => 'fa-not-equal'], ['route' => 'admin.photography.index', 'label' => 'التصوير', 'icon' => 'fa-camera']]; @endphp
    <div class="bg-gradient-to-l from-[#E07A5F]/10 to-[#D4694C]/5 rounded-xl p-1.5 border border-[#E07A5F]/20 shadow-sm flex flex-wrap gap-1">
        @foreach($galleryTypes as $gt)
            <a href="{{ route($gt['route']) }}"
               class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs($gt['route']) ? 'bg-white text-[#D4694C] shadow-sm ring-1 ring-[#E07A5F]/20' : 'text-gray-600 hover:bg-white/60 hover:text-gray-800' }}">
                <i class="fas {{ $gt['icon'] }} {{ request()->routeIs($gt['route']) ? 'text-[#D4694C]' : 'text-gray-400' }}"></i>
                <span>{{ $gt['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">{{ $config['label'] }}</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">صور قبل وبعد التنفيذ - تظهر مع خاصية المقارنة التفاعلية</p>
        </div>
        <a href="{{ route($config['route_prefix'] . '.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i> إضافة {{ $config['title_single'] }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($items->count())
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($items as $item)
                        <div class="group relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                            <div class="grid grid-cols-2 divide-x divide-gray-300">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $item->before_image) }}" alt="قبل" class="w-full h-40 object-cover">
                                    <span class="absolute top-1 right-1 px-1.5 py-0.5 bg-red-500 text-white text-[10px] rounded font-bold">قبل</span>
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $item->after_image) }}" alt="بعد" class="w-full h-40 object-cover">
                                    <span class="absolute top-1 left-1 px-1.5 py-0.5 bg-emerald-500 text-white text-[10px] rounded font-bold">بعد</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-gray-800 truncate">{{ $item->title }}</h3>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="px-2 py-0.5 text-[10px] rounded-full {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    <div class="flex gap-1">
                                        <a href="{{ route($config['route_prefix'] . '.edit', $item) }}" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all" title="تعديل">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route($config['route_prefix'] . '.toggle-active', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center {{ $item->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} transition-all">
                                                <i class="fas {{ $item->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route($config['route_prefix'] . '.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-red-600 hover:bg-red-50 transition-all">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="px-4 py-12 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <i class="fas fa-not-equal text-4xl"></i>
                    <p class="text-sm">لا توجد صور قبل وبعد</p>
                    <a href="{{ route($config['route_prefix'] . '.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول مجموعة</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
