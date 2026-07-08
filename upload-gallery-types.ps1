$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"

function Create-FtpDir($path) {
    $url = "ftp://$ftpHost/$path"
    try {
        $req = [System.Net.FtpWebRequest]::Create($url)
        $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $req.UseBinary = $true
        $req.UsePassive = $true
        $req.KeepAlive = $false
        $resp = $req.GetResponse()
        $resp.Close()
        Write-Host "Created: $path"
    } catch {
        Write-Host "Exists/skip: $path"
    }
}

function Upload-File($localPath, $remotePath) {
    $remoteUrl = "ftp://$ftpHost/$remotePath"
    try {
        $webClient = New-Object System.Net.WebClient
        $webClient.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $webClient.UploadFile($remoteUrl, 'STOR', $localPath)
        $webClient.Dispose()
        Write-Host "  OK: $remotePath"
    } catch {
        Write-Host "  FAIL: $remotePath - $_"
    }
}

# Create directories explicitly
Create-FtpDir "resources/views/admin/gallery-types"
Create-FtpDir "resources/views/admin/gallery-types/videos"
Create-FtpDir "resources/views/admin/gallery-types/tours"
Create-FtpDir "resources/views/admin/gallery-types/before-after"

# Upload gallery type files
$localRoot = "C:\Users\Owner\Desktop\smart"
$files = @(
    "resources/views/admin/gallery-types/videos/index.blade.php",
    "resources/views/admin/gallery-types/videos/form.blade.php",
    "resources/views/admin/gallery-types/videos/edit.blade.php",
    "resources/views/admin/gallery-types/videos/create.blade.php",
    "resources/views/admin/gallery-types/before-after/index.blade.php",
    "resources/views/admin/gallery-types/before-after/form.blade.php",
    "resources/views/admin/gallery-types/before-after/edit.blade.php",
    "resources/views/admin/gallery-types/before-after/create.blade.php",
    "resources/views/admin/gallery-types/tours/index.blade.php",
    "resources/views/admin/gallery-types/tours/form.blade.php",
    "resources/views/admin/gallery-types/tours/edit.blade.php",
    "resources/views/admin/gallery-types/tours/create.blade.php"
)

foreach ($file in $files) {
    $localFile = Join-Path $localRoot $file
    if (Test-Path $localFile) {
        Write-Host "Uploading: $file"
        Upload-File $localFile $file
    }
}
