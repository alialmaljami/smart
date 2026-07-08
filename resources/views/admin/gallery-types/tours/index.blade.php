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
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة جولات 360 للمشاريع</p>
        </div>
        <a href="{{ route($config['route_prefix'] . '.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i> إضافة {{ $config['title_single'] }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($items->count())
            <div class="overflow-x-auto">
                <table class="w-full admin-table">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">العنوان</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الرابط</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الحالة</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($items as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $item->title }}</p>
                                    @if($item->description)
                                        <p class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ $item->tour_url }}" target="_blank" class="text-xs text-blue-600 hover:underline truncate max-w-[200px] inline-block">{{ $item->tour_url }}</a>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route($config['route_prefix'] . '.edit', $item) }}" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all" title="تعديل">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route($config['route_prefix'] . '.toggle-active', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center {{ $item->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} transition-all">
                                                <i class="fas {{ $item->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route($config['route_prefix'] . '.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-red-600 hover:bg-red-50 transition-all">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-4 py-12 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <i class="fas fa-vr-cardboard text-4xl"></i>
                    <p class="text-sm">لا توجد جولات 360 بعد</p>
                    <a href="{{ route($config['route_prefix'] . '.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول جولة</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
