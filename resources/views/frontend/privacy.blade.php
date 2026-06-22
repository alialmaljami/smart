@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Privacy Policy') }} - {{ __('Smart Designer Decorations') }}">
<meta name="keywords" content="سياسة الخصوصية, خصوصية, بيانات">
<meta property="og:title" content="{{ __('Privacy Policy') }} - {{ __('Smart Designer Decorations') }}">
@endpush

@section('title', __('Privacy Policy') . ' - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <span class="section-label">{{ __('Privacy') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Privacy Policy') }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ __('Last updated') }}: 1 {{ __('June') }} 2026</p>
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="prose prose-lg max-w-none" style="color: var(--text-light);">
            <div class="card-elegant p-4 md:p-8 space-y-6">
                <h2 class="text-2xl font-bold text-[var(--text-heading)]">مقدمة</h2>
                <p>نحن في شركة المصمم الذكي للديكور نلتزم بحماية خصوصية زوار موقعنا الإلكتروني. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية معلوماتك الشخصية عند استخدامك لموقعنا.</p>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">المعلومات التي نجمعها</h2>
                <p>قد نجمع المعلومات التالية:</p>
                <ul class="list-disc mr-6 space-y-2">
                    <li>الاسم الكامل</li>
                    <li>البريد الإلكتروني</li>
                    <li>رقم الهاتف</li>
                    <li>الرسائل والاستفسارات التي ترسلها عبر نماذج الاتصال</li>
                    <li>معلومات الاستخدام مثل الصفحات التي تزورها ووقت الزيارة</li>
                </ul>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">كيف نستخدم معلوماتك</h2>
                <p>نستخدم المعلومات التي نجمعها للأغراض التالية:</p>
                <ul class="list-disc mr-6 space-y-2">
                    <li>الرد على استفساراتك وطلباتك</li>
                    <li>تقديم خدماتنا ومنتجاتنا</li>
                    <li>تحسين موقعنا الإلكتروني وتجربة المستخدم</li>
                    <li>إرسال تحديثات وعروض تسويقية (بموافقتك)</li>
                    <li>الامتثال للالتزامات القانونية</li>
                </ul>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">حماية المعلومات</h2>
                <p>نتخذ إجراءات أمنية مناسبة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التعديل أو الإفصاح أو الإتلاف.</p>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">ملفات تعريف الارتباط (Cookies)</h2>
                <p>نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. يمكنك التحكم في إعدادات ملفات تعريف الارتباط من خلال متصفحك.</p>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">مشاركة المعلومات مع أطراف ثالثة</h2>
                <p>لا نقوم ببيع أو تأجير أو مشاركة معلوماتك الشخصية مع أطراف ثالثة إلا في الحالات التالية: (أ) بموافقتك، (ب) للامتثال للقانون، (ج) لحماية حقوقنا القانونية.</p>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">حقوقك</h2>
                <p>لديك الحق في:</p>
                <ul class="list-disc mr-6 space-y-2">
                    <li>طلب الوصول إلى معلوماتك الشخصية</li>
                    <li>طلب تصحيح أو حذف معلوماتك</li>
                    <li>الاعتراض على معالجة معلوماتك</li>
                    <li>طلب نقل بياناتك</li>
                </ul>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">التحديثات على سياسة الخصوصية</h2>
                <p>قد نقوم بتحديث هذه السياسة من وقت لآخر. سنقوم بإشعارك بأي تغييرات جوهرية عن طريق نشر السياسة الجديدة على هذه الصفحة.</p>

                <h2 class="text-2xl font-bold text-[var(--text-heading)]">اتصل بنا</h2>
                <p>إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا عبر <a href="{{ route('contact') }}" class="text-[var(--gold)] hover:underline">صفحة الاتصال</a>.</p>
            </div>
        </div>
    </div>
</section>

@endsection
