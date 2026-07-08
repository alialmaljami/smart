@extends('layouts.app')

@push('meta')
<meta name="description" content="أفضل خدمات الديكور والتصميم الداخلي في مكة المكرمة - المصمم الذكي للديكور. ديكورات منازل، فلل، شقق، مجالس، ومكاتب بأعلى جودة">
<meta name="keywords" content="ديكور مكة, تصميم داخلي مكة, ديكور منازل مكة, ديكور فلل مكة, مصمم ديكور مكة, أفضل شركة ديكور مكة">
<meta property="og:title" content="ديكورات مكة - المصمم الذكي للديكور">
<meta property="og:description" content="أفضل خدمات الديكور والتصميم الداخلي في مكة المكرمة">
@endpush

@section('title', 'ديكورات مكة - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-24 pb-16 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(circle at 30% 50%, var(--gold) 0%, transparent 50%), radial-gradient(circle at 70% 50%, var(--gold) 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                <i class="fas fa-mosque text-2xl md:text-3xl text-[var(--gold)]"></i>
            </div>
            <h1 class="text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">ديكورات مكة</h1>
            <p class="text-[var(--text-light)] text-lg">أفضل خدمات التصميم الداخلي والديكور في مكة المكرمة - المصمم الذكي للديكور</p>
        </div>
    </div>
</section>

<section class="py-12 md:py-20 bg-[var(--navy)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div data-aos="fade-left">
                <span class="section-label">ديكورات مكة</span>
                <h2 class="text-2xl md:text-3xl font-black text-[var(--text-heading)] mt-3 mb-4">شركة المصمم الذكي للديكور في مكة المكرمة</h2>
                <p class="text-[var(--text-light)] leading-relaxed mb-6">
                    نقدم في شركة المصمم الذكي للديكور أفضل خدمات التصميم الداخلي والديكور في مكة المكرمة.
                    لدينا فريق متخصص في تنفيذ ديكورات المنازل والفلل والشقق في مكة بأحدث التصاميم 
                    وأعلى معايير الجودة. نحرص على تلبية احتياجات عملائنا في مكة بأسعار تنافسية.
                </p>
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-[var(--text-heading)] mb-3">نغطي جميع أحياء مكة:</h3>
                    <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أجياد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أجياد السد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أجياد المصافي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأندلس</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الإسكان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأشراف</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الأزهري</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البحيرات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">البيبان</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">التخصصي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">التنعيم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">التيسير</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجميزة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجفالي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجميزة الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجعرانة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الجامعة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحجون</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحمراء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحسينية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحفائر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحمراء وأم الجود</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الحوية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخالدية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخنساء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخضراء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الخنساء الشمالية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الرصيفة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الروابي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الروضة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزاهر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزاهر الغربي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزاهر الشرقي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزاهر الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزايدي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الزيمة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السبهانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السليمانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">السلامة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشامية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشرائع</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشرائع الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الششة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشهداء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشوقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الشوقية الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الصفا</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الطندباوي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العتيبية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية الجنوبية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العزيزية الشمالية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العمرة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العمرة الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العوالي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العكيشية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العوالي الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">العسيلة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الغزة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الغسالة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الفيحاء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">القرارة الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكعكية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكدوة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الكوثر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">اللحيانية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المعابدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المعابدة الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المعابدة الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المعابدة الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المعيصم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الملك فهد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الملك عبدالله</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المسفلة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المشاعر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المشاعر الجنوبية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المشاعر الشمالية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المشاعر الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المشاعر الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المطار</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">المرسلات</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النزهة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النورية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">النسيم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهجرة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهنداوية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهجلة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهدا</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهدا الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهجرة الغربية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهجرة الشرقية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الهجرة الحديثة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">الوادي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">وادي جليل</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">ولي العهد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">بطحاء قريش</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">بطحاء قريش الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">جبل النور</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">جبل ثور</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">جرهم</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">جرول</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">جرول الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">ريع ذاخر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">شعب عامر</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">شعب علي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">شارع الحج</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كدي</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كدي الجديدة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كدي المسفلة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">كراء</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">محبس الجن</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">مخطط الملك فهد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">مخطط ولي العهد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الجود</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الكتاد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الكتد</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الزلة</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الحمام</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أم الجود الصناعية</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">أبو مراغ</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-[var(--gold)]/10 text-[var(--gold)] border border-[var(--gold)]/20">زهرة العمرة</span>
                    </div>
                </div>
                <div class="space-y-2 md:space-y-3">
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">تصميم داخلي للمنازل والفلل بمكة</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">ديكورات مجالس وغرف استقبال فاخرة</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">تشطيب وديكور الشقق السكنية</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-[var(--gold)]/10 flex items-center justify-center text-[var(--gold)] shrink-0"><i class="fas fa-check text-xs md:text-base"></i></div>
                        <span class="text-sm md:text-base text-[var(--text-light)]">ديكورات مطابخ وحمامات عصرية</span>
                    </div>
                </div>
            </div>
            <div data-aos="fade-right" class="rounded-2xl overflow-hidden h-48 md:h-96 bg-gradient-to-br from-[var(--navy)] to-[var(--navy)] flex items-center justify-center">
                <div class="text-center p-4 md:p-8">
                    <i class="fas fa-mosque text-3xl md:text-6xl text-[var(--gold)]/30 mb-2 md:mb-4"></i>
                    <p class="text-[var(--text-light)] text-sm md:text-lg">مكة المكرمة - المملكة العربية السعودية</p>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="text-center bg-[var(--white)] rounded-2xl p-5 md:p-10 shadow-sm border border-[var(--stone)]">
            <h3 class="text-2xl font-bold text-[var(--text-heading)] mb-4">احصل على استشارة مجانية في مكة</h3>
            <p class="text-[var(--text-light)] mb-8 max-w-xl mx-auto">تواصل معنا اليوم للحصول على استشارة مجانية لمشروعك في مكة المكرمة</p>
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
                        @php $pimgs = array_map(fn($i) => asset('storage/' . \App\Services\ImageService::webp('storage/' . $i)), $imgs); @endphp
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($pimgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                     loading="lazy" decoding="async" width="800" height="500">
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

@if($neighborhoods->count())
<section class="py-12 md:py-16 bg-[var(--white)] overflow-x-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div data-aos="fade-up" class="text-center mb-8 md:mb-12">
            <h2 class="section-title text-[var(--text-heading)]">{{ __('Neighborhoods We Serve in Mecca') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
            @foreach($neighborhoods as $n)
                <a href="{{ route('area.show', $n->slug) }}" class="group bg-[var(--navy)]/5 hover:bg-[var(--gold)]/10 rounded-xl p-4 text-center transition-all">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                        <i class="fas fa-map-pin text-[var(--gold)]"></i>
                    </div>
                    <h3 class="font-bold text-sm text-[var(--text-heading)] group-hover:text-[var(--gold)] transition-colors">{{ $n->name }}</h3>
                </a>
            @endforeach
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
                    {!! \App\Services\ImageService::picture($g->image, $g->title, 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700') !!}
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
                        @php $pimgs = array_map(fn($i) => asset('storage/' . \App\Services\ImageService::webp('storage/' . $i)), $imgs); @endphp
                        <div class="aspect-[16/10] overflow-hidden relative"
                             x-data="{ imgs: @js($pimgs), idx: 0 }"
                             x-init="if(imgs.length>1) setInterval(() => idx=(idx+1)%imgs.length, 3500)">
                            <template x-for="(img, i) in imgs" :key="i">
                                <img :src="img"
                                     x-show="idx === i"
                                     x-transition:enter="transition ease-in-out duration-700"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                     loading="lazy" decoding="async" width="800" height="500">
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
            <h2 class="section-title text-[var(--text-heading)] mb-4">{{ __('Contact Us') }}</h2>
            <div class="section-divider mb-8"></div>
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>

@endsection
