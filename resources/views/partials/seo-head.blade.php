@php
    $locale = app()->getLocale();
    $otherLocale = $locale === 'ar' ? 'en' : 'ar';
    $currentUrl = url()->current();
    $otherUrl = url()->current();
    // Cache bust for path: replace /ar/ or /en/ prefix if needed
    if (request()->route()) {
        $routeName = request()->route()->getName();
        $routeParams = request()->route()->parameters();
        try {
            $otherUrl = route($routeName, array_merge($routeParams, ['_locale' => $otherLocale]));
        } catch (\Exception $e) {
            $otherUrl = $currentUrl;
        }
    }
    $siteName = __('Smart Designer Decorations');
    $defaultTitle = $siteName;
    $pageTitle = trim(view()->yieldContent('title')) ?: $defaultTitle;
    $pageDescription = view()->yieldContent('description') ?: __('Smart Designer Decorations - Professional interior design and decoration services in Saudi Arabia');
    $pageImage = view()->yieldContent('image') ?: url('/storage/settings/og-default.jpg');
    if (!file_exists(public_path('/storage/settings/og-default.jpg')) && file_exists(public_path('/storage/settings/logo.png'))) {
        $pageImage = url('/storage/settings/logo.png');
    }
    $pageType = view()->yieldContent('og_type') ?: 'website';
@endphp

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $currentUrl }}" />

{{-- Hreflang --}}
<link rel="alternate" hreflang="ar" href="{{ $locale === 'ar' ? $currentUrl : $otherUrl }}" />
<link rel="alternate" hreflang="en" href="{{ $locale === 'en' ? $currentUrl : $otherUrl }}" />
<link rel="alternate" hreflang="x-default" href="{{ $locale === 'ar' ? $currentUrl : $otherUrl }}" />

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:title" content="{{ $pageTitle }}" />
<meta property="og:description" content="{{ $pageDescription }}" />
<meta property="og:url" content="{{ $currentUrl }}" />
<meta property="og:image" content="{{ $pageImage }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:type" content="{{ $pageType }}" />
<meta property="og:locale" content="{{ $locale === 'ar' ? 'ar_AR' : 'en_US' }}" />

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $pageTitle }}" />
<meta name="twitter:description" content="{{ $pageDescription }}" />
<meta name="twitter:image" content="{{ $pageImage }}" />

{{-- Additional Meta --}}
<meta name="description" content="{{ $pageDescription }}" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
