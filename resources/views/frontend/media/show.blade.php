@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $metaDescription }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ asset('storage/' . $imagePath) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="900">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('title', $metaTitle . ' - ' . __('Smart Designer Decorations'))

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ImageObject",
  "name": "{{ $entityName }} - {{ __('Image') }} {{ $index + 1 }}",
  "contentUrl": "{{ asset('storage/' . $imagePath) }}",
  "description": "{{ $entityDescription }}",
  "author": {
    "@type": "Organization",
    "name": "{{ __('Smart Designer Decorations') }}"
  }
}
</script>
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-4 pb-4 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            @foreach($breadcrumbs as $crumb)
                @if($crumb['url'] && !$loop->last)
                    <a href="{{ $crumb['url'] }}" class="hover:text-[var(--gold)] transition-colors">{{ $crumb['name'] }}</a>
                    <i class="fas fa-chevron-left text-xs"></i>
                @else
                    <span class="text-[var(--gold)] font-bold">{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</section>

{{-- Image Detail --}}
<section class="py-8 md:py-16 bg-gradient-to-br from-[var(--cream)] to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            {{-- Navigation header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ $entityRoute }}" class="text-[var(--gold)] hover:text-[var(--gold)]/80 font-medium text-sm transition-colors">
                        <i class="fas fa-arrow-right ml-2"></i>
                        @if($type === 'project')
                            {{ __('Back to Project') }}
                        @elseif($type === 'blog')
                            {{ __('Back to Article') }}
                        @elseif($type === 'service')
                            {{ __('Back to Service') }}
                        @else
                            {{ __('Back') }}
                        @endif
                    </a>
                    <h1 class="text-xl md:text-2xl font-bold text-[var(--text-heading)] mt-2">{{ $entityName }}</h1>
                    <p class="text-sm text-[var(--text-muted)]">{{ $typeLabel }} - {{ __('Image') }} {{ $index + 1 }} / {{ $totalImages }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($prevIndex !== null)
                        <a href="{{ route('media.show', [$type, $entity->slug, $prevIndex]) }}" class="px-4 py-2 bg-white border border-[var(--stone)] rounded-xl hover:bg-[var(--cream)] transition-colors text-sm font-medium" aria-label="{{ __('Previous Image') }}">
                            <i class="fas fa-chevron-right"></i> {{ __('Previous') }}
                        </a>
                    @endif
                    @if($nextIndex !== null)
                        <a href="{{ route('media.show', [$type, $entity->slug, $nextIndex]) }}" class="px-4 py-2 bg-[var(--gold)] text-white rounded-xl hover:opacity-90 transition-colors text-sm font-medium" aria-label="{{ __('Next Image') }}">
                            {{ __('Next') }} <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Main Image --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-[var(--stone)] mb-6">
                <div class="relative bg-[var(--navy)]/5 flex items-center justify-center p-2 md:p-4">
                    <img src="{{ \App\Services\ImageService::sized($imagePath, 'large') }}"
                         srcset="{{ \App\Services\ImageService::srcset($imagePath) }}"
                         sizes="(max-width: 768px) 100vw, 1024px"
                         alt="{{ $entityName }}"
                         class="w-full h-auto max-h-[70vh] object-contain rounded-xl"
                         loading="eager">
                </div>
            </div>

            {{-- Entity Description --}}
            @if($entityDescription)
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-[var(--stone)] mb-6">
                    <p class="text-[var(--text-secondary)] text-sm leading-relaxed">{{ $entityDescription }}</p>
                    <a href="{{ $entityRoute }}" class="inline-flex items-center text-[var(--gold)] font-bold text-sm mt-3 hover:opacity-80 transition-colors">
                        @if($type === 'project')
                            {{ __('View Full Project Details') }}
                        @elseif($type === 'blog')
                            {{ __('Read Full Article') }}
                        @elseif($type === 'service')
                            {{ __('View Full Service Details') }}
                        @else
                            {{ __('View Full Details') }}
                        @endif
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                </div>
            @endif

            {{-- All Images Grid --}}
            @if($totalImages > 1)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-[var(--text-heading)] mb-4">{{ __('All Images') }} ({{ $totalImages }})</h2>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @foreach($images as $i => $img)
                            @if($img)
                                <a href="{{ route('media.show', [$type, $entity->slug, $i]) }}"
                                   class="block rounded-xl overflow-hidden border-2 transition-all duration-200 hover:border-[var(--gold)] @if($i === $index) border-[var(--gold)] ring-2 ring-[var(--gold)]/30 @else border-[var(--stone)] @endif">
                                    <img src="{{ \App\Services\ImageService::sized($img, 'thumb') }}"
                                         alt="" class="w-full h-20 sm:h-24 object-cover" loading="lazy">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Share --}}
            <div class="text-center">
                <p class="text-sm font-medium text-[var(--text-muted)] mb-3">{{ __('Share') }}</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="https://wa.me/?text={{ urlencode($metaTitle . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:opacity-90 transition-colors" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:opacity-90 transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($metaTitle) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90 transition-colors" aria-label="Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(asset('storage/' . $imagePath)) }}&description={{ urlencode($metaTitle) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center hover:opacity-90 transition-colors" aria-label="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
