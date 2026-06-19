@php
    $reviews = \App\Models\Review::where('is_active', true)->latest()->get();
@endphp

<section class="py-20 md:py-28 bg-[var(--white)]">
    <div class="container mx-auto px-4 lg:px-8">
        <div data-aos="fade-up" class="text-center mb-14">
            <span class="section-label">آراء العملاء</span>
            <h2 class="section-title text-[var(--text-heading)]">ماذا قالوا عنا</h2>
            <div class="section-divider"></div>
            <p class="text-[var(--text-light)] max-w-xl mx-auto mt-4 text-base">نفخر بثقة عملائنا التي هي الدافع الحقيقي لتقديم الأفضل دائماً</p>
        </div>

        @if($reviews->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @foreach($reviews as $review)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" class="card-elegant p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                @if($review->image)
                                    <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->name }}" class="w-10 h-10 rounded-full object-cover border border-[var(--stone)]">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[var(--gold)]/5 flex items-center justify-center text-[var(--gold)] font-bold text-sm border border-[var(--stone)]/30">
                                        {{ mb_substr($review->name, 0, 1) }}
                                    </div>
                                @endif
                                <h3 class="font-semibold text-[var(--text-heading)] text-sm">{{ $review->name }}</h3>
                            </div>
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $review->stars ? 'text-[var(--gold)]' : 'text-[var(--stone)]' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-[var(--text-light)] leading-relaxed text-sm">"{{ $review->text }}"</p>
                        <div class="mt-4 pt-4 border-t border-[var(--stone)]/20">
                            <div class="flex text-[var(--gold)]">
                                @for($i = 1; $i <= $review->stars; $i++)
                                    <i class="fas fa-star text-xs"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Review Form --}}
        <div data-aos="fade-up" class="max-w-xl mx-auto card-elegant p-8 md:p-10 border border-[var(--stone)]/20">
            <div class="text-center mb-8">
                <h3 class="text-xl font-bold text-[var(--text-heading)]">أضف تقييمك</h3>
                <p class="text-[var(--text-light)] text-sm mt-1">شاركنا رأيك وتجربتك معنا</p>
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
                        <label class="block text-sm font-medium text-[var(--text-light)] mb-2">تقييمك</label>
                        <div class="flex items-center justify-center gap-1">
                            <template x-for="i in 5" :key="i">
                                <button type="button" @@click="stars = i" @@mouseenter="hover = i" @@mouseleave="hover = 0" class="text-2xl transition-colors duration-150 focus:outline-none" :class="(hover || stars) >= i ? 'text-[var(--gold)]' : 'text-[var(--stone)]'">
                                    <i class="fas fa-star"></i>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="stars" x-model="stars">
                        @error('stars') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="review_name" class="block text-sm font-medium text-[var(--text-light)] mb-1.5">الاسم</label>
                        <input type="text" name="name" id="review_name" value="{{ old('name') }}" required
                               class="input-elegant" placeholder="اسمك الكريم">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Text --}}
                    <div>
                        <label for="review_text" class="block text-sm font-medium text-[var(--text-light)] mb-1.5">التقييم</label>
                        <textarea name="text" id="review_text" rows="4" required
                                  class="input-elegant resize-none" placeholder="اكتب رأيك وتجربتك معنا...">{{ old('text') }}</textarea>
                        @error('text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full btn-primary justify-center py-3">
                        إرسال التقييم
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
