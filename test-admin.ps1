$urls = @(
    "https://smartdecorat.com/admin/videos",
    "https://smartdecorat.com/admin/videos/create",
    "https://smartdecorat.com/admin/tours",
    "https://smartdecorat.com/admin/before-after",
    "https://smartdecorat.com/admin/neighborhoods"
)

foreach ($url in $urls) {
    Write-Host "=== $url ==="
    try {
        $wc = New-Object System.Net.WebClient
        $result = $wc.DownloadString($url)
        Write-Host "Status: OK"
        if ($result.Length -gt 200) {
            Write-Host "Response length: $($result.Length) chars"
        } else {
            Write-Host $result
        }
        $wc.Dispose()
    } catch {
        Write-Host "ERROR: $($_.Exception.Message)"
        if ($_.Exception.InnerException) {
            try { Write-Host "Inner: $($_.Exception.InnerException.Message)" } catch {}
        }
    }
    Write-Host ""
}
