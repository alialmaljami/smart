@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $item->meta_description ?: ($item->description ?? $item->title) }}">
@if($item->meta_title)
    <meta name="title" content="{{ $item->meta_title }}">
@endif
<meta property="og:title" content="{{ $item->meta_title ?: $item->title }}">
<meta property="og:description" content="{{ $item->meta_description ?: ($item->description ?? '') }}">
<meta property="og:image" content="{{ $item->getDisplayImage() ? asset('storage/' . $item->getDisplayImage()) : '' }}">
<meta property="og:type" content="article">
@endpush

@section('title', ($item->meta_title ?: $item->title) . ' - ' . __('Gallery') . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $schemaItems = [
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Gallery'), 'url' => route('gallery')],
            ['name' => $item->title, 'url' => route('gallery.show', [$item->id, $item->slug])],
        ]),
    ];
    if ($displayImg = $item->getDisplayImage()) {
        $schemaItems[] = \App\Services\SchemaService::imageObject(asset('storage/' . $displayImg), $item->alt_text ?? $item->title);
    }
    echo \App\Services\SchemaService::renderSchemas($schemaItems);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <a href="{{ route('gallery') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Gallery') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            @if($item->type !== 'image')
                <a href="{{ $item->isVideo() ? route('gallery.videos') : ($item->isTour() ? route('gallery.tours') : ($item->isBeforeAfter() ? route('gallery.before-after') : route('gallery.photography'))) }}"
                   class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">
                    {{ $item->isVideo() ? __('Videos') : ($item->isTour() ? __('360 Tours') : ($item->isBeforeAfter() ? __('Before & After') : __('Photography'))) }}
                </a>
                <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            @endif
            @if($item->category)
                <span class="text-[var(--text-light)] truncate max-w-[80px] sm:max-w-[150px]">{{ $item->category }}</span>
                <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            @endif
            <span class="text-[var(--gold)] font-bold truncate max-w-[100px] sm:max-w-[250px]">{{ $item->title }}</span>
        </nav>
    </div>
</section>

{{-- Image Detail --}}
<section class="py-6 md:py-12 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <div class="max-w-5xl mx-auto min-w-0 max-w-full">
            {{-- Main Image --}}
            <div class="rounded-2xl overflow-hidden bg-[var(--navy-dark)] mb-6 md:mb-8 relative">
                @if($item->isBeforeAfter())
                    @if($item->show_comparison)
                        <div x-data="{ pos: 50 }" class="relative select-none">
                            {!! \App\Services\ImageService::picture($item->after_image, $item->title . ' - ' . __('After'), 'w-full h-64 sm:h-96 md:h-[70vh] object-cover') !!}
                            <div class="absolute inset-0 overflow-hidden" :style="'clip-path: inset(0 ' + (100 - pos) + '% 0 0)'">
                                {!! \App\Services\ImageService::picture($item->before_image, $item->title . ' - ' . __('Before'), 'w-full h-64 sm:h-96 md:h-[70vh] object-cover') !!}
                            </div>
                            <input type="range" min="0" max="100" x-model="pos" class="absolute bottom-4 left-4 right-4 z-10 w-[calc(100%-2rem)] accent-[var(--gold)]">
                        </div>
                    @else
                        <div class="grid grid-cols-2">
                            <div class="relative">
                                <span class="absolute top-3 right-3 bg-black/60 text-white text-xs px-2 py-0.5 rounded z-10">{{ __('Before') }}</span>
                                {!! \App\Services\ImageService::picture($item->before_image, $item->title . ' - ' . __('Before'), 'w-full h-64 sm:h-96 md:h-[70vh] object-cover') !!}
                            </div>
                            <div class="relative">
                                <span class="absolute top-3 right-3 bg-[var(--gold)]/80 text-white text-xs px-2 py-0.5 rounded z-10">{{ __('After') }}</span>
                                {!! \App\Services\ImageService::picture($item->after_image, $item->title . ' - ' . __('After'), 'w-full h-64 sm:h-96 md:h-[70vh] object-cover') !!}
                            </div>
                        </div>
                    @endif
                @elseif($item->isVideo() && $item->getVideoEmbedUrl())
                    <div class="aspect-video relative">
                        @include('partials.video-embed', ['url' => $item->getVideoEmbedUrl()])
                    </div>
                @elseif($item->isTour() && $item->tour_url)
                    @include('partials.tour-embed', ['url' => $item->tour_url, 'title' => $item->title, 'image' => $item->getDisplayImage()])
                @else
                    {!! \App\Services\ImageService::picture($item->getDisplayImage(), $item->alt_text ?: $item->title, 'w-full h-auto max-h-[50vh] sm:max-h-[70vh] md:max-h-[80vh] object-contain') !!}
                @endif
                <button type="button" @click.stop="toggleFavorite('gallery', {{ $item->id }})"
                        :class="isFavorite('gallery', {{ $item->id }}) ? 'text-red-400' : 'text-white'"
                        class="absolute top-3 left-3 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                        title="{{ __('Add to Favorites') }}">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('gallery', {{ $item->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
            </div>

            {{-- Info --}}
            <div class="max-w-3xl mx-auto text-center min-w-0 max-w-full">
                <h1 class="text-xl sm:text-2xl md:text-4xl font-black text-[var(--text-heading)] mb-3 md:mb-4 break-words">{{ $item->title }}</h1>
                @if($item->description)
                    <p class="text-[var(--text-light)] text-sm sm:text-base md:text-lg leading-relaxed mb-4 md:mb-6 break-words">{{ $item->description }}</p>
                @endif

                @php
                    $galleryTags = [];
                    foreach ($item->tagItems as $t) {
                        $galleryTags[] = ['name' => $t->name, 'slug' => $t->slug, 'isMaster' => true];
                    }
                    if (is_array($item->tags)) {
                        foreach ($item->tags as $tag) {
                            foreach (explode('،', $tag) as $part) {
                                foreach (explode(',', $part) as $p) {
                                    $trimmed = trim($p);
                                    if ($trimmed !== '') $galleryTags[] = ['name' => $trimmed, 'slug' => null, 'isMaster' => false];
                                }
                            }
                        }
                    }
                    $galleryTags = collect($galleryTags)->unique('name')->all();
                @endphp
                @if(count($galleryTags))
                    <div class="flex flex-wrap justify-center gap-1.5 md:gap-2 mb-4 md:mb-6">
                        @foreach($galleryTags as $tag)
                            <a href="{{ $tag['isMaster'] ? route('tag.slug', $tag['slug']) : route('tag', urlencode($tag['name'])) }}" class="px-2.5 md:px-3 py-1 rounded-full text-[10px] md:text-xs font-medium {{ $tag['isMaster'] ? 'bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20' : 'bg-[var(--stone)] text-[var(--text-light)] border border-[var(--stone)]/50' }} hover:bg-[var(--gold)] hover:text-white transition-colors">{{ $tag['name'] }}</a>
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
                        <svg class="w-4 h-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
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
                        {!! \App\Services\ImageService::picture($rel->getDisplayImage(), $rel->alt_text ?: $rel->title, 'w-full h-full object-cover') !!}
                        <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
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
<section class="py-6 md:py-8 bg-[var(--navy)] border-t border-[var(--stone)] overflow-x-hidden">
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