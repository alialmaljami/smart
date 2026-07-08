<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach($pages as $p)
    <url>
        <loc>{{ $p['loc'] }}</loc>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $p['loc'] }}" />
        <xhtml:link rel="alternate" hreflang="en" href="{{ $p['loc'] }}?_locale=en" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $p['loc'] }}" />
        <changefreq>{{ $p['changefreq'] }}</changefreq>
        <priority>{{ $p['priority'] }}</priority>
    </url>
@endforeach
</urlset>
