@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Decoration and interior design services in all Saudi cities - Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('Areas We Serve') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Decoration and interior design services in all Saudi cities') }}">
@endpush

@section('title', __('Areas We Serve') . ' - ' . __('Smart Designer Decorations'))

@section('content')
<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Areas We Serve') }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ __('We provide decoration and interior design services in all Saudi cities') }}</p>
        </div>
    </div>
</section>

<section class="py-20 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @if($cities->count())
                @foreach($cities as $city)
                    <a href="{{ route('city.show', $city->slug) }}" data-aos="fade-up" class="group bg-white rounded-2xl overflow-hidden border border-[var(--stone)]/20 hover:shadow-xl transition-all">
                        <div class="aspect-[16/9] bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]/80 flex items-center justify-center relative">
                            <div class="absolute inset-0 opacity-[0.1]" style="background: radial-gradient(circle at 50% 50%, var(--gold) 0%, transparent 70%);"></div>
                            <div class="text-center relative z-10">
                                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                                    <i class="fas fa-city text-2xl text-[var(--gold)]"></i>
                                </div>
                                <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ $city->name }}</h2>
                                <p class="text-[var(--text-light)] text-sm mt-2">{{ $city->description ?? __('Decoration and design services') }}</p>
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <span class="inline-flex items-center gap-2 text-sm text-[var(--gold)] font-bold">
                                {{ __('View Details') }} <i class="fas fa-arrow-left text-xs"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            @endif
            @if($cities->count() < 2)
            <a href="{{ route('city.jeddah') }}" data-aos="fade-up" class="group bg-white rounded-2xl overflow-hidden border border-[var(--stone)]/20 hover:shadow-xl transition-all">
                <div class="aspect-[16/9] bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]/80 flex items-center justify-center relative">
                    <div class="absolute inset-0 opacity-[0.1]" style="background: radial-gradient(circle at 50% 50%, var(--gold) 0%, transparent 70%);"></div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                            <i class="fas fa-city text-2xl text-[var(--gold)]"></i>
                        </div>
                        <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Jeddah Decorations') }}</h2>
                        <p class="text-[var(--text-light)] text-sm mt-2">{{ __('Decoration and design services in Jeddah') }}</p>
                    </div>
                </div>
                <div class="p-6">
                    @if($jeddahServices->count())
                        <p class="text-sm font-bold text-[var(--text-heading)] mb-2">{{ __('Available Services') }}:</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($jeddahServices as $s)
                                <span class="text-xs px-3 py-1 bg-[var(--gold)]/10 text-[var(--gold)] rounded-full">{{ $s->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($jeddahProjects->count())
                        <p class="text-sm text-[var(--text-secondary)]">{{ __('Recent projects') }}: {{ $jeddahProjects->count() }} {{ __('projects') }}</p>
                    @endif
                    <div class="mt-3 text-[var(--gold)] font-bold text-sm group-hover:translate-x-2 transition-transform">
                        {{ __('Explore Jeddah') }} <i class="fas fa-arrow-left mr-1"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('city.mecca') }}" data-aos="fade-up" data-aos-delay="100" class="group bg-white rounded-2xl overflow-hidden border border-[var(--stone)]/20 hover:shadow-xl transition-all">
                <div class="aspect-[16/9] bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]/80 flex items-center justify-center relative">
                    <div class="absolute inset-0 opacity-[0.1]" style="background: radial-gradient(circle at 50% 50%, var(--gold) 0%, transparent 70%);"></div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                            <i class="fas fa-mosque text-2xl text-[var(--gold)]"></i>
                        </div>
                        <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Mecca Decorations') }}</h2>
                        <p class="text-[var(--text-light)] text-sm mt-2">{{ __('Decoration and design services in Mecca') }}</p>
                    </div>
                </div>
                <div class="p-6">
                    @if($meccaServices->count())
                        <p class="text-sm font-bold text-[var(--text-heading)] mb-2">{{ __('Available Services') }}:</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($meccaServices as $s)
                                <span class="text-xs px-3 py-1 bg-[var(--gold)]/10 text-[var(--gold)] rounded-full">{{ $s->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($meccaProjects->count())
                        <p class="text-sm text-[var(--text-light)]">{{ __('Recent projects') }}: {{ $meccaProjects->count() }} {{ __('projects') }}</p>
                    @endif
                    <div class="mt-3 text-[var(--gold)] font-bold text-sm group-hover:translate-x-2 transition-transform">
                        {{ __('Explore Mecca') }} <i class="fas fa-arrow-left mr-1"></i>
                    </div>
                </div>
            </a>
            @endif
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-12">
            <h2 class="text-3xl font-black text-[var(--text-heading)]">{{ __('Neighborhoods We Serve') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @if($cities->count())
                @foreach($cities as $city)
                    @php $cityNeighborhoods = $city->neighborhoods()->where('is_active', true)->orderBy('sort_order')->get(); @endphp
                    <div>
                        <h3 class="text-xl font-bold text-[var(--gold)] mb-4 flex items-center gap-2">
                            <i class="fas fa-city"></i> {{ $city->name }}
                        </h3>
                        @if($cityNeighborhoods->count())
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($cityNeighborhoods as $n)
                                    <a href="{{ route('area.show', $n->slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-[var(--navy)]/5 hover:bg-[var(--gold)]/10 text-[var(--text-heading)] hover:text-[var(--gold)] transition-all text-sm">
                                        <i class="fas fa-map-pin text-[10px] text-[var(--gold)]"></i>
                                        <span>{{ $n->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-[var(--text-light)] text-sm">{{ __('No neighborhoods listed yet') }}</p>
                        @endif
                    </div>
                @endforeach
            @else
                <div>
                    <h3 class="text-xl font-bold text-[var(--gold)] mb-4 flex items-center gap-2"><i class="fas fa-city"></i> {{ __('Jeddah') }}</h3>
                    @if($jeddahNeighborhoods->count())
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($jeddahNeighborhoods as $n)
                                <a href="{{ route('area.show', $n->slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-[var(--navy)]/5 hover:bg-[var(--gold)]/10 text-[var(--text-heading)] hover:text-[var(--gold)] transition-all text-sm">
                                    <i class="fas fa-map-pin text-[10px] text-[var(--gold)]"></i>
                                    <span>{{ $n->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[var(--text-light)] text-sm">{{ __('No neighborhoods listed yet') }}</p>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-bold text-[var(--gold)] mb-4 flex items-center gap-2"><i class="fas fa-mosque"></i> {{ __('Mecca') }}</h3>
                    @if($meccaNeighborhoods->count())
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($meccaNeighborhoods as $n)
                                <a href="{{ route('area.show', $n->slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-[var(--navy)]/5 hover:bg-[var(--gold)]/10 text-[var(--text-heading)] hover:text-[var(--gold)] transition-all text-sm">
                                    <i class="fas fa-map-pin text-[10px] text-[var(--gold)]"></i>
                                    <span>{{ $n->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[var(--text-light)] text-sm">{{ __('No neighborhoods listed yet') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-4xl text-center">
        <div data-aos="fade-up">
            <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-4">{{ __('More cities coming soon') }}</h2>
            <p class="text-[var(--text-secondary)]">{{ __('We are expanding our services to cover more Saudi cities. Contact us to inquire about services in your area.') }}</p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                @foreach($cities as $city)
                    <a href="{{ route('city.show', $city->slug) }}" class="px-5 py-2.5 bg-[var(--gold)]/10 text-[var(--gold)] rounded-full text-sm font-bold hover:bg-[var(--gold)] hover:text-white transition-all">
                        {{ $city->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
