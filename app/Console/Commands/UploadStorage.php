<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class UploadStorage extends Command
{
    protected $signature = 'storage:upload {--dir= : Upload only files from this directory}';
    protected $description = 'Upload local storage files to Supabase Storage';

    public function handle()
    {
        $baseUrl = 'https://wjdxxowpvduuflsfylhj.supabase.co/storage/v1/object/storage-backup';
        $serviceKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6IndqZHh4b3dwdmR1dWZsc2Z5bGhqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4MjI0Mjc4MCwiZXhwIjoyMDk3ODE4NzgwfQ.tc9HDbH5ZHFdUOXmjTwa9Zifo57IrWxI77yituUIZgc';
        $targetDir = $this->option('dir');

        $files = $this->getLocalFiles(storage_path('app/public'), $targetDir);
        $this->info("Found " . count($files) . " files to upload");

        $uploaded = 0;
        $skipped = 0;
        $errors = [];

        foreach ($files as $file) {
            $localPath = storage_path('app/public/' . $file);
            if (!file_exists($localPath)) {
                continue;
            }

            $this->line("Uploading: $file");
            $result = $this->uploadFile($baseUrl, $serviceKey, $file, $localPath);

            if ($result) {
                $uploaded++;
                // no delay
            } else {
                $errors[] = $file;
                $this->error("Failed: $file");
                usleep(1000000);
            }
        }

        $this->info("Done: $uploaded uploaded, $skipped skipped, " . count($errors) . " errors");
        if ($errors) {
            $this->warn("Failed files:");
            foreach ($errors as $e) {
                $this->line("  $e");
            }
        }
    }

    private function getLocalFiles($basePath, $filterDir = null)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        $files = [];
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relPath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relPath = str_replace('\\', '/', $relPath);

                if ($relPath === '.gitignore') continue;
                if ($filterDir && strpos($relPath, $filterDir . '/') !== 0) continue;

                $files[] = $relPath;
            }
        }
        sort($files);
        return $files;
    }

    private function encodePath($path)
    {
        return implode('/', array_map('rawurlencode', explode('/', $path)));
    }

    private function fileExistsInCloud($baseUrl, $key, $path)
    {
        $url = $baseUrl . '/' . $this->encodePath($path);
        $ctx = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'header' => "Authorization: Bearer $key",
                'timeout' => 5,
            ]
        ]);
        $result = @file_get_contents($url, false, $ctx);
        return $result !== false;
    }

    private function uploadFile($baseUrl, $key, $path, $localPath)
    {
        $url = $baseUrl . '/' . $this->encodePath($path);
        $data = file_get_contents($localPath);
        if ($data === false) return false;

        $mime = mime_content_type($localPath) ?: 'application/octet-stream';

        $ctx = stream_context_create([
            'http' => [
                'method' => 'PUT',
                'header' => implode("\r\n", [
                    "Authorization: Bearer $key",
                    "Content-Type: $mime",
                    "Content-Length: " . strlen($data),
                ]),
                'content' => $data,
                'timeout' => 30,
            ]
        ]);

        $result = @file_get_contents($url, false, $ctx);
        return $result !== false;
    }
}
