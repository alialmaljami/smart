@php
    $youtubeMatch = preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $ym);
    $vimeoMatch = preg_match('/(?:vimeo\.com\/(?:video\/)?)(\d+)/', $url, $vm);
@endphp
@if($youtubeMatch)
    <iframe src="https://www.youtube.com/embed/{{ $ym[1] }}" title="{{ $title ?? '' }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full absolute inset-0"></iframe>
@elseif($vimeoMatch)
    <iframe src="https://player.vimeo.com/video/{{ $vm[1] }}" title="{{ $title ?? '' }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="w-full h-full absolute inset-0"></iframe>
@else
    <video controls class="w-full h-full object-cover">
        <source src="{{ $url }}" type="video/mp4">
    </video>
@endif
