<?php
$sql = file_get_contents("C:\\Users\\Owner\\Desktop\\smart\\database\\export_mysql.sql");
$lines = explode("\n", $sql);
$inProject = false;
foreach ($lines as $line) {
    if (strpos($line, "INSERT INTO `projects`") === 0) {
        $inProject = true;
    }
    if ($inProject) {
        // Try to parse tags from the end of the VALUES line
        if (preg_match("/VALUES\s*\('(\d+)'.*\)\s*;\s*$/", $line, $m)) {
            echo "Project ID: " . $m[1] . "\n";
        }
        // Get the tags part - last column before );
        if (preg_match("/,\s*'(\[.*?\])'\s*\)\s*;\s*$/", $line, $m)) {
            echo "  tags: " . $m[1] . "\n";
        } elseif (preg_match("/,\s*NULL\s*\)\s*;\s*$/", $line, $m)) {
            echo "  tags: NULL\n";
        }
        $inProject = false;
    }
}
