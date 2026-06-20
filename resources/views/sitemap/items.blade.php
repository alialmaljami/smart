<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@php $params = $params ?? []; @endphp
@foreach($items as $item)
    <url>
        <loc>{{ route($route, count($params) ? array_combine($params, [$item->{$params[array_key_first($params)]}, $item->{$params[array_key_last($params)] ?? array_key_first($params)}]) : [$item->slug]) }}</loc>
        <lastmod>{{ $item->updated_at->toIso8601String() }}</lastmod>
        <changefreq>{{ $changefreq }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
@endforeach
</urlset>
