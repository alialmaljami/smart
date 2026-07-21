<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
@php $params = $params ?? []; @endphp
@foreach($items as $item)
@php
    $url = route($route, count($params) ? array_combine($params, [$item->{$params[array_key_first($params)]}, $item->{$params[array_key_last($params)] ?? array_key_first($params)}]) : [$item->slug]);
@endphp
    <url>
        <loc>{{ $url }}</loc>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $url }}" />
        <xhtml:link rel="alternate" hreflang="en" href="{{ str_contains($url, '?') ? $url . '&_locale=en' : $url . '?_locale=en' }}" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url }}" />
        <lastmod>{{ $item->updated_at->toIso8601String() }}</lastmod>
        <changefreq>{{ $changefreq }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
@endforeach
</urlset>
