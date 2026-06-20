<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($staticCities as $c)
    <url>
        <loc>{{ $c['loc'] }}</loc>
        <lastmod>{{ $c['lastmod']->toIso8601String() }}</lastmod>
        <changefreq>{{ $c['changefreq'] }}</changefreq>
        <priority>{{ $c['priority'] }}</priority>
    </url>
@endforeach
@foreach($questions as $q)
    <url>
        <loc>{{ route('q.show', $q->slug) }}</loc>
        <lastmod>{{ $q->updated_at->toIso8601String() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
@endforeach
</urlset>
