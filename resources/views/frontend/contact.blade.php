@php
    $contacts = App\Models\Contact::where('is_active', true)->get();
    $mapUrl = App\Models\Setting::getValue('map_url', '');
    $email = App\Models\Setting::getValue('email', 'info@smart-designer.com');
    $phone = App\Models\Setting::getValue('phone', '+966 50 000 0000');
    $address = App\Models\Setting::getValue('address', 'الرياض، المملكة العربية السعودية');
    $fallbackMap = 'https://maps.google.com/maps?q=' . urlencode($address) . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
    $mapEmbedSrc = $mapUrl ? (str_contains($mapUrl, '/maps/embed') ? $mapUrl : $fallbackMap) : $fallbackMap;
@endphp

@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Contact Us') }} - {{ __('Smart Designer Decorations') }}. {{ __('Get in Touch') }}">
<meta name="keywords" content="{{ __('Contact Us') }}, ديكور, تصميم داخلي, الرياض">
<meta property="og:title" content="{{ __('Contact Us') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Get in Touch') }}">
@endpush

@section('title', __('Contact Us') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative py-24 md:py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="overlay-gradient"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Contact Us') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-muted)] text-lg max-w-2xl mx-auto">{{ __('Get in Touch') }}</p>
    </div>
</section>

{{-- Contact Info Cards --}}
<section class="py-12 md:py-16 -mt-12 md:-mt-16 relative z-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <a href="{{ $mapUrl ?: 'https://www.google.com/maps?q=' . urlencode($address) }}" target="_blank" rel="noopener noreferrer" class="card-elegant p-5 md:p-8 text-center block hover:scale-[1.02] transition-all duration-300">
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="location" class="w-6 h-6 md:w-8 md:h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-base md:text-lg font-bold text-[var(--gold)] mb-1 md:mb-2">{{ __('Address') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)]">{{ $address }}</p>
            </a>
            <a href="mailto:{{ $email }}" target="_blank" rel="noopener noreferrer" class="card-elegant p-5 md:p-8 text-center block hover:scale-[1.02] transition-all duration-300">
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="email" class="w-6 h-6 md:w-8 md:h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-base md:text-lg font-bold text-[var(--gold)] mb-1 md:mb-2">{{ __('Email') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)]" dir="ltr">{{ $email }}</p>
            </a>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" target="_blank" rel="noopener noreferrer" class="card-elegant p-5 md:p-8 text-center block hover:scale-[1.02] transition-all duration-300">
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="phone" class="w-6 h-6 md:w-8 md:h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-base md:text-lg font-bold text-[var(--gold)] mb-1 md:mb-2">{{ __('Phone Number') }}</h3>
                <p class="text-sm md:text-base text-[var(--text-light)]" dir="ltr">{{ $phone }}</p>
            </a>
        </div>
    </div>
</section>

{{-- Contact Form + Map --}}
<section class="py-12 md:py-16 relative z-10">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 md:gap-12">
            {{-- Form --}}
            <div data-aos="fade-left">
                <h2 class="text-2xl md:text-3xl font-black text-[var(--gold)] mb-2">{{ __('Send Us a Message') }}</h2>
                <div class="section-divider mb-6"></div>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5"
                      toolname="sendMessage"
                      tooldescription="Send a message to Smart Designer Decorations. Accepts: name (full name), email (email address), phone (mobile number), message (text). Returns: confirmation that message was sent.">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-[var(--text-heading)] mb-1">{{ __('Full Name') }}</label>
                        <input type="text" name="name" id="name" required class="input-elegant" placeholder="{{ __('Enter your full name') }}" toolparamdescription="Full name of the person sending the message">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-[var(--text-heading)] mb-1">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" required class="input-elegant" placeholder="{{ __('Email') }}" dir="ltr" toolparamdescription="Email address for reply">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-[var(--text-heading)] mb-1">{{ __('Mobile Number') }}</label>
                        <input type="tel" name="phone" id="phone" required class="input-elegant" placeholder="{{ __('Enter your mobile number') }}" dir="ltr" toolparamdescription="Contact phone number">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-bold text-[var(--text-heading)] mb-1">{{ __('Message') }}</label>
                        <textarea name="message" id="message" rows="5" required class="input-elegant resize-none" placeholder="{{ __('Write your message here...') }}" toolparamdescription="The message content"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 rounded-xl font-bold text-lg">
                        <x-icon name="paper_plane" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('Send Message') }}
                    </button>
                </form>
            </div>

            {{-- Map --}}
            <div data-aos="fade-right">
                <h2 class="text-2xl md:text-3xl font-black text-[var(--gold)] mb-2">{{ __('Our Location') }}</h2>
                <div class="section-divider mb-6"></div>
                @if($mapEmbedSrc)
                    <div class="rounded-2xl overflow-hidden h-64 md:h-96">
                        <iframe src="{{ $mapEmbedSrc }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @else
                    <div class="rounded-2xl overflow-hidden h-64 md:h-96 flex items-center justify-center bg-[var(--stone)]">
                        <div class="text-center">
                            <x-icon name="map_marked" class="w-16 h-16 text-[var(--text-muted)] inline-block mb-4" />
                            <p class="text-[var(--text-light)]">{{ __('Map not available') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Social Media --}}
<section class="py-12 md:py-16 relative z-10 border-t border-[var(--glass-border)] bg-[var(--glass-bg)] backdrop-blur-sm">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="text-2xl md:text-3xl font-black text-[var(--gold)] mb-2">{{ __('Follow us on social media') }}</h2>
            <div class="section-divider mb-4 md:mb-6"></div>
            <p class="text-sm md:text-base text-[var(--text-light)] mb-6 md:mb-8">{{ __('Stay updated with our latest work') }}</p>
            <div class="flex justify-center flex-wrap gap-3">
                @include('partials.social-icons', ['socialLinks' => $socialLinks])
            </div>
        </div>
    </div>
</section>

@endsection