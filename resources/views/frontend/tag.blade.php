@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Browse all content related to') }} {{ $tag }} - {{ __('Smart Designer Decorations') }}">
<meta name="robots" content="noindex">
@endpush

@section('title', $tag . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative pt-20 pb-12 md:pt-32 md:pb-16 overflow-hidden bg-[var(--navy)]">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 30% 50%, var(--cream) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--cream) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ __('Tag') }}: {{ $tag }}</h1>
            <div class="section-divider"></div>
            <p class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">{{ __('All content related to') }} <strong class="text-[var(--gold)]">"{{ $tag }}"</strong></p>
        </div>
    </div>
</section>

{{-- Results --}}
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        @php $hasResults = $services->count() || $projects->count() || $posts->count() || $galleries->count() || $materials->count(); @endphp

        @if($hasResults)
            {{-- Services --}}
            @if($services->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Services') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $item)
                            <div data-aos="fade-up" class="card-elegant group">
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->name }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('service.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Service') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Projects --}}
            @if($projects->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Projects') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $item)
                            @php $img = is_array($item->images) ? ($item->images[0] ?? '') : $item->image; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($img)
                                    <div class="img-zoom h-48">
                                        <img src="{{ \App\Services\ImageService::asset($img) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('project.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Project') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Blog Posts --}}
            @if($posts->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Articles') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($posts as $item)
                            @php $bImg = is_array($item->images) ? ($item->images[0] ?? '') : $item->image; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($bImg)
                                    <div class="img-zoom h-48">
                                        <img src="{{ \App\Services\ImageService::asset($bImg) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                    <a href="{{ route('blog.post', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('Read Article') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Gallery --}}
            @if($galleries->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Gallery') }}</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($galleries as $item)
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                <div class="img-zoom aspect-square">
                                    <img src="{{ \App\Services\ImageService::asset($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-bold text-[var(--text-heading)]">{{ $item->title }}</h3>
                                    <a href="{{ route('gallery.show', ['id' => $item->id, 'slug' => $item->slug]) }}" class="text-xs text-[var(--gold)] font-semibold hover:underline">{{ __('View') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Materials --}}
            @if($materials->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Materials') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($materials as $item)
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($item->image)
                                    <div class="img-zoom h-48">
                                        <img src="{{ \App\Services\ImageService::asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->name }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('material.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Material') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)]/50 flex items-center justify-center">
                    <i class="fas fa-tag text-3xl text-[var(--text-muted)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-2">{{ __('No results found') }}</h3>
                <p class="text-[var(--text-light)] max-w-md mx-auto">{{ __('No content related to') }} "{{ $tag }}"</p>
                <a href="{{ route('home') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 mt-6 rounded-xl font-bold">{{ __('Back to Home') }}</a>
            </div>
        @endif
    </div>
</section>

@endsection
