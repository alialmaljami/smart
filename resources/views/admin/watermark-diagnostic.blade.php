<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">تشخيص العلامة المائية</h1>

        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h2 class="text-lg font-semibold mb-4">معلومات الخط</h2>
                <table class="w-full text-sm">
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">مسار الخط</td>
                        <td class="py-2 text-left font-mono text-xs">{{ $info['font_path'] ?? 'N/A' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">هل الملف موجود؟</td>
                        <td class="py-2 text-left">
                            @if($info['font_exists'] ?? false)
                                <span class="text-green-600 font-bold">نعم</span>
                            @else
                                <span class="text-red-600 font-bold">لا</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">اختبار imagettfbbox</td>
                        <td class="py-2 text-left">
                            @if(($info['font_bbox'] ?? '') === 'OK')
                                <span class="text-green-600 font-bold">نجاح</span>
                            @else
                                <span class="text-red-600 font-bold">{{ $info['font_bbox'] ?? 'خطأ' }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h2 class="text-lg font-semibold mb-4">إعدادات العلامة المائية</h2>
                <table class="w-full text-sm">
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">النوع</td>
                        <td class="py-2 text-left">{{ $info['watermark_type'] ?? 'N/A' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">الشفافية</td>
                        <td class="py-2 text-left">{{ $info['watermark_opacity'] ?? 'N/A' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">الموضع</td>
                        <td class="py-2 text-left">{{ $info['watermark_position'] ?? 'N/A' }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-600 font-medium">الحجم</td>
                        <td class="py-2 text-left">{{ $info['watermark_size'] ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h2 class="text-lg font-semibold mb-4">اختبار الصورة</h2>
                @if(isset($info['error']))
                    <div class="bg-red-50 text-red-700 p-4 rounded-lg">{{ $info['error'] }}</div>
                @endif
                @if(isset($info['text_rendered']))
                    <p class="mb-3">
                        <span class="text-gray-600 font-medium">نتيجة التطبيق:</span>
                        @if($info['text_rendered'] === 'YES')
                            <span class="text-green-600 font-bold">نجاح</span>
                        @else
                            <span class="text-red-600 font-bold">{{ $info['text_rendered'] }}</span>
                        @endif
                    </p>
                @endif
                @if(isset($info['test_image_base64']))
                    <img src="data:image/png;base64,{{ $info['test_image_base64'] }}" alt="Test watermark" class="border rounded-lg max-w-full">
                    <p class="text-xs text-gray-400 mt-2">صورة اختبارية مع العلامة المائية (يجب أن يظهر النص رمادي شفاف)</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h2 class="text-lg font-semibold mb-4">صورة حقيقية (آخر صورة مرفوعة)</h2>
                @php
                    use Illuminate\Support\Facades\Storage;
                    $files = Storage::disk('public')->allFiles();
                    $images = array_values(array_filter($files, fn($f) => preg_match('/\.(jpg|jpeg|png|webp)$/i', $f)));
                    $lastImg = $images[count($images)-1] ?? null;
                @endphp
                @if($lastImg)
                    @php
                        $fullPath = storage_path('app/public/' . $lastImg);
                        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                        $watermark = new \App\Services\WatermarkService();
                        try {
                            $image = $manager->decodePath($fullPath);
                            $watermarkedInfo = 'before: ' . $image->width() . 'x' . $image->height();
                            $watermark->apply($image);
                            $watermarkedInfo .= ', after: ' . $image->width() . 'x' . $image->height();
                            $saved = storage_path('app/public/test_watermarked.png');
                            $image->save($saved, quality: 85);
                        } catch (\Throwable $e) {
                            $watermarkedInfo = 'error: ' . $e->getMessage();
                        }
                    @endphp
                    <p class="text-xs text-gray-400 mb-2">الملف: {{ $lastImg }} | {{ $watermarkedInfo ?? '' }}</p>
                    @if(isset($saved) && file_exists($saved))
                        <img src="{{ asset('storage/test_watermarked.png') }}" alt="Real test" class="border rounded-lg max-w-full">
                        @php unlink($saved); @endphp
                    @endif
                @else
                    <p class="text-gray-500">لا توجد صور في storage</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
