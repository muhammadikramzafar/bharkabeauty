---
description: Start the BharkaBeauty dev server and verify it's running
---

# Run — BharkaBeauty Dev Server

## Prerequisites
- PHP binary at `C:\php83\php.exe` — always prepend to PATH
- MySQL running with database `bharka` (root, no password)
- `.env` has `DB_CONNECTION=mysql`, `DB_DATABASE=bharka`

## Start the server

```powershell
$env:PATH = "C:\php83;" + $env:PATH
Set-Location "c:\laravel\bharkabeauty"
php artisan serve --port=8000
```

Server runs at **http://127.0.0.1:8000**

## Verify it's up (in a second terminal)

```powershell
$env:PATH = "C:\php83;" + $env:PATH
Set-Location "c:\laravel\bharkabeauty"
$r = Invoke-WebRequest -Uri "http://127.0.0.1:8000" -UseBasicParsing -ErrorAction SilentlyContinue
Write-Host "HTTP $($r.StatusCode)"
```

Expected: `HTTP 200`

## Smoke-test key pages

```powershell
@('/', '/shop', '/brands', '/customer/login', '/my-account', '/cart', '/checkout') | ForEach-Object {
    $r = Invoke-WebRequest -Uri "http://127.0.0.1:8000$_" -UseBasicParsing -MaximumRedirection 5 -ErrorAction SilentlyContinue
    Write-Host "$_ → HTTP $($r.StatusCode)"
}
```

## Clear all caches (do after any code change)

```powershell
$env:PATH = "C:\php83;" + $env:PATH
Set-Location "c:\laravel\bharkabeauty"
php artisan config:clear; php artisan view:clear; php artisan route:clear
```

## Common startup errors

| Error | Fix |
|---|---|
| `Class not found` | Run `composer install` |
| `No application encryption key` | Run `php artisan key:generate` |
| `SQLSTATE[HY000]` DB error | Check MySQL is running; create `bharka` database |
| `BOM` PHP fatal error | PHP file has UTF-8 BOM — re-write via Claude Code Write tool |
| `Route not found` | Run `php artisan route:clear` |
| `View not found` | Run `php artisan view:clear` |
| Port 8000 in use | Use `php artisan serve --port=8001` |
