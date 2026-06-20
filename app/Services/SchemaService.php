<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\SocialLink;

class SchemaService
{
    public static function localBusiness(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => url('/') . '#organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'logo' => asset('storage/' . Setting::getValue('logo', '')),
            'image' => asset('storage/' . Setting::getValue('logo', '')),
            'description' => __('Smart Designer Decorations') . ' - ' . __('Professional decoration and design services'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressRegion' => 'Saudi Arabia',
            ],
            'telephone' => Setting::getValue('phone', ''),
            'email' => Setting::getValue('email', ''),
            'sameAs' => self::getSocialLinks(),
            'priceRange' => 'SAR 5,000 - SAR 500,000',
        ];
    }

    public static function breadcrumbList(array $items): array
    {
        $itemList = [];
        foreach ($items as $i => $item) {
            $itemList[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemList,
        ];
    }

    public static function article(string $title, string $description, ?string $image = null, ?string $datePublished = null, ?string $author = null, ?string $dateModified = null): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title,
            'description' => $description,
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('storage/' . Setting::getValue('logo', '')),
                ],
            ],
        ];
        if ($image) $schema['image'] = asset('storage/' . $image);
        if ($datePublished) $schema['datePublished'] = $datePublished;
        if ($dateModified) $schema['dateModified'] = $dateModified;
        if ($author) $schema['author'] = ['@type' => 'Person', 'name' => $author];
        return ['@context' => 'https://schema.org', ...$schema];
    }

    public static function service(array $service): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'],
            'description' => $service['description'],
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => config('app.name'),
            ],
            'url' => $service['url'],
            'image' => $service['image'] ?? null,
        ];
    }

    public static function product(array $product): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $product['description'],
            'image' => $product['image'] ?? null,
            'offers' => [
                '@type' => 'Offer',
                'price' => $product['price'] ?? '0',
                'priceCurrency' => 'SAR',
            ],
        ];
    }

    public static function review(array $review): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'reviewBody' => $review['text'],
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => $review['stars'],
                'bestRating' => 5,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $review['name'],
            ],
        ];
    }

    public static function faqPage(array $questions): array
    {
        $mainEntity = [];
        foreach ($questions as $q) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $q['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $q['answer'],
                ],
            ];
        }
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity,
        ];
    }

    public static function imageObject(string $url, string $caption, int $width = 1200, int $height = 800): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ImageObject',
            'url' => $url,
            'caption' => $caption,
            'width' => $width,
            'height' => $height,
        ];
    }

    public static function renderSchemas(array $schemas): string
    {
        $output = '';
        foreach ($schemas as $schema) {
            $output .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        }
        return $output;
    }

    private static function getSocialLinks(): array
    {
        $links = [];
        if ($socials = \App\Models\SocialLink::where('is_active', true)->get()) {
            foreach ($socials as $social) {
                $links[] = $social->url;
            }
        }
        return $links;
    }
}
