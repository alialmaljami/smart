$urls = @(
    "https://smartdecorat.com/migrate-features.php",
    "https://smartdecorat.com/clear-cache.php"
)

foreach ($url in $urls) {
    Write-Host "=== Fetching: $url ==="
    try {
        $wc = New-Object System.Net.WebClient
        $result = $wc.DownloadString($url)
        $wc.Dispose()
        Write-Host $result
    } catch {
        Write-Host "Error: $($_.Exception.Message)"
    }
    Write-Host ""
}
