@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
    $settings = App\Models\Setting::all()->pluck('value', 'key')->toArray();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $settings['about_meta_description'] ?? __('We are a leading interior design and decoration company, combining modern elegance with authentic Arabic touches.') }}">
<meta name="keywords" content="{{ $settings['about_meta_keywords'] ?? __('About Us') . ', ' . __('Smart Designer Decorations') . ', ' . __('Design') }}">
<meta property="og:title" content="{{ $settings['about_meta_title'] ?? __('About Us') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ $settings['about_meta_description'] ?? __('Who We Are') }}">
@endpush

@section('title', ($settings['about_meta_title'] ?? __('About Us')) . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative py-24 md:py-32 flex items-center justify-center overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 30% 50%, var(--stone) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--stone) 0%, transparent 50%);"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ $settings['about_title'] ?? __('About Us') }}</h1>
        @if(!empty($settings['about_subtitle']))
            <p data-aos="fade-up" data-aos-delay="50" class="text-[var(--gold)] text-lg font-medium mb-2">{{ $settings['about_subtitle'] }}</p>
        @endif
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-light)] text-lg max-w-3xl mx-auto">{{ $settings['about_description'] ?? __('We are a leading interior design and decoration company, combining modern elegance with authentic Arabic touches.') }}</p>
    </div>
</section>

{{-- Company Story --}}
<section class="py-12 md:py-20 relative z-10">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center">
            <div data-aos="fade-left">
                <span class="section-label">{{ $settings['about_story_label'] ?? __('Our Story') }}</span>
                <h2 class="text-3xl md:text-5xl font-black text-[var(--gold)] mt-2 mb-6">{{ __('Who We Are') }}</h2>
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
                <div class="rounded-2xl overflow-hidden h-64 md:h-96 border border-[var(--stone)]/20">
                    @if(!empty($settings['about_image']))
                        {!! \App\Services\ImageService::picture($settings['about_image'], $settings['about_title'] ?? __('About Us'), 'w-full h-full object-cover') !!}
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--gold)] to-[var(--gold)]">
                            <div class="text-center text-white p-8">
                                <x-icon name="star" class="w-16 h-16 inline-block mb-4 opacity-50" />
                                <p class="text-2xl font-bold">{{ __('Smart Designer Decorations') }}</p>
                                <p class="text-lg opacity-80">{{ __('Where creativity meets elegance') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-4 -left-4 w-24 h-24 md:w-32 md:h-32 bg-[var(--gold)] rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- Vision, Mission, Values --}}
<section class="py-12 md:py-20 relative z-10 border-y border-[var(--glass-border)] bg-[var(--glass-bg)] backdrop-blur-sm">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-6 md:gap-8">
            <div data-aos="fade-up" class="card-elegant p-5 md:p-8 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="star" class="w-8 h-8 md:w-10 md:h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-[var(--gold)] mb-3 md:mb-4">{{ $settings['about_vision_title'] ?? __('Our Vision') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)] leading-relaxed">{{ $settings['about_vision_text'] ?? '' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="card-elegant p-5 md:p-8 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="check" class="w-8 h-8 md:w-10 md:h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-[var(--gold)] mb-3 md:mb-4">{{ $settings['about_mission_title'] ?? __('Our Mission') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)] leading-relaxed">{{ $settings['about_mission_text'] ?? '' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="card-elegant p-5 md:p-8 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="heart" class="w-8 h-8 md:w-10 md:h-10 text-[var(--gold)]" />
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-[var(--gold)] mb-3 md:mb-4">{{ $settings['about_values_title'] ?? __('Our Values') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)] leading-relaxed">{{ $settings['about_values_text'] ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-12 md:py-20 relative overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 opacity-5" style="background: radial-gradient(circle at 20% 50%, var(--stone) 0%, transparent 50%), radial-gradient(circle at 80% 50%, var(--stone) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div data-aos="fade-up" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_years'] ?? '10+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_years_label'] ?? __('Years of Experience') }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_projects'] ?? '100+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_projects_label'] ?? __('Completed Projects') }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_clients'] ?? '50+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_clients_label'] ?? __('Happy Clients') }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300" class="text-center">
                <div class="stat-number">{{ $settings['about_stat_awards'] ?? '20+' }}</div>
                <p class="text-[var(--text-light)] text-lg mt-2">{{ $settings['about_stat_awards_label'] ?? __('Awards') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-[var(--gold)] relative z-20">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $settings['about_cta_title'] ?? __('Ready to get started?') }}</h2>
            <p class="text-white/80 text-lg mb-8">{{ $settings['about_cta_text'] ?? __('Let us transform your space into a masterpiece') }}</p>
            <a href="{{ route('contact') }}" class="btn-light inline-flex items-center px-8 py-3 rounded-lg font-bold">
                <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ $settings['about_cta_button'] ?? __('Contact us today') }}
            </a>
        </div>
    </div>
</section>

@endsection