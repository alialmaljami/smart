<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

try {
    $projects = DB::table('projects')->get();
    $updated = 0;

    foreach ($projects as $p) {
        $desc = trim($p->description ?? '');
        if (!$desc) continue;

        // Split by sentence-ending punctuation (period, question mark, Arabic question mark, exclamation)
        // then group into paragraphs of ~2-3 sentences
        $sentences = preg_split('/(?<=[.?!\\x{061F}\\x{060C}])\s+/u', $desc);
        
        if (count($sentences) <= 2) continue; // already short

        $paragraphs = [];
        $buffer = [];
        foreach ($sentences as $s) {
            $buffer[] = $s;
            if (count($buffer) >= 3) {
                $paragraphs[] = implode(' ', $buffer);
                $buffer = [];
            }
        }
        if (!empty($buffer)) {
            $paragraphs[] = implode(' ', $buffer);
        }

        $newDesc = implode("\n\n", $paragraphs);

        if ($newDesc !== $desc) {
            DB::table('projects')->where('id', $p->id)->update(['description' => $newDesc]);
            echo "Updated project {$p->id}: {$p->slug}\n";
            $updated++;
        }
    }

    echo "Done. Updated $updated projects.\n";

} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage();
}
