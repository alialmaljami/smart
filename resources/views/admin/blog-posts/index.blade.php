@extends('layouts.admin')

@section('title', 'المقالات')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">المقالات</h1>
            <p class="text-gray-500 mt-1">إدارة مقالات المدونة</p>
        </div>
        <a href="{{ route('admin.blog-posts.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة مقال جديد
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">العنوان</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الحالة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">تاريخ النشر</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($posts ?? [] as $post)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $post->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $post->title }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $post->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $post->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $post->is_active ? 'منشور' : 'مسودة' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $post->created_at ? $post->created_at->format('Y-m-d') : '--' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.blog-posts.edit', $post) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.blog-posts.toggle-active', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $post->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-green-500 hover:bg-green-50 hover:border-green-200' }} transition-all" title="{{ $post->is_active ? 'إلغاء النشر' : 'نشر' }}">
                                            <i class="fas {{ $post->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
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
                            <td colspan="5" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i class="fas fa-newspaper text-4xl"></i>
                                    <p class="text-sm">لا توجد مقالات مضافة بعد</p>
                                    <a href="{{ route('admin.blog-posts.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول مقال</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($posts) && method_exists($posts, 'links'))
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
