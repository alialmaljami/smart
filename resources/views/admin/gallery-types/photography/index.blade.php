@extends('layouts.admin')

@section('title', $config['label'])

@section('content')
<div class="space-y-6">
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
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة {{ $config['label'] }}</p>
        </div>
        <a href="{{ route($config['route_prefix'] . '.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة {{ $config['title_single'] }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($items->count())
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($items as $item)
                        <div class="group relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-camera text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="absolute bottom-0 right-0 left-0 p-4">
                                    <h3 class="text-white font-bold text-sm truncate">{{ $item->title }}</h3>
                                </div>
                                <div class="absolute top-2 left-2 flex gap-1.5">
                                    <a href="{{ route($config['route_prefix'] . '.edit', $item) }}" class="w-9 h-9 bg-white/95 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 shadow-sm transition-all" title="تعديل">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route($config['route_prefix'] . '.toggle-active', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-9 h-9 bg-white/95 rounded-lg flex items-center justify-center {{ $item->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} shadow-sm transition-all">
                                            <i class="fas {{ $item->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route($config['route_prefix'] . '.destroy', $item) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white/95 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 shadow-sm transition-all">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if(!$item->is_active)
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
                    <i class="fas fa-camera text-4xl"></i>
                    <p class="text-sm">لا توجد صور تصوير بعد</p>
                    <a href="{{ route($config['route_prefix'] . '.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول صورة</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
