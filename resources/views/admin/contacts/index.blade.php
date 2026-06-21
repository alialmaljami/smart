@extends('layouts.admin')

@section('title', 'معلومات الاتصال')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">معلومات الاتصال</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">إدارة معلومات التواصل وبيانات الاتصال</p>
        </div>
        <a href="{{ route('admin.contacts.create') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-gold-600 hover:bg-gold-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i>
            إضافة
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto admin-table-wrap">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">النوع</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">القيمة</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">التصنيف</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الحالة</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($contacts ?? [] as $contact)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $contact->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @php
                                        $typeIcons = ['email' => 'fas fa-envelope text-blue-500', 'phone' => 'fas fa-phone text-green-500', 'address' => 'fas fa-map-marker-alt text-red-500', 'map_url' => 'fas fa-map text-purple-500'];
                                        $typeLabels = ['email' => 'بريد إلكتروني', 'phone' => 'هاتف', 'address' => 'عنوان', 'map_url' => 'رابط خريطة'];
                                    @endphp
                                    <i class="{{ $typeIcons[$contact->type] ?? 'fas fa-info-circle text-gray-500' }}"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $typeLabels[$contact->type] ?? $contact->type }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $contact->value }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $contact->label ?? '--' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $contact->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $contact->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $contact->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.contacts.edit', $contact) }}" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.contacts.toggle-active', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center {{ $contact->is_active ? 'text-red-500 hover:bg-red-50 hover:border-red-200' : 'text-green-500 hover:bg-green-50 hover:border-green-200' }} transition-all" title="{{ $contact->is_active ? 'إيقاف' : 'تفعيل' }}">
                                            <i class="fas {{ $contact->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف معلومات الاتصال هذه؟')">
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
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i class="fas fa-address-card text-4xl"></i>
                                    <p class="text-sm">لا توجد معلومات اتصال مضافة بعد</p>
                                    <a href="{{ route('admin.contacts.create') }}" class="text-gold-600 hover:text-gold-700 text-sm font-medium">إضافة أول معلومات اتصال</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($contacts) && method_exists($contacts, 'links'))
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
