@php
    $contacts = App\Models\Contact::where('is_active', true)->get();
    $mapUrl = App\Models\Setting::getValue('map_url', '');
    $email = App\Models\Setting::getValue('email', 'info@smart-designer.com');
    $phone = App\Models\Setting::getValue('phone', '+966 50 000 0000');
    $address = App\Models\Setting::getValue('address', 'الرياض، المملكة العربية السعودية');
@endphp

@php
    $socialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="اتصل بنا - ديكورات المصمم الذكي. تواصل معنا لاستفساراتك واستشاراتك في مجال الديكور والتصميم الداخلي.">
<meta name="keywords" content="اتصل بنا, ديكور, تصميم داخلي, استشارات ديكور, الرياض, المملكة العربية السعودية">
<meta property="og:title" content="اتصل بنا - ديكورات المصمم الذكي">
<meta property="og:description" content="تواصل معنا لاستفساراتك واستشاراتك في مجال الديكور والتصميم الداخلي">
@endpush

@section('title', 'اتصل بنا - ديكورات المصمم الذكي')

@section('content')

{{-- Hero --}}
<section class="relative py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="overlay-gradient"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-5xl md:text-6xl font-black text-white mb-4">اتصل بنا</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-muted)] text-lg max-w-2xl mx-auto">نحن هنا للإجابة على جميع استفساراتكم وتقديم المساعدة</p>
    </div>
</section>

{{-- Contact Info Cards --}}
<section class="py-16 bg-[var(--cream)] -mt-16 relative z-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div data-aos="fade-up" class="card-elegant p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="location" class="w-8 h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-lg font-bold text-[var(--gold)] mb-2">العنوان</h3>
                <p class="text-[var(--text-light)]">{{ $address }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="card-elegant p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="email" class="w-8 h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-lg font-bold text-[var(--gold)] mb-2">البريد الإلكتروني</h3>
                <p class="text-[var(--text-light)]" dir="ltr">{{ $email }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="card-elegant p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[var(--gold)]/10 flex items-center justify-center">
                    <x-icon name="phone" class="w-8 h-8 text-[var(--gold)]" />
                </div>
                <h3 class="text-lg font-bold text-[var(--gold)] mb-2">رقم الهاتف</h3>
                <p class="text-[var(--text-light)]" dir="ltr">{{ $phone }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Contact Form + Map --}}
<section class="py-16 bg-[var(--white)]">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12">
            {{-- Form --}}
            <div data-aos="fade-left">
                <h2 class="text-3xl font-black text-[var(--gold)] mb-2">أرسل لنا رسالة</h2>
                <div class="section-divider mb-6"></div>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-[var(--text-heading)] mb-1">الاسم كامل</label>
                        <input type="text" name="name" id="name" required class="input-elegant" placeholder="أدخل اسمك الكامل">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-[var(--text-heading)] mb-1">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" required class="input-elegant" placeholder="أدخل بريدك الإلكتروني" dir="ltr">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-[var(--text-heading)] mb-1">رقم الجوال</label>
                        <input type="tel" name="phone" id="phone" required class="input-elegant" placeholder="أدخل رقم جوالك" dir="ltr">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-bold text-[var(--text-heading)] mb-1">الرسالة</label>
                        <textarea name="message" id="message" rows="5" required class="input-elegant resize-none" placeholder="اكتب رسالتك هنا..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 rounded-xl font-bold text-lg">
                        <x-icon name="paper_plane" class="w-5 h-5 inline-block ml-2 align-middle" /> إرسال الرسالة
                    </button>
                </form>
            </div>

            {{-- Map --}}
            <div data-aos="fade-right">
                <h2 class="text-3xl font-black text-[var(--gold)] mb-2">موقعنا</h2>
                <div class="section-divider mb-6"></div>
                @if($mapUrl)
                    <div class="rounded-2xl overflow-hidden h-96">
                        <iframe src="{{ $mapUrl }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @else
                    <div class="rounded-2xl overflow-hidden h-96 flex items-center justify-center bg-[var(--stone)]">
                        <div class="text-center">
                            <x-icon name="map_marked" class="w-16 h-16 text-[var(--text-muted)] inline-block mb-4" />
                            <p class="text-[var(--text-light)]">الخريطة غير متوفرة حالياً</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Social Media --}}
<section class="py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="text-3xl font-black text-[var(--gold)] mb-2">تابعنا على وسائل التواصل</h2>
            <div class="section-divider mb-6"></div>
            <p class="text-[var(--text-light)] mb-8">كن على اطلاع بأحدث أعمالنا وعروضنا</p>
            <div class="flex justify-center space-x-4 space-x-reverse flex-wrap gap-4">
                @include('partials.social-icons', ['socialLinks' => $socialLinks])
            </div>
        </div>
    </div>
</section>

@endsection
