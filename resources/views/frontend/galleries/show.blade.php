@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $item->meta_description ?: ($item->description ?? $item->title) }}">
@if($item->meta_title)
    <meta name="title" content="{{ $item->meta_title }}">
@endif
<meta property="og:title" content="{{ $item->meta_title ?: $item->title }}">
<meta property="og:description" content="{{ $item->meta_description ?: ($item->description ?? '') }}">
<meta property="og:image" content="{{ asset('storage/' . $item->image) }}">
<meta property="og:type" content="article">
@endpush

@section('title', ($item->meta_title ?: $item->title) . ' - ' . __('Gallery') . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $schemaItems = [
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Gallery'), 'url' => route('gallery')],
            ['name' => $item->title, 'url' => route('gallery.show', [$item->id, $item->slug])],
        ]),
    ];
    if ($item->image) {
        $schemaItems[] = \App\Services\SchemaService::imageObject(asset('storage/' . $item->image), $item->alt_text ?? $item->title);
    }
    echo \App\Services\SchemaService::renderSchemas($schemaItems);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('gallery') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Gallery') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            @if($item->category)
                <span class="text-[var(--text-light)]">{{ $item->category }}</span>
                <i class="fas fa-chevron-left text-xs"></i>
            @endif
            <span class="text-[var(--gold)] font-bold">{{ $item->title }}</span>
        </nav>
    </div>
</section>

{{-- Image Detail --}}
<section class="py-12 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            {{-- Main Image --}}
            <div data-aos="zoom-in" class="rounded-2xl overflow-hidden card-elegant mb-8">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="w-full h-auto max-h-[80vh] object-contain bg-[var(--navy)]" loading="lazy">
            </div>

            {{-- Info --}}
            <div data-aos="fade-up" class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-black text-[var(--text-heading)] mb-4">{{ $item->title }}</h1>
                @if($item->description)
                    <p class="text-[var(--text-light)] text-lg leading-relaxed mb-6">{{ $item->description }}</p>
                @endif

                @if($item->tags)
                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                        @foreach(explode(',', $item->tags) as $tag)
                            <a href="{{ route('tag', trim($tag)) }}" class="px-3 py-1 rounded-full text-xs font-medium bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20 hover:bg-[var(--gold)] hover:text-white transition-colors">{{ trim($tag) }}</a>
                        @endforeach
                    </div>
                @endif

                @if($item->service || $item->project)
                    <div class="flex flex-wrap justify-center gap-4 mb-6">
                        @if($item->service)
                            <a href="{{ route('service.show', $item->service->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[var(--navy)]/5 text-[var(--text-light)] text-sm hover:bg-[var(--navy)]/10 transition-colors">
                                <i class="fas fa-tag text-xs"></i> {{ $item->service->name }}
                            </a>
                        @endif
                        @if($item->project)
                            <a href="{{ route('project.show', $item->project->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[var(--navy)]/5 text-[var(--text-light)] text-sm hover:bg-[var(--navy)]/10 transition-colors">
                                <i class="fas fa-folder text-xs"></i> {{ $item->project->title }}
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Like Button --}}
                <div x-data="{ liked: {{ $item->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $item->likeCount() }} }" class="mb-8">
                    <button @@click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'gallery', id: {{ $item->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
                            :class="liked ? 'border-red-500 text-red-500 bg-red-50' : 'border-[var(--stone)] text-[var(--text-light)] hover:border-red-300'">
                        <i class="fas fa-heart" :class="liked ? 'fas' : 'far'"></i>
                        <span class="font-bold" x-text="count">0</span>
                    </button>
                </div>

                <a href="{{ route('gallery') }}" class="inline-flex items-center text-[var(--gold)] font-bold hover:gap-2 transition-all">
                    <i class="fas fa-arrow-right ml-2"></i> {{ __('Back to Gallery') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Related Images --}}
@if($related->count())
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--gold)]">{{ __('Related Images') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($related as $rel)
                    <a href="{{ route('gallery.show', [$rel->id, $rel->slug]) }}" data-aos="zoom-in" class="group relative rounded-xl overflow-hidden img-zoom h-48 block">
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->alt_text ?: $rel->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-2xl"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-8 bg-[var(--cream)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">{{ __('Share') }}:</span>
        <div class="inline-flex space-x-2 space-x-reverse items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

@endsection