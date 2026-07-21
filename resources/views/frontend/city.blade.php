@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $city->meta_description ?? $city->description ?? __('Decoration services in') . ' ' . $city->name }}">
<meta name="keywords" content="{{ $city->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $city->meta_title ?? $city->name . ' - ' . __('Decoration Services') }}">
<meta property="og:description" content="{{ $city->meta_description ?? $city->description ?? __('Decoration services in') . ' ' . $city->name }}">
@if($city->image)
<meta property="og:image" content="{{ asset('storage/' . $city->image) }}">
@endif
@endpush

@section('title', ($city->meta_title ?? $city->name . ' - ' . __('Decoration Services')) . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $schemaItems = [
        \App\Services\SchemaService::breadcrumbList($breadcrumbs),
    ];
    echo \App\Services\SchemaService::renderSchemas($schemaItems);
@endphp
@endpush

@section('content')

<section class="relative pt-24 pb-16 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)] mb-4">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <span class="text-[var(--gold)] font-bold truncate">{{ $city->name }}</span>
        </nav>
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-city text-2xl md:text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Decoration Services in') }} {{ $city->name }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ $city->description ?? __('Best decoration and interior design services in') . ' ' . $city->name }}</p>
        </div>
    </div>
</section>

<section class="py-12 md:py-20 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div data-aos="fade-left">
                <span class="section-label">{{ $city->name }}</span>
                <h2 class="text-2xl md:text-3xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Decoration Services in') }} {{ $city->name }}</h2>
                @if($city->content)
                    <div class="text-[var(--text-light)] leading-relaxed mb-6">{!! $city->content !!}</div>
                @else
                    <p class="text-[var(--text-light)] leading-relaxed mb-6">
                        {{ __('We offer the best decoration and interior design services in') }} {{ $city->name }}.
                        {{ __('Our team of expert designers and engineers specialize in modern and classic decoration trends.') }}
                    </p>
                @endif
                @if($neighborhoods->count())
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-[var(--text-heading)] mb-3">{{ __('Neighborhoods we serve in') }} {{ $city->name }}:</h3>
                    <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                        @foreach($neighborhoods as $n)
                            <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">{{ $n->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="space-y-2 md:space-y-3">
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">{{ __('Home and villa decoration design and execution') }}</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">{{ __('Living room and lounge decoration') }}</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">{{ __('Modern kitchen and bathroom decoration') }}</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">{{ __('Exterior facades and home gardens') }}</span>
                    </div>
                </div>
            </div>
            <div data-aos="fade-right" class="rounded-2xl overflow-hidden h-48 md:h-96 bg-gradient-to-br from-[var(--navy)] to-[var(--navy)] flex items-center justify-center">
                <div class="text-center p-4 md:p-8">
                    <i class="fas fa-city text-3xl md:text-6xl text-[var(--gold)]/30 mb-2 md:mb-4"></i>
                    <p class="text-[var(--text-light)] text-sm md:text-lg">{{ $city->name }} - {{ __('Saudi Arabia') }}</p>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="text-center bg-[var(--white)] rounded-2xl p-5 md:p-10 shadow-sm border border-[var(--stone)]">
            <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-4">{{ __('Get a free consultation in') }} {{ $city->name }}</h3>
            <p class="text-[var(--text-light)] mb-8 max-w-xl mx-auto">{{ __('Contact us today for a free consultation for your project in') }} {{ $city->name }}</p>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>

@if($services->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Services') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($services as $s)
                @php $imgs = array_values(array_filter(array_merge([$s->image], $s->images ?? []))); @endphp
                <a href="{{ route('service.show', $s->slug) }}" class="card-elegant group overflow-hidden rounded-2xl">
                    @if($imgs)
                        @php $pimgs = array_map(fn($i) => asset('storage/' . \App\Services\ImageService::webp('storage/' . $i)), $imgs); @endphp
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($pimgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                     loading="lazy" decoding="async" width="800" height="500">
                            </template>
                        </div>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)] mb-1">{{ $s->name }}</h3>
                        <p class="text-[var(--text-secondary)] text-xs md:text-sm">{{ Str::limit($s->description, 80) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('services') }}" class="btn-outline px-6 py-3">{{ __('All Services') }}</a>
        </div>
    </div>
</section>
@endif

@if($neighborhoods->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Neighborhoods We Serve in') }} {{ $city->name }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
            @foreach($neighborhoods as $n)
                <a href="{{ route('area.show', $n->slug) }}" class="group bg-[var(--navy)]/5 hover:bg-[var(--gold)]/10 rounded-xl p-4 text-center transition-all">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                        <i class="fas fa-map-pin text-[var(--gold)]"></i>
                    </div>
                    <h3 class="font-bold text-sm text-[var(--text-heading)] group-hover:text-[var(--gold)] transition-colors">{{ $n->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($galleries->count())
<section class="py-12 md:py-16 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Gallery') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($galleries as $g)
                <a href="{{ route('gallery.show', [$g->id, $g->slug]) }}" class="group aspect-square overflow-hidden rounded-xl">
                    {!! \App\Services\ImageService::picture($g->image, $g->title, 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700') !!}
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('gallery') }}" class="btn-outline px-6 py-3">{{ __('View Gallery') }}</a>
        </div>
    </div>
</section>
@endif

@if($projects->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Recent Projects') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            @foreach($projects as $p)
                @php $imgs = array_values(array_filter(array_merge([$p->image], $p->images ?? []))); @endphp
                <a href="{{ route('project.show', $p->slug) }}" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        @php $pimgs = array_map(fn($i) => asset('storage/' . \App\Services\ImageService::webp('storage/' . $i)), $imgs); @endphp
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($pimgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                     loading="lazy" decoding="async" width="800" height="500">
                            </template>
                        </div>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)]">{{ $p->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('projects') }}" class="btn-outline px-6 py-3">{{ __('All Projects') }}</a>
        </div>
    </div>
</section>
@endif

<section class="py-12 md:py-16 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="section-title text-[var(--text-heading)] mb-4">{{ __('Our Work in') }} {{ $city->name }}</h2>
            <div class="section-divider mb-8"></div>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>

@endsection
