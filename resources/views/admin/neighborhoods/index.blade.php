@extends('layouts.admin')

@section('title', 'الأحياء')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">الأحياء</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة أحياء مكة وجدة - صفحة مستقلة لكل حي</p>
        </div>
        <a href="{{ route('admin.neighborhoods.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i> إضافة حي
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($neighborhoods->count())
            <div class="overflow-x-auto">
                <table class="w-full admin-table">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الاسم</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">المدينة</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الوصف</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الحالة</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($neighborhoods as $nb)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $nb->name }}</p>
                                    <span class="text-[10px] text-gray-400">/area/{{ $nb->slug }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $nb->city === 'mecca' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $nb->city_name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $nb->description }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $nb->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $nb->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.neighborhoods.edit', $nb) }}" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all" title="تعديل">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.neighborhoods.toggle-active', $nb) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center {{ $nb->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} transition-all">
                                                <i class="fas {{ $nb->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.neighborhoods.destroy', $nb) }}" method="POST" class="inline" onsubmit="return confirm('حذف {{ $nb->name }}؟')">
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
                    <i class="fas fa-map-marker-alt text-4xl"></i>
                    <p class="text-sm">لا توجد أحياء بعد. أشغل migrate-features.php لإضافة الأحياء الافتراضية</p>
                    <a href="{{ route('admin.neighborhoods.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة حي</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
