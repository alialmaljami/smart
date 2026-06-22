@php
    $heroBg = App\Models\Setting::getValue('home_hero_bg', '');
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Gallery') . ' - ' . __('Smart Designer Decorations') . '. ' . __('Our Works Gallery') }}">
<meta name="keywords" content="{{ __('Gallery') }}, {{ __('Design') }}, {{ __('Decoration') }}">
<meta property="og:title" content="{{ __('Gallery') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Our Works Gallery') }}">
@endpush

@section('title', __('Gallery') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <span class="section-label">{{ __('Gallery') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Our Works Gallery') }}</h1>
            <p class="text-[var(--text-light)] max-w-2xl mx-auto text-lg">{{ __('A collection of our latest projects and designs in the world of decoration and interior design') }}</p>
        </div>
    </div>
</section>

{{-- Categories Filter --}}
@if($categories->count())
    <section class="py-8 bg-[var(--white)] border-b border-[var(--stone)] sticky top-0 z-30">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button onclick="filterGallery('all')" class="filter-btn active px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--gold)] text-white" data-filter="all">
                    {{ __('All') }}
                </button>
                @foreach($categories as $cat)
                    <button onclick="filterGallery('{{ $cat->name }}')" class="filter-btn px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white" data-filter="{{ $cat->name }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Gallery Grid --}}
<section class="py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        @if($galleries->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($galleries as $gallery)
                    @php $catName = $gallery->getRelation('category')?->name ?? $gallery->category ?? 'all'; @endphp
                    <div data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}" class="gallery-item group relative rounded-2xl overflow-hidden img-zoom h-72 cursor-pointer"
                         data-category="{{ $catName }}"
                         onclick="location.href='{{ route('gallery.show', [$gallery->id, $gallery->slug]) }}'">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->alt_text ?: $gallery->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div x-data="{ liked: {{ $gallery->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $gallery->likeCount() }} }" class="absolute top-3 left-3 z-10" @click.stop="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'gallery', id: {{ $gallery->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1 px-2.5 py-1 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 transition-all text-xs pointer-events-none">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <button type="button" @click.stop="toggleFavorite('gallery', {{ $gallery->id }})"
                                :class="isFavorite('gallery', {{ $gallery->id }}) ? 'text-red-400' : 'text-white'"
                                class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                                title="{{ __('Add to Favorites') }}">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('gallery', {{ $gallery->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                        <a href="{{ route('gallery.show', [$gallery->id, $gallery->slug]) }}" class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="absolute bottom-0 right-0 left-0 p-5">
                                <h3 class="text-white font-bold text-lg mb-1">{{ $gallery->title }}</h3>
                                @if($gallery->description)
                                    <p class="text-white text-sm line-clamp-2">{{ $gallery->description }}</p>
                                @endif
                            </div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <div class="w-16 h-16 rounded-full bg-[var(--gold)]/90 flex items-center justify-center text-white text-2xl transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)] flex items-center justify-center">
                    <x-icon name="star" class="w-12 h-12 text-[var(--text-light)]" />
                </div>
                <h3 class="text-2xl font-bold text-[var(--gold)] mb-2">{{ __('No images in gallery') }}</h3>
                <p class="text-[var(--text-light)]">{{ __('Images will be added soon') }}</p>
            </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="gallery-modal" class="fixed inset-0 z-50 hidden" x-data="{ open: false }">
    <div class="absolute inset-0 bg-[var(--navy)]/90 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative h-full flex items-center justify-center p-4">
        <button onclick="closeModal()" class="absolute top-4 left-4 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10">
            <i class="fas fa-times text-xl"></i>
        </button>
        <button onclick="navigateModal(-1)" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>
        <button onclick="navigateModal(1)" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-10">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        <div class="max-w-5xl max-h-[85vh] text-center">
            <img id="modal-image" src="" alt="{{ __('Image preview') }}" class="max-w-full max-h-[75vh] rounded-2xl shadow-2xl mx-auto object-contain">
            <div class="mt-4 text-white">
                <h3 id="modal-title" class="text-xl font-bold"></h3>
                <p id="modal-description" class="text-white/60 text-sm mt-1"></p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .gallery-item { transition: all 0.3s ease; }
    .gallery-item:hover { transform: translateY(-5px); }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .filter-btn.active { background: var(--gold); color: white; }
</style>
@endpush

@push('scripts')
<script>
    let galleryItems = [];
    let currentIndex = 0;

    document.querySelectorAll('.gallery-item').forEach((el, i) => {
        galleryItems.push({
            src: el.dataset.src || el.querySelector('img').src,
            title: el.querySelector('h3')?.textContent || '',
            desc: el.querySelector('p')?.textContent || '',
            category: el.dataset.category || 'all',
        });
    });

    function openModal(src, title, desc) {
        currentIndex = galleryItems.findIndex(item => item.src === src);
        document.getElementById('modal-image').src = src;
        document.getElementById('modal-title').textContent = title;
        document.getElementById('modal-description').textContent = desc;
        document.getElementById('gallery-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('gallery-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function navigateModal(dir) {
        currentIndex += dir;
        if (currentIndex < 0) currentIndex = galleryItems.length - 1;
        if (currentIndex >= galleryItems.length) currentIndex = 0;
        const item = galleryItems[currentIndex];
        document.getElementById('modal-image').src = item.src;
        document.getElementById('modal-title').textContent = item.title;
        document.getElementById('modal-description').textContent = item.desc;
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowLeft') navigateModal(1);
        if (e.key === 'ArrowRight') navigateModal(-1);
    });

    function filterGallery(category) {
        document.querySelectorAll('.gallery-item').forEach(el => {
            if (category === 'all' || el.dataset.category === category) {
                el.style.display = '';
            } else {
                el.style.display = 'none';
            }
        });
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === category);
            if (btn.dataset.filter === category) {
                btn.className = 'filter-btn active px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--gold)] text-white';
            } else {
                btn.className = 'filter-btn px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 bg-[var(--cream)] text-[var(--text-light)] hover:bg-[var(--gold)] hover:text-white';
            }
        });
        galleryItems = [];
        document.querySelectorAll('.gallery-item').forEach((el, i) => {
            if (el.style.display !== 'none') {
                galleryItems.push({
                    src: el.dataset.src || el.querySelector('img').src,
                    title: el.querySelector('h3')?.textContent || '',
                    desc: el.querySelector('p')?.textContent || '',
                    category: el.dataset.category || 'all',
                });
            }
        });
    }
</script>
@endpush
@endsection