@extends('layouts.admin')

@section('title', 'إدارة الوسوم - لوحة التحكم')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">إدارة الوسوم</h1>
            <p class="text-gray-500 text-sm mt-1">إدارة الوسوم المستخدمة في الموقع (Tags)</p>
        </div>
        <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-gray-900 font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fas fa-plus"></i>
            إضافة وسم جديد
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-l from-gray-50 to-white border-b border-gray-200">
                        <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">الوسم</th>
                        <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">الرابط المختصر</th>
                        <th class="text-center px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">عدد الاستخدامات</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tags as $tag)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-800">{{ $tag->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $tag->slug }}</code>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($usages[$tag->id] ?? 0) > 0 ? 'bg-gold-50 text-gold-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $usages[$tag->id] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.tags.edit', $tag) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-edit"></i>
                                        تعديل
                                    </a>
                                    <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الوسم؟')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                            <i class="fas fa-trash"></i>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-tag text-4xl text-gray-300"></i>
                                    <p class="text-gray-500 text-sm">لا توجد وسوم بعد</p>
                                    <a href="{{ route('admin.tags.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول وسم</a>
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
