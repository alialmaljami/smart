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
<section class="pt-4 pb-4 bg-[var(--cream)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <a href="{{ route('gallery') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Gallery') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            @if($item->category)
                <span class="text-[var(--text-light)] truncate max-w-[80px] sm:max-w-[150px]">{{ $item->category }}</span>
                <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            @endif
            <span class="text-[var(--gold)] font-bold truncate max-w-[100px] sm:max-w-[250px]">{{ $item->title }}</span>
        </nav>
    </div>
</section>

{{-- Image Detail --}}
<section class="py-6 md:py-12 bg-[var(--cream)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <div class="max-w-5xl mx-auto min-w-0 max-w-full">
            {{-- Main Image --}}
            <div class="rounded-2xl overflow-hidden bg-[var(--navy-dark)] mb-6 md:mb-8">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="w-full h-auto max-h-[50vh] sm:max-h-[70vh] md:max-h-[80vh] object-contain" loading="lazy">
            </div>

            {{-- Info --}}
            <div class="max-w-3xl mx-auto text-center min-w-0 max-w-full">
                <h1 class="text-xl sm:text-2xl md:text-4xl font-black text-[var(--text-heading)] mb-3 md:mb-4 break-words">{{ $item->title }}</h1>
                @if($item->description)
                    <p class="text-[var(--text-light)] text-sm sm:text-base md:text-lg leading-relaxed mb-4 md:mb-6 break-words">{{ $item->description }}</p>
                @endif

                @if($item->tags)
                    <div class="flex flex-wrap justify-center gap-1.5 md:gap-2 mb-4 md:mb-6">
                        @foreach(explode(',', $item->tags) as $tag)
                            <a href="{{ route('tag', trim($tag)) }}" class="px-2.5 md:px-3 py-1 rounded-full text-[10px] md:text-xs font-medium bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20 hover:bg-[var(--gold)] hover:text-white transition-colors">{{ trim($tag) }}</a>
                        @endforeach
                    </div>
                @endif

                @if($item->service || $item->project)
                    <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-4 md:mb-6">
                        @if($item->service)
                            <a href="{{ route('service.show', $item->service->slug) }}" class="inline-flex items-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2 rounded-lg bg-[var(--navy)]/5 text-[var(--text-light)] text-[11px] md:text-sm hover:bg-[var(--navy)]/10 transition-colors">
                                <i class="fas fa-tag text-[10px]"></i> {{ $item->service->name }}
                            </a>
                        @endif
                        @if($item->project)
                            <a href="{{ route('project.show', $item->project->slug) }}" class="inline-flex items-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2 rounded-lg bg-[var(--navy)]/5 text-[var(--text-light)] text-[11px] md:text-sm hover:bg-[var(--navy)]/10 transition-colors">
                                <i class="fas fa-folder text-[10px]"></i> {{ $item->project->title }}
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Like Button --}}
                <div x-data="{ liked: {{ $item->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $item->likeCount() }} }" class="mb-6 md:mb-8">
                    <button @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'gallery', id: {{ $item->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })"
                            class="inline-flex items-center gap-1.5 md:gap-2 px-4 md:px-6 py-2 md:py-3 rounded-full border-2 transition-all text-xs md:text-sm"
                            :class="liked ? 'border-red-500 text-red-500 bg-red-50' : 'border-[var(--stone)] text-[var(--text-light)] hover:border-red-300'">
                        <i class="fas fa-heart" :class="liked ? 'fas' : 'far'"></i>
                        <span class="font-bold" x-text="count">0</span>
                    </button>
                </div>

                <a href="{{ route('gallery') }}" class="inline-flex items-center text-[var(--gold)] font-bold hover:gap-2 transition-all text-xs md:text-sm">
                    <i class="fas fa-arrow-right ml-1.5 md:ml-2"></i> {{ __('Back to Gallery') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Related Images --}}
@if($related->count())
    <section class="py-10 md:py-16 bg-[var(--white)] overflow-x-hidden">
        <div class="container mx-auto px-4 max-w-full">
            <div class="text-center mb-6 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Related Images') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                @foreach($related as $rel)
                    <a href="{{ route('gallery.show', [$rel->id, $rel->slug]) }}" class="group relative rounded-xl overflow-hidden h-32 sm:h-40 md:h-48 block w-full">
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->alt_text ?: $rel->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-lg md:text-2xl"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-6 md:py-8 bg-[var(--cream)] border-t border-[var(--stone)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3">
            <span class="text-xs sm:text-base text-[var(--text-light)]">{{ __('Share') }}:</span>
            <div class="flex flex-wrap justify-center gap-2 items-center" dir="ltr">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' ' . request()->url()) }}" target="_blank" class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 shrink-0"><x-icon name="whatsapp" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5" /></a>
                @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
            </div>
        </div>
    </div>
</section>

@endsection