<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = new PDO('mysql:host=localhost;dbname=u304271186_smartdecor_db;charset=utf8mb4', 'u304271186_ali', 'Alialmaljami2024');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = [
    'projects',
    'blog_posts',
    'services',
    'materials',
    'neighborhoods',
    'galleries',
    'tags',
    'visitor_questions',
];

$log = [];
$totalFixed = 0;

foreach ($tables as $table) {
    $stmt = $pdo->query("SELECT id, slug FROM {$table} WHERE slug LIKE '% %' OR slug LIKE '%(%' OR slug != LOWER(slug)");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($items)) {
        continue;
    }

    $log[] = "<b>{$table}:</b> Found " . count($items) . " slugs to fix";

    foreach ($items as $item) {
        $oldSlug = $item['slug'];
        $newSlug = strtolower(trim(preg_replace('/[\s_]+/', '-', preg_replace('/[^\p{L}\p{N}\s-]/u', '', $oldSlug)), '-'));

        if ($newSlug === $oldSlug || empty($newSlug)) {
            continue;
        }

        $original = $newSlug;
        $counter = 2;
        while (true) {
            $check = $pdo->prepare("SELECT id FROM {$table} WHERE slug = ? AND id != ?");
            $check->execute([$newSlug, $item['id']]);
            if (!$check->fetch()) {
                break;
            }
            $newSlug = $original . '-' . $counter;
            $counter++;
        }

        $update = $pdo->prepare("UPDATE {$table} SET slug = ? WHERE id = ?");
        $update->execute([$newSlug, $item['id']]);
        $log[] = "  \"{$oldSlug}\" → \"{$newSlug}\"";
        $totalFixed++;
    }
}

$log[] = "";
$log[] = "<b>Total: {$totalFixed} slugs fixed.</b>";

echo "<h1>Fix Slugs Complete</h1>";
echo "<pre dir='ltr'>" . htmlspecialchars(implode("\n", $log)) . "</pre>";
echo "<p><b>DELETE this file after use!</b></p>";
