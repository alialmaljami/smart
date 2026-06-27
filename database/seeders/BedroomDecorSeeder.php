<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Gallery;
use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BedroomDecorSeeder extends Seeder
{
    public function run(): void
    {
        // Use existing images from storage
        $existingProjectImages = [
            'projects/mirror-project-1.jpg',
            'projects/mirror-project-2.jpg',
            'projects/mirror-project-3.jpg',
            'projects/project-tv-1.jpg',
            'projects/project-tv-2.jpg',
            'projects/project-tv-3.jpg',
        ];

        $existingGalleryImages = [
            'galleries/mirror-gallery-1.jpg',
            'galleries/mirror-gallery-2.jpg',
            'galleries/mirror-gallery-3.jpg',
            'galleries/gallery-tv-1.jpg',
            'galleries/gallery-tv-2.jpg',
            'galleries/gallery-tv-3.jpg',
            'living-rooms/classic-wall.jpg',
            'living-rooms/geometric-art.jpg',
            'living-rooms/mirrors-entry.jpg',
            'living-rooms/modern-sofa.jpg',
            'living-rooms/ring-chandelier.jpg',
        ];

        // Get services
        $interior = Service::where('slug', 'interior-decorations')->first();
        $walls = Service::where('slug', 'wall-decorations')->first();
        $lighting = Service::where('slug', 'lighting-and-mirrors')->first();
        $flooring = Service::where('slug', 'flooring-and-parquet')->first();
        $curtains = Service::where('slug', 'curtains-and-upholstery')->first();

        // Clear all bedroom galleries
        Gallery::where('category', 'غرف النوم')->delete();

        // Delete projects by slugs we use
        Project::whereIn('slug', [
            'modern-bedroom-led-lighting',
            'luxury-bedroom-night-view',
            'minimalist-bedroom-wooden-walls',
            'artistic-bedroom-arched-walls',
            'antique-bedroom-round-wood',
            'classic-bedroom-oval-mirror',
            'all-white-bedroom',
            'warm-brown-bedroom-minimal',
            'purple-bedroom-modern',
            'pink-brown-warm-bedroom',
            'kids-bedroom-warm-design',
            'minimalist-bedroom-black-white',
            'bedroom-with-en-suite-bath',
            'circular-bed-bedroom',
            'luxury-bedroom-wood-paneling',
        ])->delete();

        $projects = [
            [
                'title' => 'غرفة نوم عصرية بمرايا أنيقة',
                'slug' => 'modern-bedroom-led-lighting',
                'description' => 'تصميم غرفة نوم عصرية مع إضاءة LED ذكية ومرايا عاكسة لتوسيع المساحة. سرير مزدوج مع مفروشات فاخرة وبوف مع فرو.',
                'images' => [$existingProjectImages[0]],
                'tags' => ['غرفة نوم', 'عصري', 'إضاءة LED'],
                'service_ids' => [$interior?->id, $lighting?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة نوم فاخرة بتصميم مودرن',
                'slug' => 'luxury-bedroom-night-view',
                'description' => 'غرفة نوم فاخرة مع خلفية تلفزيون مدمجة وإضاءة دافئة. أثاث خشبي أنيق مع سجادة فاخرة وستائر مودرن.',
                'images' => [$existingProjectImages[3]],
                'tags' => ['غرفة نوم', 'فاخر', 'مودرن'],
                'service_ids' => [$interior?->id, $walls?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة نوم مينيمال بجدران خشبية',
                'slug' => 'minimalist-bedroom-wooden-walls',
                'description' => 'تصميم مينيمال نظيف مع جدران خشبية أنيقة، أرضيات فاخرة، وإضاءة ناعمة. مساحة مثالية للراحة والاسترخاء.',
                'images' => [$existingProjectImages[4]],
                'tags' => ['غرفة نوم', 'مينيمال', 'خشب'],
                'service_ids' => [$interior?->id, $flooring?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة جلوس عصرية بفن جدراني',
                'slug' => 'artistic-bedroom-arched-walls',
                'description' => 'مساحة معيشة عصرية مع جدران مزخرفة فنياً وإضاءة ذكية. كنب مريح مع طاولة قهوة أنيقة وستائر راقية.',
                'images' => [$existingGalleryImages[2]],
                'tags' => ['غرفة جلوس', 'عصري', 'فن جدراني'],
                'service_ids' => [$interior?->id, $lighting?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة نوم دافئة بمرآة أنيقة',
                'slug' => 'antique-bedroom-round-wood',
                'description' => 'غرفة نوم دافئة بألوان محايدة ومرآة كبيرة في مدخل الغرفة. أثاث مريح مع إضاءة ذهبية دافئة.',
                'images' => [$existingGalleryImages[1]],
                'tags' => ['غرفة نوم', 'دافئ', 'مرآة'],
                'service_ids' => [$interior?->id, $curtains?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة معيشة كلاسيكية',
                'slug' => 'classic-bedroom-oval-mirror',
                'description' => 'غرفة معيشة كلاسيكية بأناقة، جدران مزخرفة وأثاث خشبي فاخر. إضاءة طبيعية من النوافذ الكبيرة.',
                'images' => [$existingGalleryImages[0]],
                'tags' => ['غرفة معيشة', 'كلاسيك', 'فاخر'],
                'service_ids' => [$interior?->id, $walls?->id],
                'is_active' => true,
            ],
            [
                'title' => 'صالة عصرية بسيطة',
                'slug' => 'all-white-bedroom',
                'description' => 'صالة عصرية تدعو للراحة بألوان فاتحة وفرش مريح. تصميم مينيمال أنيق مع لمسات طبيعية.',
                'images' => [$existingProjectImages[1]],
                'tags' => ['صالة', 'عصري', 'بسيط'],
                'service_ids' => [$interior?->id, $lighting?->id],
                'is_active' => true,
            ],
            [
                'title' => 'غرفة عائلية مريحة',
                'slug' => 'warm-brown-bedroom-minimal',
                'description' => 'غرفة عائلية واسعة بفراش مريح ومنطقة جلوس أنيقة. إضاءة طبيعية وستائر أنيقة.',
                'images' => [$existingProjectImages[2]],
                'tags' => ['غرفة عائلية', 'مريح', 'طبيعي'],
                'service_ids' => [$interior?->id, $curtains?->id],
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            $serviceIds = $project['service_ids'] ?? [];
            unset($project['service_ids']);

            $newProject = Project::create($project);
            if (!empty($serviceIds)) {
                $newProject->services()->sync($serviceIds);
            }
        }

        // Gallery Items using existing images
        $galleryItems = [
            ['title' => 'مرآة أنيقة في مدخل الغرفة', 'image' => $existingGalleryImages[2], 'slug' => Str::slug('مرآة أنيقة في مدخل الغرفة', '-', 'ar')],
            ['title' => 'جدار مزخرف بتدرجات لونية', 'image' => $existingGalleryImages[1], 'slug' => Str::slug('جدار مزخرف بتدرجات لونية', '-', 'ar')],
            ['title' => 'تصميم جدار فني حديث', 'image' => $existingGalleryImages[0], 'slug' => Str::slug('تصميم جدار فني حديث', '-', 'ar')],
            ['title' => 'إضاءة ذهبية دافئة', 'image' => 'living-rooms/ring-chandelier.jpg', 'slug' => Str::slug('إضاءة ذهبية دافئة', '-', 'ar')],
            ['title' => 'غرفة معيشة عصرية', 'image' => 'living-rooms/modern-sofa.jpg', 'slug' => Str::slug('غرفة معيشة عصرية', '-', 'ar')],
        ];

        foreach ($galleryItems as $item) {
            $item['description'] = $item['title'] . ' - من تصميمات المصمم الذكي المميزة.';
            $item['alt_text'] = $item['title'];
            $item['category'] = 'غرف النوم';
            $item['service_id'] = $interior?->id ?? null;
            $item['sort_order'] = array_search($item, $galleryItems) + 1;
            $item['is_active'] = true;

            Gallery::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // Blog Posts - bedroom specific
        $bedroomArticles = [
            [
                'title' => 'أحدث ديكورات غرف النوم المودرن 2026',
                'excerpt' => 'اكتشف أحدث صيحات ديكور غرف النوم لهذا العام مع النصائح الحصرية من المصمم الذكي.',
                'tags' => 'غرف نوم,مودرن,2026,تريند',
            ],
            [
                'title' => 'كيف تختار إضاءة غرفة النوم المناسبة',
                'excerpt' => 'إضاءة غرفة النوم تلعب دوراً مهماً في الراحة والاسترخاء. تعرف على أنواع الإضاءة وكيفية اختيارها.',
                'tags' => 'إضاءة,غرف نوم,نصائح,راحة',
            ],
            [
                'title' => 'أفضل ألوان الدهانات لغرف النوم',
                'excerpt' => 'الألوان تؤثر بشكل كبير على المزاج والنوم. تعرف على الألوان المثالية لكل ذوق.',
                'tags' => 'ألوان,دهانات,غرف نوم,نفسية',
            ],
            [
                'title' => 'ديكورات جدران غرف النوم الفاخرة',
                'excerpt' => 'من الخشب إلى الجبس إلى ورق الجدران 3D، تعرف على أبرز خيارات ديكور الجدران.',
                'tags' => 'جدران,ديكور,غرف نوم,فخامة',
            ],
            [
                'title' => 'تنسيق الألوان في غرف النوم',
                'excerpt' => 'كيف تخلق تناغماً لونياً مريحاً في غرفة نومك مع هذه النصائح البسيطة.',
                'tags' => 'ألوان,تنسيق,ديكور,غرف نوم',
            ],
            [
                'title' => 'أفكار تخزين ذكية لغرف النوم الصغيرة',
                'excerpt' => 'استغلال المساحات الصغيرة بشكل ذكي مع حلول تخزين مبتكرة تناسب غرف النوم المحدودة.',
                'tags' => 'تخزين,مساحات صغيرة,غرف نوم,نصائح',
            ],
            [
                'title' => 'الفراش والمفروشات المثالية لغرف النوم',
                'excerpt' => 'من السيرNING إلى المراتب إلى الوسائد، دليل شامل لاختيار أفضل الفراش.',
                'tags' => 'فراش,مفروشات,راحة,غرف نوم',
            ],
            [
                'title' => 'ديكورات غرف نوم أطفال آمنة وممتعة',
                'excerpt' => 'كيف تصمم غرفة نوم تجمع بين الأمان والمرح لاطفالك مع مراعاة نموهم.',
                'tags' => 'أطفال,أمان,ديكور,غرف نوم',
            ],
            [
                'title' => 'الستائر وأهميتها في ديكور غرف النوم',
                'excerpt' => 'الستائر ليست فقط للخصوصية بل عنصر أساسي في جمالية الغرفة. تعرف على أنواعها.',
                'tags' => 'ستائر,ديكور,غرف نوم,نصائح',
            ],
            [
                'title' => 'جديد في أرضيات غرف النوم',
                'excerpt' => 'من الباركيه إلى الرخام إلى السيراميك، أحدث الخيارات لأرضيات غرف النوم الفاخرة.',
                'tags' => 'أرضيات,باركيه,رخام,غرف نوم',
            ],
        ];

        foreach ($bedroomArticles as $article) {
            $slug = Str::slug($article['title'], '-', 'ar');

            if (BlogPost::where('slug', $slug)->exists()) {
                continue;
            }

            BlogPost::create([
                'title' => $article['title'],
                'slug' => $slug,
                'content' => '<p>في هذا المقال، نستعرض معكم أفضل النصائح والأفكار حول <strong>' . $article['title'] . '</strong>. يتميز المصمم الذكي بتقديم أحدث صيحات الديكور الداخلي وخاصة في مجال غرف النوم التي تعتبر مساحة الاسترخاء والراحة الأساسية في المنزل.</p><p>نحن نحرص على اختيار أفضل الخامات والألوان والتصاميم التي تناسب جميع الأذواق، من المودرن إلى الكلاسيك، مع مراعاة أعلى معايير الجودة والراحة.</p><p>تواصل معنا اليوم لتحصل على استشارة مجانية حول تصميم غرفة نوم أحلامك!</p>',
                'excerpt' => $article['excerpt'],
                'tags' => $article['tags'],
                'is_active' => true,
                'meta_title' => $article['title'] . ' | المصمم الذكي',
                'meta_description' => 'اقرأ عن أفضل النصائح Debt ' . $article['title'] . ' وتأكد من تطبيقها في غرفة نومك.',
                'meta_keywords' => $article['tags'] . ',ديكور,غرف نوم,تصميم',
            ]);
        }
    }
}