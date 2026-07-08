$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"
$localFile = "C:\Users\Owner\Desktop\smart\app\Http\Controllers\Frontend\PageController.php"
$remoteFile = "app/Http/Controllers/Frontend/PageController.php"

Write-Host "Uploading fixed PageController..."
try {
    $webClient = New-Object System.Net.WebClient
    $webClient.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
    $webClient.UploadFile("ftp://$ftpHost/$remoteFile", 'STOR', $localFile)
    $webClient.Dispose()
    Write-Host "OK: Uploaded successfully"
} catch {
    Write-Host "FAIL: $_"
}

Write-Host ""
Write-Host "Now clearing cache..."
try {
    $wc = New-Object System.Net.WebClient
    $result = $wc.DownloadString("https://smartdecorat.com/clear-cache.php")
    Write-Host $result
    $wc.Dispose()
} catch {
    Write-Host "Error: $($_.Exception.Message)"
}
