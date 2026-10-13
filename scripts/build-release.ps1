param(
    [string]$Version = (Get-Date -Format 'yyyyMMdd-HHmm')
)

$ErrorActionPreference = 'Stop'
$projectRoot = [IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..'))
$distRoot = Join-Path $projectRoot 'dist'
$stagingRoot = Join-Path $distRoot "xanhsm-$Version"
$archivePath = Join-Path $distRoot "xanhsm-$Version.zip"

if ([IO.Path]::GetFullPath($distRoot) -ne (Join-Path $projectRoot 'dist')) {
    throw 'Unexpected release directory.'
}

New-Item -ItemType Directory -Path $distRoot -Force | Out-Null
if (Test-Path -LiteralPath $stagingRoot) {
    Remove-Item -LiteralPath $stagingRoot -Recurse -Force
}
if (Test-Path -LiteralPath $archivePath) {
    Remove-Item -LiteralPath $archivePath -Force
}
New-Item -ItemType Directory -Path $stagingRoot -Force | Out-Null

$runtimeDirectories = @('app', 'config', 'content', 'cron', 'database', 'public')
foreach ($directory in $runtimeDirectories) {
    Copy-Item -LiteralPath (Join-Path $projectRoot $directory) -Destination $stagingRoot -Recurse
}

New-Item -ItemType Directory -Path (Join-Path $stagingRoot 'scripts') -Force | Out-Null
Copy-Item -LiteralPath (Join-Path $projectRoot 'scripts/migrate.php') -Destination (Join-Path $stagingRoot 'scripts/migrate.php')
New-Item -ItemType Directory -Path (Join-Path $stagingRoot 'storage/logs') -Force | Out-Null
Copy-Item -LiteralPath (Join-Path $projectRoot 'storage/logs/.gitkeep') -Destination (Join-Path $stagingRoot 'storage/logs/.gitkeep')
Copy-Item -LiteralPath (Join-Path $projectRoot '.env.example') -Destination (Join-Path $stagingRoot '.env.example')
Copy-Item -LiteralPath (Join-Path $projectRoot 'README.md') -Destination (Join-Path $stagingRoot 'README.md')

Compress-Archive -LiteralPath $stagingRoot -DestinationPath $archivePath -CompressionLevel Optimal
Remove-Item -LiteralPath $stagingRoot -Recurse -Force

Write-Output $archivePath
