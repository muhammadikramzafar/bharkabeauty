# BharkaBeauty — Claude Code Reference

## Project Overview
Laravel 13 beauty e-commerce store with full admin panel. Pakistani market, prices in PKR.

- **GitHub:** https://github.com/muhammadikramzafar/bharkabeauty.git
- **Stack:** PHP 8.5.7, Laravel 13.x, MySQL, Spatie Laravel Permission v8, Blade
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
- **Driver:** MySQL — database `bharka`, host `127.0.0.1:3306`, user `root`, no password
- **Seeded data:** 69 products, 35 categories (7 root + 28 sub), 14 brands
- **To reset and reseed:**
  ```powershell
  php artisan migrate:fresh --seed
  ```
- **Migration FK note:** `cms_pages` must run before `menu_items` (FK dependency). Migration filenames encode this: `093317_5_create_cms_pages`, `093317_create_menus`, `093319_create_menu_items`. Do NOT renumber these without checking dependencies.

## Critical: PowerShell Gotchas
- **Never use** `Set-Content -Encoding utf8` for PHP files — adds UTF-8 BOM (EF BB BF) → `PHP Fatal error: Namespace declaration statement has to be the very first statement`
- **Always write PHP files** via the Write tool (Claude Code). To strip BOM manually:
  ```powershell
  $bytes = [System.IO.File]::ReadAllBytes($path)
  if ($bytes[0] -eq 0xEF -and $bytes[1] -eq 0xBB -and $bytes[2] -eq 0xBF) {
      [System.IO.File]::WriteAllBytes($path, $bytes[3..($bytes.Length-1)])
  }
  ```
- **No `&&` operator** in PowerShell 5.1 — use `;` or `if ($?) { ... }`
- **No `head` command** — use `| Select-Object -First N`
- **No `--compact` flag** on `php artisan route:list`
- **Multi-line git commit messages** — use PowerShell here-string: `$msg = @'...'@; git commit -m $msg`

## Storage & Images
- Public disk: `storage/app/public/` → symlinked to `public/storage/`
- Run `php artisan storage:link` once after fresh clone
- Images stored in: `storage/app/public/categories/`, `brands/`, `products/`
- **Images committed to git** — 35 category JPGs, 14 brand SVGs, 69 product JPGs
- Seeders skip download if file already exists (`file_exists()` check) — safe to re-run
- GD extension NOT available — use cURL for image downloads, PHP SVG strings for logos
- No `imagecreate`, `imagejpeg` etc. on this PHP install

## URL Structure (SEO-friendly)
```
/                        → HomeController@index
/shop                    → CategoryController@index  (all products)
/shop/{cat}              → CategoryController@index  (e.g. /shop/skincare, /shop/tools)
/product/{slug}          → ProductController@show
/brands                  → BrandController@index
/blog                    → BlogPageController@index
/blog/{slug}             → BlogPageController@show
/services                → ServicePageController@index
/admin                   → Admin panel (auth + role guarded)
```

Filter params stay as query strings — never path segments:
`/shop/skincare?brand[]=neutrogena&category[]=moisturizers&price[]=1000-2999&sort=price-asc`

**Route generation:**
```php
route('category.index')                                              // /shop
route('category.index', ['cat' => 'skincare'])                       // /shop/skincare
route('category.index', ['cat' => 'skincare', 'brand' => 'loreal'])  // /shop/skincare?brand=loreal
```

**Active nav detection** (cat is a route param, not query string):
```blade
{{ request()->route('cat') == 'skincare' ? 'active' : '' }}
```

## Key Models & Accessors
```
Product   → main_image       string  — full public URL, never null (has Unsplash fallback)
          → first_image_url  ?string — first image URL or null
          → all_image_urls   array   — all image full URLs (for gallery loops)
          → images           array   — raw relative storage paths (cast: array)
          → scopeActive(), scopeFeatured()
          → slug is the route key (getRouteKeyName() → 'slug')

Category  → image_url        ?string — Storage URL or null
          → parent() / children() / products()
          → scopeActive()

Brand     → logo_url         ?string — Storage URL or null
          → scopeActive(), scopeFeatured()
          → products() hasMany

User      → orders() hasMany Order
          → Spatie HasRoles trait
```

## Frontend Controllers (all fully implemented)

| Controller | Method | What it does |
|---|---|---|
| `HomeController` | `index()` | Passes `$featuredProducts`, `$newArrivals`, `$saleProducts`, `$rootCategories`, `$featuredBrands` |
| `CategoryController` | `index(Request, ?string $cat)` | Full filter/sort: brand[], category[], price[], availability[], sort |
| `ProductController` | `show(string $slug)` | Loads product + related products (same cat/brand) |
| `BrandController` | `index()` | All active brands with product counts |

**Sidebar partial** (`partials/sidebar.blade.php`) wraps filters in a `<form method="GET">` that auto-submits on checkbox change. Action URL is `route('category.index', ['cat' => request()->route('cat')])` so the category path segment is preserved. Sort uses a JS `URL.searchParams` redirect.

## Admin Panel Routes (all under /admin, `auth + role:super-admin,admin,editor`)
```
/admin/products           → CRUD
/admin/categories         → CRUD
/admin/brands             → CRUD
/admin/orders             → index + show + update status
/admin/users              → CRUD with role assignment
/admin/customers          → index (frontend users only) + show
/admin/homepage           → hero, banners, services, counters, testimonials, logos, ctas
/admin/blog/posts         → CRUD
/admin/blog/categories    → CRUD (no show)
/admin/blog/tags          → CRUD (no show)
/admin/service-categories → CRUD (no show)
/admin/services           → CRUD (no show)
/admin/inquiries          → index + show
/admin/newsletter         → index
/admin/seo                → index (global SEO settings)
/admin/site-settings      → general site config
```

## View Conventions
- **Admin layout:** `@extends('admin.layouts.app')` with `@section('title')` and `@section('content')`
- **Admin form layout:** `page-editor-layout` div → `page-editor-main` + `page-editor-sidebar`
- **Admin CSS:** `public/assets/css/admin.css`
- **Frontend layout:** `@extends('layouts.app')` — has `@stack('scripts')` before `</body>`
- **Frontend CSS:** `public/assets/css/style.css`
- **Product card partial:** `@include('partials.product-card', ['product' => $product])` — uses `$product->main_image`
- **Sidebar partial:** `@include('partials.sidebar')` — requires `$categories` + `$brands` from controller
- **Pagination:** always `LengthAwarePaginator` + `->withQueryString()` — plain `collect()` has no `hasPages()`
- **JS in views:** use `@push('scripts') ... @endpush` — the layout has `@stack('scripts')`

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
// Image source: https://picsum.photos/seed/{slug}/800/800
```

### Brand SVG logo generation (no image library needed):
```php
private function generateSvgLogo(string $slug, string $text, string $bg): string
{
    $path = "brands/{$slug}.svg";
    $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 240 120\">
        <rect width=\"240\" height=\"120\" rx=\"12\" fill=\"{$bg}\"/>
        <text x=\"120\" y=\"68\" font-family=\"Georgia\" font-size=\"28\" font-weight=\"bold\"
              fill=\"#fff\" text-anchor=\"middle\">{$text}</text></svg>";
    file_put_contents(storage_path("app/public/{$path}"), $svg);
    return $path;
}
```

### Converting storage paths to public URLs in views:
```blade
{{-- Single image --}}
src="{{ Storage::disk('public')->url($path) }}"

{{-- All images loop (use all_image_urls accessor) --}}
@foreach($product->all_image_urls as $url)
    <img src="{{ $url }}">
@endforeach
```

## Setup on a New PC
```powershell
git clone https://github.com/muhammadikramzafar/bharkabeauty.git
cd bharkabeauty
composer install
cp .env.example .env
# In phpMyAdmin / MySQL Workbench: create database named "bharka"
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```
Images are committed to git so `storage:link` is all that's needed — no re-download.
