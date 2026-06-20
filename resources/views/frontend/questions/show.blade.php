@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ strip_tags($q->answer ?: $q->question) }}">
<meta property="og:title" content="{{ $q->question . ' - ' . __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ strip_tags($q->answer ?: $q->question) }}">
@endpush

@push('schema')
{!! \App\Services\SchemaService::renderSchemas([
    \App\Services\SchemaService::breadcrumbList($breadcrumbs),
    [
        '@context' => 'https://schema.org',
        '@type' => 'QAPage',
        'mainEntity' => [
            '@type' => 'Question',
            'name' => $q->question,
            'text' => $q->question,
            'author' => $q->asked_by ? ['@type' => 'Person', 'name' => $q->asked_by] : ['@type' => 'Person', 'name' => 'Guest'],
            'dateCreated' => $q->created_at->toIso8601String(),
            ...($q->answer ? [
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $q->answer,
                    'dateCreated' => $q->updated_at->toIso8601String(),
                ],
            ] : []),
        ],
    ],
]) !!}
@endpush

@section('title', $q->question . ' - ' . __('Smart Designer Decorations'))

@section('content')
<section class="relative pt-40 pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="max-w-4xl mx-auto">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-14 h-14 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <i class="fas fa-question text-xl text-[var(--gold)]"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-[var(--text-heading)]">{{ $q->question }}</h1>
            </div>
        </div>
    </div>
</section>

@if($q->answer)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div data-aos="fade-up" class="bg-[var(--cream)] rounded-2xl p-8 border border-[var(--stone)]/20">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-[var(--gold)] flex items-center justify-center text-white">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="font-bold text-[var(--text-heading)]">{{ __('Answer') }}</span>
                </div>
                <div class="text-[var(--text-secondary)] leading-relaxed whitespace-pre-line">
                    {{ $q->answer }}
                </div>
            </div>
        </div>
    </section>
@else
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <p class="text-[var(--text-secondary)] text-lg">{{ __('This question has not been answered yet') }}</p>
        </div>
    </section>
@endif

@if($related->count())
    <section class="py-16 bg-[var(--cream)]">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-xl font-bold text-[var(--text-heading)] mb-6">{{ __('Related Questions') }}</h2>
            <div class="space-y-3">
                @foreach($related as $rq)
                    <a href="{{ route('q.show', $rq->slug) }}" class="block bg-white rounded-xl p-4 hover:shadow-md transition-all border border-[var(--stone)]/20 group">
                        <h3 class="font-bold text-[var(--text-heading)] group-hover:text-[var(--gold)] transition-colors text-sm">{{ $rq->question }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

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
