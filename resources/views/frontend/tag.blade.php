@extends('layouts.app')

@php
    $tagName = $tag ?? '';
    $slugged = \Illuminate\Support\Str::slug($tagName);
    $canonicalUrl = $slugged ? route('tag.slug', $slugged) : url()->current();
    $totalCount = $projects->count() + $posts->count() + $galleries->count() + $materials->count();
    $metaDesc = app()->getLocale() === 'ar'
        ? "جميع المحتويات المتعلقة بـ \"{$tagName}\" في ديكورات المصمم الذكي - {$totalCount} نتيجة"
        : "All content related to \"{$tagName}\" at Smart Designer Decorations - {$totalCount} result" . ($totalCount !== 1 ? 's' : '');
@endphp

@push('meta')
<meta name="description" content="{{ $metaDesc }}">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta name="robots" content="index, follow">
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "{{ $tagName }}",
    "description": "{{ $metaDesc }}",
    "url": "{{ $canonicalUrl }}"
}
</script>
@endpush

@section('title', $tagName . ' - ' . __('Smart Designer Decorations'))

@section('content')
{{-- Breadcrumbs --}}
<section class="relative pt-24 pb-0 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center gap-2 text-sm text-[var(--text-light)] mb-6 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('home') }}" class="hover:text-[var(--gold)] transition-colors shrink-0">{{ __('Home') }}</a>
            <i class="fas {{ app()->getLocale() === 'ar' ? 'fa-chevron-left' : 'fa-chevron-right' }} text-[10px] text-[var(--text-muted)] shrink-0"></i>
            <span class="text-[var(--gold)] shrink-0">{{ Str::limit($tagName, 30) }}</span>
        </nav>
    </div>
</section>

{{-- Hero --}}
<section class="relative pt-8 pb-12 md:pb-16 overflow-hidden bg-[var(--navy)]">
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[var(--gold)]/10 text-[var(--gold)] text-sm font-semibold mb-4">
                <i class="fas fa-tag"></i>
                <span>{{ __('Tag') }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ $tagName }}</h1>
            <div class="section-divider"></div>
            <p class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">
                {{ __('All content related to') }} <strong class="text-[var(--gold)]">"{{ $tagName }}"</strong>
                @if($totalCount > 0)
                    <br><span class="text-sm text-[var(--text-muted)]">({{ $totalCount }} {{ __('results') }})</span>
                @endif
            </p>
        </div>
    </div>
</section>

{{-- Results Section --}}
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        @if($projects->count() || $posts->count() || $galleries->count() || $materials->count())
            {{-- Projects --}}
            @if($projects->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Projects') }} ({{ $projects->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $item)
                            @php $img = is_array($item->images) ? ($item->images[0] ?? '') : $item->image; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($img)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($img, $item->title, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('project.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Project') }} <i class="fas {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Blog Posts --}}
            @if($posts->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Articles') }} ({{ $posts->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($posts as $item)
                            @php $bImg = is_array($item->images) ? ($item->images[0] ?? '') : $item->image; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($bImg)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($bImg, $item->title, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                    <a href="{{ route('blog.post', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('Read Article') }} <i class="fas {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Gallery --}}
            @if($galleries->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Gallery') }} ({{ $galleries->count() }})</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($galleries as $item)
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                <div class="img-zoom aspect-square">
                                    {!! \App\Services\ImageService::picture($item->image, $item->title, 'w-full h-full object-cover') !!}
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-bold text-[var(--text-heading)]">{{ $item->title }}</h3>
                                    <a href="{{ route('gallery.show', ['id' => $item->id, 'slug' => $item->slug]) }}" class="text-xs text-[var(--gold)] font-semibold hover:underline">{{ __('View') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Materials --}}
            @if($materials->count())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[var(--text-heading)] mb-6">{{ __('Materials') }} ({{ $materials->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($materials as $item)
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($item->image)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($item->image, $item->name, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->name }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('material.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Material') }} <i class="fas {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)]/50 flex items-center justify-center">
                    <i class="fas fa-tag text-3xl text-[var(--text-muted)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-2">{{ __('No results found') }}</h3>
                <p class="text-[var(--text-light)] max-w-md mx-auto">{{ __('No content related to') }} "{{ $tagName }}"</p>
                <a href="{{ route('home') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 mt-6 rounded-xl font-bold">{{ __('Back to Home') }}</a>
            </div>
        @endif
    </div>
</section>
@endsection