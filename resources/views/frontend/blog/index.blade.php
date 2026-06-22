@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Blog') . ' - ' . __('Smart Designer Decorations') . '. ' . __('Latest articles and tips in the world of decoration and interior design') }}">
<meta name="keywords" content="{{ __('Blog') }}, {{ __('Design') }}, {{ __('Decoration') }}, {{ __('Articles') }}">
<meta property="og:title" content="{{ __('Blog') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Latest articles and tips in the world of decoration and interior design') }}">
@endpush

@section('title', __('Blog') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative py-16 md:py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="overlay-gradient"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl sm:text-4xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Blog') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-muted)] text-lg max-w-2xl mx-auto">{{ __('Latest articles and tips in the world of decoration and interior design') }}</p>
    </div>
</section>

{{-- Category Chips --}}
<section class="py-4 bg-[var(--white)] border-b border-[var(--stone)] sticky top-20 z-30">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-2">
            <a href="{{ route('blog') }}"
               class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ !$category ? 'bg-[var(--gold)] text-black' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)]/20 hover:text-[var(--gold)]' }}">
                {{ __('All') }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog', array_merge(request()->query(), ['category' => $cat])) }}"
                   class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $category == $cat ? 'bg-[var(--gold)] text-black' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)]/20 hover:text-[var(--gold)]' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Blog Posts --}}
<section class="py-10 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                @php
                    $postImages = is_array($post->images) ? array_values(array_filter($post->images)) : [];
                    $singleImage = $post->image ?? ($postImages[0] ?? null);
                @endphp
                <article data-aos="fade-up" data-aos-delay="{{ $loop->index * 30 }}" class="card-elegant overflow-hidden">
                    @if($singleImage)
                        <div class="relative h-52 overflow-hidden group/img"
                            @if(count($postImages) > 1)
                            x-data="{
                                s: 0,
                                t: {{ count($postImages) }},
                                p: false,
                                int: null,
                                go() { this.int = setInterval(() => { if (!this.p) this.s = (this.s + 1) % this.t; }, 4500); },
                                stop() { if (this.int) clearInterval(this.int); },
                                init() { this.go(); },
                                destroy() { this.stop(); }
                            }"
                            @@mouseenter="p = true"
                            @@mouseleave="p = false"
                            @endif
                        >
                            {{-- Favorite --}}
                            <button type="button" @click.stop="toggleFavorite('blog', {{ $post->id }})"
                                    :class="isFavorite('blog', {{ $post->id }}) ? 'text-red-400' : 'text-white'"
                                    class="absolute top-3 left-3 z-20 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                    title="{{ __('Add to Favorites') }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('blog', {{ $post->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                            @if(count($postImages) > 1)
                                @foreach($postImages as $bi => $bImg)
                                <img src="{{ asset('storage/' . $bImg) }}" alt="{{ $post->title }}"
                                     class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out"
                                     :class="s === {{ $bi }} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'"
                                     loading="lazy">
                                @endforeach
                                <div class="absolute top-2 right-2 z-20 flex gap-1">
                                    @foreach($postImages as $bi => $bImg)
                                    <button @@click.stop="s = {{ $bi }}; p = true; setTimeout(() => p = false, 5500)"
                                            class="w-1.5 h-1.5 rounded-full transition-all duration-300"
                                            :class="s === {{ $bi }} ? 'bg-[var(--gold)] w-3' : 'bg-white/40 hover:bg-white/70'"></button>
                                    @endforeach
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $singleImage) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
                            @endif
                        </div>
                    @else
                        <div class="h-52 flex items-center justify-center bg-[var(--gold)]">
                            <i class="fas fa-newspaper text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-sm text-[var(--text-light)] mb-3">
                            <span><x-icon name="star" class="w-3 h-3 text-[var(--gold)] inline-block ml-1 align-middle" /> {{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-[var(--text-heading)] mb-3 leading-relaxed">
                            <a href="{{ route('blog.post', $post->slug) }}" class="hover:text-[var(--gold)] transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        @if($post->excerpt)
                            <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($post->excerpt, 120) }}</p>
                        @endif
                        <a href="{{ route('blog.post', $post->slug) }}" class="inline-flex items-center text-[var(--gold)] font-bold text-sm hover:gap-2 transition-all">
                            {{ __('Read More') }} <i class="fas fa-arrow-left mr-1"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-16">
                    <i class="fas fa-blog text-6xl text-[var(--text-muted)] mb-4"></i>
                    <p class="text-[var(--text-light)] text-xl">{{ __('No articles available') }}</p>
                    <p class="text-[var(--text-muted)] mt-2">{{ __('Content will be added soon') }}</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>

@endsection