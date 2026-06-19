@php
    $materials = $category->materials()->where('is_active', true)->get();
    $relatedProjects = $category->relatedProjects()->where('is_active', true)->get();
    $relatedServices = $category->services()->where('is_active', true)->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $category->meta_description ?? $category->description }}">
<meta name="keywords" content="{{ $category->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $category->meta_title ?? $category->name }}">
<meta property="og:description" content="{{ $category->meta_description ?? $category->description }}">
<meta property="og:image" content="{{ asset('storage/' . $category->image) }}">
@endpush

@section('title', ($category->meta_title ?? $category->name) . ' - مواد الديكور - ديكورات المصمم الذكي')

@section('content')

{{-- Breadcrumb --}}
<section class="pt-28 pb-4 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('materials') }}" class="hover:text-[var(--gold)] transition-colors">مواد الديكور</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <span class="text-[var(--gold)] font-bold">{{ $category->name }}</span>
        </nav>
    </div>
</section>

{{-- Hero --}}
<section class="relative py-20 overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div data-aos="fade-left">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-[var(--text-light)] text-lg leading-relaxed">{{ $category->description }}</p>
                @endif
                <a href="{{ route('contact') }}" class="inline-flex items-center btn-primary px-6 py-3 rounded-lg font-bold mt-6">
                    <x-icon name="shopping_cart" class="w-5 h-5 inline-block ml-2 align-middle" /> استفسر عن المواد
                </a>
            </div>
            @if($category->image)
                <div data-aos="fade-right" class="relative">
                    <div class="rounded-2xl overflow-hidden">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-80 object-cover">
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Materials Gallery --}}
@if($materials->count())
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">المواد المتوفرة</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($materials as $material)
                    <div data-aos="fade-up" class="card-elegant">
                        @if($material->image)
                            <div class="relative img-zoom h-48">
                                <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                                <div x-data="{ liked: {{ $material->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $material->likeCount() }} }" class="absolute top-3 left-3 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'material', id: {{ $material->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                    <button class="flex items-center gap-1 px-2.5 py-1 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all text-xs">
                                        <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                        <span x-text="count">0</span>
                                    </button>
                                </div>
                            </div>
                        @elseif(is_array($material->images) && count($material->images))
                            <div class="relative img-zoom h-48">
                                <img src="{{ asset('storage/' . $material->images[0]) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                                <div x-data="{ liked: {{ $material->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $material->likeCount() }} }" class="absolute top-3 left-3 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'material', id: {{ $material->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                    <button class="flex items-center gap-1 px-2.5 py-1 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all text-xs">
                                        <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                        <span x-text="count">0</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="h-48 flex items-center justify-center bg-[var(--stone)]">
                                <x-icon name="image" class="w-12 h-12 text-[var(--text-light)]" />
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-[var(--text-heading)] mb-2">{{ $material->name }}</h3>
                            @if($material->description)
                                <p class="text-[var(--text-light)] text-sm">{{ Str::limit($material->description, 80) }}</p>
                            @endif
                            @if($material->price)
                                <p class="text-[var(--gold)] font-bold mt-2">{{ number_format($material->price, 2) }} ريال</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Related Projects --}}
@if($relatedProjects->count())
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">مشاريع استخدمت هذه المواد</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProjects as $project)
                    @php $img = is_array($project->images) ? ($project->images[0] ?? '') : $project->images; @endphp
                    <div data-aos="fade-up" class="group relative rounded-xl overflow-hidden img-zoom h-64">
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-3 left-3 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1 px-2.5 py-1 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all text-xs">
                                <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <div class="absolute bottom-4 right-4">
                            <h3 class="text-white font-bold text-lg">{{ $project->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 transition-all">
                            <span class="text-white font-bold border-2 border-white px-4 py-2 rounded-lg">عرض المشروع</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Related Services --}}
@if($relatedServices->count())
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">خدمات ذات صلة</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedServices as $service)
                    <div data-aos="fade-up" class="card-elegant p-6">
                        <div class="flex items-center gap-3 mb-3">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-2xl text-[var(--gold)]"></i>
                            @else
                                <x-icon name="star" class="w-8 h-8 text-[var(--gold)]" />
                            @endif
                            <h3 class="font-bold text-[var(--text-heading)]">{{ $service->name }}</h3>
                        </div>
                        <a href="{{ route('service.show', $service->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-bold">
                            اقرأ المزيد <i class="fas fa-arrow-left mr-1"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
<section class="py-8 bg-[var(--cream)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">شارك هذه الفئة:</span>
        <div class="inline-flex space-x-2 space-x-reverse" dir="ltr">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="facebook" class="w-5 h-5" /></a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($category->name) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#000000] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="x_twitter" class="w-5 h-5" /></a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($category->name . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($category->name) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="pinterest" class="w-5 h-5" /></a>
        </div>
    </div>
</section>

@endsection
