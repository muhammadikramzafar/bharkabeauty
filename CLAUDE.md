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
- **MySQL location:** `C:\xampp3\mysql\bin\mysqld.exe` — NOT a Windows service. Start via XAMPP Control Panel at `C:\xampp3\xampp-control.exe`
- **Seeded data:** 69 products, 35 categories (7 root + 28 sub), 14 brands, 4 coupons
- **To reset and reseed:**
  ```powershell
  php artisan migrate:fresh --seed
  php artisan db:seed --class=CouponSeeder
  ```
- **Migration FK note:** `cms_pages` must run before `menu_items` (FK dependency). Filenames encode this: `093317_5_create_cms_pages`, `093317_create_menus`, `093319_create_menu_items`. Do NOT renumber without checking deps.

## Critical: PowerShell Gotchas
- **Never use** `Set-Content -Encoding utf8` for PHP files — adds UTF-8 BOM → `PHP Fatal error: Namespace declaration...`
- **Always write PHP files** via the Write tool (Claude Code). Strip BOM manually if needed:
  ```powershell
  $bytes = [System.IO.File]::ReadAllBytes($path)
  if ($bytes[0] -eq 0xEF -and $bytes[1] -eq 0xBB -and $bytes[2] -eq 0xBF) {
      [System.IO.File]::WriteAllBytes($path, $bytes[3..($bytes.Length-1)])
  }
  ```
- **No `&&` operator** in PowerShell 5.1 — use `;` or `if ($?) { ... }`
- **No `head` command** — use `| Select-Object -First N`
- **No `--compact` flag** on `php artisan route:list`
- **Multi-line git commit** — use PowerShell here-string: `$msg = @'...'@; git commit -m $msg`

## Storage & Images
- Public disk: `storage/app/public/` → symlinked to `public/storage/`
- Run `php artisan storage:link` once after fresh clone
- Images in: `storage/app/public/categories/`, `brands/`, `products/`
- **Images committed to git** — 35 category JPGs, 14 brand SVGs, 69 product JPGs
- GD extension NOT available — use cURL for downloads, PHP SVG strings for logos

## URL Structure (SEO-friendly)

```
/                             → HomeController@index
/shop                         → CategoryController@index  (all products)
/shop/{cat}                   → CategoryController@index  (e.g. /shop/skincare)
/product/{slug}               → ProductController@show
/brands                       → BrandController@index
/blog / /blog/{slug}          → BlogPageController
/services / /services/{slug}  → ServicePageController
/cart                         → CartController@index
/wishlist                     → WishlistController@index
/checkout                     → CheckoutController (guest + auth, 3-step)
/order/success/{orderNumber}  → CheckoutController@success (guest: session-validated; auth: user_id match)
/customer/login               → OtpController@showLogin
/customer/register            → OtpController@showRegister
/customer/otp/verify          → OtpController@showVerify
/my-account                   → CustomerProfileController@dashboard (auth)
/my-account/orders            → CustomerProfileController@orders (auth)
/my-account/orders/{number}   → CustomerProfileController@orderDetail (auth)
/my-account/settings          → CustomerProfileController@settings (auth)
/admin                        → Admin panel (auth + role guarded)
```

Filter params stay as query strings — never path segments:
`/shop/skincare?brand[]=neutrogena&category[]=moisturizers&price[]=1000-2999&sort=price-asc`

**Route generation:**
```php
route('category.index')                         // /shop
route('category.index', ['cat' => 'skincare'])  // /shop/skincare
route('customer.dashboard')                     // /my-account
route('customer.orders')                        // /my-account/orders
route('order.success', $order->order_number)    // /order/success/BB-XXXXXX
```

**Active nav detection** (cat is a route param, not query string):
```blade
{{ request()->route('cat') == 'skincare' ? 'active' : '' }}
```

## Key Models & Accessors

```
Product    → main_image       string  — full public URL, never null (Unsplash fallback)
           → first_image_url  ?string — first image URL or null
           → all_image_urls   array   — all image full URLs (for gallery loops)
           → images           array   — raw relative storage paths (cast: array)
           → scopeActive(), scopeFeatured()
           → slug is the route key (getRouteKeyName() → 'slug')

Category   → image_url        ?string — Storage URL or null
           → parent() / children() / products()
           → scopeActive()

Brand      → logo_url         ?string — Storage URL or null
           → scopeActive(), scopeFeatured()
           → products() hasMany

User       → orders() hasMany Order
           → phone  (nullable string)
           → Spatie HasRoles trait
           → Fillable: name, email, phone, password

Order      → items() hasMany OrderItem
           → user() belongsTo User
           → shipping_address (cast: array) — stores first_name, phone, email, address, city, postal_code
           → order_number auto-generated: BB-XXXXXX
           → status: pending|confirmed|processing|shipped|delivered|cancelled|refunded
           → payment_method: cod|jazzcash|easypaisa
           → discount  — coupon discount amount saved on order
           → scopeByStatus(string $status)

OrderItem  → order() / product()
           → product_name (snapshot, product may be deleted)

OtpToken   → email, token (6 digits), expires_at, used_at
           → isValid(): bool — checks used_at is null AND expires_at is future

Coupon     → code (unique), type (percent|fixed), value, min_order, max_uses, used_count, expires_at, active
           → isValid(float $subtotal): bool — checks active, not expired, not exhausted, meets min_order
           → discountAmount(float $subtotal): float — percent: round(subtotal * value/100); fixed: min(value, subtotal)
```

## Authentication — Two Separate Flows

### Admin / Staff Login (`/login`)
- Standard Breeze email + password
- Required for accessing `/admin`

### Customer OTP Login (`/customer/login`)
- **Register:** name + mobile (Pakistani format `03XX`) + email → same 6-digit OTP fires to both email AND SMS
- **Login:** enter mobile OR email → system looks up account → OTP to both channels
- **Verify:** 6 individual digit boxes, auto-submits on 6th digit, paste-from-SMS works
- OTP valid for 10 minutes, single-use
- Header icon links to `/customer/login` for guests, `/my-account` for logged-in users

### SMS Gateway (`app/Services/SmsService.php`)
Currently logs OTP to `storage/logs/laravel.log` (search `[SMS]`). To enable real SMS:
```php
// In SmsService::send() swap the commented block with your provider:
// Twilio, MSG91, Zong Business, Telenor Business, etc.
```
`.env` variables to add when using a real gateway: `TWILIO_SID`, `TWILIO_TOKEN`, `TWILIO_FROM`

## Checkout Flow (3 steps, guest + auth)

No login required. Works for both guests and logged-in customers.

```
Step 1 /checkout          → Address: name, mobile, email, street, city, postal code
Step 2 POST checkout/address → saved to session['checkout_address']
Step 3 /checkout (step 2) → Delivery method (standard free >PKR2000, express PKR300, same-day PKR500)
Step 4 /checkout (step 3) → Payment: COD | JazzCash | EasyPaisa  (card removed)
Step 5 POST checkout/place-order → creates Order + OrderItems in DB, sends 2 emails, clears cart
       → redirect to /order/success/{orderNumber}
```

**`checkout_address` session keys:** `first_name`, `phone`, `email`, `address`, `city`, `postal_code`

**Delivery fee logic:** subtotal ≥ PKR 2,000 → free; otherwise PKR 150 (standard).

**Coupon discount** is read from `session('coupon')` in `cartData()` and applied before delivery:
`total = subtotal − couponDiscount + delivery`

**Phone validation regex** (Pakistani numbers only): `/^(03[0-9]{9}|\+923[0-9]{9})$/`

**Inline field errors** in step 1: each input gets `class="form-input{{ $errors->has('field') ? ' is-invalid' : '' }}"` and `@error('field')<p class="field-error">{{ $message }}</p>@enderror` below it.

**On order placement** (`CheckoutController::placeOrder`):
1. Validates `payment_method` in `cod|jazzcash|easypaisa`
2. Creates `Order` record — `user_id` is `Auth::id()` (null for guests), `discount` = `$couponDiscount`
3. Creates `OrderItem` for each cart item (price snapshot)
4. Sends `OrderConfirmationMail($order, false)` to `$address['email']` (from form, not `Auth::user()`)
5. Sends `OrderConfirmationMail($order, true)` to `config('mail.admin_email')` (default: superadmin@bharkabeauty.com)
6. Stores `last_order_number` in session (lets guests view their success page)
7. Clears `cart`, `checkout_address`, `checkout_delivery`, `coupon` from session

**Success page access:**
- Logged-in: validated by `user_id` match (or `last_order_number` session for just-placed orders)
- Guest: validated by `session('last_order_number') === $orderNumber` — 403 otherwise

**`order-success.blade.php` email display:**
```blade
{{ $order->shipping_address['email'] ?? auth()->user()?->email ?? '' }}
```
Never use `auth()->user()->email` directly — crashes for guests.

## Customer Profile (`/my-account`)

| Route | View | What it shows |
|---|---|---|
| `customer.dashboard` | `profile/dashboard` | Welcome banner, 3 stats (orders/spent/delivered), last 5 orders |
| `customer.orders` | `profile/orders` | Paginated order list with delivery progress bar per order |
| `customer.orders.detail` | `profile/order-detail` | Full order: items + images, totals, address, payment, status tracker |
| `customer.settings` | `profile/settings` | Edit name + phone; email is read-only |

**Sidebar partial:** `@include('profile._sidebar')` — shows avatar initial, name, email, nav links, sign out. Highlights active route via `Route::currentRouteName()`.

**Delivery status tracker steps:** `pending → confirmed → processing → shipped → delivered`

## Email System

| Mailable | View | Trigger |
|---|---|---|
| `OtpMail($token)` | `emails/otp` | OTP login/register |
| `OrderConfirmationMail($order, false)` | `emails/order-customer` | Customer after placing order |
| `OrderConfirmationMail($order, true)` | `emails/order-admin` | Admin after any order |

**Mail config (`config/mail.php`):** Added `'admin_email' => env('MAIL_ADMIN_EMAIL', 'superadmin@bharkabeauty.com')`

**Current driver:** `MAIL_MAILER=log` → emails go to `storage/logs/laravel.log`. To send real email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bharkabeauty.com
MAIL_ADMIN_EMAIL=superadmin@bharkabeauty.com
```

## Frontend Controllers (all fully implemented)

| Controller | Method | What it does |
|---|---|---|
| `HomeController` | `index()` | Passes `$featuredProducts`, `$newArrivals`, `$saleProducts`, `$rootCategories`, `$featuredBrands` |
| `CategoryController` | `index(Request, ?string $cat)` | Full filter/sort: brand[], category[], price[], availability[], sort |
| `ProductController` | `show(string $slug)` | Loads product + related products (same cat/brand) |
| `BrandController` | `index()` | All active brands with product counts |
| `CartController` | `index/add/update/remove/applyCoupon/removeCoupon` | Cart in session; `add()` fetches from DB; coupon validated against `coupons` table |
| `WishlistController` | `toggle()/index()/remove()` | Session wishlist; `toggle()` returns JSON (AJAX); `index()` = `/wishlist` page |
| `CheckoutController` | `index/storeAddress/storeDelivery/placeOrder/success` | 3-step checkout + coupon discount + order save + emails |
| `OtpController` | `showLogin/showRegister/register/sendOtp/showVerify/verify/resend` | Passwordless OTP auth |
| `CustomerProfileController` | `dashboard/orders/orderDetail/settings/updateSettings` | Customer account pages |

**Sidebar partial** (`partials/sidebar.blade.php`):
- Wrapped in `<form method="GET">` auto-submitting on checkbox change
- Action preserves cat path: `route('category.index', ['cat' => request()->route('cat')])`
- Submit button in `<div style="padding:1.5rem 0 .5rem;border-top:...">` — NOT bare in form
- CSS fix: `.filter-group:last-of-type` not `:last-child` (button is actual last child of form)
- Checkboxes use custom CSS (`appearance:none`, accent fill + white tick `::after` on `:checked`)
- Count shown as pill badge (`.filter-count` now has `background:var(--color-bg-alt);border-radius:20px`)

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
- **Profile sidebar:** `@include('profile._sidebar')` — no extra vars needed (reads `auth()->user()` directly)
- **Breadcrumb:** `<div class="breadcrumb-bar"><div class="container"><nav class="breadcrumb"><ol><li>...</li></ol></nav></div></div>` — uses `li + li::before` chevron CSS
- **Pagination:** always `LengthAwarePaginator` + `->withQueryString()` — plain `collect()` has no `hasPages()`
- **JS in views:** use `@push('scripts') ... @endpush` — layout has `@stack('scripts')`

## CSS Key Classes (style.css)

| Class | Purpose |
|---|---|
| `.breadcrumb-bar` | Full-width strip, `background: var(--color-bg-alt)`, `border-bottom` |
| `.breadcrumb ol` | Flex row; `li + li::before` injects chevron separator |
| `.checkout-layout` | `grid-template-columns: 1fr 400px` — left form + right order summary |
| `.checkout-steps` | Flex progress bar; `.step-num` for circle, `.checkout-step.active/.done` |
| `.checkout-section-title` | Section headings inside checkout |
| `.form-grid` | `grid-template-columns: 1fr 1fr` two-col form row |
| `.form-input` | Styled text/email/tel input (height 44px, accent border on focus) |
| `.form-input.is-invalid` | Red border + `#fff5f5` background — used with `@error` in checkout |
| `.field-error` | Red error text under invalid field (`color:#dc2626;font-size:.78rem`) |
| `.payment-methods` | Flex column of `.payment-option` cards |
| `.filter-group:last-of-type` | Removes border-bottom from last filter group (NOT `:last-child`) |
| `.filters-sidebar` | Sticky sidebar; hidden on mobile |
| `.filter-checkbox input[type="checkbox"]` | Custom checkbox: `appearance:none`, accent fill + white tick on `:checked` |
| `.filter-count` | Pill badge showing product count per filter item |
| `.cart-layout` | `grid-template-columns: 1fr 380px` |
| `.cart-item` | Grid: image + details + price/remove |
| `.category-hero--has-image` | Hero with `background-image` + `background-size:cover` |
| `.category-hero__overlay` | Gradient overlay for text legibility over category image |

## Seeder Pattern
```php
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=CouponSeeder   // run after migrate; safe to re-run (updateOrCreate)

// DatabaseSeeder call order:
RolesAndPermissionsSeeder → CategorySeeder → BrandSeeder → ProductSeeder
// CouponSeeder is standalone — run separately after migrate
```

**Seeded coupon codes:**
| Code | Type | Value | Min Order |
|---|---|---|---|
| `BHARKA10` | percent | 10% | none |
| `BEAUTY20` | percent | 20% | PKR 2,000 |
| `WELCOME150` | fixed | PKR 150 | PKR 1,000 |
| `SAVE500` | fixed | PKR 500 | PKR 3,000 |

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

### Brand SVG logo generation:
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
src="{{ Storage::disk('public')->url($path) }}"

@foreach($product->all_image_urls as $url)
    <img src="{{ $url }}">
@endforeach
```

### OTP dispatch pattern:
```php
// Generate, save, send to email + SMS, store email in session
$token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
OtpToken::create(['email' => $email, 'token' => $token, 'expires_at' => now()->addMinutes(10)]);
Mail::to($email)->send(new OtpMail($token));
SmsService::send($phone, "Your code: {$token}");
session(['otp_email' => $email, 'otp_phone' => $phone]);
```

### Session key reference

| Key | Set by | Cleared by | Contents |
|---|---|---|---|
| `cart` | `CartController::add()` | `placeOrder()` | `[id => {id,name,slug,brand,price,original_price,quantity,image}]` |
| `wishlist` | `WishlistController::toggle()` | user removes or clears | `[product_id => {id,name,slug,price,image,brand}]` |
| `coupon` | `CartController::applyCoupon()` | `placeOrder()` or `removeCoupon()` | `{code, type, value, discount}` |
| `checkout_address` | `CheckoutController::storeAddress()` | `placeOrder()` | `{first_name,phone,email,address,city,postal_code}` |
| `checkout_delivery` | `CheckoutController::storeDelivery()` | `placeOrder()` | `standard\|express\|same_day` |
| `last_order_number` | `placeOrder()` | never (expires with session) | `BB-XXXXXX` — gates guest access to success page |
| `otp_email` / `otp_phone` | `OtpController::sendOtp()` | after verify | stored for OTP verify screen |

### Wishlist AJAX pattern (frontend JS):
```js
fetch('/wishlist/toggle', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
  body: JSON.stringify({ product_id: id }),
})
.then(r => r.json())
.then(data => {
  // data.in_wishlist (bool), data.count (int), data.message (string)
});
```
Buttons need `data-wishlist-btn` + `data-product="{{ $product->id }}"` + `data-active="{{ inWishlist ? 'true' : 'false' }}"`.

### Coupon apply pattern:
```php
$coupon = Coupon::where('code', $code)->first();
if (!$coupon || !$coupon->isValid($subtotal)) { return back()->with('error', '...'); }
$discount = $coupon->discountAmount($subtotal);
session(['coupon' => ['code' => $coupon->code, 'type' => $coupon->type, 'value' => $coupon->value, 'discount' => $discount]]);
```

### Order creation pattern:
```php
$order = Order::create([...]);
foreach ($cartItems as $item) {
    $order->items()->create(['product_name' => $item['name'], 'price' => $item['price'], 'qty' => $item['quantity'], 'total' => $item['price'] * $item['quantity']]);
}
$order->load('items', 'user');
Mail::to($userEmail)->send(new OrderConfirmationMail($order, false));  // customer
Mail::to(config('mail.admin_email'))->send(new OrderConfirmationMail($order, true));  // admin
session()->forget(['cart', 'checkout_address', 'checkout_delivery', 'coupon']);
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
