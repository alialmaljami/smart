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
<section class="pt-20 pb-12 md:pt-32 md:pb-16">
    <div class="container-wide">
        <div class="text-center mb-16">
            <span class="section-label">{{ __('Favorites') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ __('My Favorites') }}</h1>
            <div class="section-divider"></div>
        </div>

        <div x-data="{
            items: { project: [], blog: [], service: [], material: [], gallery: [] },
            loading: true,
            empty: false,
            activeTab: 'all',

            init() {
                const favs = JSON.parse(localStorage.getItem('sm_favorites') || '{}');
                const hasAny = Object.values(favs).some(a => a && a.length > 0);
                if (!hasAny) { this.loading = false; this.empty = true; return; }

                fetch('{{ route('favorites.items') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ types: favs })
                })
                .then(r => r.json())
                .then(data => { this.items = data; this.loading = false; this.empty = true; for (let k in data) { if (data[k].length) { this.empty = false; break; } } })
                .catch(() => { this.loading = false; this.empty = true; });
            },

            tabItems(tab) {
                if (tab === 'all') {
                    let all = [];
                    for (let k in this.items) { all = all.concat(this.items[k].map(i => ({ ...i, _type: k }))); }
                    return all;
                }
                return (this.items[tab] || []).map(i => ({ ...i, _type: tab }));
            },

            tabCount(tab) {
                if (tab === 'all') return Object.values(this.items).reduce((a, b) => a + b.length, 0);
                return (this.items[tab] || []).length;
            }
        }" x-init="init()" class="min-h-[50vh]">
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
                        <button @click="activeTab = 'all'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'all' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('All') }} (<span x-text="tabCount('all')"></span>)
                        </button>
                        <button @click="activeTab = 'project'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'project' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('Projects') }} (<span x-text="tabCount('project')"></span>)
                        </button>
                        <button @click="activeTab = 'service'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'service' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('Services') }} (<span x-text="tabCount('service')"></span>)
                        </button>
                        <button @click="activeTab = 'material'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'material' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('Decoration Materials') }} (<span x-text="tabCount('material')"></span>)
                        </button>
                        <button @click="activeTab = 'gallery'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'gallery' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('Gallery') }} (<span x-text="tabCount('gallery')"></span>)
                        </button>
                        <button @click="activeTab = 'blog'" class="px-5 py-2 rounded-full text-xs font-bold transition-all" :class="activeTab === 'blog' ? 'bg-[var(--gold)] text-black' : 'bg-white/5 text-white/60 hover:bg-white/10'">
                            {{ __('Blog') }} (<span x-text="tabCount('blog')"></span>)
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <template x-for="item in tabItems(activeTab)" :key="item._type + '-' + item.id">
                            <div class="card-elegant group">
                                <div class="relative overflow-hidden h-48">
                                    <a :href="item._type === 'service' ? '/services/' + item.slug : item._type === 'project' ? '/projects/' + item.slug : item._type === 'blog' ? '/blog/' + item.slug : item._type === 'material' ? '/material/' + item.slug : '/gallery/' + item.id + '/' + item.slug">
                                        <img :src="item.image ? '/storage/' + (item.image || item.images?.[0]) : ''" :alt="item.title || item.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy"
                                             @error.once="$el.src = ''; $el.parentElement.innerHTML = '<div class=\'w-full h-full bg-white/5 flex items-center justify-center text-white/20\'><svg class=\'w-8 h-8\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                    </a>
                                    <button @click="toggleFavorite(item._type, item.id); items[item._type] = items[item._type].filter(i => i.id !== item.id); if (Object.values(items).every(a => a.length === 0)) empty = true;"
                                            class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-black/40 backdrop-blur-sm flex items-center justify-center hover:bg-black/60 transition-all">
                                        <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    </button>
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-black/40 backdrop-blur-sm text-white/80"
                                              x-text="item._type === 'project' ? '{{ __('Project') }}' : item._type === 'service' ? '{{ __('Service') }}' : item._type === 'blog' ? '{{ __('Article') }}' : item._type === 'material' ? '{{ __('Material') }}' : '{{ __('Gallery') }}'"></span>
                                    </div>
                                    <div class="overlay-gradient absolute inset-0"></div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-sm font-bold text-[var(--text-heading)] mb-2 line-clamp-2">
                                        <a :href="item._type === 'service' ? '/services/' + item.slug : item._type === 'project' ? '/projects/' + item.slug : item._type === 'blog' ? '/blog/' + item.slug : item._type === 'material' ? '/material/' + item.slug : '/gallery/' + item.id + '/' + item.slug" class="hover:text-[var(--gold)] transition-colors"
                                           x-text="item.title || item.name"></a>
                                    </h3>
                                    <p x-show="item.description" class="text-xs text-[var(--text-light)] line-clamp-2 leading-relaxed" x-text="item.description ? item.description.substring(0, 100) + '...' : ''"></p>
                                    <p x-show="item.client_name" class="text-[11px] text-white/30 mt-2" x-text="item.client_name"></p>
                                    <a :href="item._type === 'service' ? '/services/' + item.slug : item._type === 'project' ? '/projects/' + item.slug : item._type === 'blog' ? '/blog/' + item.slug : item._type === 'material' ? '/material/' + item.slug : '/gallery/' + item.id + '/' + item.slug"
                                       class="inline-flex items-center text-[var(--gold)] text-xs font-semibold mt-3 group-hover:gap-2 transition-all">
                                        {{ __('View Details') }} <x-icon name="arrow_left" class="w-3 h-3 mr-1" />
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush
