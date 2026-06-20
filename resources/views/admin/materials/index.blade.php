@extends('layouts.admin')

@section('title', 'المواد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">المواد</h1>
            <p class="text-gray-500 mt-1">إدارة مواد الديكور والبناء</p>
        </div>
        <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة مادة جديدة
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">تصفية حسب التصنيف</label>
                <select name="category_id" id="category_filter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500 outline-none text-sm"
                        onchange="this.form.submit()">
                    <option value="">جميع التصنيفات</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-filter ml-1"></i>
                تصفية
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الاسم</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">التصنيف</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الصورة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">السعر</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الحالة</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($materials ?? [] as $material)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $material->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $material->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $material->category->name ?? '--' }}</td>
                            <td class="px-4 py-3">
                                @if($material->image)
                                    <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $material->price ? number_format($material->price, 2) . ' ر.س' : '--' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $material->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $material->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $material->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.materials.edit', $material) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.materials.toggle-active', $material) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $material->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-green-500 hover:bg-green-50 hover:border-green-200' }} transition-all" title="{{ $material->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $material->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه المادة؟')">
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
                                    <i class="fas fa-cubes text-4xl"></i>
                                    <p class="text-sm">لا توجد مواد مضافة بعد</p>
                                    <a href="{{ route('admin.materials.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول مادة</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($materials) && method_exists($materials, 'links'))
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $materials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
