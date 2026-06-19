@php
    $platformIcons = [
        'whatsapp' => ['color' => '#25D366'],
        'telegram' => ['color' => '#2AABEE'],
        'instagram' => ['color' => '#E4405F'],
        'tiktok' => ['color' => '#000000'],
        'pinterest' => ['color' => '#E60023'],
        'google_maps' => ['color' => '#4285F4'],
        'x_twitter' => ['color' => '#000000'],
        'linkedin' => ['color' => '#0A66C2'],
        'youtube' => ['color' => '#FF0000'],
        'facebook' => ['color' => '#1877F2'],
        'snapchat' => ['color' => '#FFFC00'],
        'website' => ['color' => '#D4AF37'],
        'location' => ['color' => '#D4AF37'],
        'email' => ['color' => '#EA4335'],
        'phone' => ['color' => '#34A853'],
    ];
@endphp

@if(isset($socialLinks) && $socialLinks->count())
    @foreach($socialLinks as $link)
        @php
            $platform = $platformIcons[$link->platform] ?? ['color' => '#D4AF37'];
        @endphp
        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full transition-all duration-300 hover:scale-110 hover:shadow-lg"
           style="background: {{ $platform['color'] }}; color: white;"
           title="{{ $link->platform }}">
            <x-icon :name="$link->platform" class="w-3.5 h-3.5" />
        </a>
    @endforeach
@endif
