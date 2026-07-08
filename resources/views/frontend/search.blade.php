@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Search') . ' - ' . __('Smart Designer Decorations') }}">
<meta name="robots" content="noindex">
@endpush

@section('title', __('Search') . ' - ' . __('Smart Designer Decorations'))

@section('content')

{{-- Hero --}}
<section class="relative pt-20 pb-12 md:pt-32 md:pb-16 overflow-hidden bg-[var(--navy)]">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(circle at 30% 50%, var(--cream) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--cream) 0%, transparent 50%);"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center">
            <h1 class="text-4xl md:text-5xl font-black text-[var(--text-heading)] mb-4">{{ __('Search') }}</h1>
            <div class="section-divider"></div>
            <p class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">{{ __('Search results for') }}: <strong class="text-[var(--gold)]">"{{ $q }}"</strong></p>
        </div>
    </div>
</section>

{{-- Search Form --}}
<section class="py-8 bg-[var(--white)] border-b border-[var(--stone)]">
    <div class="container mx-auto px-4">
        <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto"
              toolname="searchSite"
              tooldescription="Search the Smart Designer Decorations website. Accepts: q (search query). Returns: search results page with matching services, projects, materials, and articles.">
            <div class="relative">
                <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('Search for services, projects, materials, articles...') }}"
                       class="w-full px-6 py-4 pr-14 text-base bg-[var(--white)] rounded-2xl shadow-md border border-[var(--stone)] outline-none text-[var(--text-heading)] placeholder-[var(--text-muted)] focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]"
                       toolparamdescription="Search query text">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-[var(--gold)] hover:text-[var(--text-heading)] transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Results --}}
<section class="py-16 bg-[var(--navy)]">
    <div class="container mx-auto px-4">
        @if($results->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $result)
                    @php $item = $result['item']; $type = $result['type']; @endphp
                    @switch($type)
                        @case('service')
                            <div data-aos="fade-up" class="card-elegant group">
                                <div class="p-6">
                                    <span class="text-[10px] font-bold tracking-wider text-[var(--gold)] uppercase">{{ __('Service') }}</span>
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->name }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('service.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Service') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @break
                        @case('project')
                            @php $img = is_array($item->images) ? ($item->images[0] ?? '') : $item->images; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($img)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($img, $item->title, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <span class="text-[10px] font-bold tracking-wider text-[var(--gold)] uppercase">{{ __('Project') }}</span>
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('project.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Project') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @break
                        @case('blog')
                            @php $bImg = is_array($item->images) ? ($item->images[0] ?? '') : $item->image; @endphp
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($bImg)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($bImg, $item->title, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <span class="text-[10px] font-bold tracking-wider text-[var(--gold)] uppercase">{{ __('Article') }}</span>
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                    <a href="{{ route('blog.post', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('Read Article') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @break
                        @case('material')
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                @if($item->image)
                                    <div class="img-zoom h-48">
                                        {!! \App\Services\ImageService::picture($item->image, $item->name, 'w-full h-full object-cover') !!}
                                    </div>
                                @endif
                                <div class="p-6">
                                    <span class="text-[10px] font-bold tracking-wider text-[var(--gold)] uppercase">{{ __('Material') }}</span>
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->name }}</h3>
                                    <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    <a href="{{ route('material.show', $item->slug) }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Material') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @break
                        @case('gallery')
                            <div data-aos="fade-up" class="card-elegant group overflow-hidden">
                                <div class="img-zoom h-48">
                                    {!! \App\Services\ImageService::picture($item->image, $item->title, 'w-full h-full object-cover') !!}
                                </div>
                                <div class="p-6">
                                    <span class="text-[10px] font-bold tracking-wider text-[var(--gold)] uppercase">{{ __('Gallery') }}</span>
                                    <h3 class="text-lg font-bold text-[var(--text-heading)] mt-1 mb-2">{{ $item->title }}</h3>
                                    @if($item->description)
                                        <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    @endif
                                    <a href="{{ route('gallery') }}" class="inline-flex items-center text-[var(--gold)] text-sm font-semibold group-hover:gap-3 transition-all">
                                        {{ __('View Gallery') }} <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @break
                    @endswitch
                @endforeach
            </div>
        @elseif($q)
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)]/50 flex items-center justify-center">
                    <i class="fas fa-search text-3xl text-[var(--text-muted)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-2">{{ __('No results found') }}</h3>
                <p class="text-[var(--text-light)] max-w-md mx-auto">{{ __('No results match') }} "{{ $q }}". {{ __('Try different keywords') }}</p>
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[var(--stone)]/50 flex items-center justify-center">
                    <i class="fas fa-search text-3xl text-[var(--text-muted)]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-2">{{ __('Enter search keyword') }}</h3>
                <p class="text-[var(--text-light)] max-w-md mx-auto">{{ __('Search for services, projects, materials, articles...') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection