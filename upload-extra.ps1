$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"
$localRoot = "C:\Users\Owner\Desktop\smart"

function Ensure-RemoteDir($relativeDir) {
    $parts = $relativeDir.Split('/')
    $pathSoFar = ""
    foreach ($part in $parts) {
        if ([string]::IsNullOrEmpty($part)) { continue }
        $pathSoFar = if ($pathSoFar) { "$pathSoFar/$part" } else { $part }
        $dirUrl = "ftp://$ftpHost/$pathSoFar"
        try {
            $req = [System.Net.FtpWebRequest]::Create($dirUrl)
            $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
            $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
            $req.UseBinary = $true
            $req.UsePassive = $true
            $req.KeepAlive = $false
            $resp = $req.GetResponse()
            $resp.Close()
        } catch { }
    }
}

function Upload-File($localPath, $remotePath) {
    $remoteUrl = "ftp://$ftpHost/$remotePath"
    $remoteDir = Split-Path $remotePath -Parent
    Ensure-RemoteDir $remoteDir
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

$extraFiles = @(
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
    "resources/views/admin/gallery-types/tours/create.blade.php",
    "resources/views/admin/neighborhoods/index.blade.php",
    "resources/views/admin/neighborhoods/form.blade.php",
    "resources/views/admin/neighborhoods/edit.blade.php",
    "resources/views/admin/neighborhoods/create.blade.php",
    "resources/views/frontend/media/show.blade.php",
    "resources/views/frontend/neighborhoods/show.blade.php",
    "resources/views/errors/404.blade.php"
)

Write-Host "=== Uploading $($extraFiles.Count) extra (new) view files ==="

foreach ($file in $extraFiles) {
    $localFile = Join-Path $localRoot $file
    if (Test-Path $localFile) {
        Write-Host "Uploading: $file"
        Upload-File $localFile $file
    } else {
        Write-Host "SKIP (not found): $file"
    }
}

Write-Host "=== Extra upload complete ==="
