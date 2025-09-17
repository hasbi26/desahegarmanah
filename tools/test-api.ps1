# Simple PowerShell API test script for local CodeIgniter API
# Usage: Open PowerShell in project root and run: .\tools\test-api.ps1

$base = 'http://127.0.0.1:8000/api'

function Invoke-Json {
    param($method, $url, $body=$null)
    try {
        if ($body -ne $null) {
            $json = $body | ConvertTo-Json -Depth 10
            $res = Invoke-RestMethod -Uri $url -Method $method -Body $json -ContentType 'application/json'
        } else {
            $res = Invoke-RestMethod -Uri $url -Method $method
        }
        return @{ ok = $true; data = $res }
    } catch {
        return @{ ok = $false; error = $_.Exception.Response.StatusCode.Value__ ; raw = $_.Exception.Response.StatusDescription }
    }
}

Write-Host "Testing Enumerator endpoints..." -ForegroundColor Cyan

# 1. List
$list = Invoke-Json -method GET -url "$base/enumerator"
Write-Host "GET /enumerator ->" ($list.ok ? 'OK' : 'FAILED')
$list | ConvertTo-Json -Depth 5 | Write-Host

# 2. Create
$createBody = @{ nama = 'Test Enumerator'; alamat = 'Jl Contoh'; hp_telepon = '08123456789' }
$create = Invoke-Json -method POST -url "$base/enumerator" -body $createBody
Write-Host "POST /enumerator ->" ($create.ok ? 'OK' : 'FAILED')
$create | ConvertTo-Json -Depth 5 | Write-Host

# If create succeeded, capture id
if ($create.ok -and $create.data.id) { $id = $create.data.id } else { $id = $null }

if ($id) {
    # 3. Show
    $show = Invoke-Json -method GET -url "$base/enumerator/$id"
    Write-Host "GET /enumerator/$id ->" ($show.ok ? 'OK' : 'FAILED')
    $show | ConvertTo-Json -Depth 5 | Write-Host

    # 4. Update
    $updateBody = @{ nama = 'Updated Enumerator'; alamat = 'Alamat baru'; hp_telepon = '08987654321' }
    $update = Invoke-Json -method POST -url "$base/enumerator/$id/update" -body $updateBody
    Write-Host "POST /enumerator/$id/update ->" ($update.ok ? 'OK' : 'FAILED')
    $update | ConvertTo-Json -Depth 5 | Write-Host

    # 5. Delete
    $delete = Invoke-Json -method DELETE -url "$base/enumerator/$id"
    Write-Host "DELETE /enumerator/$id ->" ($delete.ok ? 'OK' : 'FAILED')
    $delete | ConvertTo-Json -Depth 5 | Write-Host
} else {
    Write-Host "Create failed; skipping show/update/delete." -ForegroundColor Yellow
}

Write-Host "\nTesting Penduduk endpoints..." -ForegroundColor Cyan

# 1. List
$pList = Invoke-Json -method GET -url "$base/penduduk"
Write-Host "GET /penduduk ->" ($pList.ok ? 'OK' : 'FAILED')
$pList | ConvertTo-Json -Depth 5 | Write-Host

# 2. Create (basic required fields)
$pCreateBody = @{ nama_lengkap='Script Tester'; nik='9999999999999999'; rt_id=1 }
$pCreate = Invoke-Json -method POST -url "$base/penduduk" -body $pCreateBody
Write-Host "POST /penduduk ->" ($pCreate.ok ? 'OK' : 'FAILED')
$pCreate | ConvertTo-Json -Depth 5 | Write-Host

if ($pCreate.ok -and $pCreate.data.id) { $pid = $pCreate.data.id } else { $pid = $null }

if ($pid) {
    $pShow = Invoke-Json -method GET -url "$base/penduduk/$pid"
    Write-Host "GET /penduduk/$pid ->" ($pShow.ok ? 'OK' : 'FAILED')
    $pShow | ConvertTo-Json -Depth 5 | Write-Host

    $pUpdateBody = @{ nama_lengkap='Updated Script Tester' }
    try {
        $pUpdate = Invoke-RestMethod -Uri "$base/penduduk/$pid" -Method PUT -Body ($pUpdateBody | ConvertTo-Json -Depth 5) -ContentType 'application/json'
        Write-Host "PUT /penduduk/$pid -> OK"
    } catch {
        Write-Host "PUT /penduduk/$pid -> FAILED: $_"
    }

    $pDelete = Invoke-Json -method DELETE -url "$base/penduduk/$pid"
    Write-Host "DELETE /penduduk/$pid ->" ($pDelete.ok ? 'OK' : 'FAILED')
    $pDelete | ConvertTo-Json -Depth 5 | Write-Host
} else {
    Write-Host "Penduduk create failed; skipping show/update/delete." -ForegroundColor Yellow
}

Write-Host "\nDone." -ForegroundColor Green
