@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Professional photography gallery - Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('Photography') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Professional photography gallery') }}">
@endpush

@section('title', __('Photography') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Type Tabs --}}
<section class="py-6 bg-[var(--white)] border-b border-[var(--stone)]">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('gallery') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('All') }}</a>
            <a href="{{ route('gallery.videos') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('Videos') }}</a>
            <a href="{{ route('gallery.tours') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('360 Tours') }}</a>
            <a href="{{ route('gallery.before-after') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white">{{ __('Before & After') }}</a>
            <a href="{{ route('gallery.photography') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--gold)] text-white"><i class="fas fa-camera ml-1.5"></i>{{ __('Photography') }}</a>
        </div>
    </div>
</section>

<section class="relative pt-24 pb-16 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-camera text-2xl md:text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Photography') }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ __('Professional photography gallery') }}</p>
        </div>
    </div>
</section>

<section class="py-12 md:py-20 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-6xl">
        @if($items->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($items as $item)
                    <a href="{{ route('gallery.show', [$item->id, $item->slug]) }}" class="group block">
                        <div class="rounded-xl overflow-hidden bg-[var(--white)] shadow-sm border border-[var(--stone)]/20 group-hover:shadow-lg transition-all">
                            @if($item->image)
                                {!! \App\Services\ImageService::picture($item->image, $item->title, 'w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700') !!}
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)] group-hover:text-[var(--gold)] transition-colors">{{ $item->title }}</h3>
                                @if($item->description)
                                    <p class="text-xs md:text-sm text-[var(--text-secondary)] mt-1">{{ Str::limit($item->description, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <i class="fas fa-camera text-3xl text-[var(--gold)]"></i>
                </div>
                <p class="text-[var(--text-light)]">{{ __('No photos available yet') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection
