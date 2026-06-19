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

@section('title', ($project->meta_title ?? $project->title) . ' - ديكورات المصمم الذكي')

@section('content')

{{-- Breadcrumb --}}
<section class="pt-28 pb-4 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 space-x-reverse text-sm text-[var(--stone)]">
            <a href="{{ route('home') }}" class="text-[var(--cream)] hover:text-white transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <a href="{{ route('projects') }}" class="text-[var(--cream)] hover:text-white transition-colors">مشاريعنا</a>
            <i class="fas fa-chevron-left text-xs"></i>
            <span class="text-[var(--cream)] font-bold">{{ $project->title }}</span>
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
                        <div class="relative rounded-[var(--radius-lg)] overflow-hidden card-elegant h-96 mb-4">
                            <div x-data="{ liked: {{ $project->isLikedByCurrentUser() ? 'true' : 'false' }}, count: {{ $project->likeCount() }} }" class="absolute top-4 left-4 z-10" @@click="fetch('{{ route('like.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'project', id: {{ $project->id }} }) }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-black/40 backdrop-blur-sm rounded-full text-white hover:bg-black/60 transition-all">
                                    <i class="fas fa-heart" :class="liked ? 'text-red-500' : 'text-white/70'"></i>
                                    <span class="text-xs font-medium" x-text="count">0</span>
                                </button>
                            </div>
                            <img :src="images[activeImage]" alt="{{ $project->title }}" class="w-full h-full object-cover">
                            <template x-for="(img, i) in images" :key="i">
                                <div x-show="activeImage === i" x-cloak></div>
                            </template>
                            @if(count($images) > 1)
                                <button @click="activeImage = activeImage > 0 ? activeImage - 1 : images.length - 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 flex items-center justify-center text-[var(--gold)] hover:bg-white transition-all">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <button @click="activeImage = activeImage < images.length - 1 ? activeImage + 1 : 0" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 flex items-center justify-center text-[var(--gold)] hover:bg-white transition-all">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @endif
                        </div>
                        @if(count($images) > 1)
                            <div class="flex space-x-2 space-x-reverse overflow-x-auto pb-2">
                                @foreach($images as $idx => $img)
                                    <button @click="activeImage = {{ $idx }}" class="flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 transition-all" :class="activeImage === {{ $idx }} ? 'border-[var(--gold)]/50' : 'border-transparent'">
                                        <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <h1 data-aos="fade-up" class="text-3xl md:text-4xl font-black text-[var(--cream)] mb-4">{{ $project->title }}</h1>
                <div data-aos="fade-up" class="prose max-w-none text-[var(--stone)] leading-relaxed">
                    {{ $project->description }}
                </div>

                {{-- Videos --}}
                @if(count($videos))
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-[var(--cream)] mb-6">فيديوهات المشروع</h2>
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
                <div class="bg-[var(--white)] rounded-[var(--radius-lg)] p-6 card-elegant sticky top-28 border border-[var(--stone)]">
                    <h3 class="text-xl font-bold text-[var(--gold)] mb-6">معلومات المشروع</h3>
                    <div class="space-y-4">
                        @if($project->client_name)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="user" class="w-5 h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">العميل</span>
                                    <p class="font-bold text-[var(--gold)]">{{ $project->client_name }}</p>
                                </div>
                            </div>
                        @endif
                        @if($project->completion_date)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="calendar" class="w-5 h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">تاريخ الإنجاز</span>
                                    <p class="font-bold text-[var(--gold)]">{{ $project->completion_date->format('d / m / Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($project->services->count())
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="star" class="w-5 h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">الخدمات</span>
                                    @foreach($project->services as $service)
                                        <p class="font-bold text-[var(--gold)]">{{ $service->name }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($project->materialCategories->count())
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[var(--gold)]/10 flex items-center justify-center">
                                    <x-icon name="star" class="w-5 h-5 text-[var(--gold)]" />
                                </div>
                                <div>
                                    <span class="text-[var(--text-light)] text-sm">المواد المستخدمة</span>
                                    @foreach($project->materialCategories as $mc)
                                        <p class="font-bold text-[var(--gold)]">{{ $mc->name }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-8 pt-6 border-t border-[var(--stone)]">
                        <a href="{{ route('contact') }}" class="btn-primary w-full text-center px-6 py-3 rounded-lg font-bold block">
                            <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> تواصل لمشروع مماثل
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Projects --}}
@if($relatedProjects->count())
    <section class="py-16 bg-[var(--white)]">
        <div class="container mx-auto px-4">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="text-3xl font-black text-[var(--gold)]">مشاريع مشابهة</h2>
                <div class="section-divider"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProjects as $related)
                    @php $rImg = is_array($related->images) ? ($related->images[0] ?? '') : $related->images; @endphp
                    <div data-aos="fade-up" class="group relative rounded-[var(--radius-lg)] overflow-hidden img-zoom h-64 card-elegant">
                        <img src="{{ asset('storage/' . $rImg) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
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
                            <span class="text-white font-bold border-2 border-white px-4 py-2 rounded-lg">عرض المشروع</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Social Share --}}
<section class="py-8 bg-[var(--cream)] border-t border-[var(--stone)]">
    <div class="container mx-auto px-4 text-center">
        <span class="text-[var(--text-light)] ml-2">شارك هذا المشروع:</span>
        <div class="inline-flex space-x-2 space-x-reverse" dir="ltr">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="facebook" class="w-5 h-5" /></a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($project->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#000000] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="x_twitter" class="w-5 h-5" /></a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($project->title . ' ' . request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="whatsapp" class="w-5 h-5" /></a>
            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ count($images) ? urlencode($images[0]) : '' }}&description={{ urlencode($project->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#E60023] text-white flex items-center justify-center hover:scale-110 transition-transform"><x-icon name="pinterest" class="w-5 h-5" /></a>
        </div>
    </div>
</section>

@if(count($images))
    <script>
        const images = @json($images);
    </script>
@endif

@endsection
