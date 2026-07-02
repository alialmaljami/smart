<?php
$host = "localhost";
$db = "smartdecor_db";
$user = "ali";
$pass = "Alialmaljami2024";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$conn->set_charset("utf8mb4");

$whatsapp = "https://wa.me/966541232717";

echo "<pre>";
echo "=== Current Telegram/Pinterest Links ===\n\n";

$result = $conn->query("SELECT id, platform, url, sort_order FROM social_links WHERE platform IN ('telegram', 'pinterest') ORDER BY platform");
if ($result->num_rows === 0) {
    echo "No telegram or pinterest links found in DB.\n";
    echo "Creating them...\n\n";
    
    // Get max sort_order
    $max = $conn->query("SELECT MAX(sort_order) as m FROM social_links")->fetch_assoc();
    $next = ($max['m'] ?? 0) + 1;
    
    $stmt = $conn->prepare("INSERT INTO social_links (platform, url, is_active, sort_order) VALUES (?, ?, 1, ?)");
    $stmt->bind_param("ssi", $platform, $whatsapp, $sort);
    
    $platform = 'telegram'; $sort = $next;
    $stmt->execute();
    echo "Created telegram -> $whatsapp\n";
    
    $platform = 'pinterest'; $sort = $next + 1;
    $stmt->execute();
    echo "Created pinterest -> $whatsapp\n";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "ID={$row['id']} platform={$row['platform']} url={$row['url']} sort={$row['sort_order']}\n";
        $stmt = $conn->prepare("UPDATE social_links SET url = ? WHERE id = ?");
        $stmt->bind_param("si", $whatsapp, $row['id']);
        $stmt->execute();
        echo "  -> Updated to $whatsapp\n";
    }
}

echo "\n=== Updated Social Links ===\n\n";
$result = $conn->query("SELECT id, platform, url FROM social_links ORDER BY sort_order");
while ($row = $result->fetch_assoc()) {
    echo "ID={$row['id']} platform={$row['platform']} url={$row['url']}\n";
}

$conn->close();
echo "\nDONE</pre>";
