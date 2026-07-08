$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"

# Try to read the Laravel error log
$logPaths = @(
    "storage/logs/laravel.log",
    "storage/logs/laravel-$(Get-Date -Format 'yyyy-MM-dd').log"
)

foreach ($logPath in $logPaths) {
    Write-Host "=== Checking: $logPath ==="
    try {
        $req = [System.Net.FtpWebRequest]::Create("ftp://$ftpHost/$logPath")
        $req.Method = [System.Net.WebRequestMethods+Ftp]::DownloadFile
        $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $req.UseBinary = $true
        $req.UsePassive = $true
        $req.KeepAlive = $false
        $resp = $req.GetResponse()
        $stream = $resp.GetResponseStream()
        $reader = New-Object System.IO.StreamReader($stream)
        $content = $reader.ReadToEnd()
        $reader.Close()
        $resp.Close()
        
        # Show last 50 lines
        $lines = $content -split "`n"
        $start = [Math]::Max(0, $lines.Count - 50)
        for ($i = $start; $i -lt $lines.Count; $i++) {
            Write-Host $lines[$i]
        }
    } catch {
        Write-Host "  Not found or error: $_"
    }
}
