@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
    $settings = App\Models\Setting::all()->pluck('value', 'key')->toArray();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $settings['about_meta_description'] ?? 'ديكورات المصمم الذكي - شركة رائدة في التصميم الداخلي والديكور في المملكة العربية السعودية. نتميز بخبرة تتجاوز 10 سنوات في تقديم حلول ديكور مبتكرة تجمع بين الأناقة العصرية واللمسات العربية الأصيلة.' }}">
<meta name="keywords" content="{{ $settings['about_meta_keywords'] ?? 'عن الشركة, ديكورات المصمم الذكي, تصميم داخلي, ديكور, الرياض' }}">
<meta property="og:title" content="{{ $settings['about_meta_title'] ?? 'عن الشركة - ديكورات المصمم الذكي' }}">
<meta property="og:description" content="{{ $settings['about_meta_description'] ?? 'شركة رائدة في التصميم الداخلي والديكور' }}">
@endpush

@section('title', ($settings['about_meta_title'] ?? 'عن الشركة') . ' - ديكورات المصمم الذكي')

@section('content')

{{-- Hero --}}
<section class="relative py-32 flex items-center justify-center overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 30% 50%, var(--stone) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--stone) 0%, transparent 50%);"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-5xl md:text-6xl font-black text-white mb-4">{{ $settings['about_title'] ?? 'عن الشركة' }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-light)] text-lg max-w-3xl mx-auto">{{ $settings['about_description'] ?? 'نحن شركة رائدة في مجال التصميم الداخلي والديكور، نجمع بين الأناقة العصرية واللمسات العربية الأصيلة' }}</p>
    </div>
</section>

{{-- Company Story --}}
<section class="py-20 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-left">
                <span class="section-label">{{ $settings['about_story_label'] ?? 'قصتنا' }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-[var(--gold)] mt-2 mb-6">من نحن</h2>
                <div class="section-divider mb-6"></div>
                @if(!empty($settings['about_story_1']))
                    <p class="text-[var(--text-light)] leading-relaxed mb-4">{{ $settings['about_story_1'] }}</p>
                @endif
                @if(!empty($settings['about_story_2']))
                    <p class="text-[var(--text-light)] leading-relaxed mb-4">{{ $settings['about_story_2'] }}</p>
                @endif
                @if(!empty($settings['about_story_3']))
                    <p class="text-[var(--text-light)] leading-relaxed">{{ $settings['about_story_3'] }}</p>
                @endif
            </div>
            <div data-aos="fade-right" class="relative">
                <div class="rounded-2xl overflow-hidden h-96 border border-[var(--stone)]/20">
                    @if(!empty($settings['about_image']))
                        <img src="{{ asset('storage/' . $settings['about_image']) }}" alt="{{ $settings['about_title'] ?? 'عن الشركة' }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--gold)] to-[var(--gold)]">
                            <div class="text-center text-white p-8">
                                <x-icon name="star" class="w-16 h-16 inline-block mb-4 opacity-50" />
                                <p class="text-2xl font-bold">ديكورات المصمم الذكي</p>
                                <p class="text-lg opacity-80">حيث يلتقي الإبداع مع الأناقة</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-[var(--gold)] rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- Vision, Mission, Values --}}
<section class="py-20 bg-[var(--white)]">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <div data-aos="fade-up" class="card-elegant p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="star" class="w-10 h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-4">{{ $settings['about_vision_title'] ?? 'رؤيتنا' }}</h3>
                <p class="text-[var(--text-light)] leading-relaxed">{{ $settings['about_vision_text'] ?? 'أن نكون الرواد في مجال التصميم الداخلي والديكور في المنطقة، ونضع معايير جديدة للابتكار والجودة' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="card-elegant p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="check" class="w-10 h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-4">{{ $settings['about_mission_title'] ?? 'رسالتنا' }}</h3>
                <p class="text-[var(--text-light)] leading-relaxed">{{ $settings['about_mission_text'] ?? 'تقديم حلول تصميم مبتكرة ومستدامة تتجاوز توقعات عملائنا، مع الالتزام بأعلى معايير الجودة والاحترافية' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="card-elegant p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="heart" class="w-10 h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-4">{{ $settings['about_values_title'] ?? 'قيمنا' }}</h3>
                <p class="text-[var(--text-light)] leading-relaxed">{{ $settings['about_values_text'] ?? 'الإبداع، الجودة، النزاهة، العمل الجماعي، والتركيز على تحقيق رضا العملاء في كل مشروع' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-20 relative overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 opacity-5" style="background: radial-gradient(circle at 20% 50%, var(--stone) 0%, transparent 50%), radial-gradient(circle at 80% 50%, var(--stone) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div data-aos="fade-up" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_years'] ?? '10+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_years_label'] ?? 'سنوات خبرة' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_projects'] ?? '100+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_projects_label'] ?? 'مشروع مكتمل' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_clients'] ?? '50+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_clients_label'] ?? 'عميل سعيد' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_awards'] ?? '20+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_awards_label'] ?? 'جائزة وتكريم' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-[var(--gold)]">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $settings['about_cta_title'] ?? 'هل أنت مستعد للبدء؟' }}</h2>
            <p class="text-white/80 text-lg mb-8">{{ $settings['about_cta_text'] ?? 'دعنا نحول مساحتك إلى تحفة فنية' }}</p>
            <a href="{{ route('contact') }}" class="btn-light inline-flex items-center px-8 py-3 rounded-lg font-bold">
                <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ $settings['about_cta_button'] ?? 'تواصل معنا اليوم' }}
            </a>
        </div>
    </div>
</section>

@endsection
