@php
    $categories = App\Models\Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
@endphp

@extends('layouts.app')

@push('meta')
<meta name="description" content="مواد الديكور من ديكورات المصمم الذكي - تشكيلة واسعة من مواد الديكور عالية الجودة: الخشب، الرخام، الحجر، ورق الجدران، الإضاءة، الستائر، والأكسسوارات.">
<meta name="keywords" content="مواد ديكور, خشب, رخام, حجر, ورق جدران, إضاءة, ستائر, ديكور, الرياض">
<meta property="og:title" content="مواد الديكور - ديكورات المصمم الذكي">
<meta property="og:description" content="تشكيلة واسعة من مواد الديكور عالية الجودة">
@endpush

@section('title', 'مواد الديكور - ديكورات المصمم الذكي')

@section('content')

{{-- Hero --}}
<section class="relative py-32 flex items-center justify-center overflow-hidden bg-gradient-to-br from-[var(--navy)] to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="relative z-10 text-center px-4">
        <h1 data-aos="fade-up" class="text-5xl md:text-6xl font-black text-white mb-4">مواد الديكور</h1>
        <div class="section-divider"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-[var(--text-light)] text-lg max-w-2xl mx-auto">تشكيلة واسعة من أجود مواد الديكور لتلبية جميع احتياجات مشروعك</p>
    </div>
</section>

{{-- Categories Grid --}}
<section class="py-20 bg-[var(--cream)]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 30 }}" class="card-elegant">
                    <div class="img-zoom h-56">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[var(--stone)]">
                                <i class="fas fa-box text-6xl text-[var(--text-light)]"></i>
                            </div>
                        @endif
                        <div class="overlay-gradient absolute inset-0"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-[var(--text-heading)] mb-3">{{ $category->name }}</h3>
                        @if($category->description)
                            <p class="text-[var(--text-light)] text-sm leading-relaxed mb-4">{{ Str::limit($category->description, 80) }}</p>
                        @endif
                        <a href="{{ route('material.category.show', $category->slug) }}" class="inline-flex items-center btn-primary px-6 py-2 rounded-lg font-bold text-sm">
                            تصفح المجموعة <i class="fas fa-arrow-left mr-2"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-cubes text-6xl text-[var(--stone)] mb-4"></i>
                    <p class="text-[var(--text-light)] text-xl">لا توجد تصنيفات متاحة حالياً</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-[var(--gold)]">
    <div class="container mx-auto px-4 text-center">
        <h2 data-aos="fade-up" class="text-3xl md:text-4xl font-black text-white mb-4">تحتاج مساعدة في اختيار المواد؟</h2>
        <p data-aos="fade-up" data-aos-delay="100" class="text-white/80 text-lg mb-8">فريقنا جاهز لتقديم الاستشارات والنصائح لاختيار أفضل المواد لمشروعك</p>
        <a data-aos="fade-up" data-aos-delay="200" href="{{ route('contact') }}" class="btn-light inline-flex items-center px-8 py-3 rounded-lg font-bold">
            <x-icon name="phone" class="w-5 h-5 inline-block ml-2 align-middle" /> استشرنا الآن
        </a>
    </div>
</section>

@endsection
