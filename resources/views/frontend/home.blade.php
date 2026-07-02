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
                $heroImages[] = \App\Services\ImageService::asset($img);
            }
        }
        if(empty($heroImages) && $hero->image) {
            $heroImages[] = \App\Services\ImageService::asset($hero->image);
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
<section class="relative h-screen min-h-[500px] md:min-h-[650px] overflow-hidden group"
    @if(count($heroImages) > 1)
    x-data="{
        current: 0,
        total: {{ count($heroImages) }},
        paused: false,
        interval: null,
        startTimer() {
            this.interval = setInterval(() => {
                if (!this.paused) this.current = (this.current + 1) % this.total;
            }, 6000);
        },
        init() { this.startTimer(); },
        destroy() { if (this.interval) clearInterval(this.interval); }
    }"
    @@mouseenter="paused = true"
    @@mouseleave="paused = false"
    @endif
>
    @if(count($heroImages) > 1)
        @foreach($heroImages as $i => $heroImg)
        <div class="absolute inset-0 transition-all duration-1000 ease-in-out"
             :class="current === {{ $i }} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'">
            <img src="{{ $heroImg }}" alt="{{ __('Smart Designer Decorations - Hero Background') }}" width="1920" height="1080" class="w-full h-full object-cover hero-zoom" fetchpriority="high" decoding="async"
                 :class="current === {{ $i }} ? 'hero-zoom-active' : ''">
        </div>
        @endforeach
    @elseif(count($heroImages) === 1)
        <div class="absolute inset-0 z-[1]">
            <img src="{{ $heroImages[0] }}" alt="{{ __('Smart Designer Decorations - Hero Image') }}" width="1920" height="1080" class="w-full h-full object-cover hero-zoom hero-zoom-active" fetchpriority="high" decoding="async">
        </div>
    @else
        <div class="absolute inset-0 z-[1] bg-[var(--navy)]"></div>
    @endif

    <div class="absolute inset-0 z-[2] navy-gradient"></div>
    <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-[var(--cream)] to-transparent z-[2]"></div>
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent z-[2]"></div>

    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="text-center px-4 max-w-4xl mx-auto">
            <span class="inline-block text-[var(--gold)] font-medium text-xs tracking-[0.3em] uppercase mb-6">{{ __('Smart Designer Decorations') }}</span>
            @if($hero->title)
            <h1 class="hero-title font-black text-white mb-6">
                {!! nl2br(e($hero->title)) !!}
            </h1>
            @endif
            @if($hero->subtitle)
            <p class="text-base md:text-lg text-white/50 mb-10 font-light leading-relaxed max-w-2xl mx-auto">
                {{ $hero->subtitle }}
            </p>
            @endif
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
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
        <button @click="current = {{ $i }}; paused = true; setTimeout(() => { paused = false; }, 8000)" class="group">
            <span class="block rounded-full transition-all duration-500"
                  :class="current === {{ $i }} ? 'w-8 h-2.5 bg-[var(--gold)] shadow-[0_0_12px_rgba(234,179,8,0.5)]' : 'w-2.5 h-2.5 bg-white/30 hover:bg-white/50'"></span>
        </button>
        @endforeach
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 z-40 bg-white/5">
        <div class="h-full bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] progress-bar" :style="{ animationDuration: paused ? '0s' : '6s' }"></div>
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
            <button @click="sl()" class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100" aria-label="{{ __('Previous') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="sr()" class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100" aria-label="{{ __('Next') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-ref="strack" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 snap-x snap-mandatory" style="-ms-overflow-style: none; scrollbar-width: none;">
                @foreach($services as $service)
                    <div class="flex-shrink-0 w-[300px] snap-start card-elegant group">
                        @if($service->image)
                            <div class="img-zoom h-48">
                                <img src="{{ \App\Services\ImageService::asset($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover" loading="lazy">
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
            <button @click="sl()" class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100" aria-label="{{ __('Previous') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="sr()" class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-[var(--cream)] border border-[var(--stone)] shadow-xl text-[var(--text-heading)] hover:text-[var(--gold)] hover:border-[var(--gold)] transition-all flex items-center justify-center opacity-0 group-hover/carousel:opacity-100" aria-label="{{ __('Next') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-ref="ptrack" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 snap-x snap-mandatory" style="-ms-overflow-style: none; scrollbar-width: none;">
                @foreach($projects as $project)
                    @php
                        $projImages = is_array($project->images) ? array_values(array_filter($project->images)) : [];
                        $projImg = $projImages[0] ?? $project->images ?? '';
                    @endphp
                    <div class="flex-shrink-0 w-[280px] sm:w-[400px] snap-start group relative rounded-[var(--radius-lg)] overflow-hidden h-80 border border-[var(--glass-border)] bg-transparent"
                        @if(count($projImages) > 1)
                        x-data="{
                            si: 0,
                            ti: {{ count($projImages) }},
                            pi: false,
                            ini: null,
                            go() { this.ini = setInterval(() => { if (!this.pi) this.si = (this.si + 1) % this.ti; }, 4000); },
                            st() { if (this.ini) clearInterval(this.ini); },
                            init() { this.go(); },
                            destroy() { this.st(); }
                        }"
                        @@mouseenter="pi = true"
                        @@mouseleave="pi = false"
                        @endif
                    >
                        @if(count($projImages) > 1)
                            @foreach($projImages as $pi => $pimg)
                            <img src="{{ \App\Services\ImageService::asset($pimg) }}" alt="{{ $project->title }}"
                                 class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out"
                                 :class="si === {{ $pi }} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'"
                                 loading="lazy">
                            @endforeach
                            <div class="absolute top-3 right-3 z-20 flex gap-1">
                                @foreach($projImages as $pi => $pimg)
                                <button @@click.stop="si = {{ $pi }}; pi = true; setTimeout(() => pi = false, 5000)"
                                        class="w-1.5 h-1.5 rounded-full transition-all duration-300"
                                        :class="si === {{ $pi }} ? 'bg-[var(--gold)] w-3' : 'bg-white/40 hover:bg-white/70'"
                                        :aria-label="'{{ __('Project image') }} ' + ({{ $pi }} + 1)"></button>
                                @endforeach
                            </div>
                        @else
                            <img src="{{ $projImg ? \App\Services\ImageService::asset($projImg) : '' }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                        @endif
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-4 left-4 z-10" @click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1.5 px-2.5 py-1.5 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 transition-all text-xs" aria-label="{{ __('Like') }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <button type="button" @click.stop="toggleFavorite('project', {{ $project->id }})"
                                :class="isFavorite('project', {{ $project->id }}) ? 'text-red-400' : 'text-white'"
                                class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                aria-label="{{ __('Add to Favorites') }}" title="{{ __('Add to Favorites') }}">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('project', {{ $project->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                        <div class="absolute bottom-0 right-0 left-0 p-6 z-[2]">
                            <h3 class="text-lg font-bold text-white mb-1">{{ $project->title }}</h3>
                            @if(is_array($project->tags) && count($project->tags))
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($project->tags, 0, 3) as $tag)
                                        <a href="{{ route('tag', urlencode($tag)) }}" class="text-[10px] font-bold text-[var(--gold)] bg-[var(--gold)]/10 hover:bg-[var(--gold)]/20 px-2 py-0.5 rounded-full transition-colors">{{ $tag }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 z-[3] flex items-center justify-center bg-[var(--gold)]/90 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm">
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
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-[var(--gold)]/5 flex items-center justify-center text-2xl text-[var(--gold)]">
                        @php $iconName = str_replace(['fas fa-', 'far fa-', 'fab fa-'], '', $item['icon'] ?? 'check'); @endphp
                        <x-icon name="{{ $iconName }}" class="w-7 h-7" />
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
