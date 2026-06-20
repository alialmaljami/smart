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
<section class="relative py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="overlay-gradient"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-5xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Blog') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-muted)] text-lg max-w-2xl mx-auto">{{ __('Latest articles and tips in the world of decoration and interior design') }}</p>
    </div>
</section>

{{-- Blog Posts --}}
<section class="py-20 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article data-aos="fade-up" data-aos-delay="{{ $loop->index * 30 }}" class="card-elegant overflow-hidden">
                    @if($post->image)
                        <div class="img-zoom h-52">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
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