@php
    $relatedPosts = App\Models\BlogPost::where('is_active', true)
        ->where('id', '!=', $post->id)
        ->latest()
        ->take(3)
        ->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit($post->content, 160) }}">
<meta name="keywords" content="{{ $post->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $post->meta_title ?? $post->title }}">
<meta property="og:description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit($post->content, 160) }}">
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
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Blog'), 'url' => route('blog')],
            ['name' => $post->title, 'url' => route('blog.post', $post->slug)],
        ]),
        \App\Services\SchemaService::article(
            $post->title,
            $post->meta_description ?? $post->excerpt ?? Str::limit($post->content, 160),
            $post->image,
            $post->created_at?->toIso8601String(),
            config('app.name'),
            $post->updated_at?->toIso8601String()
        ),
    ]);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('blog') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Blog') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <span class="text-[var(--gold)] font-bold">{{ $post->title }}</span>
        </nav>
    </div>
</section>

{{-- Post Content --}}
<article class="py-12 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-4xl">
        @if($post->image)
            <div data-aos="zoom-in" class="rounded-2xl overflow-hidden mb-8 h-96">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
            </div>
        @endif

        @if(isset($post->images) && is_array($post->images) && count($post->images))
            <div data-aos="fade-up" class="mb-10">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($post->images as $img)
                        <div class="rounded-xl overflow-hidden h-48">
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <header data-aos="fade-up" class="mb-8">
            <div class="flex items-center gap-4 text-sm text-[var(--text-light)] mb-4">
                <span><x-icon name="calendar" class="w-4 h-4 text-[var(--gold)] inline-block ml-1 align-middle" /> {{ $post->created_at->format('d M Y') }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] leading-tight">{{ $post->title }}</h1>
        </header>

        @if($post->excerpt)
            <div data-aos="fade-up" class="text-xl text-[var(--text-light)] leading-relaxed mb-8 border-r-4 border-[var(--gold)] pr-4">
                {{ $post->excerpt }}
            </div>
        @endif

        <div data-aos="fade-up" class="prose prose-lg max-w-none text-[var(--text-heading)] leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>

        {{-- Tags --}}
        @if($post->tags)
            <div class="mt-8 pt-8 border-t border-[var(--stone)]">
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $post->tags) as $tag)
                        <a href="{{ route('tag', trim($tag)) }}" class="px-4 py-1 rounded-full text-sm bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white transition-colors">#{{ trim($tag) }}</a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-8 bg-[var(--white)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">{{ __('Share this article:') }}</span>
        <div class="inline-flex space-x-2 space-x-reverse items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ $post->image ? urlencode(asset('storage/' . $post->image)) : '' }}&description={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="pinterest" class="w-5 h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

{{-- Related Posts --}}
@if($relatedPosts->count())
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--gold)]">{{ __('Related Articles') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <article data-aos="fade-up" class="card-elegant overflow-hidden">
                        @if($related->image)
                            <div class="img-zoom h-44">
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="p-4">
                            <span class="text-xs text-[var(--text-light)]"><x-icon name="calendar" class="w-3 h-3 text-[var(--gold)] inline-block ml-1 align-middle" /> {{ $related->created_at->format('d M Y') }}</span>
                            <h3 class="font-bold text-[var(--text-heading)] mt-2 mb-2">
                                <a href="{{ route('blog.post', $related->slug) }}" class="hover:text-[var(--gold)] transition-colors">{{ $related->title }}</a>
                            </h3>
                            <a href="{{ route('blog.post', $related->slug) }}" class="text-sm text-[var(--gold)] font-bold">{{ __('Read More') }} <i class="fas fa-arrow-left mr-1"></i></a>
                        </div>
                    </article>
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
    <section class="py-16 bg-[var(--white)] border-t border-[var(--stone)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--gold)]">{{ __('Discover Our Projects') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($discoverProjects as $project)
                    @php $img = is_array($project->images) ? ($project->images[0] ?? '') : $project->images; @endphp
                    <div data-aos="fade-up" class="group relative rounded-xl overflow-hidden img-zoom h-64">
                        <img src="{{ asset('storage/' . ($project->image ?: $img)) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
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

{{-- CTA --}}
<section class="py-16 bg-[var(--gold)]">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ __('Liked this article?') }}</h2>
            <p class="text-white/80 text-lg mb-8">{{ __('Contact us for a free consultation') }}</p>
            <a href="{{ route('contact') }}" class="btn-light inline-flex items-center px-8 py-3 rounded-lg font-bold">
                <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('Contact us') }}
            </a>
        </div>
    </div>
</section>

@endsection