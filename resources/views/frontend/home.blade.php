@php
    $hero = $sections['hero'] ?? null;
    $servicesHeader = $sections['services'] ?? null;
    $projectsHeader = $sections['projects'] ?? null;
    $whyUs = $sections['why_us'] ?? null;
    $stats = $sections['stats'] ?? null;
    $cta = $sections['cta'] ?? null;
    $heroBg = App\Models\Setting::getValue('home_hero_bg', '');

    // Hero images: from extra['images'] array, or fallback to single hero image
    $heroImages = [];
    if($hero) {
        $extraImages = $hero->extra['images'] ?? [];
        if(!empty($extraImages)) {
            foreach($extraImages as $img) {
                $heroImages[] = asset('storage/' . $img);
            }
        }
        if(empty($heroImages) && $hero->image) {
            $heroImages[] = asset('storage/' . $hero->image);
        }
        if(empty($heroImages) && $heroBg) {
            $heroImages[] = $heroBg;
        }
    }
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Smart Designer Decorations') }} - {{ __('We are a leading interior design and decoration company, combining modern elegance with authentic Arabic touches.') }}">
<meta name="keywords" content="ديكور, تصميم داخلي, ديكورات, المصمم الذكي, الرياض, السعودية">
<meta property="og:title" content="{{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('We are a leading interior design and decoration company, combining modern elegance with authentic Arabic touches.') }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('title', __('Smart Designer Decorations'))

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList([
            ['name' => __('Home'), 'url' => route('home')],
        ]),
    ]);
@endphp
@endpush

@section('content')

@if($hero)
{{-- Hero with Multi-Image Slider --}}
<section class="relative h-screen min-h-[650px] overflow-hidden"
    @if(count($heroImages) > 1)
    x-data="{
        current: 0,
        total: {{ count($heroImages) }},
        init() { setInterval(() => { this.current = (this.current + 1) % this.total; }, 6000); }
    }"
    @endif
>
    @if(count($heroImages) > 1)
        @foreach($heroImages as $i => $heroImg)
        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
             :class="current === {{ $i }} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'">
            <img src="{{ $heroImg }}" alt="{{ __('Smart Designer Decorations - Hero Background') }}" class="w-full h-full object-cover" fetchpriority="high"
                 :style="current === {{ $i }} ? 'transform: scale(1); transition: transform 8s ease-out;' : 'transform: scale(1.08);'">
        </div>
        @endforeach
    @elseif(count($heroImages) === 1)
        <div class="absolute inset-0 z-[1]">
            <img src="{{ $heroImages[0] }}" alt="{{ __('Smart Designer Decorations - Hero Image') }}" class="w-full h-full object-cover" fetchpriority="high">
        </div>
    @else
        <div class="absolute inset-0 z-[1] bg-[var(--navy)]"></div>
    @endif

    <div class="absolute inset-0 z-[2] navy-gradient"></div>
    <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-[var(--cream)] to-transparent z-[2]"></div>
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent z-[2]"></div>

    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="text-center px-4 max-w-4xl mx-auto">
            <span data-aos="fade-up" data-aos-delay="50" class="inline-block text-[var(--gold)] font-medium text-xs tracking-[0.3em] uppercase mb-6">{{ __('Smart Designer Decorations') }}</span>
            @if($hero->title)
            <h1 data-aos="fade-up" data-aos-delay="100" class="hero-title font-black text-white mb-6">
                {!! nl2br(e($hero->title)) !!}
            </h1>
            @endif
            @if($hero->subtitle)
            <p data-aos="fade-up" data-aos-delay="150" class="text-base md:text-lg text-white/50 mb-10 font-light leading-relaxed max-w-2xl mx-auto">
                {{ $hero->subtitle }}
            </p>
            @endif
            <div data-aos="fade-up" data-aos-delay="200" class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if($hero->button_text)
                <a href="{{ $hero->button_url ?? route('services') }}" class="btn-primary text-xs px-8 py-3.5 gold-pulse">
                    {{ $hero->button_text }}
                </a>
                @endif
                @if($hero->button_text_2)
                <a href="{{ $hero->button_url_2 ?? route('contact') }}" class="btn-outline text-xs px-8 py-3.5">
                    {{ $hero->button_text_2 }}
                </a>
                @endif
            </div>
        </div>
    </div>

    @if(count($heroImages) > 1)
    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-40 flex items-center gap-2">
        @foreach($heroImages as $i => $heroImg)
        <button @click="current = {{ $i }}" class="group">
            <span class="block rounded-full transition-all duration-500"
                  :class="current === {{ $i }} ? 'w-8 h-2.5 bg-[var(--gold)] shadow-[0_0_12px_rgba(234,179,8,0.5)]' : 'w-2.5 h-2.5 bg-white/30 hover:bg-white/50'"></span>
        </button>
        @endforeach
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 z-40 bg-white/5">
        <div class="h-full bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)]" style="animation: heroProgress 6s linear infinite;"></div>
    </div>
    @endif

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce z-30">
        <x-icon name="chevron_down" class="w-5 h-5 text-[var(--gold)]" />
    </div>
</section>
@endif

{{-- Services Carousel --}}
<section class="py-24 md:py-32">
    <div class="container-wide">
        <div data-aos="fade-up" class="text-center mb-16">
            <span class="section-label">{{ __('Our Services') }}</span>
            <h2 class="section-title">{{ $servicesHeader->title ?? __('What We Offer') }}</h2>
            <div class="section-divider"></div>
            @if($servicesHeader && $servicesHeader->subtitle)
            <p class="text-[var(--text-light)] max-w-2xl mx-auto mt-4 text-base leading-relaxed">{{ $servicesHeader->subtitle }}</p>
            @endif
        </div>

        <div data-aos="fade-up" x-data="{
            init() { this.c = this.$refs.strack; },
            c: null,
            sl() { this.c.scrollBy({ left: -340, behavior: 'smooth' }); },
            sr() { this.c.scrollBy({ left: 340, behavior: 'smooth' }); }
        }" class="relative group/carousel">
            <button @click="sl()" class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="sr()" class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-ref="strack" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 snap-x snap-mandatory" style="-ms-overflow-style: none; scrollbar-width: none;">
                @foreach($services as $service)
                    <div class="flex-shrink-0 w-[300px] snap-start card-elegant group">
                        @if($service->image)
                            <div class="img-zoom h-48">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="p-6">
                            @if(!$service->image)
                            <div class="w-12 h-12 mb-4 rounded-xl bg-[var(--gold)]/10 flex items-center justify-center group-hover:bg-[var(--gold)] transition-all duration-300">
                                @if($service->icon)
                                    <i class="{{ $service->icon }} text-lg text-[var(--gold)] group-hover:text-white transition-colors"></i>
                                @else
                                    <x-icon name="paint_roller" class="w-5 h-5 text-[var(--gold)] group-hover:text-white transition-colors" />
                                @endif
                            </div>
                            @endif
                            <h3 class="text-lg font-bold text-[var(--text-heading)] mb-3">{{ $service->name }}</h3>
                            <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($service->description, 100) }}</p>
                            <a href="{{ route('service.show', $service->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                {{ __('Read More') }} <x-icon name="arrow_left" class="w-3.5 h-3.5 mr-1.5" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" class="text-center mt-14">
            <a href="{{ route('services') }}" class="btn-outline">
                {{ __('View All Services') }} <x-icon name="arrow_left" class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>

{{-- Projects Carousel --}}
<section class="py-24 md:py-32 relative z-10">
    <div class="container-wide">
        <div data-aos="fade-up" class="text-center mb-16">
            <span class="section-label">{{ __('Our Projects') }}</span>
            <h2 class="section-title">{{ $projectsHeader->title ?? __('Our Latest Projects') }}</h2>
            <div class="section-divider"></div>
            @if($projectsHeader && $projectsHeader->subtitle)
            <p class="text-[var(--text-light)] max-w-2xl mx-auto mt-4 text-base">{{ $projectsHeader->subtitle }}</p>
            @endif
        </div>

        <div data-aos="fade-up" x-data="{
            init() { this.c = this.$refs.ptrack; },
            c: null,
            sl() { this.c.scrollBy({ left: -420, behavior: 'smooth' }); },
            sr() { this.c.scrollBy({ left: 420, behavior: 'smooth' }); }
        }" class="relative group/carousel">
            <button @click="sl()" class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="sr()" class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-ref="ptrack" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 snap-x snap-mandatory" style="-ms-overflow-style: none; scrollbar-width: none;">
                @foreach($projects as $project)
                    @php $image = is_array($project->images) ? ($project->images[0] ?? '') : $project->images; @endphp
                    <div class="flex-shrink-0 w-[400px] snap-start group relative rounded-[var(--radius-lg)] overflow-hidden img-zoom h-80 border border-[var(--glass-border)] bg-transparent">
                        <img src="{{ $image ? asset('storage/' . $image) : '' }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-4 left-4 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1.5 px-2.5 py-1.5 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all text-xs">
                                <i class="fas fa-heart text-xs" :class="liked ? 'text-red-400' : 'text-white/70'"></i>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <div class="absolute bottom-0 right-0 left-0 p-6">
                            <h3 class="text-lg font-bold text-white mb-1">{{ $project->title }}</h3>
                            @if($project->client_name)
                                <span class="text-white/50 text-xs flex items-center gap-1.5"><x-icon name="user" class="w-3 h-3 text-[var(--gold)]" /> {{ $project->client_name }}</span>
                            @endif
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/90 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm">
                            <span class="text-white text-xs font-semibold border-2 border-white/80 px-6 py-2.5 rounded-xl inline-flex items-center gap-2 uppercase tracking-wider">
                                <x-icon name="eye" class="w-4 h-4" /> {{ __('View Project') }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" class="text-center mt-14">
            <a href="{{ route('projects') }}" class="btn-outline">
                {{ __('View All Projects') }} <x-icon name="arrow_left" class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>

@if($whyUs)
{{-- Why Us --}}
@php $whyItems = $whyUs->extra['items'] ?? []; @endphp
@if(count($whyItems))
<section class="py-24 md:py-32">
    <div class="container-wide">
        <div data-aos="fade-up" class="text-center mb-16">
            <span class="section-label">{{ __('Why Us') }}</span>
            <h2 class="section-title">{{ $whyUs->title ?? __('Why Choose Smart Designer') }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($whyItems as $i => $item)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 80 }}" class="card-elegant p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-[var(--gold)]/5 flex items-center justify-center">
                        <i class="{{ $item['icon'] ?? 'fas fa-check' }} text-2xl text-[var(--gold)]"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[var(--text-heading)] mb-3">{{ $item['title'] ?? '' }}</h3>
                    <p class="text-[var(--text-light)] text-sm leading-relaxed">{{ $item['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endif

@include('partials.reviews-section')

@if($stats)
{{-- Stats --}}
@php $statItems = $stats->extra['items'] ?? []; @endphp
@if(count($statItems))
<section class="py-24 md:py-32 relative overflow-hidden border-y border-[var(--glass-border)] bg-[var(--glass-bg)] backdrop-blur-sm">
    <div class="absolute inset-0 opacity-[0.03]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container-wide relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
            @foreach($statItems as $i => $item)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 80 }}" class="text-center">
                    <div class="stat-number">{{ $item['number'] ?? '0' }}</div>
                    <p class="text-white/40 text-sm mt-2 tracking-wide uppercase text-xs">{{ $item['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endif

@if($cta)
{{-- CTA --}}
<section class="py-24 md:py-32 relative z-10">
    <div class="container-wide text-center">
        <div data-aos="fade-up">
            @if($cta->title)
            <h2 class="section-title mb-4">{{ $cta->title }}</h2>
            @endif
            @if($cta->subtitle)
            <p class="text-[var(--text-light)] text-lg mb-10 max-w-xl mx-auto font-light">{{ $cta->subtitle }}</p>
            @endif
            @if($cta->button_text)
            <a href="{{ $cta->button_url ?? route('contact') }}" class="btn-primary text-xs px-10 py-3.5">
                {{ $cta->button_text }}
            </a>
            @endif
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endpush
