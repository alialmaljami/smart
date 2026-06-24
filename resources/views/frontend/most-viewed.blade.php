@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Most Viewed') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('Most Viewed') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Most popular content on our site') }}">
@endpush

@section('title', __('Most Viewed') . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $items = [];
    foreach ([['label' => __('Home'), 'url' => route('home')], ['label' => __('Most Viewed'), 'url' => route('most-viewed')]] as $b) {
        $items[] = ['name' => $b['label'], 'url' => $b['url']];
    }
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($items),
    ]);
@endphp
@endpush

@section('content')
<section class="relative py-16 md:py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="overlay-gradient"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl sm:text-4xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Most Viewed') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-muted)] text-lg max-w-2xl mx-auto">{{ __('Most popular content on our site') }}</p>
    </div>
</section>

@if($projects->count())
<section class="py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ __('Most Viewed Projects') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                @php $imgs = array_values(array_filter(array_merge([$project->image], $project->images ?? []))); @endphp
                <a href="{{ route('project.show', $project->slug) }}" data-aos="fade-up" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-[var(--text-heading)] mb-2">{{ $project->title }}</h3>
                        <span class="text-xs text-[var(--text-muted)]"><i class="fas fa-eye ml-1"></i> {{ number_format($project->views) }} {{ __('views') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-10">
            <a href="{{ route('projects') }}" class="btn-outline px-6 py-3">عرض جميع المشاريع</a>
        </div>
    </div>
</section>
@endif

@if($posts->count())
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ __('Most Read Articles') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                @php $imgs = array_values(array_filter(array_merge([$post->image], $post->images ?? []))); @endphp
                <a href="{{ route('blog.post', $post->slug) }}" data-aos="fade-up" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-[var(--text-heading)] mb-2">{{ $post->title }}</h3>
                        <span class="text-xs text-[var(--text-muted)]"><i class="fas fa-eye ml-1"></i> {{ number_format($post->views) }} {{ __('views') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-10">
            <a href="{{ route('blog') }}" class="btn-outline px-6 py-3">عرض جميع المقالات</a>
        </div>
    </div>
</section>
@endif

@if($services->count())
<section class="py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ __('Most Popular Services') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                @php $imgs = array_values(array_filter(array_merge([$service->image], $service->images ?? []))); @endphp
                <a href="{{ route('service.show', $service->slug) }}" data-aos="fade-up" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-[var(--text-heading)] mb-2">{{ $service->name }}</h3>
                        <span class="text-xs text-[var(--text-muted)]"><i class="fas fa-eye ml-1"></i> {{ number_format($service->views) }} {{ __('views') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-10">
            <a href="{{ route('services') }}" class="btn-outline px-6 py-3">عرض جميع الخدمات</a>
        </div>
    </div>
</section>
@endif

@if($galleries->count())
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ __('Most Viewed Gallery') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $gallery)
                <a href="{{ route('gallery.show', [$gallery->id, $gallery->slug]) }}" data-aos="fade-up" class="card-elegant group overflow-hidden">
                    @if($gallery->image)
                        <div class="aspect-square">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->alt_text ?? $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                    @endif
                    <div class="p-3">
                        <h4 class="text-sm font-bold text-[var(--text-heading)] truncate">{{ $gallery->title }}</h4>
                        <span class="text-xs text-[var(--text-muted)]"><i class="fas fa-eye ml-1"></i> {{ number_format($gallery->views) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-10">
            <a href="{{ route('gallery') }}" class="btn-outline px-6 py-3">عرض المعرض</a>
        </div>
    </div>
</section>
@endif

@if($materials->count())
<section class="py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ __('Most Viewed Materials') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($materials as $material)
                @php $imgs = array_values(array_filter(array_merge([$material->image], $material->images ?? []))); @endphp
                <a href="{{ route('material.show', $material->slug) }}" data-aos="fade-up" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-[var(--text-heading)] mb-2">{{ $material->name }}</h3>
                        <span class="text-xs text-[var(--text-muted)]"><i class="fas fa-eye ml-1"></i> {{ number_format($material->views) }} {{ __('views') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-10">
            <a href="{{ route('materials') }}" class="btn-outline px-6 py-3">عرض جميع المواد</a>
        </div>
    </div>
</section>
@endif
@endsection
