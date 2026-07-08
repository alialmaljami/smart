@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Video Gallery') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('Video Gallery') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Browse our video gallery showcasing our decoration projects') }}">
@endpush

@section('title', __('Video Gallery') . ' - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <span class="section-label">{{ __('Gallery') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Video Gallery') }}</h1>
            <p class="text-[var(--text-light)] max-w-2xl mx-auto text-lg">{{ __('Browse our collection of decoration videos') }}</p>
        </div>
    </div>
</section>

{{-- Type Tabs --}}
<section class="py-6 bg-[var(--white)] border-b border-[var(--stone)]">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('gallery') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('All') }}</a>
            <a href="{{ route('gallery.videos') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--gold)] text-white">{{ __('Videos') }}</a>
            <a href="{{ route('gallery.tours') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('360 Tours') }}</a>
            <a href="{{ route('gallery.before-after') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('Before & After') }}</a>
            <a href="{{ route('gallery.photography') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white"><i class="fas fa-camera ml-1.5"></i>{{ __('Photography') }}</a>
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        @if($items->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}" class="group rounded-2xl overflow-hidden bg-[var(--navy-dark)] cursor-pointer"
                         onclick="location.href='{{ route('gallery.show', [$item->id, $item->slug]) }}'">
                        <div class="relative aspect-video">
                            {!! \App\Services\ImageService::picture($item->getDisplayImage(), $item->alt_text ?: $item->title, 'w-full h-full object-cover') !!}
                            <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/10 transition-all">
                                <div class="w-16 h-16 rounded-full bg-[var(--gold)]/90 flex items-center justify-center text-white text-2xl">
                                    <i class="fas fa-play ml-0.5"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-lg mb-1">{{ $item->title }}</h3>
                            @if($item->description)
                                <p class="text-[var(--text-light)] text-sm line-clamp-2">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)] flex items-center justify-center">
                    <i class="fas fa-video text-3xl text-[var(--text-light)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-2">{{ __('No videos yet') }}</h3>
                <p class="text-[var(--text-light)]">{{ __('Videos will be added soon') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection
