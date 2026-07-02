<?php
$sql = file_get_contents("C:\\Users\\Owner\\Desktop\\smart\\database\\export_mysql.sql");
$lines = explode("\n", $sql);
$inGallery = false;
$galleryBuffer = "";
foreach ($lines as $line) {
    if (strpos($line, "INSERT INTO `galleries`") === 0) {
        $inGallery = true;
        $galleryBuffer = $line;
    } elseif ($inGallery && strpos($line, ");") !== false) {
        $galleryBuffer .= " " . $line;
        // Parse the gallery buffer
        if (preg_match("/VALUES\s*\('(\d+)'/", $galleryBuffer, $m)) {
            $id = $m[1];
            // Find meta_keywords
            if (preg_match("/'([^']*(?:''[^']*)*)'\s*,\s*'([^']*(?:''[^']*)*)'\s*\)\s*;\s*$/", $galleryBuffer, $m2)) {
                // This is too complex for regex. Just print and parse manually.
            }
            // Simpler: find the tags column (2nd to last)
            $parts = explode(",", $galleryBuffer);
            $lastPart = trim(end($parts));
            echo "Gallery $id: tags ending = " . substr($lastPart, 0, 80) . "\n";
        }
        $inGallery = false;
        $galleryBuffer = "";
    } elseif ($inGallery) {
        $galleryBuffer .= " " . $line;
    }
}
