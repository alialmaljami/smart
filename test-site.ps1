try {
    $wc = New-Object System.Net.WebClient
    $result = $wc.DownloadString("https://smartdecorat.com/admin/login")
    Write-Host "Login page: OK ($($result.Length) chars)"
    $wc.Dispose()
} catch {
    Write-Host "Login page: $($_.Exception.Message)"
}

try {
    $wc = New-Object System.Net.WebClient
    $result = $wc.DownloadString("https://smartdecorat.com/clear-cache.php")
    Write-Host $result
    $wc.Dispose()
} catch {
    Write-Host "Clear cache: $($_.Exception.Message)"
}
