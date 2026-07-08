$url = "https://smartdecorat.com/admin/videos"
Write-Host "Fetching: $url"

try {
    $req = [System.Net.HttpWebRequest]::Create($url)
    $req.Method = "GET"
    $req.AllowAutoRedirect = $false
    $resp = $req.GetResponse()
    Write-Host "Status: $($resp.StatusCode) $($resp.StatusDescription)"
    $stream = $resp.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $body = $reader.ReadToEnd()
    $reader.Close()
    $resp.Close()
    if ($body.Length -gt 1000) {
        Write-Host "Body length: $($body.Length)"
        Write-Host "First 1000 chars:"
        Write-Host $body.Substring(0, [Math]::Min(1000, $body.Length))
    } else {
        Write-Host "Body:"
        Write-Host $body
    }
} catch {
    Write-Host "ERROR: $($_.Exception.Message)"
    if ($_.Exception.Response) {
        $resp = $_.Exception.Response
        $stream = $resp.GetResponseStream()
        $reader = New-Object System.IO.StreamReader($stream)
        $body = $reader.ReadToEnd()
        $reader.Close()
        Write-Host "Error body: $body"
    }
}
