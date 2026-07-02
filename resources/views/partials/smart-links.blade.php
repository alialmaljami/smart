@if(isset($relatedProjects) && $relatedProjects->count())
<section class="py-12">
    <div class="container mx-auto px-4">
        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-8">{{ __('Related Projects') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedProjects as $rp)
                <a href="{{ route('project.show', $rp->slug) }}" class="card-elegant group overflow-hidden">
                    @if($rp->image)
                        <div class="aspect-[16/10] overflow-hidden">
                            <img src="{{ \App\Services\ImageService::asset($rp->image) }}" alt="{{ $rp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4">
                        <h4 class="font-bold text-[var(--text-heading)] text-sm">{{ $rp->title }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($relatedBlogPosts) && $relatedBlogPosts->count())
<section class="py-12 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-8">{{ __('Related Articles') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedBlogPosts as $rp)
                <a href="{{ route('blog.post', $rp->slug) }}" class="card-elegant group overflow-hidden">
                    @if($rp->image)
                        <div class="aspect-[16/10] overflow-hidden">
                            <img src="{{ \App\Services\ImageService::asset($rp->image) }}" alt="{{ $rp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4">
                        <h4 class="font-bold text-[var(--text-heading)] text-sm">{{ $rp->title }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($relatedServices) && $relatedServices->count())
<section class="py-12">
    <div class="container mx-auto px-4">
        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-8">{{ __('Related Services') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedServices as $rs)
                <a href="{{ route('service.show', $rs->slug) }}" class="card-elegant group p-5 text-center">
                    @if($rs->icon)
                        <i class="{{ $rs->icon }} text-3xl text-[var(--gold)] mb-3"></i>
                    @endif
                    <h4 class="font-bold text-[var(--text-heading)] text-sm">{{ $rs->name }}</h4>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($relatedMaterials) && $relatedMaterials->count())
<section class="py-12 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-8">{{ __('Related Materials') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedMaterials as $rm)
                <a href="{{ route('material.show', $rm->slug) }}" class="card-elegant group overflow-hidden">
                    @if($rm->image)
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ \App\Services\ImageService::asset($rm->image) }}" alt="{{ $rm->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4">
                        <h4 class="font-bold text-[var(--text-heading)] text-sm">{{ $rm->name }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
