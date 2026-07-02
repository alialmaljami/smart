<?php
$m = new mysqli('localhost', 'u304271186_ali', 'Alialmaljami2024', 'u304271186_smartdecor_db');
if ($m->connect_error) die("DB error");
$r = $m->query("SELECT id, tags FROM materials WHERE id = 1");
$row = $r->fetch_assoc();
echo "tags raw: " . $row['tags'] . PHP_EOL;
$decoded = json_decode($row['tags'], true);
echo "is_array: " . (is_array($decoded) ? 'yes' : 'no') . PHP_EOL;
if (is_array($decoded)) {
    echo "count: " . count($decoded) . PHP_EOL;
    foreach ($decoded as $i => $t) {
        echo "  [$i] " . $t . PHP_EOL;
    }
}
$m->close();
