<?php
$m = new mysqli('localhost', 'u304271186_ali', 'Alialmaljami2024', 'u304271186_smartdecor_db');
if ($m->connect_error) die($m->connect_error);
echo "<pre>";

[$id, $table] = [2, 'blog_posts'];
$r = $m->query("SELECT id, LENGTH(tags) as len, tags FROM `$table` WHERE id = $id");
$row = $r->fetch_assoc();
echo "ID: {$row['id']}, LEN={$row['len']}\n";
echo "Hex (first 200): " . bin2hex(substr($row['tags'], 0, 100)) . "\n";
echo "Raw: " . $row['tags'] . "\n";
echo "JSON decode: ";
$d = @json_decode($row['tags'], true);
if ($d) echo implode(', ', $d) . "\n";
else echo json_last_error_msg() . "\n";

$m->close();
echo "\nDone\n";
