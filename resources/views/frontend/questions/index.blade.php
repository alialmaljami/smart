@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Common questions and answers about decoration and interior design services') }}">
<meta property="og:title" content="{{ __('Questions & Answers') . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Common questions and answers about decoration and interior design services') }}">
@endpush

@section('title', __('Questions & Answers') . ' - ' . __('Smart Designer Decorations'))

@section('content')
<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-question-circle text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Questions & Answers') }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ __('Common questions and answers about decoration and interior design services') }}</p>
        </div>
    </div>
</section>

<section class="py-20 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="space-y-4" data-aos="fade-up">
            @forelse($questions as $q)
                <a href="{{ route('q.show', $q->slug) }}" class="block bg-white rounded-xl p-5 hover:shadow-md transition-all border border-[var(--stone)]/20 group">
                    <h3 class="font-bold text-[var(--text-heading)] group-hover:text-[var(--gold)] transition-colors">{{ $q->question }}</h3>
                    @if($q->answer)
                        <p class="text-sm text-[var(--text-secondary)] mt-2 line-clamp-2">{{ strip_tags($q->answer) }}</p>
                    @endif
                </a>
            @empty
                <div class="text-center py-12 text-[var(--text-secondary)]">
                    <p>{{ __('No questions yet') }}</p>
                </div>
            @endforelse
        </div>

        @if($questions->hasPages())
            <div class="mt-8" data-aos="fade-up">
                {{ $questions->links() }}
            </div>
        @endif
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-2xl">
        <div data-aos="fade-up" class="text-center mb-10">
            <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-2">{{ __('Ask a Question') }}</h2>
            <p class="text-[var(--text-secondary)]">{{ __('Have a question? Ask us and we will answer as soon as possible') }}</p>
        </div>
        <form action="{{ route('questions.store') }}" method="POST" data-aos="fade-up">
            @csrf
            <div class="mb-4">
                <textarea name="question" rows="3" required class="w-full border border-[var(--stone)] rounded-xl px-5 py-4 text-sm focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none transition-colors bg-[var(--cream)]" placeholder="{{ __('Write your question here...') }}"></textarea>
            </div>
            <div class="mb-4">
                <input type="text" name="asked_by" class="w-full border border-[var(--stone)] rounded-xl px-5 py-4 text-sm focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none transition-colors bg-[var(--cream)]" placeholder="{{ __('Your name (optional)') }}">
            </div>
            <button type="submit" class="w-full py-3.5 bg-[var(--gold)] text-white font-bold rounded-xl hover:opacity-90 transition-all text-sm">
                {{ __('Send Question') }}
            </button>
        </form>
    </div>
</section>
@endsection
