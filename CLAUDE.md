# BharkaBeauty — Claude Code Reference

## Project Overview
Laravel 13 beauty e-commerce store with full admin panel. Pakistani market, prices in PKR.

- **GitHub:** https://github.com/muhammadikramzafar/bharkabeauty.git
- **Stack:** PHP 8.5.7, Laravel 13.x, SQLite, Spatie Laravel Permission v8, Blade
- **PHP binary:** `C:\php83\php.exe`

## Running the App

```powershell
# Always prefix commands with this in PowerShell:
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"

# Start dev server
php artisan serve --port=8000

# Clear caches (do this after editing controllers/routes/views)
php artisan config:clear; php artisan view:clear; php artisan route:clear
```

## Admin Access
- **URL:** http://localhost:8000/admin
- **Email:** superadmin@bharkabeauty.com
- **Password:** Admin@1234
- **Roles:** super-admin, admin, editor (via Spatie)

## Database
- **Driver:** SQLite at `database/database.sqlite` (committed to git — import-ready)
- **Seeded data:** 69 products, 35 categories (7 root + 28 sub), 14 brands
- **To reset and reseed:**
  ```powershell
  php artisan migrate:fresh --seed
  ```

## Critical: PowerShell Gotchas
- **Never use** `Set-Content -Encoding utf8` for PHP files — it adds a UTF-8 BOM (EF BB BF) which causes `PHP Fatal error: Namespace declaration statement has to be the very first statement`
- **Always write PHP files** via the Write tool (Claude Code) or strip BOM after writing:
  ```powershell
  $bytes = [System.IO.File]::ReadAllBytes($path)
  if ($bytes[0] -eq 0xEF -and $bytes[1] -eq 0xBB -and $bytes[2] -eq 0xBF) {
      [System.IO.File]::WriteAllBytes($path, $bytes[3..($bytes.Length-1)])
  }
  ```
- **No `&&` operator** in PowerShell 5.1 — use `;` or `if ($?) { ... }`
- **No `head` command** — use `| Select-Object -First N`
- **No `--compact` flag** on `php artisan route:list`

## Storage & Images
- Public disk: `storage/app/public/` → symlinked to `public/storage/`
- Run `php artisan storage:link` once after fresh clone
- Images stored in: `storage/app/public/categories/`, `brands/`, `products/`
- Images committed to git — no re-seeding needed after clone
- GD extension NOT available — use cURL to download images, SVG strings for logos
- No `imagecreate`, `imagejpeg`, etc. — they don't exist on this PHP install

## URL Structure (SEO-friendly)
```
/                        → HomeController@index
/shop                    → CategoryController@index (all products)
/shop/{cat}              → CategoryController@index (e.g. /shop/skincare, /shop/makeup)
/product/{slug}          → ProductController@show
/brands                  → BrandController@index
/blog                    → BlogPageController@index
/blog/{slug}             → BlogPageController@show
/services                → ServicePageController@index
/admin                   → Admin panel (auth + role guarded)
```

Filter params (always query string, never path segments):
`?brand[]=huda-beauty&category[]=moisturizers&price[]=1000-2999&sort=price-asc`

## Key Models & Accessors
```
Product   → main_image (string, URL with fallback)
          → first_image_url (?string, first image URL or null)
          → all_image_urls (array of full URLs)
          → images (cast: array, stores relative storage paths)
          → scopeActive(), scopeFeatured()
          → getRouteKeyName() returns 'slug'

Category  → image_url (?string), scopeActive()
          → parent() / children() / products()

Brand     → logo_url (?string), scopeActive(), scopeFeatured()
          → products() hasMany

User      → orders() hasMany, Spatie HasRoles trait
```

## Admin Panel Routes (all under /admin, `auth + role:super-admin,admin,editor`)
```
/admin/products          → CRUD
/admin/categories        → CRUD
/admin/brands            → CRUD
/admin/orders            → index + show + update status
/admin/users             → CRUD with role assignment
/admin/customers         → index (frontend users only) + show
/admin/homepage          → hero, banners, services, counters, testimonials, logos, ctas
/admin/blog/posts        → CRUD
/admin/blog/categories   → CRUD (no show)
/admin/blog/tags         → CRUD (no show)
/admin/service-categories → CRUD (no show)
/admin/services          → CRUD (no show)
/admin/inquiries         → index + show
/admin/newsletter        → index
/admin/seo               → index (global SEO settings)
/admin/site-settings     → general site config
```

## View Conventions
- **Admin layout:** `@extends('admin.layouts.app')` with `@section('title')` and `@section('content')`
- **Admin form layout:** `page-editor-layout` → `page-editor-main` + `page-editor-sidebar`
- **Admin CSS:** `public/assets/css/admin.css`
- **Frontend layout:** `@extends('layouts.app')`
- **Frontend CSS:** `public/assets/css/style.css`
- **Product card partial:** `@include('partials.product-card', ['product' => $product])` — uses `$product->main_image`
- **Sidebar partial:** `@include('partials.sidebar')` — needs `$categories` and `$brands` passed from controller
- **Pagination:** always use `LengthAwarePaginator` (plain `collect()` has no `hasPages()`)

## Seeder Pattern
```php
// Run individual seeders:
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=ProductSeeder

// DatabaseSeeder call order:
RolesAndPermissionsSeeder → CategorySeeder → BrandSeeder → ProductSeeder
```

## Frequent Patterns

### Image download in seeders (cURL, no GD):
```php
private function downloadImage(string $url, string $folder, string $slug): ?string
{
    $path = "{$folder}/{$slug}.jpg";
    $dest = storage_path("app/public/{$path}");
    if (file_exists($dest)) return $path;
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_FOLLOWLOCATION=>true,
        CURLOPT_TIMEOUT=>15, CURLOPT_SSL_VERIFYPEER=>false]);
    $data = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    if ($data && $code === 200) { file_put_contents($dest, $data); return $path; }
    return null;
}
```

### Generating route URLs with category segment:
```php
route('category.index')                          // → /shop
route('category.index', ['cat' => 'skincare'])   // → /shop/skincare
route('category.index', ['cat' => 'skincare', 'brand' => 'neutrogena']) // → /shop/skincare?brand=neutrogena
```

### Checking active nav link:
```blade
{{ request()->route('cat') == 'skincare' ? 'active' : '' }}
```

## Setup on a New PC
```powershell
git clone https://github.com/muhammadikramzafar/bharkabeauty.git
cd bharkabeauty
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan serve
```
No migration or seeding needed — `database/database.sqlite` is in the repo.
