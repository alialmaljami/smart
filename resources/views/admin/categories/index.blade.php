@extends('layouts.admin')

@section('title', 'التصنيفات')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">التصنيفات</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة تصنيفات المشاريع ومعرض الصور ومواد الديكور</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة
        </a>
    </div>

    {{-- Filter tabs --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1 flex gap-1">
        <a href="{{ route('admin.categories.index') }}"
           class="flex-1 py-2.5 text-center rounded-lg text-sm font-medium transition-all {{ !request('type') ? 'bg-gold-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
            الكل
        </a>
        @foreach($types as $key => $label)
            <a href="{{ route('admin.categories.index', ['type' => $key]) }}"
               class="flex-1 py-2.5 text-center rounded-lg text-sm font-medium transition-all {{ request('type') == $key ? 'bg-gold-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto admin-table-wrap">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الاسم</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">النوع</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الصورة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الحالة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الترتيب</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $category->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $category->name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $category->type == 'project' ? 'bg-blue-100 text-blue-700' : ($category->type == 'gallery' ? 'bg-purple-100 text-purple-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $types[$category->type] ?? $category->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $category->sort_order ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.toggle-active', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $category->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-green-500 hover:bg-green-50 hover:border-green-200' }} transition-all" title="{{ $category->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $category->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i class="fas fa-layer-group text-4xl"></i>
                                    <p class="text-sm">لا توجد تصنيفات بعد</p>
                                    <a href="{{ route('admin.categories.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول تصنيف</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection