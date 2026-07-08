@extends('layouts.admin')

@section('title', 'Google Search Console')

@section('content')
<div class="space-y-6" x-data="gscApp()" x-init="init()">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">Google Search Console</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">ربط الموقع بمحرك بحث Google وإرسال خريطة الموقع</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 flex items-start gap-3 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="font-medium text-sm">{{ session('success') }}</div>
    </div>
    @endif

    {{-- Status Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg"
                     :class="verified ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400'">
                    <i class="fab fa-google" :class="verified ? '' : 'text-gray-300'"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400">حالة Search Console</p>
                    <p class="font-semibold text-sm" x-text="verified ? 'مفعل' : 'غير مفعل'"
                       :class="verified ? 'text-green-600' : 'text-gray-500'"></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg"
                     :class="metaPresent ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400">رمز التحقق</p>
                    <p class="font-semibold text-sm" x-text="metaPresent ? 'موجود في الموقع' : 'لم يتم التحقق بعد'"
                       :class="metaPresent ? 'text-green-600' : 'text-yellow-600'"></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg bg-blue-100 text-blue-600">
                    <i class="fab fa-microsoft"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400">IndexNow / Bing</p>
                    <p class="font-semibold text-sm text-blue-600">جاهز</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">إعدادات الاتصال</h2>
            <p class="text-xs text-gray-400 mt-1">أدخل بيانات Google Search Console و Google Analytics</p>
        </div>

        <form action="{{ route('admin.google-search-console.update') }}" method="POST" class="p-5 sm:p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    <i class="fab fa-google text-gold-600 ml-1"></i>
                    رمز التحقق من Google Search Console
                </label>
                <input type="text" name="google_search_console"
                       placeholder="مثال: abc123def456"
                       x-model="gscCode"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#E07A5F]/20 focus:border-[#E07A5F] outline-none transition-all text-sm">
                <p class="text-xs text-gray-400 mt-1.5">
                    يمكنك الحصول على الرمز من
                    <a href="https://search.google.com/search-console" target="_blank" class="text-[#E07A5F] hover:underline">Google Search Console</a>
                    ← إضافة خاصية ← اختيار "HTML tag" ← نسخ الرمز
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    <i class="fab fa-google text-gold-600 ml-1"></i>
                    معرف Google Analytics (GA4)
                </label>
                <input type="text" name="google_analytics_id"
                       placeholder="مثال: G-XXXXXXXXXX"
                       x-model="gaId"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#E07A5F]/20 focus:border-[#E07A5F] outline-none transition-all text-sm">
                <p class="text-xs text-gray-400 mt-1.5">
                    احصل عليه من
                    <a href="https://analytics.google.com" target="_blank" class="text-[#E07A5F] hover:underline">Google Analytics</a>
                    ← المسؤول ← تدفق البيانات
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-l from-[#E07A5F] to-[#D4694C] text-white rounded-lg text-sm font-medium hover:brightness-105 transition-all shadow-sm shadow-[#E07A5F]/20">
                    <i class="fas fa-save ml-1.5"></i>
                    حفظ الإعدادات
                </button>

                <button type="button" @click="checkMeta()" :disabled="!gscCode"
                        class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-search ml-1.5"></i>
                    التحقق من وجود الرمز
                </button>
            </div>
        </form>
    </div>

    {{-- Step by Step Guide --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">طريقة ربط الموقع مع Google</h2>
            <p class="text-xs text-gray-400 mt-1">اتبع الخطوات التالية بالترتيب</p>
        </div>

        <div class="p-5 sm:p-6 space-y-4">
            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">1</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">تسجيل الدخول إلى Google Search Console</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        استخدم البريد الإلكتروني
                        <span class="font-mono text-gray-700">almaljamialrimi@gmail.com</span>
                    </p>
                    <a href="https://search.google.com/search-console" target="_blank"
                       class="inline-flex items-center gap-1.5 mt-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100 transition-all">
                        <i class="fas fa-external-link-alt text-xs"></i>
                        فتح Search Console
                    </a>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">2</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">إضافة الموقع</p>
                    <p class="text-xs text-gray-500 mt-0.5">اختر "URL prefix" وأدخل:</p>
                    <code class="block mt-1.5 px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-mono border border-gray-200">https://smartdecorat.com</code>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">3</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">اختيار طريقة التحقق</p>
                    <p class="text-xs text-gray-500 mt-0.5">اختر "HTML tag" — ستظهر لك علامة meta مثل:</p>
                    <code class="block mt-1.5 px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-mono border border-gray-200" dir="ltr">
                        &lt;meta name="google-site-verification" content="<span class="text-red-500">your-code-here</span>" /&gt;
                    </code>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">4</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">نسخ الرمز ولصقه هنا</p>
                    <p class="text-xs text-gray-500 mt-0.5">انسخ فقط المحتوى (ما بين علامتي الاقتباس) والصقه في حقل "رمز التحقق" بالأعلى، ثم احفظ</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">5</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">العودة إلى Search Console والضغط على "Verify"</p>
                    <p class="text-xs text-gray-500 mt-0.5">بعد حفظ الرمز في الموقع، ارجع إلى Search Console واضغط "Verify" لاكتشاف الرمز تلقائياً</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-[#E07A5F]/10 text-[#E07A5F] flex items-center justify-center font-bold text-sm shrink-0">6</div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">إرسال خريطة الموقع</p>
                    <p class="text-xs text-gray-500 mt-0.5">بعد التحقق، اذهب إلى Sitemaps ← Add a new sitemap وأدخل:</p>
                    <code class="block mt-1.5 px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-mono border border-gray-200">sitemap.xml</code>
                    <p class="text-xs text-gray-400 mt-1.5">أو استخدم الزر أدناه لإرسال جميع خرائط الموقع عبر IndexNow (Bing, Yandex, Seznam)</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sitemap Submission --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">إرسال خرائط الموقع</h2>
            <p class="text-xs text-gray-400 mt-1">إرسال جميع خرائط الموقع إلى Bing / IndexNow (يشارك مع Yandex و Seznam)</p>
        </div>

        <div class="p-5 sm:p-6">
            <button type="button" @click="submitSitemaps()" :disabled="submitting"
                    class="px-6 py-2.5 bg-gradient-to-l from-blue-500 to-blue-600 text-white rounded-lg text-sm font-medium hover:brightness-105 transition-all shadow-sm shadow-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-paper-plane ml-1.5" :class="submitting ? 'fa-spin' : ''"></i>
                <span x-text="submitting ? 'جاري الإرسال...' : 'إرسال خرائط الموقع إلى IndexNow'"></span>
            </button>

            <div x-show="submitResults.length > 0" x-cloak class="mt-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-right py-2 text-gray-500 font-medium">خريطة الموقع</th>
                            <th class="text-center py-2 text-gray-500 font-medium">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="r in submitResults" :key="r.sitemap">
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-700 font-mono text-xs" x-text="r.sitemap"></td>
                                <td class="py-2 text-center">
                                    <span x-show="r.status === 'ok'"
                                          class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i> تم
                                    </span>
                                    <span x-show="r.status !== 'ok'"
                                          class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">
                                        <i class="fas fa-times-circle"></i> <span x-text="r.http"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Resources --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6">
            <h2 class="font-bold text-gray-800 mb-3">روابط مفيدة</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="https://search.google.com/search-console" target="_blank"
                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                    <i class="fab fa-google text-lg text-blue-500"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Google Search Console</p>
                        <p class="text-xs text-gray-400">إدارة أداء الموقع في البحث</p>
                    </div>
                </a>
                <a href="https://analytics.google.com" target="_blank"
                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                    <i class="fab fa-google text-lg text-orange-500"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Google Analytics</p>
                        <p class="text-xs text-gray-400">تحليل الزوار والسلوك</p>
                    </div>
                </a>
                <a href="https://www.bing.com/webmasters" target="_blank"
                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                    <i class="fab fa-microsoft text-lg text-blue-600"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Bing Webmaster Tools</p>
                        <p class="text-xs text-gray-400">مشرفي المواقع بينج</p>
                    </div>
                </a>
                <a href="https://webmaster.yandex.com" target="_blank"
                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                    <i class="fas fa-search text-lg text-yellow-500"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Yandex Webmaster</p>
                        <p class="text-xs text-gray-400">مشرفي المواقع ياندكس</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function gscApp() {
    return {
        gscCode: '{{ $gscCode }}',
        gaId: '{{ $gaId }}',
        verified: {{ $verified ? 'true' : 'false' }},
        metaPresent: {{ $metaTagPresent ? 'true' : 'false' }},
        submitting: false,
        submitResults: [],
        init() {},
        checkMeta() {
            fetch('{{ route("admin.google-search-console.check-meta") }}')
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'verified') {
                        this.metaPresent = true;
                    }
                    alert(data.message);
                })
                .catch(() => alert('فشل الاتصال بالخادم'));
        },
        submitSitemaps() {
            this.submitting = true;
            this.submitResults = [];
            fetch('{{ route("admin.google-search-console.submit-sitemaps") }}')
                .then(r => r.json())
                .then(data => {
                    this.submitResults = data.results || [];
                    this.submitting = false;
                })
                .catch(() => {
                    alert('فشل إرسال خرائط الموقع');
                    this.submitting = false;
                });
        }
    };
}
</script>
@endpush
