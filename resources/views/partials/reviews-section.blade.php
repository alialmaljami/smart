@php
    $reviews = \App\Models\Review::where('is_active', true)->latest()->get();
@endphp

<section class="py-20 md:py-28 relative z-10">
    <div class="container mx-auto px-4 lg:px-8">
        <div data-aos="fade-up" class="text-center mb-14">
            <span class="section-label">{{ __('Client Reviews') }}</span>
            <h2 class="section-title text-[var(--text-heading)]">{{ __('What Our Clients Say') }}</h2>
            <div class="section-divider"></div>
        </div>

        @if($reviews->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @foreach($reviews as $review)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" class="card-elegant p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                @if($review->image)
                                    <img src="{{ \App\Services\ImageService::asset($review->image) }}" alt="{{ $review->name }}" class="w-10 h-10 rounded-full object-cover border border-[var(--stone)]" loading="lazy">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[#E07A5F] font-bold text-sm border border-[var(--stone)]/30">
                                        {{ mb_substr($review->name, 0, 1) }}
                                    </div>
                                @endif
                                <h3 class="font-semibold text-[var(--text-heading)] text-sm">{{ $review->name }}</h3>
                            </div>
                            <div class="flex items-center gap-0.5" dir="ltr">
                                @php $starCount = $review->stars ?: 5; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4" style="color: {{ $i <= $starCount ? '#EAB308' : '#cbd5e1' }};">
                                      <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-[var(--text-secondary)] leading-relaxed text-sm">"{{ $review->text }}"</p>
                        @if($review->reply)
                            <div class="mt-3 p-3 bg-black/40 rounded-lg border-r-2 border-[var(--gold)]">
                                <p class="text-xs font-medium text-[var(--gold)] mb-1">{{ __('Reply from management') }}</p>
                                <p class="text-sm text-white/90">{{ $review->reply }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Review Form --}}
        <div data-aos="fade-up" class="max-w-xl mx-auto card-elegant p-8 md:p-10 border border-[var(--stone)]/20">
            <div class="text-center mb-8">
                <h3 class="text-xl font-bold text-[var(--text-heading)]">{{ __('Submit Your Review') }}</h3>
            </div>

            @if(session('review_success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm text-center font-medium">
                    {{ session('review_success') }}
                </div>
            @endif

            <form action="{{ route('review.submit') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    {{-- Stars --}}
                    <div x-data="{ stars: 0, hover: 0 }" class="text-center">
                        <label class="block text-sm font-medium text-[var(--text-light)] mb-2">{{ __('Rating') }}</label>
                        <div class="flex items-center justify-center gap-1">
                            <template x-for="i in 5" :key="i">
                                <button type="button" @click="stars = i" @mouseenter="hover = i" @mouseleave="hover = 0" class="transition-colors duration-150 focus:outline-none" :style="`color: ${(hover || stars) >= i ? '#EAB308' : '#cbd5e1'}`">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 inline-block">
                                      <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="stars" x-model="stars">
                        @error('stars') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="review_name" class="block text-sm font-medium text-[var(--text-light)] mb-1.5">{{ __('Name') }}</label>
                        <input type="text" name="name" id="review_name" value="{{ old('name') }}" required
                               class="input-elegant" placeholder="{{ __('Name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Text --}}
                    <div>
                        <label for="review_text" class="block text-sm font-medium text-[var(--text-light)] mb-1.5">{{ __('Review') }}</label>
                        <textarea name="text" id="review_text" rows="4" required
                                  class="input-elegant resize-none" placeholder="{{ __('Your Message') }}">{{ old('text') }}</textarea>
                        @error('text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full btn-primary justify-center py-3">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
