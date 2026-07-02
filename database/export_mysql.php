<?php
$db = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);

$output = "-- Export from SQLite to MySQL\n-- Date: " . date('Y-m-d H:i:s') . "\n-- Tables: " . implode(', ', $tables) . "\n\n";
$output .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

foreach ($tables as $table) {
    $create = $db->query("SELECT sql FROM sqlite_master WHERE name = '$table'")->fetchColumn();
    if (!$create) continue;

    $mysql = preg_replace('/INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT/i', 'INT AUTO_INCREMENT PRIMARY KEY', $create);
    $mysql = preg_replace('/INTEGER/', 'INT', $mysql);
    $mysql = preg_replace('/TEXT/', 'LONGTEXT', $mysql);
    $mysql = preg_replace('/REAL/', 'DOUBLE', $mysql);
    $mysql = preg_replace('/BLOB/', 'LONGBLOB', $mysql);
    $mysql = preg_replace('/NUMERIC/', 'DECIMAL(10,2)', $mysql);
    $mysql = preg_replace('/AUTOINCREMENT/i', 'AUTO_INCREMENT', $mysql);
    $mysql = str_replace('"', '`', $mysql);
    $output .= "DROP TABLE IF EXISTS `$table`;\n$mysql;\n\n";

    $rows = $db->query("SELECT * FROM \"$table\"")->fetchAll(PDO::FETCH_ASSOC);
    if (!count($rows)) continue;

    $cols = array_keys($rows[0]);
    $colList = '`' . implode('`, `', $cols) . '`';

    foreach ($rows as $row) {
        $vals = [];
        foreach ($row as $v) {
            if ($v === null) { $vals[] = 'NULL'; }
            else { $vals[] = "'" . str_replace("'", "''", $v) . "'"; }
        }
        $output .= "INSERT INTO `$table` ($colList) VALUES (" . implode(', ', $vals) . ");\n";
    }
    $output .= "\n";
}

$output .= "SET FOREIGN_KEY_CHECKS = 1;\n";

$path = __DIR__ . '/export_mysql.sql';
file_put_contents($path, $output);
echo "✅ Exported " . count($tables) . " tables to database/export_mysql.sql (" . number_format(strlen($output) / 1024, 1) . " KB)\n";
