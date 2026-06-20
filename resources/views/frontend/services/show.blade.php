@php
    $relatedProjects = $service->projects()->where('is_active', true)->get();
    $relatedMaterials = $service->materialCategories()->where('is_active', true)->get();
    $images = is_array($service->images) ? $service->images : [];
    $videos = is_array($service->videos) ? $service->videos : [];
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $service->meta_description ?? $service->description }}">
<meta name="keywords" content="{{ $service->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $service->meta_title ?? $service->name }}">
<meta property="og:description" content="{{ $service->meta_description ?? $service->description }}">
<meta property="og:image" content="{{ $service->image ? asset('storage/' . $service->image) : '' }}">
@endpush

@section('title', ($service->meta_title ?? $service->name) . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Our Services'), 'url' => route('services')],
            ['name' => $service->name, 'url' => route('service.show', $service->slug)],
        ]),
        \App\Services\SchemaService::service([
            'name' => $service->name,
            'description' => $service->meta_description ?? $service->description,
            'url' => route('service.show', $service->slug),
            'image' => $service->image ? asset('storage/' . $service->image) : null,
        ]),
    ]);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-28 pb-4 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--text-light)]">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('services') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Our Services') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <span class="text-[var(--gold)] font-bold">{{ $service->name }}</span>
        </nav>
    </div>
</section>

{{-- Hero --}}
<section class="relative py-20 flex items-center overflow-hidden bg-[var(--navy)]">
    <div class="absolute inset-0 opacity-[0.04]" style="background: radial-gradient(circle at 30% 50%, var(--cream) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--cream) 0%, transparent 50%);"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div data-aos="fade-left">
                <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ $service->name }}</h1>
                <p class="text-[var(--text-light)] text-lg leading-relaxed">{{ $service->description }}</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center btn-primary px-6 py-3 rounded-lg font-bold mt-6">
            <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('Order the service now') }}
        </a>
            </div>
            @if($service->image)
                <div data-aos="fade-right" class="relative">
                    <div class="rounded-2xl overflow-hidden relative">
                        <div x-data="{ liked: {{ $service->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $service->likeCount() }} }" class="absolute top-4 left-4 z-20" @click.prevent="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'service', id: {{ $service->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1.5 px-4 py-2 bg-black/40 backdrop-blur-md rounded-full text-white hover:bg-black/60 transition-all shadow-lg">
                                <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                <span class="text-sm font-medium" x-text="count"></span>
                            </button>
                        </div>
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-80 object-cover" loading="lazy">
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-[var(--gold)] rounded-2xl -z-10"></div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Gallery --}}
@if(count($images))
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Images') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $image)
                    <div data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}" class="img-zoom rounded-xl overflow-hidden h-48">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Videos --}}
@if(count($videos))
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Videos') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videos as $video)
                    <div data-aos="fade-up" class="rounded-xl overflow-hidden">
                        <video controls class="w-full h-64 object-cover">
                            <source src="{{ $video }}" type="video/mp4">
                        </video>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Related Projects --}}
@if($relatedProjects->count())
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Related Projects') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProjects as $project)
                    @php $img = is_array($project->images) ? ($project->images[0] ?? '') : $project->images; @endphp
                    <div data-aos="fade-up" class="group relative rounded-xl overflow-hidden img-zoom h-64">
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div class="absolute bottom-4 right-4">
                            <h3 class="text-white font-bold text-lg">{{ $project->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 transition-all">
                            <span class="text-white font-bold border-2 border-white px-4 py-2 rounded-lg">{{ __('View Project') }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Related Materials --}}
@if($relatedMaterials->count())
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Related Decoration Materials') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedMaterials as $category)
                    <div data-aos="fade-up" class="card-elegant bg-[var(--white)] rounded-xl overflow-hidden">
                        @if($category->image)
                            <div class="img-zoom h-40">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-[var(--text-heading)]">{{ $category->name }}</h3>
                            <a href="{{ route('material.category.show', $category->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-bold mt-2">
                                {{ __('Browse Collection') }} <i class="fas fa-arrow-left mr-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-8 bg-[var(--white)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">{{ __('Share this service:') }}</span>
        <div class="inline-flex space-x-2 space-x-reverse items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($service->name . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($service->name) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="pinterest" class="w-5 h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

@endsection