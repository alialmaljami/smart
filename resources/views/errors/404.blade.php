@extends('layouts.app')

@section('title', '404 - ' . __('Page Not Found'))

@section('content')
<section class="relative pt-32 pb-20 overflow-hidden bg-[var(--navy)]" style="min-height: 70vh;">
    <div class="absolute inset-0 opacity-[0.05]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-xl mx-auto">
            <div class="text-8xl md:text-9xl font-black text-[var(--gold)]/20 mb-4">404</div>
            <h1 class="text-3xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ __('Page Not Found') }}</h1>
            <p class="text-[var(--text-light)] text-lg mb-8">{{ __('The page you are looking for does not exist or has been moved') }}</p>
            <a href="{{ route('home') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-3 rounded-xl font-bold">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Home') }}
            </a>
        </div>
    </div>
</section>
@endsection