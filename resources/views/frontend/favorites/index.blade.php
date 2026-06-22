@extends('layouts.app')

@section('title', __('My Favorites'))

@push('meta')
<meta name="description" content="{{ __('My Favorites - Smart Designer Decorations') }}">
<meta property="og:title" content="{{ __('My Favorites') }}">
<meta property="og:description" content="{{ __('My Favorites - Smart Designer Decorations') }}">
@endpush

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::breadcrumbList([
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('My Favorites'), 'url' => route('favorites')],
        ]),
    ]);
@endphp
@endpush

@section('content')
<section class="pt-20 pb-12 md:pt-32 md:pb-16 bg-black"
    x-data="{
        items: [],
        loading: true,
        empty: false,
        activeTab: 'all',
        get filteredItems() {
            if (this.activeTab === 'all') return this.items;
            return this.items.filter(i => i._type === this.activeTab);
        },
        get tabCounts() {
            const c = { all: this.items.length, project: 0, blog: 0, service: 0, material: 0, gallery: 0 };
            this.items.forEach(i => { if (c[i._type] !== undefined) c[i._type]++; });
            return c;
        },
        removeItem(type, id) {
            let favs = {};
            try { favs = JSON.parse(localStorage.getItem('sm_favorites') || '{}'); } catch(e) {}
            if (favs[type]) {
                favs[type] = favs[type].filter(i => i !== id);
                if (favs[type].length === 0) delete favs[type];
            }
            localStorage.setItem('sm_favorites', JSON.stringify(favs));
            this.items = this.items.filter(i => !(i._type === type && i.id === id));
            if (this.items.length === 0) this.empty = true;
            window.dispatchEvent(new CustomEvent('fav-updated'));
        },
        init() {
            let favs = {};
            try { favs = JSON.parse(localStorage.getItem('sm_favorites') || '{}'); } catch(e) {}
            const hasAny = Object.values(favs).some(a => a && a.length > 0);
            if (!hasAny) {
                this.loading = false;
                this.empty = true;
                return;
            }
            fetch('{{ route('favorites.items') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ types: favs })
            })
            .then(r => r.json())
            .then(data => {
                const result = [];
                const labels = {
                    project: '{{ __('Project') }}',
                    service: '{{ __('Service') }}',
                    blog: '{{ __('Article') }}',
                    material: '{{ __('Material') }}',
                    gallery: '{{ __('Gallery') }}'
                };
                for (const type in data) {
                    (data[type] || []).forEach(d => {
                        const img = d.image || (d.images && d.images[0]) || '';
                        result.push({
                            id: d.id, _type: type,
                            _typeLabel: labels[type] || type,
                            link: { project: '/projects/', service: '/services/', blog: '/blog/', material: '/material/', gallery: '/gallery/' }[type] + (d.slug || d.id),
                            title: d.title || d.name,
                            img: img ? '/storage/' + img : '',
                            desc: d.description ? d.description.substring(0, 100) + '...' : '',
                            meta: d.client_name || ''
                        });
                    });
                }
                this.items = result;
                this.loading = false;
                this.empty = result.length === 0;
            })
            .catch(() => {
                this.loading = false;
                this.empty = true;
            });
        }
    }">
    <div class="container-wide">
        <div class="text-center mb-16">
            <span class="section-label">{{ __('Favorites') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-black text-white mb-4">{{ __('My Favorites') }}</h1>
            <div class="section-divider"></div>
        </div>

        <div x-show="loading" class="text-center py-20">
            <svg class="animate-spin w-10 h-10 mx-auto text-[var(--gold)]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
        </div>

        <div x-show="!loading && empty" class="text-center py-20">
            <svg class="w-20 h-20 mx-auto text-white/10 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <p class="text-white/40 text-lg mb-4">{{ __('No favorites yet') }}</p>
            <p class="text-white/20 text-sm mb-8">{{ __('Browse our projects, services, and articles and add your favorites') }}</p>
            <a href="{{ route('projects') }}" class="btn-primary text-xs">{{ __('Browse Projects') }}</a>
        </div>

        <template x-if="!loading && !empty">
            <div>
                <div class="flex flex-wrap justify-center gap-2 mb-12">
                    <template x-for="tab in [
                        { key: 'all', label: '{{ __('All') }}' },
                        { key: 'project', label: '{{ __('Projects') }}' },
                        { key: 'service', label: '{{ __('Services') }}' },
                        { key: 'material', label: '{{ __('Decoration Materials') }}' },
                        { key: 'gallery', label: '{{ __('Gallery') }}' },
                        { key: 'blog', label: '{{ __('Blog') }}' }
                    ]" :key="tab.key">
                        <button @click="activeTab = tab.key"
                                class="px-5 py-2 rounded-full text-xs font-bold transition-all"
                                :class="activeTab === tab.key ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'"
                                x-text="tab.label + ' (' + (tabCounts[tab.key] || 0) + ')'">
                        </button>
                    </template>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template x-for="(item, idx) in filteredItems" :key="item._type + '-' + item.id">
                        <div class="card-elegant group">
                            <div class="relative overflow-hidden h-48">
                                <a :href="item.link">
                                    <img :src="item.img" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy"
                                         @error.once="$el.style.display='none'; $el.parentElement.innerHTML='<div class=\'w-full h-full bg-white/5 flex items-center justify-center text-white/20\'><svg class=\'w-8 h-8\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                </a>
                                <button @click="removeItem(item._type, item.id)"
                                        class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all">
                                    <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </button>
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-black/40 backdrop-blur-sm text-white/80" x-text="item._typeLabel"></span>
                                </div>
                                <div class="overlay-gradient absolute inset-0"></div>
                            </div>
                            <div class="p-5">
                                <h3 class="text-sm font-bold text-white mb-2 line-clamp-2">
                                    <a :href="item.link" class="hover:text-[var(--gold)] transition-colors" x-text="item.title"></a>
                                </h3>
                                <p x-show="item.desc" class="text-xs text-white/60 line-clamp-2 leading-relaxed" x-text="item.desc"></p>
                                <p x-show="item.meta" class="text-[11px] text-white/30 mt-2" x-text="item.meta"></p>
                                <a :href="item.link" class="inline-flex items-center text-[var(--gold)] text-xs font-semibold mt-3 group-hover:gap-2 transition-all">
                                    {{ __('View Details') }} <x-icon name="arrow_left" class="w-3 h-3 mr-1" />
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush
