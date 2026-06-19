@extends('layouts.admin')

@section('title', 'الروابط الاجتماعية')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">الروابط الاجتماعية</h1>
            <p class="text-gray-500 mt-1">إدارة روابط منصات التواصل الاجتماعي</p>
        </div>
        <a href="{{ route('admin.social-links.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-sm font-medium transition-colors">
            <x-icon name="plus" class="w-4 h-4" />
            إضافة رابط جديد
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">المنصة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الرابط</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الحالة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الترتيب</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($socialLinks ?? [] as $link)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $link->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @php
                                        $adminColors = ['whatsapp' => 'text-green-500', 'telegram' => 'text-blue-500', 'instagram' => 'text-pink-500', 'tiktok' => 'text-gray-900', 'pinterest' => 'text-red-500', 'google_maps' => 'text-blue-600', 'x_twitter' => 'text-gray-900', 'linkedin' => 'text-blue-700', 'youtube' => 'text-red-600', 'facebook' => 'text-blue-600', 'snapchat' => 'text-yellow-500', 'website' => 'text-gold-600', 'email' => 'text-red-500', 'phone' => 'text-green-500'];
                                        $iconColor = $adminColors[$link->platform] ?? 'text-gray-500';
                                    @endphp
                                    <x-icon :name="$link->platform" class="w-5 h-5 {{ $iconColor }}" />
                                    <span class="text-sm font-medium text-gray-800">{{ $link->platform_name ?? $link->platform }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 max-w-[200px] truncate">
                                <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $link->url }}</a>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $link->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $link->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $link->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $link->sort_order ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.social-links.edit', $link) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <x-icon name="edit" class="w-4 h-4" />
                                    </a>

                                    <form action="{{ route('admin.social-links.toggle-active', $link) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $link->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-green-500 hover:bg-green-50 hover:border-green-200' }} transition-all" title="{{ $link->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <x-icon :name="$link->is_active ? 'toggle_on' : 'toggle_off'" class="w-4 h-4" />
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الرابط؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                            <x-icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <x-icon name="share_alt" class="w-10 h-10" />
                                    <p class="text-sm">لا توجد روابط اجتماعية مضافة بعد</p>
                                    <a href="{{ route('admin.social-links.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول رابط</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($socialLinks) && method_exists($socialLinks, 'links'))
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $socialLinks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
