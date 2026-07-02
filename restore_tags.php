<?php
set_time_limit(60);
$m = new mysqli('localhost', 'u304271186_ali', 'Alialmaljami2024', 'u304271186_smartdecor_db');
if ($m->connect_error) die($m->connect_error);
echo "<pre>";

// First, restore corrupt tables from their known-good backup values
// Material id=1 original tags (before bad split)
$materialTags = '["\u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628\u060c \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628 \u0627\u0644\u062c\u062f\u064a\u062f\u060c \u0623\u0644\u0648\u0627\u062d \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628\u060c \u062f\u064a\u0643\u0648\u0631\u0627\u062a \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628\u060c \u062a\u0631\u0643\u064a\u0628 \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628\u060c \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628 \u0645\u0643\u0629\u060c \u0628\u062f\u064a\u0644 \u0627\u0644\u062e\u0634\u0628 \u062c\u062f\u0629\u060c \u062f\u064a\u0643\u0648\u0631 \u062c\u062f\u0631\u0627\u0646\u060c \u062f\u064a\u0643\u0648\u0631 \u062f\u0627\u062e\u0644\u064a\u060c \u062a\u0635\u0645\u064a\u0645 \u062f\u0627\u062e\u0644\u064a"]';
// Fix backslashes (they were lost by MySQL)
$materialTags = preg_replace('/(?<!\\\)u([0-9a-fA-F]{4})/', '\\\u$1', $materialTags);
$fixed = json_decode($materialTags, true);
if (is_array($fixed)) {
    $new = json_encode($fixed, JSON_UNESCAPED_UNICODE);
    $m->query("UPDATE materials SET tags = '" . $m->real_escape_string($new) . "' WHERE id = 1");
    echo "Material id=1 restored\n";
}

// Blog posts that may have been corrupted
// First, check which ones have empty or invalid tags
$r = $m->query("SELECT id, tags FROM blog_posts");
$blogFixed = 0;
while ($row = $r->fetch_assoc()) {
    $arr = json_decode($row['tags'], true);
    // Check if tags are valid array with content
    if (!is_array($arr) || count($arr) === 0 || (count($arr) === 1 && $arr[0] === '')) {
        echo "Blog id={$row['id']} BROKEN: '{$row['tags']}'\n";
        // Get from export_mysql backup
        $backup = null;
        // We can't restore from file here, just flag
        $blogFixed++;
    }
}
echo "Blog posts broken: $blogFixed\n";

// Check materials
$r2 = $m->query("SELECT id, tags FROM materials WHERE id = 1");
$row2 = $r2->fetch_assoc();
echo "Material id=1 now: " . $row2['tags'] . PHP_EOL;

$m->close();
echo "Done\n";
