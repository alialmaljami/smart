@extends('layouts.app')

@push('meta')
<meta name="description" content="أفضل خدمات الديكور والتصميم الداخلي في جدة - المصمم الذكي للديكور. ديكورات منازل، فلل، شقق، مجالس، ومكاتب بأعلى جودة">
<meta name="keywords" content="ديكور جدة, تصميم داخلي جدة, ديكور منازل جدة, ديكور فلل جدة, مصمم ديكور جدة, أفضل شركة ديكور جدة">
<meta property="og:title" content="ديكورات جدة - المصمم الذكي للديكور">
<meta property="og:description" content="أفضل خدمات الديكور والتصميم الداخلي في جدة">
@endpush

@section('title', 'ديكورات جدة - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-24 pb-16 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-city text-2xl md:text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">ديكورات جدة</h1>
            <p class="text-[var(--text-light)] text-lg">أفضل خدمات التصميم الداخلي والديكور في جدة - المصمم الذكي للديكور</p>
        </div>
    </div>
</section>

<section class="py-12 md:py-20 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div data-aos="fade-left">
                <span class="section-label">ديكورات جدة</span>
                <h2 class="text-2xl md:text-3xl font-black text-[var(--text-heading)] mt-3 mb-4">شركة المصمم الذكي للديكور في جدة</h2>
                <p class="text-[var(--text-light)] leading-relaxed mb-6">
                    نقدم في شركة المصمم الذكي للديكور أفضل خدمات التصميم الداخلي والديكور في جدة. 
                    نمتلك فريقاً من أمهر المصممين والمهندسين المتخصصين في تنفيذ أحدث صيحات الديكور 
                    العصري والكلاسيكي. نحرص على تقديم تصاميم فريدة تناسب ذوقك وميزانيتك.
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)]"><i class="fas fa-check"></i></div>
                        <span class="text-[var(--text-light)]">تصميم وتنفيذ ديكورات المنازل والفلل</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)]"><i class="fas fa-check"></i></div>
                        <span class="text-[var(--text-light)]">ديكورات المجلس والغرف والمعيشة</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)]"><i class="fas fa-check"></i></div>
                        <span class="text-[var(--text-light)]">ديكورات المطابخ والحمامات العصرية</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)]"><i class="fas fa-check"></i></div>
                        <span class="text-[var(--text-light)]">واجهات خارجية وحدائق منزلية</span>
                    </div>
                </div>
            </div>
            <div data-aos="fade-right" class="rounded-2xl overflow-hidden h-64 md:h-96 bg-gradient-to-br from-[var(--navy)] to-[var(--navy)] flex items-center justify-center">
                <div class="text-center p-6 md:p-8">
                    <i class="fas fa-city text-4xl md:text-6xl text-[var(--gold)]/30 mb-4"></i>
                    <p class="text-white/40 text-base md:text-lg">جدة - المملكة العربية السعودية</p>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="text-center bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-[var(--stone)]">
            <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-4">احصل على استشارة مجانية في جدة</h3>
            <p class="text-[var(--text-light)] mb-8 max-w-xl mx-auto">تواصل معنا اليوم للحصول على استشارة مجانية لمشروعك في جدة</p>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">تواصل معنا</a>
        </div>
    </div>
</section>

<section class="py-12 md:py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4 max-w-5xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">خدماتنا في جدة</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <div class="card-elegant p-4 md:p-6 text-center">
                <div class="w-12 h-12 md:w-14 md:h-14 mx-auto mb-3 md:mb-4 rounded-full bg-[var(--gold)]/10 flex items-center justify-center"><i class="fas fa-home text-lg md:text-xl text-[var(--gold)]"></i></div>
                <h3 class="font-bold text-[var(--text-heading)] mb-1 md:mb-2">ديكورات منازل</h3>
                <p class="text-[var(--text-light)] text-sm">تصميم داخلي عصري للمنازل والشقق السكنية</p>
            </div>
            <div class="card-elegant p-4 md:p-6 text-center">
                <div class="w-12 h-12 md:w-14 md:h-14 mx-auto mb-3 md:mb-4 rounded-full bg-[var(--gold)]/10 flex items-center justify-center"><i class="fas fa-building text-lg md:text-xl text-[var(--gold)]"></i></div>
                <h3 class="font-bold text-[var(--text-heading)] mb-1 md:mb-2">ديكورات فلل</h3>
                <p class="text-[var(--text-light)] text-sm">تصاميم فاخرة للفلل والقصور في جدة</p>
            </div>
            <div class="card-elegant p-4 md:p-6 text-center">
                <div class="w-12 h-12 md:w-14 md:h-14 mx-auto mb-3 md:mb-4 rounded-full bg-[var(--gold)]/10 flex items-center justify-center"><i class="fas fa-briefcase text-lg md:text-xl text-[var(--gold)]"></i></div>
                <h3 class="font-bold text-[var(--text-heading)] mb-1 md:mb-2">ديكورات مكاتب</h3>
                <p class="text-[var(--text-light)] text-sm">تصميم مكاتب وشركات بأعلى معايير الاحترافية</p>
            </div>
        </div>
    </div>
</section>

@if($services->count())
<section class="py-12 md:py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Services') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($services as $s)
                <a href="{{ route('service.show', $s->slug) }}" class="card-elegant p-4 md:p-6 text-center group hover:shadow-lg transition-all">
                    <div class="w-10 h-10 md:w-14 md:h-14 mx-auto mb-3 md:mb-4 rounded-full bg-[var(--gold)]/10 flex items-center justify-center group-hover:bg-[var(--gold)] group-hover:text-white transition-all">
                        <i class="{{ $s->icon ?: 'fas fa-paint-roller' }} text-base md:text-xl text-[var(--gold)] group-hover:text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)] mb-1 md:mb-2">{{ $s->name }}</h3>
                    <p class="text-[var(--text-secondary)] text-xs md:text-sm">{{ Str::limit($s->description, 80) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($galleries->count())
<section class="py-12 md:py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Gallery') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($galleries as $g)
                <a href="{{ route('gallery.show', [$g->id, $g->slug]) }}" class="group aspect-square overflow-hidden rounded-xl">
                    <img src="{{ asset('storage/' . $g->image) }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($projects->count())
<section class="py-12 md:py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Recent Projects') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            @foreach($projects as $p)
                <a href="{{ route('project.show', $p->slug) }}" class="card-elegant group overflow-hidden">
                    @if($p->image)
                        <div class="aspect-[16/10] overflow-hidden">
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)]">{{ $p->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-12 md:py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="section-title text-[var(--text-heading)] mb-4">أعمالنا في جدة</h2>
            <div class="section-divider mb-8"></div>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>

@endsection
