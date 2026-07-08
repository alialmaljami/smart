$ftpHost = "ftp.smartdecorat.com"
$ftpUser = "u304271186.ali"
$ftpPass = "Alialiali@2024"
$remoteRoot = ""  # FTP root IS the project root

$localRoot = "C:\Users\Owner\Desktop\smart"

function Create-FtpDirectory($url) {
    try {
        $req = [System.Net.FtpWebRequest]::Create($url)
        $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        $req.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $req.UseBinary = $true
        $req.UsePassive = $true
        $req.KeepAlive = $false
        $resp = $req.GetResponse()
        $resp.Close()
        Write-Host "  Created directory: $url"
    } catch {
        # Directory likely exists
    }
}

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
    $remotePathUnix = $remotePath -replace '\\', '/'
    $remoteUrl = "ftp://$ftpHost/$remotePathUnix"
    $remoteDir = Split-Path $remotePathUnix -Parent
    
    Ensure-RemoteDir $remoteDir
    
    try {
        $webClient = New-Object System.Net.WebClient
        $webClient.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $webClient.UploadFile($remoteUrl, 'STOR', $localPath)
        $webClient.Dispose()
        Write-Host "  OK: $remotePathUnix"
    } catch {
        Write-Host "  FAIL: $remotePathUnix - $_"
    }
}

# Get changed files from git
$files = git -C $localRoot status --porcelain | ForEach-Object {
    $line = $_.Trim()
    $path = if ($line -match '^[MARC]+\s+(.+)$') { $matches[1] }
            elseif ($line -match '^\?\?\s+(.+)$') { $matches[1] }
            else { $null }
    if ($path -and -not $path.EndsWith('/')) { $path }
}

# Filter: only upload project files (skip generated/build files)
$skipPatterns = @(
    '^public/build/',
    '^railway\.json$',
    '^server\.php$',
    '^public/llms\.txt$',
    '^\.gitignore$',
    '^database/export_mysql\.sql$',
    '^database/parse_',
    '^public/add-',
    '^public/count\.php$',
    '^public/fix-',
    '^public/rename-',
    '^public/update-',
    '^deploy\.ps1$',
    '^test-ftp\.ps1$'
)

$files = $files | Where-Object {
    $shouldSkip = $false
    foreach ($pattern in $skipPatterns) {
        if ($_ -match $pattern) { $shouldSkip = $true; break }
    }
    -not $shouldSkip
}

Write-Host "=== Uploading $($files.Count) files to Hostinger ==="
Write-Host ""

foreach ($file in $files) {
    $localFile = Join-Path $localRoot $file
    $remoteFile = $file -replace '\\', '/'
    
    if (Test-Path $localFile) {
        Write-Host "Uploading: $file"
        Upload-File $localFile $remoteFile
    } else {
        Write-Host "SKIP (not found): $file"
    }
}

Write-Host ""
Write-Host "=== Upload complete ==="
Write-Host "Now visit: https://smartdecorat.com/migrate-features.php"
Write-Host "Then:     https://smartdecorat.com/clear-cache.php"
