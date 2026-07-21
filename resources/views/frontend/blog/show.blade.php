@php
    $relatedPosts = App\Models\BlogPost::where('is_active', true)
        ->where('id', '!=', $post->id)
        ->latest()
        ->take(3)
        ->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}">
<meta name="keywords" content="{{ $post->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $post->meta_title ?? $post->title }}">
<meta property="og:description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}">
@if($post->image)
    <meta property="og:image" content="{{ asset('storage/' . $post->image) }}">
@endif
<meta property="og:type" content="article">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('title', ($post->meta_title ?? $post->title) . ' - ' . __('Blog') . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Blog'), 'url' => route('blog')],
            ['name' => $post->title, 'url' => route('blog.post', $post->slug)],
        ]),
        \App\Services\SchemaService::article(
            $post->title,
            $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160),
            $post->image,
            $post->created_at?->toIso8601String(),
            config('app.name'),
            $post->updated_at?->toIso8601String()
        ),
    ]);
@endphp
@endpush

@push('styles')
<style>
    .blog-content { line-height: 1.9; word-spacing: 0.05em; }
    .blog-content p { margin-bottom: 1.25rem; text-align: justify; }
    .blog-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 1.5rem 0; }
    .blog-content h2 { font-size: 1.5rem; font-weight: 800; margin: 2rem 0 1rem; color: var(--text-heading); }
    .blog-content h3 { font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem; color: var(--text-heading); }
    .blog-content ul, .blog-content ol { margin-bottom: 1.25rem; padding-right: 1.5rem; }
    .blog-content li { margin-bottom: 0.5rem; }
    .blog-content a { color: var(--gold); text-decoration: underline; }
    .blog-content blockquote { border-right: 3px solid var(--gold); padding-right: 1rem; margin: 1.5rem 0; color: var(--text-light); font-style: italic; }
    @media (max-width: 639px) {
        .blog-content h2 { font-size: 1.25rem; }
        .blog-content h3 { font-size: 1.1rem; }
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <nav class="flex items-center flex-wrap gap-x-1 gap-y-1 text-[11px] sm:text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <a href="{{ route('blog') }}" class="text-[var(--text-muted)] hover:text-[var(--gold)] whitespace-nowrap">{{ __('Blog') }}</a>
            <i class="fas fa-chevron-left text-[9px] text-[var(--text-muted)] mx-0.5"></i>
            <span class="text-[var(--gold)] font-bold truncate max-w-[120px] sm:max-w-[300px]">{{ $post->title }}</span>
        </nav>
    </div>
</section>

{{-- Post Content --}}
<article class="py-6 md:py-12 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full">
        <div class="max-w-4xl mx-auto min-w-0 max-w-full">
            @if($post->image)
                <div class="rounded-2xl overflow-hidden mb-6 md:mb-8 h-48 sm:h-64 md:h-96 w-full relative">
                    {!! \App\Services\ImageService::picture($post->image, $post->title, 'w-full h-full object-cover') !!}
                    <button type="button" @click.stop="toggleFavorite('blog', {{ $post->id }})"
                            :class="isFavorite('blog', {{ $post->id }}) ? 'text-red-400' : 'text-white'"
                            class="absolute top-3 left-3 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                            title="{{ __('Add to Favorites') }}">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('blog', {{ $post->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
            @endif

            @if(isset($post->images) && is_array($post->images) && count($post->images))
                <div class="mb-6 md:mb-10">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        @foreach($post->images as $idx => $img)
                            <a href="{{ route('media.show', ['blog', $post->slug, $idx]) }}" class="block rounded-xl overflow-hidden h-32 sm:h-40 md:h-48 w-full group relative">
                                {!! \App\Services\ImageService::picture($img, $post->title, 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500') !!}
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <i class="fas fa-expand text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <header class="mb-6 md:mb-8">
                <div class="flex items-center gap-3 text-[11px] sm:text-sm text-[var(--text-light)] mb-3 md:mb-4">
                    <span><x-icon name="calendar" class="w-3 h-3 md:w-4 md:h-4 text-[var(--gold)] inline-block ml-1 align-middle" /> {{ $post->created_at->format('d M Y') }}</span>
                </div>
                <h1 class="text-xl sm:text-3xl md:text-5xl font-black text-[var(--text-heading)] leading-tight break-words">{{ $post->title }}</h1>
            </header>

            @if($post->excerpt)
                <div class="text-sm sm:text-base md:text-xl text-[var(--text-light)] leading-relaxed mb-6 md:mb-8 border-r-2 md:border-r-4 border-[var(--gold)] pr-3 md:pr-4 break-words">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="blog-content text-[14px] sm:text-base md:text-lg text-[var(--text-heading)] leading-relaxed break-words max-w-full">
                @php
                    $content = $post->content;
                    if (!str_contains($content, '<p') && !str_contains($content, '<h')) {
                        $content = '<p>' . preg_replace('/\n\n+/', '</p><p>', trim($content)) . '</p>';
                        $content = str_replace(["\r\n", "\n"], '<br>', $content);
                    }
                @endphp
                {!! strip_tags($content, '<p><br><strong><em><a><u><ol><ul><li><h1><h2><h3><h4><h5><h6><img><blockquote><pre><code><table><tr><td><th><span><div><section><figure><figcaption><hr>') !!}
            </div>

            {{-- Tags --}}
            @php
                $displayTags = [];
                foreach ($post->tagItems as $t) {
                    $displayTags[] = ['name' => $t->name, 'slug' => $t->slug, 'isMaster' => true];
                }
                if (is_array($post->tags)) {
                    foreach ($post->tags as $tag) {
                        foreach (explode('،', $tag) as $part) {
                            foreach (explode(',', $part) as $p) {
                                $trimmed = trim($p);
                                if ($trimmed !== '') $displayTags[] = ['name' => $trimmed, 'slug' => null, 'isMaster' => false];
                            }
                        }
                    }
                }
                $displayTags = collect($displayTags)->unique('name')->all();
            @endphp
            @if(count($displayTags))
                <div class="mt-6 md:mt-8 pt-6 md:pt-8 border-t border-[var(--stone)]">
                    <div class="flex flex-wrap gap-1.5 md:gap-2">
                        @foreach($displayTags as $tag)
                            <a href="{{ $tag['isMaster'] ? route('tag.slug', $tag['slug']) : route('tag', urlencode($tag['name'])) }}" class="px-3 md:px-4 py-1 rounded-full text-[11px] md:text-sm {{ $tag['isMaster'] ? 'bg-[var(--gold)]/10 text-[var(--gold)] hover:bg-[var(--gold)] hover:text-white' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white' }} transition-colors">#{{ $tag['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</article>

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-6 md:py-8 bg-[var(--white)] border-t border-[var(--stone)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3">
            <span class="text-xs sm:text-base text-[var(--text-light)]">{{ __('Share this article:') }}</span>
            <div class="flex flex-wrap justify-center gap-2 items-center" dir="ltr">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 shrink-0"><x-icon name="whatsapp" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5" /></a>
                <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ $post->image ? urlencode(asset('storage/' . $post->image)) : '' }}&description={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 shrink-0"><x-icon name="pinterest" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5" /></a>
                @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
            </div>
        </div>
    </div>
</section>

{{-- Related Posts --}}
@if($relatedPosts->count())
    <section class="py-10 md:py-16 bg-[var(--navy)] overflow-x-hidden">
        <div class="container mx-auto px-4 max-w-full">
            <div class="text-center mb-6 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Related Articles') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @foreach($relatedPosts as $related)
                    <div class="rounded-[var(--radius-lg)] overflow-hidden bg-[var(--navy-dark)] border border-[var(--stone)]">
                        @if($related->image)
                            <div class="h-36 sm:h-40 md:h-44 w-full overflow-hidden">
                                {!! \App\Services\ImageService::picture($related->image, $related->title, 'w-full h-full object-cover hover:scale-105 transition-transform duration-500') !!}
                            </div>
                        @endif
                        <div class="p-3 md:p-4">
                            <span class="text-[10px] md:text-xs text-[var(--text-light)]"><x-icon name="calendar" class="w-2.5 h-2.5 md:w-3 md:h-3 text-[var(--gold)] inline-block ml-1 align-middle" /> {{ $related->created_at->format('d M Y') }}</span>
                            <h3 class="font-bold text-[var(--text-heading)] mt-1.5 md:mt-2 mb-1.5 md:mb-2 text-sm md:text-base">
                                <a href="{{ route('blog.post', $related->slug) }}" class="hover:text-[var(--gold)] transition-colors break-words">{{ $related->title }}</a>
                            </h3>
                            <a href="{{ route('blog.post', $related->slug) }}" class="text-[11px] md:text-sm text-[var(--gold)] font-bold">{{ __('Read More') }} <i class="fas fa-arrow-left mr-1"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@php
    $discoverProjects = App\Models\Project::where('is_active', true)->inRandomOrder()->take(3)->get();
@endphp

{{-- Discover More Projects --}}
@if($discoverProjects->count())
    <section class="py-10 md:py-16 bg-[var(--white)] border-t border-[var(--stone)] overflow-x-hidden">
        <div class="container mx-auto px-4 max-w-full">
            <div class="text-center mb-6 md:mb-12">
                <h2 class="text-xl md:text-3xl font-black text-[var(--gold)]">{{ __('Discover Our Projects') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @foreach($discoverProjects as $project)
                    @php $img = is_array($project->images) ? ($project->images[0] ?? '') : ($project->images ?? ''); @endphp
                    <div class="group relative rounded-xl overflow-hidden h-48 sm:h-52 md:h-64 w-full">
                        {!! \App\Services\ImageService::picture($project->image ?: $img, $project->title, 'w-full h-full object-cover') !!}
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div class="absolute bottom-2 sm:bottom-4 right-2 sm:right-4 left-2 sm:left-4">
                            <h3 class="text-white font-bold text-sm sm:text-base md:text-lg break-words">{{ $project->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 rounded-xl">
                            <span class="text-white font-bold border-2 border-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm">{{ __('View Project') }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- CTA --}}
<section class="py-10 md:py-16 bg-[var(--gold)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-full text-center">
        <h2 class="text-xl md:text-3xl md:text-4xl font-black text-white mb-3 md:mb-4">{{ __('Liked this article?') }}</h2>
        <p class="text-white/80 text-sm md:text-lg mb-6 md:mb-8">{{ __('Contact us for a free consultation') }}</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 md:px-8 py-2.5 md:py-3 rounded-lg font-bold bg-white text-[var(--gold)] hover:bg-white/90 transition-all text-sm md:text-base">
            <x-icon name="phone" class="w-4 h-4 md:w-5 md:h-5 inline-block ml-1.5 md:ml-2 align-middle" /> {{ __('Contact us') }}
        </a>
    </div>
</section>

@endsection