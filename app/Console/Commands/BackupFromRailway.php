<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Gallery;
use App\Models\BlogPost;
use App\Models\Service;
use App\Models\Material;
use App\Models\Review;
use App\Models\Contact;
use App\Models\VisitorQuestion;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Category;
use App\Models\Like;

class BackupFromRailway extends Command
{
    protected $signature = 'backup:railway';
    protected $description = 'Backup all data and files from Railway to local project';

    public function handle()
    {
        $backupPath = base_path('backups/railway-' . date('Y-m-d-H-i-s'));
        mkdir($backupPath, 0755, true);

        $models = [
            'projects' => Project::all(),
            'galleries' => Gallery::all(),
            'blog_posts' => BlogPost::all(),
            'services' => Service::all(),
            'materials' => Material::all(),
            'reviews' => Review::all(),
            'contacts' => Contact::all(),
            'visitor_questions' => VisitorQuestion::all(),
            'faqs' => Faq::all(),
            'settings' => Setting::all(),
            'social_links' => SocialLink::all(),
            'categories' => Category::all(),
            'likes' => Like::all(),
        ];

        foreach ($models as $name => $data) {
            file_put_contents(
                "$backupPath/$name.json",
                json_encode($data->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
            $this->info("Exported $name (" . $data->count() . " records)");
        }

        $files = [];

        foreach (Gallery::all() as $g) {
            if ($g->image) $files[] = $g->image;
        }
        foreach (BlogPost::all() as $b) {
            if ($b->image) $files[] = $b->image;
        }
        foreach (Service::all() as $s) {
            if ($s->image) $files[] = $s->image;
            if ($s->icon) $files[] = $s->icon;
        }
        foreach (Material::all() as $m) {
            if ($m->image) $files[] = $m->image;
        }
        foreach (Project::all() as $p) {
            $images = is_array($p->images) ? $p->images : json_decode($p->images ?? '[]', true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    if ($img) $files[] = $img;
                }
            }
        }
        foreach (Setting::all() as $s) {
            if ($s->value && str_starts_with($s->value, 'settings/')) {
                $files[] = $s->value;
            }
        }

        $files = array_unique(array_filter($files));
        $baseUrl = rtrim(env('APP_URL'), '/');
        $filesPath = "$backupPath/files";
        mkdir($filesPath, 0755, true);
        $downloaded = 0;

        foreach ($files as $file) {
            $url = "$baseUrl/storage/$file";
            $dest = "$filesPath/$file";
            $dir = dirname($dest);
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $ch = curl_init($url);
            $fp = fopen($dest, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            fclose($fp);

            if ($httpCode === 200) {
                $downloaded++;
                $this->info("Downloaded: $file");
            } else {
                unlink($dest);
                $this->warn("Failed ($httpCode): $file");
            }
        }

        $this->info("Downloaded $downloaded / " . count($files) . " files");

        $zipFile = "$backupPath.zip";
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($backupPath, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($files as $name => $file) {
                $relativePath = substr($file->getRealPath(), strlen($backupPath) + 1);
                if ($relativePath !== '..' && $relativePath !== '.') {
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }
            $zip->close();
            $this->info("Backup created: $zipFile");
        }

        $this->info("Backup completed successfully!");
    }
}
