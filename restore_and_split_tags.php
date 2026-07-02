<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo "<pre>\n";
$m = new mysqli('localhost', 'u304271186_ali', 'Alialmaljami2024', 'u304271186_smartdecor_db');
if ($m->connect_error) die("DB: " . $m->connect_error);

// Reconstruct tags from meta_keywords for blog_posts and materials
// meta_keywords contains comma-separated keywords like tags
$tables = [
    'blog_posts' => 'meta_keywords',
    'materials' => 'meta_keywords'
];
$total = 0;

foreach ($tables as $table => $kwCol) {
    echo "--- $table ---\n";
    $r = $m->query("SELECT id, $kwCol, tags FROM `$table` WHERE $kwCol IS NOT NULL AND $kwCol != ''");
    while ($row = $r->fetch_assoc()) {
        // Split keywords by Arabic comma
        $keywords = preg_split('/[،,]/u', $row[$kwCol]);
        $tags = [];
        foreach ($keywords as $kw) {
            $kw = trim($kw);
            if ($kw !== '') $tags[] = $kw;
        }
        $tags = array_values(array_unique($tags));
        if (count($tags) === 0) continue;
        
        $newJson = json_encode($tags, JSON_UNESCAPED_UNICODE);
        $m->query("UPDATE `$table` SET tags = '" . $m->real_escape_string($newJson) . "' WHERE id = {$row['id']}");
        echo "  id={$row['id']}: " . substr($newJson, 0, 60) . "\n";
        $total++;
    }
}

// For galleries and projects, read from the export SQL file
$sqlPath = __DIR__ . '/../storage/app/export_mysql.sql';
if (file_exists($sqlPath)) {
    $sql = file_get_contents($sqlPath);
    
    // Fix \u in tags for galleries
    echo "\n--- galleries (from SQL) ---\n";
    preg_match_all('/INSERT INTO `galleries`[\s\S]*?VALUES\s*\((.*?)\);/s', $sql, $galInserts);
    foreach ($galInserts[1] as $i => $valsStr) {
        // Find id and tags in the values
        // Tags is column 5 (0-indexed: 4) based on table structure
        $vals = explode("','", $valsStr);
        if (count($vals) < 5) continue;
        
        // ID is first value, tags is around position 4
        $id = trim($vals[0], "'");
        $tagsRaw = $vals[4] ?? '';
        $tagsRaw = trim($tagsRaw, "'");
        
        // Find JSON array
        if (!preg_match('/\[".*?\]/', $tagsRaw, $jm)) continue;
        $json = $jm[0];
        
        // Fix backslash and decode
        $fixed = preg_replace('/(?<!\\\\)u([0-9a-fA-F]{4})/', '\\\u$1', $json);
        $decoded = @json_decode($fixed, true);
        if (!is_array($decoded)) continue;
        
        $allTags = [];
        foreach ($decoded as $v) {
            foreach (preg_split('/[،,]/u', $v) as $p) {
                $t = trim($p);
                if ($t !== '') $allTags[] = $t;
            }
        }
        $allTags = array_values(array_unique($allTags));
        if (!count($allTags)) continue;
        
        $newJson = json_encode($allTags, JSON_UNESCAPED_UNICODE);
        $m->query("UPDATE galleries SET tags = '" . $m->real_escape_string($newJson) . "' WHERE id = $id");
        echo "  id=$id: " . substr($newJson, 0, 60) . "\n";
        $total++;
    }
    
    // Fix projects
    echo "\n--- projects (from SQL) ---\n";
    preg_match_all('/INSERT INTO `projects`[\s\S]*?VALUES\s*\((.*?)\);/s', $sql, $projInserts);
    foreach ($projInserts[1] as $i => $valsStr) {
        $vals = explode("','", $valsStr);
        if (count($vals) < 5) continue;
        
        $id = trim($vals[0], "'");
        $tagsRaw = $vals[4] ?? '';
        $tagsRaw = trim($tagsRaw, "'");
        
        if (!preg_match('/\[".*?\]/', $tagsRaw, $jm)) continue;
        $json = $jm[0];
        
        $fixed = preg_replace('/(?<!\\\\)u([0-9a-fA-F]{4})/', '\\\u$1', $json);
        $decoded = @json_decode($fixed, true);
        if (!is_array($decoded)) continue;
        
        $allTags = [];
        foreach ($decoded as $v) {
            foreach (preg_split('/[،,]/u', $v) as $p) {
                $t = trim($p);
                if ($t !== '') $allTags[] = $t;
            }
        }
        $allTags = array_values(array_unique($allTags));
        if (!count($allTags)) continue;
        
        $newJson = json_encode($allTags, JSON_UNESCAPED_UNICODE);
        $m->query("UPDATE projects SET tags = '" . $m->real_escape_string($newJson) . "' WHERE id = $id");
        echo "  id=$id: " . substr($newJson, 0, 60) . "\n";
        $total++;
    }
}

$m->close();
echo "\nTotal restored: $total\nDone\n";
