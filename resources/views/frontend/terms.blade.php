@extends('layouts.app')

@push('meta')
<meta name="description" content="{{ __('Terms and Conditions') }} - {{ __('Smart Designer Decorations') }}">
<meta name="keywords" content="شروط الاستخدام, شروط, أحكام">
<meta property="og:title" content="{{ __('Terms and Conditions') }} - {{ __('Smart Designer Decorations') }}">
@endpush

@section('title', __('Terms of Service') . ' - ' . __('Smart Designer Decorations'))

@section('content')

<section class="relative pt-20 pb-12 md:pt-40 md:pb-24 overflow-hidden bg-gradient-to-br from-[var(--navy)] via-[var(--navy)]/95 to-[var(--navy)]">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-l from-transparent via-[var(--gold)] to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div data-aos="fade-up" class="text-center max-w-3xl mx-auto">
            <span class="section-label">{{ __('Terms') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-black text-[var(--text-heading)] mt-3 mb-4">{{ __('Terms and Conditions') }}</h1>
            <p class="text-[var(--text-light)] text-lg">{{ __('Last updated') }}: 1 {{ __('June') }} 2026</p>
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--cream)]">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="card-elegant p-4 md:p-8 space-y-6">
            <h2 class="text-2xl font-bold text-[var(--text-heading)]">مقدمة</h2>
            <p class="text-[var(--text-light)]">مرحباً بكم في موقع شركة المصمم الذكي للديكور. باستخدامكم لهذا الموقع، فإنكم توافقون على الالتزام بالشروط والأحكام التالية. يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">قبول الشروط</h2>
            <p class="text-[var(--text-light)]">باستخدامكم لهذا الموقع، فإنكم توافقون على هذه الشروط والأحكام بشكل كامل. إذا كنتم لا توافقون على أي جزء من هذه الشروط، فيرجى عدم استخدام الموقع.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">الخدمات</h2>
            <p class="text-[var(--text-light)]">نقدم خدمات التصميم الداخلي والديكور بما في ذلك على سبيل المثال لا الحصر: التصميم والتنفيذ، استشارات الديكور، توريد المواد، والصيانة. جميع الخدمات تخضع لعقود منفصلة تحدد نطاق العمل والتكاليف.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">الملكية الفكرية</h2>
            <p class="text-[var(--text-light)]">جميع المحتويات المعروضة على هذا الموقع بما في ذلك النصوص والصور والتصاميم والشعارات هي ملك لشركة المصمم الذكي للديكور ولا يجوز استخدامها أو نسخها دون إذن خطي مسبق.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">استخدام الموقع</h2>
            <p class="text-[var(--text-light)]">أنت توافق على استخدام الموقع فقط للأغراض القانونية وبطريقة لا تنتهك حقوق الآخرين أو تحد من استخدامهم للموقع.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">الأسعار والدفع</h2>
            <p class="text-[var(--text-light)]">الأسعار المعروضة على الموقع قابلة للتغيير دون إشعار مسبق. يتم تحديد الأسعار النهائية في العقد الموقع بين الطرفين.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">إخلاء المسؤولية</h2>
            <p class="text-[var(--text-light)]">نحن نبذل قصارى جهدنا لضمان دقة المعلومات على موقعنا، ولكننا لا نضمن أن الموقع خالٍ من الأخطاء. يتم تقديم المعلومات والمواد "كما هي" دون أي ضمانات.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">القانون الواجب التطبيق</h2>
            <p class="text-[var(--text-light)]">تخضع هذه الشروط والأحكام وتفسر وفقاً لقوانين المملكة العربية السعودية.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">تعديل الشروط</h2>
            <p class="text-[var(--text-light)]">نحتفظ بالحق في تعديل هذه الشروط في أي وقت. سيتم إشعارك بأي تغييرات عن طريق نشر الشروط الجديدة على هذه الصفحة.</p>

            <h2 class="text-2xl font-bold text-[var(--text-heading)]">اتصل بنا</h2>
            <p class="text-[var(--text-light)]">للاستفسارات المتعلقة بهذه الشروط، يرجى <a href="{{ route('contact') }}" class="text-[var(--gold)] hover:underline">الاتصال بنا</a>.</p>
        </div>
    </div>
</section>

@endsection
