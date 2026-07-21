@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $neighborhood->meta_description ?? $neighborhood->description }}">
<meta name="keywords" content="{{ $neighborhood->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $neighborhood->meta_title ?? $neighborhood->name . ' - ' . __('Decoration Services') }}">
<meta property="og:description" content="{{ $neighborhood->meta_description ?? $neighborhood->description }}">
@if($neighborhood->image)
    <meta property="og:image" content="{{ asset('storage/' . $neighborhood->image) }}">
@endif
@endpush

@section('title', ($neighborhood->meta_title ?? $neighborhood->name . ' - ' . __('Decoration Services')) . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $schemaItems = [
        \App\Services\SchemaService::breadcrumbList($breadcrumbs),
    ];
    echo \App\Services\SchemaService::renderSchemas($schemaItems);
@endphp
@endpush

@section('content')

<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)] mb-4">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <a href="{{ route('areas.we.serve') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Areas We Serve') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <span class="text-[var(--gold)] font-bold truncate">{{ $neighborhood->name }}</span>
        </nav>
        <div data-aos="fade-up" class="text-center">
            <span class="section-label">{{ $neighborhood->city_name }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ $neighborhood->name }}</h1>
            @if($neighborhood->description)
                <p class="text-[var(--text-light)] max-w-2xl mx-auto text-lg">{{ $neighborhood->description }}</p>
            @endif
        </div>
    </div>
</section>

@if($neighborhood->image)
    <section class="py-8 md:py-12 bg-[var(--navy)]">
        <div class="container mx-auto px-4">
            <div class="rounded-2xl overflow-hidden max-w-4xl mx-auto">
                {!! \App\Services\ImageService::picture($neighborhood->image, $neighborhood->name, 'w-full h-64 md:h-96 object-cover') !!}
            </div>
        </div>
    </section>
@endif

@if($neighborhood->content)
    <section class="py-8 md:py-12 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto prose prose-lg prose-gold">
                {!! $neighborhood->content !!}
            </div>
        </div>
    </section>
@endif

{{-- Services --}}
@if($services->count())
    <section class="py-10 md:py-16 bg-[var(--navy)]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Our Services in') }} {{ $neighborhood->name }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @foreach($services as $service)
                    <div class="bg-[var(--navy-dark)] border border-[var(--stone)] rounded-2xl p-4 md:p-6 text-center hover:border-[var(--gold)] transition-all">
                        <h3 class="font-bold text-[var(--text-heading)] text-sm md:text-lg mb-2">{{ $service->name }}</h3>
                        <a href="{{ route('service.show', $service->slug) }}" class="text-[var(--gold)] text-xs md:text-sm font-bold">{{ __('Read More') }} <i class="fas fa-arrow-left mr-1"></i></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Projects --}}
@if($projects->count())
    <section class="py-10 md:py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Our Projects in') }} {{ $neighborhood->name }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($projects as $project)
                    @php $pImg = is_array($project->images) ? ($project->images[0] ?? $project->image) : $project->image; @endphp
                    <div class="group relative rounded-2xl overflow-hidden h-52 md:h-64">
                        {!! \App\Services\ImageService::picture($pImg, $project->title, 'w-full h-full object-cover') !!}
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div class="absolute bottom-2 sm:bottom-4 right-2 sm:right-4 left-2 sm:left-4">
                            <h3 class="text-white font-bold text-sm md:text-lg break-words">{{ $project->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 rounded-2xl">
                            <span class="text-white font-bold border-2 border-white px-4 py-2 rounded-lg text-sm">{{ __('View Project') }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- CTA --}}
<section class="py-10 md:py-16 bg-[var(--gold)]">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-xl md:text-4xl font-black text-white mb-3 md:mb-4">{{ __('Decoration Services in') }} {{ $neighborhood->name }}</h2>
        <p class="text-white/80 text-sm md:text-lg mb-6 md:mb-8">{{ __('Contact us for a free consultation') }}</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 md:px-8 py-2.5 md:py-3 rounded-lg font-bold bg-white text-[var(--gold)] hover:bg-white/90 transition-all text-sm md:text-base">
            <i class="fas fa-phone ml-2"></i> {{ __('Contact us') }}
        </a>
    </div>
</section>

@endsection
