<div class="aspect-square bg-black relative">
    @if($url)
        <iframe src="{{ $url }}" title="{{ $title ?? '' }}" frameborder="0" allowfullscreen class="w-full h-full absolute inset-0"></iframe>
    @elseif(isset($image) && $image)
        {!! \App\Services\ImageService::picture($image, $title ?? '', 'w-full h-full object-cover') !!}
    @endif
</div>
