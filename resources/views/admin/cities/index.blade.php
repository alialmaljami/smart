@extends('layouts.admin')

@section('title', 'المدن')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">المدن</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة صفحات المدن - صفحة مستقلة لكل مدينة</p>
        </div>
        <a href="{{ route('admin.cities.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i> إضافة مدينة
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($cities->count())
            <div class="overflow-x-auto">
                <table class="w-full admin-table">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الاسم</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الرابط</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الوصف</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500">الحالة</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($cities as $city)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $city->name }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-400">/decorations/{{ $city->slug }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $city->description }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $city->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $city->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.cities.edit', $city) }}" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all" title="تعديل">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.cities.toggle-active', $city) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="admin-action-btn w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center {{ $city->is_active ? 'text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }} transition-all">
                                                <i class="fas {{ $city->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.cities.destroy', $city) }}" method="POST" class="inline" onsubmit="return confirm('حذف {{ $city->name }}؟')">
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
                    <i class="fas fa-city text-4xl"></i>
                    <p class="text-sm">لا توجد مدن بعد. قم بإضافة مدينة جديدة</p>
                    <a href="{{ route('admin.cities.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة مدينة</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
