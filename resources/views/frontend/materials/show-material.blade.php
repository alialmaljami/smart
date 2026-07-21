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
<section class="pt-4 pb-4 bg-[var(--navy)]">
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
<section class="py-12 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            {{-- Image --}}
            <div data-aos="fade-left">
                @if($material->image)
                    <div class="rounded-2xl overflow-hidden h-96 card-elegant relative">
                        {!! \App\Services\ImageService::picture($material->image, $material->name, 'w-full h-full object-cover') !!}
                        <button type="button" @click.stop="toggleFavorite('material', {{ $material->id }})"
                                :class="isFavorite('material', {{ $material->id }}) ? 'text-red-400' : 'text-white'"
                                class="absolute top-3 left-3 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                title="{{ __('Add to Favorites') }}">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('material', {{ $material->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    </div>
                @endif
                {{-- Extra images --}}
                @if(is_array($material->images) && count($material->images))
                    <div class="grid grid-cols-4 gap-3 mt-4">
                        @foreach($material->images as $idx => $img)
                            <a href="{{ route('media.show', ['material', $material->slug, $idx]) }}" class="rounded-xl overflow-hidden h-24 group relative block">
                                {!! \App\Services\ImageService::picture($img, $material->name, 'w-full h-full object-cover') !!}
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <i class="fas fa-expand text-white text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </a>
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
                        <div class="text-[var(--text-light)] space-y-1.5">
                            @foreach(preg_split('/\r\n|\r|\n/', trim($material->specifications)) as $spec)
                                @if(trim($spec))
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-[var(--gold)] mt-1 text-sm shrink-0"></i>
                                        <span>{{ trim(ltrim($spec, '* ')) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tags --}}
                @php
                    $materialTags = [];
                    foreach ($material->tagItems as $t) {
                        $materialTags[] = ['name' => $t->name, 'slug' => $t->slug, 'isMaster' => true];
                    }
                    if (is_array($material->tags)) {
                        foreach ($material->tags as $tag) {
                            foreach (explode('،', $tag) as $part) {
                                foreach (explode(',', $part) as $p) {
                                    $trimmed = trim($p);
                                    if ($trimmed !== '') $materialTags[] = ['name' => $trimmed, 'slug' => null, 'isMaster' => false];
                                }
                            }
                        }
                    }
                    $materialTags = collect($materialTags)->unique('name')->all();
                @endphp
                @if(count($materialTags))
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach($materialTags as $tag)
                                <a href="{{ $tag['isMaster'] ? route('tag.slug', $tag['slug']) : route('tag', urlencode($tag['name'])) }}" class="px-3 py-1 rounded-full text-sm {{ $tag['isMaster'] ? 'bg-[var(--gold)]/10 text-[var(--gold)] hover:bg-[var(--gold)] hover:text-white' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white' }} transition-colors">#{{ $tag['name'] }}</a>
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
                                {!! \App\Services\ImageService::picture($rel->image, $rel->name, 'w-full h-full object-cover') !!}
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
<section class="py-8 bg-[var(--navy)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">{{ __('Share') }}:</span>
        <div class="inline-flex space-x-2 space-x-reverse items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($material->name . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

@endsection