@php
    $allServices = App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Our Services') . ' - ' . __('Smart Designer Decorations') . '. ' . __('We offer a comprehensive range of design and decoration services to meet all your needs') }}">
<meta name="keywords" content="{{ __('Our Services') }}, {{ __('Design') }}, {{ __('Decoration') }}">
<meta property="og:title" content="{{ __('Our Services') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('We offer a comprehensive range of design and decoration services to meet all your needs') }}">
@endpush

@section('title', __('Our Services') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative py-16 md:py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="absolute inset-0 opacity-[0.04]" style="background: radial-gradient(circle at 30% 50%, var(--cream) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--cream) 0%, transparent 50%);"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl sm:text-4xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Our Services') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">{{ __('We offer a comprehensive range of design and decoration services to meet all your needs') }}</p>
    </div>
</section>

{{-- Services Grid --}}
<section class="py-20 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($allServices as $service)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 30 }}" class="card-elegant bg-[var(--white)] rounded-2xl overflow-hidden">
                    @if($service->image)
                        <div class="img-zoom h-48 relative">
                            <div x-data="{ liked: {{ $service->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $service->likeCount() }} }" class="absolute top-3 left-3 z-20" @click.prevent="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'service', id: {{ $service->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 transition-all">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                    <span class="text-xs font-medium" x-text="count"></span>
                                </button>
                            </div>
                            <button type="button" @click.stop="toggleFavorite('service', {{ $service->id }})"
                                    :class="isFavorite('service', {{ $service->id }}) ? 'text-red-400' : 'text-white'"
                                    class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                    title="{{ __('Add to Favorites') }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('service', {{ $service->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-[var(--gold)] text-xl"></i>
                            @else
                                <div class="w-10 h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="star" class="w-5 h-5 text-[var(--gold)]" />
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-[var(--text-heading)]">{{ $service->name }}</h3>
                        </div>
                        <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($service->description, 120) }}</p>
                        <a href="{{ route('service.show', $service->slug) }}" class="inline-flex items-center gap-2 text-[var(--gold)] font-bold text-sm group-hover:gap-3 transition-all">
                            {{ __('Read More') }} <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <x-icon name="star" class="w-16 h-16 text-[var(--text-light)] inline-block mb-4" />
                    <p class="text-[var(--text-light)] text-xl">{{ __('No services available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-[var(--gold)]">
    <div class="container mx-auto px-4 text-center">
        <h2 data-aos="fade-up" class="text-3xl md:text-4xl font-black text-white mb-4">{{ __('Consult us today') }}</h2>
        <p data-aos="fade-up" data-aos-delay="100" class="text-white/80 text-lg mb-8">{{ __('We are here to help you choose the right service for your project') }}</p>
        <a data-aos="fade-up" data-aos-delay="200" href="{{ route('contact') }}" class="btn-light inline-flex items-center px-8 py-3 rounded-lg font-bold hover:shadow-2xl transition-all hover:scale-105">
            <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('Contact us') }}
        </a>
    </div>
</section>

@endsection