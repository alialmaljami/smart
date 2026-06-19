@extends('layouts.admin')

@section('title', 'المشاريع')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">المشاريع</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة مشاريع الديكور المنفذة للعملاء</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md shrink-0">
            <i class="fas fa-plus"></i>
            إضافة مشروع جديد
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="service_filter" class="block text-sm font-medium text-gray-700 mb-1.5">تصفية حسب الخدمة</label>
                <select name="service_id" id="service_filter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                    <option value="">جميع الخدمات</option>
                    @foreach($services ?? [] as $svc)
                        <option value="{{ $svc->id }}" {{ request('service_id') == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1.5">تصفية حسب تصنيف المواد</label>
                <select name="material_category_id" id="category_filter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 outline-none text-sm">
                    <option value="">جميع التصنيفات</option>
                    @foreach($materialCategories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ request('material_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
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
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-l from-gray-50 to-white border-b border-gray-200">
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">المشروع</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الخدمات</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">تصنيف المواد</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects ?? [] as $project)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-4 py-3.5 text-sm text-gray-500 font-medium">{{ $project->id }}</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    @php $mainImg = is_array($project->images) ? ($project->images[0] ?? null) : $project->image; @endphp
                                    @if($mainImg)
                                        <img src="{{ asset('storage/' . $mainImg) }}" alt="{{ $project->title }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-briefcase text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate max-w-[200px]">{{ $project->title }}</p>
                                        <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ $project->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-500 max-w-[150px]">
                                <span class="truncate block">{{ $project->services->pluck('name')->implode(', ') ?: '--' }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-500 max-w-[150px]">
                                <span class="truncate block">{{ $project->materialCategories->pluck('name')->implode(', ') ?: '--' }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $project->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $project->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $project->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.toggle-active', $project) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $project->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-200' }} transition-all" title="{{ $project->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $project->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('project.show', $project->slug) }}" target="_blank" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 transition-all" title="عرض">
                                        <i class="fas fa-external-link-alt text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
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
                                        <i class="fas fa-briefcase text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">لا توجد مشاريع مضافة بعد</p>
                                    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-plus"></i>
                                        إضافة أول مشروع
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($projects) && method_exists($projects, 'links'))
            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection