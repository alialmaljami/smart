@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Frequently Asked Questions') }} - {{ __('Smart Designer Decorations') }}">
<meta name="keywords" content="أسئلة شائعة, ديكور, FAQ, استفسارات">
<meta property="og:title" content="{{ __('Frequently Asked Questions') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Frequently Asked Questions') }}">
@endpush

@section('title', __('Frequently Asked Questions') . ' - ' . __('Smart Designer Decorations'))

@push('schema')
@php
    $faqData = [];
    if (isset($faqs) && $faqs->count()) {
        foreach ($faqs as $f) {
            $faqData[] = ['question' => $f->question, 'answer' => $f->answer];
        }
    }
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList([
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('FAQ'), 'url' => route('faq')],
        ]),
        \App\Services\SchemaService::faqPage($faqData),
    ]);
@endphp
@endpush

@section('content')

{{-- Hero --}}
<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <span class="section-label">الأسئلة الشائعة</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">الأسئلة الأكثر شيوعاً</h1>
            <p class="text-[var(--text-light)] text-lg">تجد هنا إجابات لأبرز استفساراتكم حول خدماتنا في التصميم والتنفيذ</p>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="py-20 bg-[var(--navy)]">
    <div class="container mx-auto px-4 max-w-4xl">
        @if($faqs->count())
            @php $grouped = $faqs->groupBy('category'); @endphp
            @foreach($grouped as $category => $items)
                <div class="mb-12" data-aos="fade-up">
                    <h2 class="text-2xl font-black text-[var(--gold)] mb-6 flex items-center gap-2">
                        <i class="fas fa-tag text-sm"></i>
                        {{ $category ?: 'عام' }}
                    </h2>
                    <div class="space-y-4">
                        @foreach($items as $faq)
                            <div x-data="{ open: false }" class="card-elegant overflow-hidden">
                                <button @@click="open = !open" class="w-full text-right p-5 flex items-center justify-between gap-4 hover:bg-[var(--white)]/50 transition-colors">
                                    <span class="font-bold text-[var(--text-heading)] flex-1">{{ $faq->question }}</span>
                                    <i class="fas fa-chevron-down text-[var(--gold)] transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse>
                                    <div class="px-5 pb-5 text-[var(--text-light)] leading-relaxed border-t border-[var(--stone)]/20 pt-4">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)] flex items-center justify-center">
                    <i class="fas fa-question-circle text-4xl text-[var(--text-light)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-2">لا توجد أسئلة شائعة حالياً</h3>
                <p class="text-[var(--text-light)]">سيتم إضافة المحتوى قريباً</p>
            </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-[var(--navy)] relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto bg-[var(--cream)] rounded-2xl p-8 md:p-12 border border-[var(--stone)]/20 shadow-xl flex flex-col md:flex-row gap-10 items-center">
            <div class="flex-1 text-center md:text-right" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-black text-[var(--text-heading)] mb-4">لم تجد ما تبحث عنه؟</h2>
                <p class="text-[var(--text-light)] text-lg mb-8">تواصل معنا وسنسعد بمساعدتك، أو اطرح سؤالك مباشرة وسنجيب عليه في أقرب وقت.</p>
                <a href="{{ route('contact') }}" class="btn-primary px-10 py-3.5">{{ __('Contact Us') }}</a>
            </div>
            
            <div class="w-full md:w-1/2" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-[var(--navy-dark)] rounded-xl p-6 border border-[var(--stone)] shadow-sm">
                    <h3 class="text-xl font-bold text-[var(--text-heading)] mb-4">{{ __('Ask a Question') }}</h3>
                    <form action="{{ route('questions.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="question" rows="3" required class="w-full border border-[var(--stone)] rounded-xl px-5 py-3 text-sm focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none transition-colors bg-[var(--cream)] text-[var(--text-heading)]" placeholder="{{ __('Write your question here...') }}"></textarea>
                        </div>
                        <div class="mb-4">
                            <input type="text" name="asked_by" class="w-full border border-[var(--stone)] rounded-xl px-5 py-3 text-sm focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none transition-colors bg-[var(--cream)] text-[var(--text-heading)]" placeholder="{{ __('Your name (optional)') }}">
                        </div>
                        <button type="submit" class="w-full py-3 bg-[var(--gold)] text-[#0F172A] font-bold rounded-xl hover:opacity-90 transition-all text-sm">
                            {{ __('Send Question') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
