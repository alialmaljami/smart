@php
    $services = App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
    $materialCategories = App\Models\Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
    $currentCategoryId = request('category_id');
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Our Projects') . ' - ' . __('Smart Designer Decorations') . '. ' . __('Browse our latest projects and get inspired for your next project') }}">
<meta name="keywords" content="{{ __('Our Projects') }}, {{ __('Design') }}, {{ __('Decoration') }}">
<meta property="og:title" content="{{ __('Our Projects') }} - {{ __('Smart Designer Decorations') }}">
<meta property="og:description" content="{{ __('Browse our latest projects and get inspired for your next project') }}">
@endpush

@push('schema')
@php
    $items = [];
    foreach (($projects ?? []) as $p) {
        $items[] = ['name' => $p->title, 'url' => route('project.show', $p->slug)];
    }
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::collectionPage(__('Our Projects'), __('Browse our latest projects and get inspired for your next project')),
        \App\Services\SchemaService::itemList(__('Our Projects'), $items),
    ]);
@endphp
@endpush

@section('title', __('Our Projects') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative py-16 md:py-32 flex items-center justify-center overflow-hidden bg-[var(--navy)]">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 30% 50%, var(--cream) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--cream) 0%, transparent 50%);"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-3xl sm:text-4xl md:text-6xl font-black text-[var(--text-heading)] mb-4">{{ __('Our Projects') }}</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">{{ __('Browse our latest projects and get inspired for your next project') }}</p>
    </div>
</section>

{{-- Category Chips --}}
<section class="py-6 bg-[var(--white)] border-b border-[var(--stone)] md:sticky md:top-20 md:z-30">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-2 mb-4">
            <a href="{{ route('projects') }}"
               class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ !$currentCategoryId ? 'bg-[var(--gold)] text-black' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)]/20 hover:text-[var(--gold)]' }}">
                {{ __('All') }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('projects', array_merge(request()->query(), ['category_id' => $cat->id])) }}"
                   class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $currentCategoryId == $cat->id ? 'bg-[var(--gold)] text-black' : 'bg-[var(--stone)] text-[var(--text-light)] hover:bg-[var(--gold)]/20 hover:text-[var(--gold)]' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('projects') }}" class="flex flex-wrap gap-3 items-center justify-center">
            <input type="hidden" name="category_id" value="{{ $currentCategoryId }}">
            <select name="service_id" class="px-3 py-1.5 border border-[var(--stone)] rounded-lg text-xs focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none bg-white text-[var(--text-light)]">
                <option value="">{{ __('All Services') }}</option>
                @foreach($services as $s)
                    <option value="{{ $s->id }}" {{ request('service_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            <select name="material_category_id" class="px-3 py-1.5 border border-[var(--stone)] rounded-lg text-xs focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)] outline-none bg-white text-[var(--text-light)]">
                <option value="">{{ __('All Materials') }}</option>
                @foreach($materialCategories as $mc)
                    <option value="{{ $mc->id }}" {{ request('material_category_id') == $mc->id ? 'selected' : '' }}>{{ $mc->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-4 py-1.5 rounded-lg font-bold text-xs">
                <i class="fas fa-filter ml-1"></i> {{ __('Filter') }}
            </button>
            @if(request('service_id') || request('material_category_id') || $currentCategoryId)
                <a href="{{ route('projects') }}" class="text-[var(--text-light)] hover:text-[var(--gold)] text-xs">
                    <i class="fas fa-times ml-1"></i> {{ __('Reset') }}
                </a>
            @endif
        </form>
    </div>
</section>

{{-- Projects Grid --}}
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                @php
                    $projectImages = is_array($project->images) ? array_values(array_filter($project->images)) : [];
                    $image = $projectImages[0] ?? $project->images ?? '';
                @endphp
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 30 }}" class="group relative rounded-[var(--radius-lg)] overflow-hidden h-80 card-elegant"
                    @if(count($projectImages) > 1)
                    x-data="{
                        slide: 0,
                        total: {{ count($projectImages) }},
                        paused: false,
                        timer: null,
                        start() { this.timer = setInterval(() => { if (!this.paused) this.slide = (this.slide + 1) % this.total; }, 4000); },
                        stop() { if (this.timer) clearInterval(this.timer); },
                        init() { this.start(); },
                        destroy() { this.stop(); }
                    }"
                    @@mouseenter="paused = true"
                    @@mouseleave="paused = false"
                    @endif
                >
                    @if(count($projectImages) > 1)
                        @foreach($projectImages as $pi => $img)
                        {!! \App\Services\ImageService::picture($img, $project->title, 'absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out', [':class' => "slide === {$pi} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'"]) !!}
                        @endforeach
                    @else
                        {!! \App\Services\ImageService::picture($image, $project->title, 'w-full h-full object-cover') !!}
                    @endif
                    <div class="overlay-gradient absolute inset-0 z-[2]"></div>
                    {{-- Dots for multi-image --}}
                    @if(count($projectImages) > 1)
                    <div class="absolute top-3 right-3 z-20 flex gap-1">
                        @foreach($projectImages as $pi => $img)
                        <button @@click.stop="slide = {{ $pi }}; paused = true; setTimeout(() => paused = false, 5000)"
                                class="w-1.5 h-1.5 rounded-full transition-all duration-300"
                                :class="slide === {{ $pi }} ? 'bg-[var(--gold)] w-3' : 'bg-white/40 hover:bg-white/70'"></button>
                        @endforeach
                    </div>
                    @endif
                    {{-- Like --}}
                    <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-4 left-4 z-10" @@click.stop="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                        <button class="flex items-center gap-1.5 px-3 py-1.5 bg-black/80 backdrop-blur-sm rounded-full text-white hover:bg-black/90 transition-all">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="liked ? 'currentColor' : 'none'"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                            <span class="text-xs font-medium" x-text="count">0</span>
                        </button>
                    </div>
                    {{-- Favorite --}}
                    <button type="button" @click.stop="toggleFavorite('project', {{ $project->id }})"
                            :class="isFavorite('project', {{ $project->id }}) ? 'text-red-400' : 'text-white'"
                            class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-black/80 backdrop-blur-sm flex items-center justify-center hover:bg-black/90 transition-all"
                            title="{{ __('Add to Favorites') }}">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :fill="isFavorite('project', {{ $project->id }}) ? 'currentColor' : 'none'"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute bottom-0 right-0 left-0 p-6 text-right z-[2]">
                        <span class="text-xs text-white font-bold bg-[var(--gold)]/80 px-3 py-1 rounded-full inline-block mb-2">
                            @if($project->services->count())
                                {{ $project->services->first()->name }}
                            @endif
                        </span>
                        <h3 class="text-xl font-bold text-white">{{ $project->title }}</h3>
                        @if(is_array($project->tags) && count($project->tags))
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach(array_slice($project->tags, 0, 3) as $tag)
                                    <a href="{{ route('tag', urlencode($tag)) }}" class="text-[10px] font-bold text-[var(--gold)] bg-[var(--gold)]/10 hover:bg-[var(--gold)]/20 px-2 py-0.5 rounded-full transition-colors">{{ $tag }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('project.show', $project->slug) }}" class="absolute inset-0 z-[3] flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <span class="text-white text-lg font-bold border-2 border-white px-6 py-3 rounded-lg">
                            <x-icon name="eye" class="w-5 h-5 inline-block ml-2 align-middle" /> {{ __('View Project') }}
                        </span>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <x-icon name="eye" class="w-16 h-16 text-[var(--text-light)] inline-block mb-4" />
                    <p class="text-[var(--text-light)] text-xl">{{ __('No projects available') }}</p>
                </div>
            @endforelse
        </div>

        @if($projects->hasPages())
            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</section>

@endsection