@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $material->meta_description ?? $material->description }}">
<meta name="keywords" content="{{ $material->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $material->meta_title ?? $material->name }}">
<meta property="og:description" content="{{ $material->meta_description ?? $material->description }}">
@if($material->image)
    <meta property="og:image" content="{{ asset('storage/' . $material->image) }}">
@endif
@endpush

@section('title', ($material->meta_title ?? $material->name) . ' - ' . __('Materials') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('materials') }}" class="hover:text-[var(--gold)] transition-colors">{{ __('Decoration Materials') }}</a>
            <i class="fas fa-chevron-left text-xs"></i>
            @if($material->category)
                <a href="{{ route('material.category.show', $material->category->slug) }}" class="hover:text-[var(--gold)] transition-colors">{{ $material->category->name }}</a>
                <i class="fas fa-chevron-left text-xs"></i>
            @endif
            <span class="text-[var(--gold)] font-bold">{{ $material->name }}</span>
        </nav>
    </div>
</section>

{{-- Material Detail --}}
<section class="py-12 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            {{-- Image --}}
            <div data-aos="fade-left">
                @if($material->image)
                    <div class="rounded-2xl overflow-hidden h-96 card-elegant">
                        <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                @endif
                {{-- Extra images --}}
                @if(is_array($material->images) && count($material->images))
                    <div class="grid grid-cols-4 gap-3 mt-4">
                        @foreach($material->images as $img)
                            <div class="rounded-xl overflow-hidden h-24">
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $material->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div data-aos="fade-right">
                <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ $material->name }}</h1>
                <div class="section-divider mb-6"></div>

                @if($material->description)
                    <p class="text-[var(--text-light)] text-lg leading-relaxed mb-6">{{ $material->description }}</p>
                @endif

                @if($material->price)
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-[var(--gold)]">{{ number_format($material->price, 2) }} {{ __('SAR') }}</span>
                    </div>
                @endif

                {{-- Specifications --}}
                @if($material->specifications)
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-3">{{ __('Specifications') }}</h3>
                        <p class="text-[var(--text-light)]">{{ $material->specifications }}</p>
                    </div>
                @endif

                {{-- Tags --}}
                @if($material->tags)
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $material->tags) as $tag)
                                <a href="{{ route('tag', trim($tag)) }}" class="px-3 py-1 rounded-full text-sm bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white transition-colors">#{{ trim($tag) }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="{{ route('contact') }}" class="btn-primary inline-flex items-center px-8 py-4 rounded-xl font-bold text-lg">
                    <x-icon name="shopping_cart" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('Inquire about materials') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Related Materials --}}
@if($relatedMaterials->count())
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--gold)]">{{ __('Related Materials') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedMaterials as $rel)
                    <div data-aos="fade-up" class="card-elegant overflow-hidden">
                        @if($rel->image)
                            <div class="img-zoom h-44">
                                <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @else
                            <div class="h-44 flex items-center justify-center bg-[var(--stone)]">
                                <x-icon name="image" class="w-10 h-10 text-[var(--text-light)]" />
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-[var(--text-heading)]">{{ $rel->name }}</h3>
                            <a href="{{ route('material.show', $rel->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-bold mt-2">
                                {{ __('Read More') }} <i class="fas fa-arrow-left mr-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
@php $shareSocialLinks = App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get(); @endphp
<section class="py-8 bg-[var(--cream)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">{{ __('Share') }}:</span>
        <div class="inline-flex space-x-2 space-x-reverse items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($material->name . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

@endsection