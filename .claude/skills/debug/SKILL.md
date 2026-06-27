---
description: Debug common BharkaBeauty errors — 500s, blank pages, mail, OTP, routes
---

# Debug — BharkaBeauty Common Issues

## Check Laravel logs

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
Get-Content storage\logs\laravel.log -Tail 50
```

For OTP codes (MAIL_MAILER=log):
```powershell
Select-String "\[SMS\]|To:.*otp|verification code" storage\logs\laravel.log | Select-Object -Last 10
```

## Route debugging

```powershell
# List all routes
php artisan route:list

# Filter by path
php artisan route:list --path=customer
php artisan route:list --path=my-account
php artisan route:list --path=checkout

# If route not found after adding it
php artisan route:clear
```

## Common errors and fixes

### 500 on any page
```powershell
# Check log tail
Get-Content storage\logs\laravel.log -Tail 30
# Clear all caches
php artisan config:clear; php artisan view:clear; php artisan route:clear
```

### `Call to undefined method ...::middleware()`
Laravel 13 removed `$this->middleware()` from controller constructors.
Fix: remove constructor, move middleware to route group in `routes/web.php`.

### `Class ... not found`
```powershell
composer install
# or
composer dump-autoload
```

### PHP fatal: `Namespace declaration statement has to be the very first statement`
UTF-8 BOM in the PHP file. Strip it:
```powershell
$path = "app\Http\Controllers\SomeController.php"
$bytes = [System.IO.File]::ReadAllBytes($path)
if ($bytes[0] -eq 0xEF) { [System.IO.File]::WriteAllBytes($path, $bytes[3..($bytes.Length-1)]) }
```
**Prevention:** always write PHP files via Claude Code Write tool, never `Set-Content -Encoding utf8`.

### Blank page / view not rendering
```powershell
php artisan view:clear
# Check for unclosed Blade tags, missing @endforeach, @endif etc.
```

### DB connection error
- Confirm MySQL is running
- Check `.env`: `DB_CONNECTION=mysql`, `DB_DATABASE=bharka`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_USERNAME=root`, `DB_PASSWORD=`
- Database must be created manually: `CREATE DATABASE bharka;`

### Migration FK constraint error
Check that `cms_pages` migration runs BEFORE `menu_items`.
Filenames must sort: `093317_5_create_cms_pages` → `093317_create_menus` → `093319_create_menu_items`.

### OTP not arriving (email)
`MAIL_MAILER=log` — check `storage/logs/laravel.log` for the code.
Look for `Subject: Your BharkaBeauty Login Code` or `[SMS]`.

### OTP not arriving (SMS)
`SmsService` logs only. Check log for `[SMS] To: 03XX...`.
To enable real SMS, edit `app/Services/SmsService.php` and add gateway credentials to `.env`.

### Cart prices PKR 0
`CartController::add()` must fetch product from DB (not trust POST fields).
Check that `Product::findOrFail($id)` is called and `main_image` accessor exists.

### Checkout 500 after placing order
Check `orders` and `order_items` tables exist: `php artisan migrate:status`

### Images not showing (broken img)
```powershell
php artisan storage:link   # creates public/storage symlink
```
Verify: `Test-Path public\storage` should return `True`.

## Verify key pages are up

```powershell
@('/', '/shop', '/customer/login', '/customer/register', '/my-account', '/cart') | ForEach-Object {
    $r = Invoke-WebRequest -Uri "http://127.0.0.1:8000$_" -UseBasicParsing -MaximumRedirection 5 -EA SilentlyContinue
    "$_ → $($r.StatusCode)"
}
```
