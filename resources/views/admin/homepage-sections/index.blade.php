@extends('layouts.admin')

@section('title', 'محتويات الصفحة الرئيسية')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">محتويات الصفحة الرئيسية</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة أقسام ومحتويات الصفحة الرئيسية</p>
        </div>
        <a href="{{ route('admin.homepage-sections.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md shrink-0">
            <i class="fas fa-plus"></i>
            إضافة قسم جديد
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gradient-to-l from-gray-50 to-white border-b border-gray-200">
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">القسم</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">النوع</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الترتيب</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sections ?? [] as $section)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-4 py-3.5 text-sm text-gray-500 font-medium">{{ $section->id }}</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                    @elseif($section->icon)
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gold-50 to-gold-100 flex items-center justify-center">
                                            <i class="{{ $section->icon }} text-gold-600"></i>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-layer-group text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate max-w-[200px]">{{ $section->title ?? $section->key }}</p>
                                        <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ $section->key }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ $section->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $section->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $section->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $section->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-500">{{ $section->sort_order ?? 0 }}</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.homepage-sections.edit', $section) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>

                                    <form action="{{ route('admin.homepage-sections.toggle-active', $section) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $section->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-200' }} transition-all" title="{{ $section->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $section->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.homepage-sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-layer-group text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">لا توجد أقسام مضافة بعد</p>
                                    <a href="{{ route('admin.homepage-sections.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-plus"></i>
                                        إضافة أول قسم
                                    </a>
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
