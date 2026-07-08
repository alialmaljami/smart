<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

try {
    $slug = 'chipboard-modern-decor-makkah-jeddah';
    $existing = DB::table('materials')->where('slug', $slug)->first();
    if ($existing) { echo 'EXISTS'; exit; }

    $cat = DB::table('categories')
        ->where('type', 'material')
        ->where('slug', 'chipboard-and-alternatives')
        ->first();

    if (!$cat) {
        $catId = DB::table('categories')->insertGetId([
            'name' => 'الشيبورد وبديل الشيبورد',
            'slug' => 'chipboard-and-alternatives',
            'type' => 'material',
            'description' => 'ألواح الشيبورد وبدائلها المناسبة للديكورات الداخلية والخارجية.',
            'is_active' => 1,
            'sort_order' => 3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        echo "CAT_CREATED\n";
    } else {
        $catId = $cat->id;
    }

    $tags = json_encode([
        'الشيبورد', 'الشيبورد الجديد', 'ألواح الشيبورد', 'ديكورات شيبورد',
        'تركيب شيبورد', 'شيبورد مكة', 'شيبورد جدة', 'ديكور جدران',
        'ديكور أسقف', 'تصميم داخلي', 'تشطيبات حديثة'
    ], JSON_UNESCAPED_UNICODE);

    $specs = "تصميم عصري يناسب الديكورات الحديثة.
خفيف الوزن وسهل النقل والتركيب.
مقاوم للرطوبة والتشقق.
سطح أملس جاهز للتشطيب أو الدهان.
مناسب للجدران والأسقف والديكورات الداخلية.
يمكن دمجه مع الإضاءة المخفية.
متوفر بمقاسات وسماكات متعددة.
عزل جيد للصوت والحرارة حسب نوع اللوح.
مناسب للمنازل والفلل والمكاتب والمحلات التجارية.
صيانة سهلة وعمر افتراضي طويل.";

    DB::table('materials')->insert([
        'material_category_id' => $catId,
        'name' => 'الشيبورد الجديد | أحدث حلول الديكورات العصرية للجدران والأسقف في مكة وجدة',
        'slug' => $slug,
        'description' => 'يعتبر الشيبورد الجديد من أكثر مواد الديكور انتشارًا في التصاميم الحديثة، حيث يجمع بين المظهر الأنيق والمتانة وسهولة التنفيذ. يستخدم في تصميم الجدران والأسقف وديكورات التلفزيون والمكاتب والمحلات التجارية، كما يمكن دمجه مع الإضاءة المخفية وبديل الخشب وبديل الرخام للحصول على مظهر عصري فاخر.

يتميز بخفة وزنه، وسهولة تركيبه، ومقاومته للرطوبة والتشقق، مع توفره بتصاميم وألوان متنوعة تناسب مختلف أنماط الديكور الداخلي للمنازل والفلل والشركات في مكة وجدة.',
        'image' => null,
        'images' => null,
        'price' => null,
        'specifications' => $specs,
        'tags' => $tags,
        'is_active' => 1,
        'views' => 0,
        'meta_title' => 'الشيبورد الجديد في مكة وجدة | تركيب ديكورات شيبورد حديثة بأفضل جودة',
        'meta_description' => 'نوفر خدمات تصميم وتركيب الشيبورد الجديد في مكة وجدة بأحدث التصاميم العصرية. حلول مثالية للجدران والأسقف وديكورات التلفزيون والمكاتب باستخدام مواد عالية الجودة وتنفيذ احترافي.',
        'meta_keywords' => 'الشيبورد، الشيبورد الجديد، تركيب شيبورد، شيبورد مكة، شيبورد جدة، ديكورات شيبورد، ألواح الشيبورد، شيبورد للجدران، شيبورد للأسقف، ديكور شيبورد، تصميم داخلي مكة، تصميم داخلي جدة، تشطيبات داخلية، ديكورات حديثة، ألواح جبسية، أسقف حديثة، ديكور تلفزيون، شيبورد مقاوم للرطوبة، أفضل شيبورد، أسعار الشيبورد',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    echo "INSERTED";

} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage();
}
