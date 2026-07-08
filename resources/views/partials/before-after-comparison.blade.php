@if($gallery->show_comparison)
    <div x-data="{ pos: 50 }" class="relative select-none">
        {!! \App\Services\ImageService::picture($gallery->after_image, $gallery->title . ' - ' . __('After'), 'w-full h-64 sm:h-80 md:h-96 object-cover') !!}
        <div class="absolute inset-0 overflow-hidden" :style="'clip-path: inset(0 ' + (100 - pos) + '% 0 0)'">
            {!! \App\Services\ImageService::picture($gallery->before_image, $gallery->title . ' - ' . __('Before'), 'w-full h-64 sm:h-80 md:h-96 object-cover') !!}
        </div>
        <input type="range" min="0" max="100" x-model="pos" class="absolute bottom-2 left-2 right-2 z-10 w-[calc(100%-1rem)]">
    </div>
@else
    <div class="grid grid-cols-2">
        <div class="relative">
            <span class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-0.5 rounded">{{ __('Before') }}</span>
            {!! \App\Services\ImageService::picture($gallery->before_image, $gallery->title . ' - ' . __('Before'), 'w-full h-64 sm:h-80 md:h-96 object-cover') !!}
        </div>
        <div class="relative">
            <span class="absolute top-2 right-2 bg-[var(--gold)]/80 text-white text-xs px-2 py-0.5 rounded">{{ __('After') }}</span>
            {!! \App\Services\ImageService::picture($gallery->after_image, $gallery->title . ' - ' . __('After'), 'w-full h-64 sm:h-80 md:h-96 object-cover') !!}
        </div>
    </div>
@endif
