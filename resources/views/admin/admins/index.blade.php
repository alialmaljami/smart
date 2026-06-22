@extends('layouts.admin')

@section('title', 'المشرفون')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">المشرفون</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة حسابات المشرفين</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة مشرف
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto admin-table-wrap">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الاسم</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">البريد</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الصلاحية</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($admins ?? [] as $admin)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $admin->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $admin->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $admin->email }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $admin->is_super_admin ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $admin->is_super_admin ? 'مدير النظام' : 'مشرف' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if(!$admin->is_super_admin || $admin->id === auth()->id())
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(!$admin->is_super_admin && $admin->id !== auth()->id())
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشرف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i class="fas fa-users-cog text-4xl"></i>
                                    <p class="text-sm">لا يوجد مشرفون</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($admins) && method_exists($admins, 'links'))
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
