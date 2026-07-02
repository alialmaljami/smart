@php
    $images = collect(is_array($project->images) ? $project->images : [])->map(fn($i) => \App\Services\ImageService::asset($i))->values()->toArray();
    $videos = is_array($project->videos) ? $project->videos : [];
    $totalImages = count($images);
    $totalVideos = count($videos);
    $relatedProjects = App\Models\Project::where('is_active', true)
        ->where('id', '!=', $project->id)
        ->orderBy('sort_order', 'desc')
        ->take(3)
        ->get();
    $descLines = preg_split('/\n\s*\n/', trim($project->description));
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $project->meta_description ?? Str::limit($project->description, 160) }}">
<meta name="keywords" content="{{ $project->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $project->meta_title ?? $project->title }}">
<meta property="og:description" content="{{ $project->meta_description ?? Str::limit($project->description, 160) }}">
@if($totalImages)
    <meta property="og:image" content="{{ $images[0] }}">
@endif
@endpush

@section('title', ($project->meta_title ?? $project->title) . ' - ' . __('Smart Designer Decorations'))

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    @media (max-width: 639px) {
        .desc-preview { display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
    }
</style>
@endpush

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Our Projects'), 'url' => route('projects')],
            ['name' => $project->title, 'url' => route('project.show', $project->slug)],
        ]),
        \App\Services\SchemaService::article($project->title, $project->meta_description ?? Str::limit($project->description, 160), $project->image),
    ]);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-full">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--text-heading)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <a href="{{ route('projects') }}" class="text-[var(--text-muted)] hover:text-[var(--text-heading)] whitespace-nowrap">{{ __('Projects') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <span class="text-[var(--text-heading)] font-bold truncate max-w-[120px] sm:max-w-[250px]">{{ $project->title }}</span>
        </nav>
    </div>
</section>

{{-- Project Detail --}}
<section class="py-6 md:py-12 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-full">
        <div class="flex flex-col lg:grid lg:grid-cols-3 gap-6 md:gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 min-w-0 max-w-full">
                {{-- Image Slider (rendered server-side, NOT in Alpine data) --}}
                @if($totalImages)
                    <div x-data="{ activeImage: 0 }" class="mb-6 md:mb-8">
                        <div class="relative rounded-[var(--radius-lg)] overflow-hidden bg-[var(--navy-dark)] h-56 sm:h-72 md:h-96 mb-3 sm:mb-4 w-full">
                            @foreach($images as $idx => $img)
                                <div x-show="activeImage === {{ $idx }}" x-cloak class="absolute inset-0 w-full h-full">
                                    <img src="{{ $img }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach

                            <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-2 sm:top-3 left-2 sm:left-3 md:top-4 md:left-4 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                <button type="button" class="flex items-center gap-1 px-2 py-1 md:gap-1.5 md:px-3 md:py-1.5 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 transition-all">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                    <span class="text-[10px] md:text-xs font-medium" x-text="count">0</span>
                                </button>
                            </div>
                            <button type="button" @click.stop="toggleFavorite('project', {{ $project->id }})"
                                    :class="isFavorite('project', {{ $project->id }}) ? 'text-red-400' : 'text-white'"
                                    class="absolute top-2 sm:top-3 right-2 sm:right-3 md:top-4 md:right-4 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                    title="{{ __('Add to Favorites') }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('project', {{ $project->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>

                            @if($totalImages > 1)
                                <button type="button" @click="activeImage = activeImage > 0 ? activeImage - 1 : {{ $totalImages - 1 }}" class="absolute right-1 sm:right-2 md:right-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 rounded-full bg-black/60 flex items-center justify-center text-white hover:bg-black/80 z-10">
                                    <i class="fas fa-chevron-right text-base sm:text-lg"></i>
                                </button>
                                <button type="button" @click="activeImage = activeImage < {{ $totalImages - 1 }} ? activeImage + 1 : 0" class="absolute left-1 sm:left-2 md:left-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 rounded-full bg-black/60 flex items-center justify-center text-white hover:bg-black/80 z-10">
                                    <i class="fas fa-chevron-left text-base sm:text-lg"></i>
                                </button>
                                <div class="absolute bottom-2 sm:bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                                    @foreach($images as $idx => $img)
                                        <button type="button" @click="activeImage = {{ $idx }}" class="transition-all rounded-full" :class="activeImage === {{ $idx }} ? 'w-5 sm:w-6 bg-white' : 'w-2 h-2 bg-white/40'"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if($totalImages > 1)
                            <div class="flex gap-2 overflow-x-auto pb-2" dir="ltr" style="scrollbar-width:none;-ms-overflow-style:none;">
                                @foreach($images as $idx => $img)
                                    <button type="button" @click="activeImage = {{ $idx }}" class="flex-shrink-0 w-16 h-12 sm:w-14 sm:h-10 md:w-20 md:h-16 rounded-lg overflow-hidden border-2 transition-all" :class="activeImage === {{ $idx }} ? 'border-[var(--gold)]' : 'border-transparent'">
                                        <img src="{{ $img }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <h1 class="text-xl sm:text-3xl md:text-4xl font-black text-[var(--text-heading)] mb-3 md:mb-4 break-words max-w-full">{{ $project->title }}</h1>

                {{-- Description collapsible on mobile --}}
                @php $descFull = strip_tags($project->description); $isLong = mb_strlen($descFull) > 300; @endphp
                <div x-data="{ expanded: false }" class="text-[13px] sm:text-sm md:text-base text-[var(--text-secondary)] leading-relaxed break-words max-w-full">
                    <div :class="expanded || !$isLong ? '' : 'desc-preview'">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                    @if($isLong)
                        <button type="button" @click="expanded = !expanded" class="mt-2 text-[var(--gold)] hover:text-[var(--gold)]/80 font-bold text-xs sm:text-sm">
                            <span x-show="!expanded">{{ __('Read More') }} <i class="fas fa-chevron-down text-[10px] mr-1"></i></span>
                            <span x-show="expanded" x-cloak>{{ __('Show Less') }} <i class="fas fa-chevron-up text-[10px] mr-1"></i></span>
                        </button>
                    @endif
                </div>

                {{-- Videos --}}
                @if($totalVideos)
                    <div x-data="{ showAll: false }" class="mt-6 md:mt-12">
                        <h2 class="text-lg md:text-2xl font-bold text-[var(--text-heading)] mb-3 md:mb-6">{{ __('Project Videos') }} ({{ $totalVideos }})</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                            @foreach($videos as $i => $video)
                                <div x-show="showAll || {{ $i < 2 ? 'true' : 'false' }}" x-cloak class="max-w-full w-full">
                                    <video controls class="w-full rounded-[var(--radius-lg)] max-h-48 md:max-h-72 bg-black">
                                        <source src="{{ $video }}" type="video/mp4">
                                    </video>
                                </div>
                            @endforeach
                        </div>
                        @if($totalVideos > 2)
                            <button type="button" @click="showAll = !showAll" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-[var(--gold)]/10 text-[var(--gold)] hover:bg-[var(--gold)]/20 rounded-lg font-bold text-xs sm:text-sm">
                                <span x-show="!showAll">{{ __('Show All') }} ({{ $totalVideos }}) <i class="fas fa-chevron-down text-[10px] mr-1"></i></span>
                                <span x-show="showAll" x-cloak>{{ __('Show Less') }} <i class="fas fa-chevron-up text-[10px] mr-1"></i></span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 min-w-0 max-w-full">
                <div class="bg-[var(--cream)] rounded-[var(--radius-lg)] p-4 md:p-6 lg:sticky top-28 border border-[var(--stone)]">
                    <h3 class="text-base md:text-xl font-bold text-[var(--gold)] mb-3 md:mb-6">{{ __('Project Information') }}</h3>
                    <div class="space-y-2 md:space-y-4">
                        @if(is_array($project->tags) && count($project->tags))
                            <div class="flex items-start gap-2 md:gap-3">
                                <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="tag" class="w-3.5 h-3.5 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div class="min-w-0 max-w-full">
                                    <span class="text-[11px] md:text-sm text-[var(--text-light)]">{{ __('Tags') }}</span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($project->tags as $tag)
                                            <a href="{{ route('tag', urlencode($tag)) }}" class="text-[11px] font-bold text-[var(--gold)] bg-[var(--gold)]/5 hover:bg-[var(--gold)]/20 px-2 py-0.5 rounded-full truncate max-w-full transition-colors">{{ $tag }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($project->services->count())
                            <div class="flex items-start gap-2 md:gap-3">
                                <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="star" class="w-3.5 h-3.5 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div class="min-w-0 max-w-full">
                                    <span class="text-[11px] md:text-sm text-[var(--text-light)]">{{ __('Services') }}</span>
                                    @foreach($project->services as $service)
                                        <a href="{{ route('service.show', $service->slug) }}" class="font-bold text-[var(--gold)] hover:text-[var(--gold)]/70 text-sm md:text-base truncate max-w-full block transition-colors">{{ $service->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($project->materialCategories->count())
                            <div class="flex items-start gap-2 md:gap-3">
                                <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-icon name="star" class="w-3.5 h-3.5 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div class="min-w-0 max-w-full">
                                    <span class="text-[11px] md:text-sm text-[var(--text-light)]">{{ __('Materials Used') }}</span>
                                    @foreach($project->materialCategories as $mc)
                                        <a href="{{ route('material.category.show', $mc->slug) }}" class="font-bold text-[var(--gold)] hover:text-[var(--gold)]/70 text-sm md:text-base truncate max-w-full block transition-colors">{{ $mc->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 md:mt-8 pt-4 md:pt-6 border-t border-[var(--stone)]">
                        <a href="{{ route('contact') }}" class="btn-primary w-full text-center px-3 md:px-6 py-3 rounded-lg font-bold block text-xs md:text-base no-underline">
                            <x-icon name="phone" class="w-4 h-4 md:w-5 md:h-5 inline-block ml-1.5 md:ml-2 align-middle" /> {{ __('Contact for a similar project') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Projects --}}
@if($relatedProjects->count())
    <section class="py-10 md:py-16 bg-[var(--navy)]">
        <div class="container mx-auto px-4 max-w-full">
            <div class="text-center mb-6 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Similar Projects') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($relatedProjects as $related)
                    @php $rImg = is_array($related->images) ? ($related->images[0] ?? '') : $related->images; @endphp
                    <div class="group relative rounded-[var(--radius-lg)] overflow-hidden shadow-lg bg-[var(--navy-dark)]">
                        <div class="h-44 sm:h-52 md:h-64 w-full">
                            <img src="{{ \App\Services\ImageService::asset($rImg) }}" alt="{{ $related->title }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div x-data="{ liked: {{ $related->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $related->likeCount() }} }" class="absolute top-2 sm:top-3 left-2 sm:left-3 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $related->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button type="button" class="flex items-center gap-1 px-2 sm:px-2.5 py-1 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 text-[10px] sm:text-xs">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <button type="button" @click.stop="toggleFavorite('project', {{ $related->id }})"
                                :class="isFavorite('project', {{ $related->id }}) ? 'text-red-400' : 'text-white'"
                                class="absolute top-2 sm:top-3 right-2 sm:right-3 z-10 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                title="{{ __('Add to Favorites') }}">
                            <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('project', {{ $related->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                        <div class="absolute bottom-2 sm:bottom-4 right-2 sm:right-4 left-2 sm:left-4">
                            <h3 class="text-white font-bold text-xs sm:text-base leading-tight break-words">{{ $related->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $related->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 rounded-[var(--radius-lg)]">
                            <span class="text-white font-bold border-2 border-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm">{{ __('View Project') }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-6 md:py-8 bg-[var(--navy)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 max-w-full text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3">
            <span class="text-xs sm:text-base text-[var(--text-light)]">{{ __('Share this project:') }}</span>
            <div class="flex flex-wrap justify-center gap-2 items-center" dir="ltr">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($project->title . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 shrink-0"><x-icon name="whatsapp" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5" /></a>
                <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ $totalImages ? urlencode($images[0]) : '' }}&description={{ urlencode($project->title) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 shrink-0"><x-icon name="pinterest" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5" /></a>
                @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
            </div>
        </div>
    </div>
</section>

@endsection