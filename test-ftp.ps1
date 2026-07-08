$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"

Write-Host "=== Testing FTP connection ==="

# Test 1: List root
try {
    $req = [System.Net.FtpWebRequest]::Create("ftp://$ftpHost/")
    $req.Method = [System.Net.WebRequestMethods+Ftp]::ListDirectory
    $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
    $req.UseBinary = $true
    $req.UsePassive = $true
    $req.KeepAlive = $false
    $resp = $req.GetResponse()
    $stream = $resp.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $lines = $reader.ReadToEnd()
    $reader.Close()
    $resp.Close()
    Write-Host "=== Root listing ==="
    Write-Host $lines
} catch {
    Write-Host "Root failed: $_"
}

# Test 2: List public_html
try {
    $req = [System.Net.FtpWebRequest]::Create("ftp://$ftpHost/public_html/")
    $req.Method = [System.Net.WebRequestMethods+Ftp]::ListDirectory
    $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
    $req.UseBinary = $true
    $req.UsePassive = $true
    $req.KeepAlive = $false
    $resp = $req.GetResponse()
    $stream = $resp.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $lines = $reader.ReadToEnd()
    $reader.Close()
    $resp.Close()
    Write-Host "=== public_html listing ==="
    Write-Host $lines
} catch {
    Write-Host "public_html failed: $_"
}
