@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Before & After') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('Before & After') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('See the transformation in our before and after decoration projects') }}">
@endpush

@section('title', __('Before & After') . ' - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <span class="section-label">{{ __('Gallery') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Before & After') }}</h1>
            <p class="text-[var(--text-light)] max-w-2xl mx-auto text-lg">{{ __('See the transformation in our decoration projects') }}</p>
        </div>
    </div>
</section>

{{-- Type Tabs --}}
<section class="py-6 bg-[var(--white)] border-b border-[var(--stone)]">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('gallery') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('All') }}</a>
            <a href="{{ route('gallery.videos') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('Videos') }}</a>
            <a href="{{ route('gallery.tours') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('360 Tours') }}</a>
            <a href="{{ route('gallery.before-after') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--gold)] text-white">{{ __('Before & After') }}</a>
            <a href="{{ route('gallery.photography') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white"><i class="fas fa-camera ml-1.5"></i>{{ __('Photography') }}</a>
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        @if($items->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($items as $item)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" class="rounded-2xl overflow-hidden bg-[var(--navy-dark)] cursor-pointer"
                         onclick="location.href='{{ route('gallery.show', [$item->id, $item->slug]) }}'">
                        @if($item->show_comparison)
                            <div x-data="{ pos: 50 }" class="relative select-none">
                                {!! \App\Services\ImageService::picture($item->after_image, $item->title . ' - ' . __('After'), 'w-full h-64 md:h-80 object-cover') !!}
                                <div class="absolute inset-0 overflow-hidden" :style="'clip-path: inset(0 ' + (100 - pos) + '% 0 0)'">
                                    {!! \App\Services\ImageService::picture($item->before_image, $item->title . ' - ' . __('Before'), 'w-full h-64 md:h-80 object-cover') !!}
                                </div>
                                <input type="range" min="0" max="100" x-model="pos"
                                       class="absolute bottom-2 left-2 right-2 z-10 w-[calc(100%-1rem)] accent-[var(--gold)]">
                            </div>
                        @else
                            <div class="grid grid-cols-2">
                                <div class="relative">
                                    <span class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-0.5 rounded z-10">{{ __('Before') }}</span>
                                    {!! \App\Services\ImageService::picture($item->before_image, $item->title . ' - ' . __('Before'), 'w-full h-64 md:h-80 object-cover') !!}
                                </div>
                                <div class="relative">
                                    <span class="absolute top-2 right-2 bg-[var(--gold)]/80 text-white text-xs px-2 py-0.5 rounded z-10">{{ __('After') }}</span>
                                    {!! \App\Services\ImageService::picture($item->after_image, $item->title . ' - ' . __('After'), 'w-full h-64 md:h-80 object-cover') !!}
                                </div>
                            </div>
                        @endif
                        <div class="p-4 text-center">
                            <h3 class="text-white font-bold text-lg">{{ $item->title }}</h3>
                            @if($item->description)
                                <p class="text-[var(--text-light)] text-sm mt-1">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)] flex items-center justify-center">
                    <i class="fas fa-not-equal text-3xl text-[var(--text-light)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-2">{{ __('No before & after images yet') }}</h3>
                <p class="text-[var(--text-light)]">{{ __('Images will be added soon') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection
