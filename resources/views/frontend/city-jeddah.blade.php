@extends('layouts.app')

@push('meta')
<meta name="description" content="أفضل خدمات الديكور والتصميم الداخلي في جدة - المصمم الذكي للديكور. ديكورات منازل، فلل، شقق، مجالس، ومكاتب بأعلى جودة">
<meta name="keywords" content="ديكور جدة, تصميم داخلي جدة, ديكور منازل جدة, ديكور فلل جدة, مصمم ديكور جدة, أفضل شركة ديكور جدة">
<meta property="og:title" content="ديكورات جدة - المصمم الذكي للديكور">
<meta property="og:description" content="أفضل خدمات الديكور والتصميم الداخلي في جدة">
@endpush

@section('title', 'ديكورات جدة - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-24 pb-16 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-city text-2xl md:text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">ديكورات جدة</h1>
            <p class="text-[var(--text-light)] text-lg">أفضل خدمات التصميم الداخلي والديكور في جدة - المصمم الذكي للديكور</p>
        </div>
    </div>
</section>

<section class="py-12 md:py-20 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div data-aos="fade-left">
                <span class="section-label">ديكورات جدة</span>
                <h2 class="text-2xl md:text-3xl font-black text-[var(--text-heading)] mt-3 mb-4">شركة المصمم الذكي للديكور في جدة</h2>
                <p class="text-[var(--text-light)] leading-relaxed mb-6">
                    نقدم في شركة المصمم الذكي للديكور أفضل خدمات التصميم الداخلي والديكور في جدة. 
                    نمتلك فريقاً من أمهر المصممين والمهندسين المتخصصين في تنفيذ أحدث صيحات الديكور 
                    العصري والكلاسيكي. نحرص على تقديم تصاميم فريدة تناسب ذوقك وميزانيتك.
                </p>
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-[var(--text-heading)] mb-3">نغطي جميع أحياء جدة:</h3>
                    <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أبحر الجنوبية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أبحر الشمالية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أبرق الرغامة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأجاويد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأجواد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأصالة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأمير فواز الشمالي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأمير فواز الجنوبي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأمير عبدالمجيد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأندلس</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأمل</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأمواج</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البساتين</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البغدادية الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البغدادية الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البوادي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البلد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البيان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">التوفيق</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الثغر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجامعة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحمدانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحمراء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحرازات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحرمين</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخالدية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخليج</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخمرة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخمرة السرورية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الربوة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الرحاب</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الرحمانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الروابي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الروضة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الرويس</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الريان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزاهرة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزهراء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السامر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السلامة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السليمانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السليمانية الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السليمانية الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السنابل</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشاطئ</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشراع</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشرفية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصفا</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصفا 1</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصفا 2</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصالحية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصناعية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفيحاء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفيصلية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفلاح</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفردوس</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفروسية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">القريات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكندرة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكوثر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المحجر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المحمدية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المروة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المرسلات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المرجان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المنتزهات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المنار</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المنارات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النخيل</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النزلة اليمانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النزلة الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النزلة الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النزهة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النهضة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النسيم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النعيم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الواحة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الورود</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الودي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الوفاء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الياقوت</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">بريمان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">بني مالك</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">مدائن الفهد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">مشرفة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">قويزة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 10</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 11</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 13</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 14</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 7</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 8</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كيلو 9</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم السلم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم حبلين الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم حبلين الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">ذهبان</span>
                    </div>
                </div>
                <div class="space-y-2 md:space-y-3">
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">تصميم وتنفيذ ديكورات المنازل والفلل</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">ديكورات المجلس والغرف والمعيشة</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">ديكورات المطابخ والحمامات العصرية</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">واجهات خارجية وحدائق منزلية</span>
                    </div>
                </div>
            </div>
            <div data-aos="fade-right" class="rounded-2xl overflow-hidden h-48 md:h-96 bg-gradient-to-br from-[var(--navy)] to-[var(--navy)] flex items-center justify-center">
                <div class="text-center p-4 md:p-8">
                    <i class="fas fa-city text-3xl md:text-6xl text-[var(--gold)]/30 mb-2 md:mb-4"></i>
                    <p class="text-[var(--text-light)] text-sm md:text-lg">جدة - المملكة العربية السعودية</p>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="text-center bg-[var(--white)] rounded-2xl p-5 md:p-10 shadow-sm border border-[var(--stone)]">
            <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-4">احصل على استشارة مجانية في جدة</h3>
            <p class="text-[var(--text-light)] mb-8 max-w-xl mx-auto">تواصل معنا اليوم للحصول على استشارة مجانية لمشروعك في جدة</p>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">تواصل معنا</a>
        </div>
    </div>
</section>

@if($services->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Services') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($services as $s)
                @php $imgs = array_values(array_filter(array_merge([$s->image], $s->images ?? []))); @endphp
                <a href="{{ route('service.show', $s->slug) }}" class="card-elegant group overflow-hidden rounded-2xl">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)] mb-1">{{ $s->name }}</h3>
                        <p class="text-[var(--text-secondary)] text-xs md:text-sm">{{ Str::limit($s->description, 80) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('services') }}" class="btn-outline px-6 py-3">عرض جميع الخدمات</a>
        </div>
    </div>
</section>
@endif

@if($galleries->count())
<section class="py-12 md:py-16 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Gallery') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($galleries as $g)
                <a href="{{ route('gallery.show', [$g->id, $g->slug]) }}" class="group aspect-square overflow-hidden rounded-xl">
                    <img src="{{ \App\Services\ImageService::asset($g->image) }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('gallery') }}" class="btn-outline px-6 py-3">عرض المعرض</a>
        </div>
    </div>
</section>
@endif

@if($projects->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Recent Projects') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            @foreach($projects as $p)
                @php $imgs = array_values(array_filter(array_merge([$p->image], $p->images ?? []))); @endphp
                <a href="{{ route('project.show', $p->slug) }}" class="card-elegant group overflow-hidden">
                    @if($imgs)
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($imgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="'/storage/' + img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </template>
                        </div>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-sm md:text-base text-[var(--text-heading)]">{{ $p->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
        <div data-aos="fade-up" class="text-center mt-8">
            <a href="{{ route('projects') }}" class="btn-outline px-6 py-3">عرض جميع المشاريع</a>
        </div>
    </div>
</section>
@endif

<section class="py-12 md:py-16 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 text-center">
        <div data-aos="fade-up">
            <h2 class="section-title text-[var(--text-heading)] mb-4">أعمالنا في جدة</h2>
            <div class="section-divider mb-8"></div>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>

@endsection
