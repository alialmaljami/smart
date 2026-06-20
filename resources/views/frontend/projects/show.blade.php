@php
    $images = collect(is_array($project->images) ? $project->images : [])->map(fn($i) => asset('storage/' . $i))->toArray();
    $videos = is_array($project->videos) ? $project->videos : [];
    $relatedProjects = App\Models\Project::where('is_active', true)
        ->where('id', '!=', $project->id)
        ->latest()
        ->take(3)
        ->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ $project->meta_description ?? Str::limit($project->description, 160) }}">
<meta name="keywords" content="{{ $project->meta_keywords ?? '' }}">
<meta property="og:title" content="{{ $project->meta_title ?? $project->title }}">
<meta property="og:description" content="{{ $project->meta_description ?? Str::limit($project->description, 160) }}">
@if(count($images))
    <meta property="og:image" content="{{ $images[0] }}">
@endif
@endpush

@section('title', ($project->meta_title ?? $project->title) . ' - ' . __('Smart Designer Decorations'))

@push('styles')
<style>
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@push('schema')
@php
    echo \App\Services\SchemaService::renderSchemas([
        \App\Services\SchemaService::localBusiness(),
        \App\Services\SchemaService::breadcrumbList($breadcrumbs ?? [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Our Projects'), 'url' => route('projects')],
            ['name' => $project->title, 'url' => route('project.show', $project->slug)],
        ]),
        \App\Services\SchemaService::article($project->title, $project->meta_description ?? Str::limit($project->description, 160), $project->image),
    ]);
@endphp
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="pt-28 pb-4 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center flex-wrap gap-x-1.5 gap-y-1 text-xs md:text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--text-muted)] hover:text-[var(--text-heading)] transition-colors whitespace-nowrap">{{ __('Home') }}</a>
            <i class="fas fa-chevron-left text-[10px] text-[var(--text-muted)]"></i>
            <a href="{{ route('projects') }}" class="text-[var(--text-muted)] hover:text-[var(--text-heading)] transition-colors whitespace-nowrap">{{ __('Our Projects') }}</a>
            <i class="fas fa-chevron-left text-[10px] text-[var(--text-muted)]"></i>
            <span class="text-[var(--text-heading)] font-bold truncate max-w-[120px] sm:max-w-[200px] md:max-w-none">{{ $project->title }}</span>
        </nav>
    </div>
</section>

{{-- Project Detail --}}
<section class="py-12 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Image Slider/Gallery --}}
                @if(count($images))
                    <div x-data="{ activeImage: 0 }" class="mb-8">
                        <div class="relative rounded-[var(--radius-lg)] overflow-hidden card-elegant h-64 md:h-96 mb-4">
                            <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-3 left-3 md:top-4 md:left-4 z-10" @@click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                <button class="flex items-center gap-1 px-2 py-1 md:gap-1.5 md:px-3 md:py-1.5 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all">
                                    <i class="fas fa-heart text-xs md:text-sm" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                    <span class="text-[10px] md:text-xs font-medium" x-text="count">0</span>
                                </button>
                            </div>
                            <img :src="images[activeImage]" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="eager">
                            <template x-for="(img, i) in images" :key="i">
                                <div x-show="activeImage === i" x-cloak></div>
                            </template>
                            @if(count($images) > 1)
                                <button @click="activeImage = activeImage > 0 ? activeImage - 1 : images.length - 1" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-9 h-9 md:w-12 md:h-12 rounded-full bg-white/80 flex items-center justify-center text-[var(--gold)] hover:bg-white transition-all">
                                    <i class="fas fa-chevron-right text-sm md:text-base"></i>
                                </button>
                                <button @click="activeImage = activeImage < images.length - 1 ? activeImage + 1 : 0" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-9 h-9 md:w-12 md:h-12 rounded-full bg-white/80 flex items-center justify-center text-[var(--gold)] hover:bg-white transition-all">
                                    <i class="fas fa-chevron-left text-sm md:text-base"></i>
                                </button>
                            @endif
                        </div>
                        @if(count($images) > 1)
                            <div class="flex space-x-2 space-x-reverse overflow-x-auto pb-2 scrollbar-none">
                                @foreach($images as $idx => $img)
                                    <button @click="activeImage = {{ $idx }}" class="flex-shrink-0 w-16 h-12 md:w-20 md:h-16 rounded-lg overflow-hidden border-2 transition-all" :class="activeImage === {{ $idx }} ? 'border-[var(--gold)]/50' : 'border-transparent'">
                                        <img src="{{ $img }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <h1 data-aos="fade-up" class="text-2xl sm:text-3xl md:text-4xl font-black text-[var(--text-heading)] mb-4">{{ $project->title }}</h1>
                <div data-aos="fade-up" class="prose max-w-none text-sm md:text-base text-[var(--text-secondary)] leading-relaxed">
                    {{ $project->description }}
                </div>

                {{-- Videos --}}
                @if(count($videos))
                    <div class="mt-8 md:mt-12">
                        <h2 class="text-xl md:text-2xl font-bold text-[var(--text-heading)] mb-4 md:mb-6">{{ __('Project Videos') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($videos as $video)
                                <video controls class="w-full rounded-[var(--radius-lg)] card-elegant">
                                    <source src="{{ $video }}" type="video/mp4">
                                </video>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1" data-aos="fade-right">
                <div class="bg-[var(--white)] rounded-[var(--radius-lg)] p-4 md:p-6 card-elegant lg:sticky top-28 border border-[var(--stone)]">
                    <h3 class="text-xl font-bold text-[var(--gold)] mb-6">{{ __('Project Information') }}</h3>
                    <div class="space-y-3 md:space-y-4">
                        @if($project->client_name)
                            <div class="flex items-center gap-2 md:gap-3">
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="user" class="w-4 h-4 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">{{ __('Client') }}</span>
                                    <p class="font-bold text-[var(--gold)]">{{ $project->client_name }}</p>
                                </div>
                            </div>
                        @endif
                        @if($project->completion_date)
                            <div class="flex items-center gap-2 md:gap-3">
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="calendar" class="w-4 h-4 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">{{ __('Completion Date') }}</span>
                                    <p class="font-bold text-[var(--gold)]">{{ $project->completion_date->format('d / m / Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($project->services->count())
                            <div class="flex items-center gap-2 md:gap-3">
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="star" class="w-4 h-4 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">{{ __('Services') }}</span>
                                    @foreach($project->services as $service)
                                        <p class="font-bold text-[var(--gold)]">{{ $service->name }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($project->materialCategories->count())
                            <div class="flex items-center gap-2 md:gap-3">
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="star" class="w-4 h-4 md:w-5 md:h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">{{ __('Materials Used') }}</span>
                                    @foreach($project->materialCategories as $mc)
                                        <p class="font-bold text-[var(--gold)]">{{ $mc->name }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-6 md:mt-8 pt-5 md:pt-6 border-t border-[var(--stone)]">
                        <a href="{{ route('contact') }}" class="btn-primary w-full text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg font-bold block text-sm md:text-base">
                            <x-icon name="phone" class="w-4 h-4 md:w-5 md:h-5 inline-block ml-1.5 md:ml-2 align-middle" /> {{ __('Contact for a similar project') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Projects --}}
@if($relatedProjects->count())
    <section class="py-12 md:py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-black text-[var(--gold)]">{{ __('Similar Projects') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($relatedProjects as $related)
                    @php $rImg = is_array($related->images) ? ($related->images[0] ?? '') : $related->images; @endphp
                    <div data-aos="fade-up" class="group relative rounded-[var(--radius-lg)] overflow-hidden img-zoom h-52 md:h-64 card-elegant">
                        <img src="{{ asset('storage/' . $rImg) }}" alt="{{ $related->title }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="overlay-gradient absolute inset-0"></div>
                        <div x-data="{ liked: {{ $related->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $related->likeCount() }} }" class="absolute top-3 left-3 z-10" @@click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $related->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                            <button class="flex items-center gap-1 px-2.5 py-1 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all text-xs">
                                <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                <span x-text="count">0</span>
                            </button>
                        </div>
                        <div class="absolute bottom-4 right-4">
                            <h3 class="text-white font-bold">{{ $related->title }}</h3>
                        </div>
                        <a href="{{ route('project.show', $related->slug) }}" class="absolute inset-0 flex items-center justify-center bg-[var(--gold)]/80 opacity-0 group-hover:opacity-100 transition-all">
                            <span class="text-white font-bold border-2 border-white px-4 py-2 rounded-lg">{{ __('View Project') }}</span>
                        </a>
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
        <span class="block sm:inline text-[var(--text-light)] mb-3 sm:mb-0 sm:ml-2">{{ __('Share this project:') }}</span>
        <div class="flex flex-wrap justify-center gap-2 items-center" dir="ltr">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($project->title . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-4 h-4 md:w-5 md:h-5" /></a>
            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ count($images) ? urlencode($images[0]) : '' }}&description={{ urlencode($project->title) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="pinterest" class="w-4 h-4 md:w-5 md:h-5" /></a>
            @include('partials.social-icons', ['socialLinks' => $shareSocialLinks])
        </div>
    </div>
</section>

@if(count($images))
    <script>
        const images = @json($images);
    </script>
@endif

@endsection