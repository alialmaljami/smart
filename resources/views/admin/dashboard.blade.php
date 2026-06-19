@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">لوحة التحكم</h1>
            <p class="text-gray-500 text-sm mt-1">نظرة عامة على نظام إدارة ديكورات المصمم الذكي</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-xl shadow-sm border border-gray-200 text-sm text-gray-500">
            <i class="far fa-calendar-alt text-gold-600"></i>
            <span>{{ now()->locale('ar')->translatedFormat('l d F Y') }}</span>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-gold-200/50">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <i class="fas fa-concierge-bell text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">إجمالي</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $servicesCount ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">الخدمات</p>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-gold-200/50">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-layer-group text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">إجمالي</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $categoriesCount ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">تصنيفات المواد</p>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-gold-200/50">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i class="fas fa-cubes text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">إجمالي</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $materialsCount ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">المواد</p>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-gold-200/50">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <i class="fas fa-briefcase text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">إجمالي</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $projectsCount ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">المشاريع</p>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-gold-200/50">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-lg shadow-rose-500/20">
                    <i class="fas fa-newspaper text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">إجمالي</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $blogPostsCount ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">المقالات</p>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-500 to-gold-700 flex items-center justify-center shadow-lg shadow-gold-500/10">
                <i class="fas fa-bolt text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">إجراءات سريعة</h2>
                <p class="text-sm text-gray-500">أكثر الإجراءات شيوعاً</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-white font-bold rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                <x-icon name="plus" class="w-4 h-4" />
                خدمة جديدة
            </a>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white rounded-lg text-sm font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                <x-icon name="plus" class="w-4 h-4" />
                تصنيف جديد
            </a>
            <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white rounded-lg text-sm font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                <x-icon name="plus" class="w-4 h-4" />
                مادة جديدة
            </a>
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-purple-600 to-purple-500 hover:from-purple-500 hover:to-purple-400 text-white rounded-lg text-sm font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                <x-icon name="plus" class="w-4 h-4" />
                مشروع جديد
            </a>
            <a href="{{ route('admin.blog-posts.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-l from-rose-600 to-rose-500 hover:from-rose-500 hover:to-rose-400 text-white rounded-lg text-sm font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                <x-icon name="plus" class="w-4 h-4" />
                مقال جديد
            </a>
        </div>
    </div>

    {{-- Recent items grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent services --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-concierge-bell text-white text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">أحدث الخدمات</h3>
                </div>
                <a href="{{ route('admin.services.index') }}" class="text-sm text-gold-600 hover:text-gold-700 font-medium transition-colors">عرض الكل <i class="fas fa-arrow-left mr-1 text-xs"></i></a>
            </div>
            <div class="space-y-1">
                @forelse($recentServices ?? [] as $service)
                    <div class="flex items-center justify-between py-2.5 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-sm"></i>
                                </div>
                            @endif
                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ $service->name }}</span>
                                <p class="text-xs text-gray-400">ترتيب: {{ $service->sort_order ?? 0 }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $service->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $service->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-concierge-bell text-3xl text-gray-200 mb-2"></i>
                        <p class="text-sm text-gray-400">لا توجد خدمات مضافة بعد</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent projects --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">أحدث المشاريع</h3>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-gold-600 hover:text-gold-700 font-medium transition-colors">عرض الكل <i class="fas fa-arrow-left mr-1 text-xs"></i></a>
            </div>
            <div class="space-y-1">
                @forelse($recentProjects ?? [] as $project)
                    <div class="flex items-center justify-between py-2.5 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                                <i class="fas fa-briefcase text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ $project->title }}</span>
                                <p class="text-xs text-gray-400">{{ $project->client_name ? "عميل: $project->client_name" : '' }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $project->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $project->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-briefcase text-3xl text-gray-200 mb-2"></i>
                        <p class="text-sm text-gray-400">لا توجد مشاريع مضافة بعد</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent blog posts --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">أحدث المقالات</h3>
                </div>
                <a href="{{ route('admin.blog-posts.index') }}" class="text-sm text-gold-600 hover:text-gold-700 font-medium transition-colors">عرض الكل <i class="fas fa-arrow-left mr-1 text-xs"></i></a>
            </div>
            <div class="space-y-1">
                @forelse($recentPosts ?? [] as $post)
                    <div class="flex items-center justify-between py-2.5 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center">
                                <i class="fas fa-newspaper text-rose-600 text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-sm font-medium text-gray-700 block truncate max-w-[200px]">{{ $post->title }}</span>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $post->created_at ? $post->created_at->format('Y-m-d') : '' }}</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-3xl text-gray-200 mb-2"></i>
                        <p class="text-sm text-gray-400">لا توجد مقالات مضافة بعد</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent contacts --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-envelope text-white text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">آخر رسائل الاتصال</h3>
                </div>
                <a href="{{ route('admin.contacts.index') }}" class="text-sm text-gold-600 hover:text-gold-700 font-medium transition-colors">عرض الكل <i class="fas fa-arrow-left mr-1 text-xs"></i></a>
            </div>
            <div class="space-y-1">
                @forelse($recentContacts ?? [] as $contact)
                    <div class="flex items-center justify-between py-2.5 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center">
                                <i class="fas fa-envelope text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $contact->value }}</p>
                                <p class="text-xs text-gray-400">{{ $contact->type }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $contact->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $contact->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-envelope text-3xl text-gray-200 mb-2"></i>
                        <p class="text-sm text-gray-400">لا توجد بيانات اتصال مضافة بعد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection