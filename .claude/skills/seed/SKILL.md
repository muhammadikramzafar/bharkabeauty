---
description: Seed the BharkaBeauty database with categories, brands, products, and admin user
---

# Seed — BharkaBeauty Database Seeding

## Run all seeders (after fresh migration)

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
php artisan migrate:fresh --seed
```

## Run individual seeders

```powershell
$env:PATH = "C:\php83;" + $env:PATH; Set-Location "c:\laravel\bharkabeauty"
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=ProductSeeder
```

## Seeder call order (must follow this)

```
RolesAndPermissionsSeeder   ← creates roles + superadmin user
CategorySeeder              ← 7 root + 28 sub-categories = 35 total
BrandSeeder                 ← 14 brands with SVG logos
ProductSeeder               ← 69 products (10 per root category)
```

## What gets seeded

- **Admin user:** superadmin@bharkabeauty.com / Admin@1234 (role: super-admin)
- **Categories:** Makeup, Skincare, Haircare, Fragrances, Bath & Body, Tools, Offers
- **Brands:** 14 brands including L'Oréal, Neutrogena, Maybelline, etc.
- **Products:** 69 products with Picsum images

## Image handling in seeders

Images are **committed to git** — seeders skip download if file exists (`file_exists()` check). Safe to re-run.

Image sources use `https://picsum.photos/seed/{slug}/800/800` — requires internet on first run.

GD extension NOT available. Use cURL pattern:
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

## After seeding on a new machine

```powershell
php artisan storage:link   # symlinks storage/app/public → public/storage
```
