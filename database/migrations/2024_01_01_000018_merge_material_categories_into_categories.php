<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add material-specific columns to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->string('tags')->nullable()->after('image');
            $table->string('meta_title')->nullable()->after('tags');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });

        // 2. Process migration if material_categories table exists
        if (!Schema::hasTable('material_categories')) {
            return;
        }

        // 3. Drop all FKs referencing material_categories
        $this->dropForeignIfExists('materials', ['material_category_id']);
        $this->dropForeignIfExists('material_category_project', ['material_category_id']);
        $this->dropForeignIfExists('service_material_category', ['material_category_id']);
        $this->dropForeignIfExists('projects', ['material_category_id']);

        // 4. Copy data from material_categories to categories with type='material'
        $oldToNew = [];
        $oldCategories = DB::table('material_categories')->get();
        foreach ($oldCategories as $old) {
            $newId = DB::table('categories')->insertGetId([
                'name' => $old->name,
                'slug' => $old->slug,
                'description' => $old->description,
                'type' => 'material',
                'image' => $old->cover_image,
                'tags' => $old->tags,
                'meta_title' => $old->meta_title,
                'meta_description' => $old->meta_description,
                'meta_keywords' => $old->meta_keywords,
                'sort_order' => $old->sort_order,
                'is_active' => $old->is_active,
                'created_at' => $old->created_at,
                'updated_at' => $old->updated_at,
            ]);
            $oldToNew[$old->id] = $newId;
        }

        // 5. Update FK values in related tables to point to new category IDs
        foreach ($oldToNew as $oldId => $newId) {
            DB::table('materials')
                ->where('material_category_id', $oldId)
                ->update(['material_category_id' => $newId]);

            DB::table('material_category_project')
                ->where('material_category_id', $oldId)
                ->update(['material_category_id' => $newId]);

            DB::table('service_material_category')
                ->where('material_category_id', $oldId)
                ->update(['material_category_id' => $newId]);

            DB::table('projects')
                ->where('material_category_id', $oldId)
                ->update(['material_category_id' => $newId]);
        }

        // 6. Add new FKs referencing categories table
        Schema::table('materials', function (Blueprint $table) {
            $table->foreign('material_category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
        Schema::table('material_category_project', function (Blueprint $table) {
            $table->foreign('material_category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
        Schema::table('service_material_category', function (Blueprint $table) {
            $table->foreign('material_category_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        // 7. Drop material_category_id from projects (redundant with category_id + pivot)
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('material_category_id');
        });

        // 8. Drop old material_categories table
        Schema::dropIfExists('material_categories');
    }

    public function down(): void
    {
        // Only roll back if material_categories doesn't exist yet
        if (Schema::hasTable('material_categories')) {
            return;
        }

        // 1. Re-create projects.material_category_id if we dropped it
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('material_category_id')->nullable()->after('id');
        });

        // 2. Re-create material_categories table
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('tags')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });

        // 3. Move material-type categories back to material_categories
        $materialCategories = DB::table('categories')->where('type', 'material')->get();
        $newToOld = [];
        foreach ($materialCategories as $cat) {
            $oldId = DB::table('material_categories')->insertGetId([
                'name' => $cat->name,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'cover_image' => $cat->image,
                'tags' => $cat->tags,
                'meta_title' => $cat->meta_title,
                'meta_description' => $cat->meta_description,
                'meta_keywords' => $cat->meta_keywords,
                'sort_order' => $cat->sort_order,
                'is_active' => $cat->is_active,
                'created_at' => $cat->created_at,
                'updated_at' => $cat->updated_at,
            ]);
            $newToOld[$cat->id] = $oldId;
        }

        if (!empty($newToOld)) {
            // 4. Drop FKs to categories
            $this->dropForeignIfExists('materials', ['material_category_id']);
            $this->dropForeignIfExists('material_category_project', ['material_category_id']);
            $this->dropForeignIfExists('service_material_category', ['material_category_id']);
            $this->dropForeignIfExists('projects', ['material_category_id']);

            // 5. Update FK values
            foreach ($newToOld as $newId => $oldId) {
                DB::table('materials')
                    ->where('material_category_id', $newId)
                    ->update(['material_category_id' => $oldId]);
                DB::table('material_category_project')
                    ->where('material_category_id', $newId)
                    ->update(['material_category_id' => $oldId]);
                DB::table('service_material_category')
                    ->where('material_category_id', $newId)
                    ->update(['material_category_id' => $oldId]);
                DB::table('projects')
                    ->where('material_category_id', $newId)
                    ->update(['material_category_id' => $oldId]);
            }

            // 6. Restore FKs to material_categories
            Schema::table('materials', function (Blueprint $table) {
                $table->foreign('material_category_id')->references('id')->on('material_categories')->cascadeOnDelete();
            });
            Schema::table('material_category_project', function (Blueprint $table) {
                $table->foreign('material_category_id')->references('id')->on('material_categories')->cascadeOnDelete();
            });
            Schema::table('service_material_category', function (Blueprint $table) {
                $table->foreign('material_category_id')->references('id')->on('material_categories')->cascadeOnDelete();
            });
            Schema::table('projects', function (Blueprint $table) {
                $table->foreign('material_category_id')->references('id')->on('material_categories')->cascadeOnDelete();
            });
        }

        // 7. Remove migrated material categories from categories table
        DB::table('categories')->where('type', 'material')->delete();

        // 8. Remove added columns from categories
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['tags', 'meta_title', 'meta_description', 'meta_keywords']);
        });
    }

    private function dropForeignIfExists(string $table, array $columns): void
    {
        try {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                $t->dropForeign($columns);
            });
        } catch (\Exception $e) {
            // Foreign key might not exist, ignore
        }
    }
};
