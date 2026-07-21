<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach($staticCities as $c)
    <url>
        <loc>{{ $c['loc'] }}</loc>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $c['loc'] }}" />
        <xhtml:link rel="alternate" hreflang="en" href="{{ $c['loc'] }}?_locale=en" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $c['loc'] }}" />
        <lastmod>{{ $c['lastmod']->toIso8601String() }}</lastmod>
        <changefreq>{{ $c['changefreq'] }}</changefreq>
        <priority>{{ $c['priority'] }}</priority>
    </url>
@endforeach
@foreach($questions as $q)
    @php $qUrl = route('q.show', $q->slug); @endphp
    <url>
        <loc>{{ $qUrl }}</loc>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $qUrl }}" />
        <xhtml:link rel="alternate" hreflang="en" href="{{ $qUrl }}?_locale=en" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $qUrl }}" />
        <lastmod>{{ $q->updated_at->toIso8601String() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
@endforeach
</urlset>
