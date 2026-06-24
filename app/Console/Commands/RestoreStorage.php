<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class RestoreStorage extends Command
{
    protected $signature = 'storage:restore';
    protected $description = 'Download and extract storage files from Supabase';

    public function handle()
    {
        $target = storage_path('app/public');
        $tmpDir = storage_path('app/restore_tmp');
        $isFresh = !is_dir($target) || count(scandir($target)) <= 2;

        if (!$isFresh) {
            $this->warn('Storage already has files, skipping restore');
            return 0;
        }

        $baseUrl = 'https://wjdxxowpvduuflsfylhj.supabase.co/storage/v1/object/public/storage-backup';
        $parts = 3;

        if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

        for ($i = 1; $i <= $parts; $i++) {
            $url = "$baseUrl/storage_part_$i.zip";
            $dest = "$tmpDir/part_$i.zip";
            $this->info("Downloading part $i...");
            file_put_contents($dest, file_get_contents($url));
            $this->info("Part $i downloaded");
        }

        $combined = "$tmpDir/combined.zip";
        $this->info('Combining parts...');
        $out = fopen($combined, 'wb');
        for ($i = 1; $i <= $parts; $i++) {
            $in = fopen("$tmpDir/part_$i.zip", 'rb');
            stream_copy_to_stream($in, $out);
            fclose($in);
        }
        fclose($out);

        $this->info('Extracting...');
        $zip = new \ZipArchive;
        if ($zip->open($combined) === true) {
            $zip->extractTo($target);
            $zip->close();
            $this->info('Storage restored successfully');
        } else {
            $this->error('Failed to extract zip');
            return 1;
        }

        array_map('unlink', glob("$tmpDir/*"));
        rmdir($tmpDir);

        return 0;
    }
}
