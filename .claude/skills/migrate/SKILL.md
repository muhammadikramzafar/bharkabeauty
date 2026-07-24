---
description: Run, check, and create migrations for Amsaz Cosmetics
---

# Migrate — Amsaz Cosmetics Database Migrations

## Check migration status

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
php artisan migrate:status
```

## Run pending migrations

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
php artisan migrate
```

## Full reset + reseed (WARNING: destroys all data)

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
php artisan migrate:fresh --seed
```

## Create a new migration

```powershell
php artisan make:migration add_column_to_table_name
php artisan make:migration create_table_name_table
```

Always **read the generated file** before writing to it (the Write tool requires a prior Read).

## Critical FK ordering rule

`cms_pages` must run before `menu_items` — this is encoded in filenames:
- `093317_5_create_cms_pages_table.php`
- `093317_create_menus_table.php`
- `093319_create_menu_items_table.php`

Do NOT renumber these migrations without checking FK dependencies.

## Adding a column to an existing table

```php
// In the migration up():
Schema::table('users', function (Blueprint $table) {
    $table->string('phone', 20)->nullable()->after('email');
});

// In down():
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('phone');
});
```

## Table inventory (as of 2026-06-27)

| Table | Purpose |
|---|---|
| `users` | All users (admin + customers). Has `phone` (nullable) |
| `orders` | Order header: status, payment_method, shipping_address (JSON) |
| `order_items` | Line items per order with price snapshot |
| `otp_tokens` | OTP codes for passwordless customer login |
| `products` | Catalog products with images (JSON array) |
| `categories` | Nested categories (parent_id nullable) |
| `brands` | Product brands |
| `sessions` | Laravel session store |
| `cache` | Laravel cache |
| `jobs` | Laravel queue |
| `permissions` / `roles` | Spatie permission tables |
