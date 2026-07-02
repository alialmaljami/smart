<?php
// Delete public SQL file
$f = __DIR__ . '/../public/export_mysql.sql';
if (file_exists($f)) { unlink($f); echo "Deleted public SQL\n"; }
echo "Done\n";
