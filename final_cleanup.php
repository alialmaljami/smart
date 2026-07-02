<?php
$files = ['fix_unicode_all.php', 'check_settings.php'];
foreach ($files as $f) {
    if (file_exists($f)) { unlink($f); echo "Deleted: $f\n"; }
}
unlink('cleanup2.php'); echo "Deleted: cleanup2.php\n";
echo "Done\n";
