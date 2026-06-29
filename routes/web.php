<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\Homepage\HomepageController;
use App\Http\Controllers\Admin\Homepage\HeroSlideController;
use App\Http\Controllers\Admin\Homepage\HomepageBannerController;
use App\Http\Controllers\Admin\Homepage\HomepageServiceController;
use App\Http\Controllers\Admin\Homepage\HomepageCounterController;
use App\Http\Controllers\Admin\Homepage\HomepageTestimonialController;
use App\Http\Controllers\Admin\Homepage\HomepageFeaturedController;
use App\Http\Controllers\Admin\Homepage\HomepageLogoController;
use App\Http\Controllers\Admin\Homepage\HomepageCtaController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\BlogPageController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogTagController as AdminBlogTagController;
use App\Http\Controllers\Admin\Blog\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\Admin\GlobalSeoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

// ─── FRONTEND ROUTES ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop — SEO-friendly: /shop, /shop/skincare, /shop/makeup ...
Route::get('/shop/{cat?}', [CategoryController::class, 'index'])->name('category.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands');

// Cart (guest accessible)
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Wishlist (session-based, guest accessible)
Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [\App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');

// Checkout (guest + auth)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address');
Route::post('/checkout/delivery', [CheckoutController::class, 'storeDelivery'])->name('checkout.delivery');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/store-locator', [PageController::class, 'storeLocator'])->name('store-locator');

// Services (public)
Route::get('/services',        [ServicePageController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');

// Blog (public) — static segments must precede dynamic {slug}
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',                [BlogPageController::class, 'index'])->name('index');
    Route::get('/category/{slug}',[BlogPageController::class, 'category'])->name('category');
    Route::get('/tag/{slug}',     [BlogPageController::class, 'tag'])->name('tag');
    Route::get('/{slug}',         [BlogPageController::class, 'show'])->name('show');
});

// CMS Pages (public — must be last to avoid conflicts)
Route::get('/page/{slug}', [PageController::class, 'cmsPage'])->name('cms.page');

// SEO: sitemap + robots
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt',  [SeoController::class, 'robots'])->name('robots');

// Newsletter (public)
Route::post('/newsletter/subscribe',          [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// ─── AUTH ROUTES (Breeze — kept for admin password login) ────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ─── CUSTOMER OTP AUTH ────────────────────────────────────────
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CustomerProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/customer/login',    [OtpController::class, 'showLogin'])->name('customer.login');
    Route::get('/customer/register', [OtpController::class, 'showRegister'])->name('customer.register');
    Route::post('/customer/register',[OtpController::class, 'register'])->name('customer.register.submit');
    Route::post('/customer/otp/send',[OtpController::class, 'sendOtp'])->name('otp.send');
    Route::get('/customer/otp/verify',[OtpController::class,'showVerify'])->name('otp.verify');
    Route::post('/customer/otp/verify',[OtpController::class,'verify'])->name('otp.verify.submit');
});
Route::post('/customer/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');

// ─── CUSTOMER PROFILE (auth required) ────────────────────────
Route::middleware('auth')->prefix('my-account')->name('customer.')->group(function () {
    Route::get('/',                          [CustomerProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders',                    [CustomerProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}',      [CustomerProfileController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/settings',                  [CustomerProfileController::class, 'settings'])->name('settings');
    Route::patch('/settings',                [CustomerProfileController::class, 'updateSettings'])->name('settings.update');
});

// ─── ADMIN ROUTES ─────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // ── Site Settings ────────────────────────────────────
        Route::get('/settings',  [SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings',  [SiteSettingController::class, 'update'])->name('settings.update');

        // ── Menu Builder ─────────────────────────────────────
        Route::resource('menus', MenuController::class)->except(['show']);
        Route::post('/menu-items',           [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
        Route::post('/menu-items/reorder',   [MenuItemController::class, 'reorder'])->name('menu-items.reorder');

        // ── CMS Pages ────────────────────────────────────────
        Route::resource('pages', CmsPageController::class);

        // ── Media Library ────────────────────────────────────
        Route::resource('media', MediaController::class)->parameters(['media' => 'medium']);

        // ── Catalog ──────────────────────────────────────────
        Route::resource('products',   AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('brands',     AdminBrandController::class);

        // ── Orders ───────────────────────────────────────────
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // ── Customers ────────────────────────────────────────
        Route::get('/customers',      [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('customers.show');

        // ── Users & Roles ────────────────────────────────────
        Route::resource('users', AdminUserController::class);

        // ── Blog Module ───────────────────────────────────────
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::resource('posts',      AdminBlogPostController::class);
            Route::resource('categories', AdminBlogCategoryController::class)->except(['show']);
            Route::resource('tags',       AdminBlogTagController::class)->except(['show']);
        });

        // ── Services Module ───────────────────────────────────
        Route::resource('service-categories', AdminServiceCategoryController::class)->except(['show']);
        Route::resource('services',           AdminServiceController::class)->except(['show']);

        // ── Inquiries ────────────────────────────────────────
        Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'update', 'destroy']);

        // ── Newsletter ───────────────────────────────────────
        Route::get('/newsletter',         [NewsletterAdminController::class, 'index'])->name('newsletter.index');
        Route::get('/newsletter/export',  [NewsletterAdminController::class, 'export'])->name('newsletter.export');
        Route::delete('/newsletter/{subscriber}', [NewsletterAdminController::class, 'destroy'])->name('newsletter.destroy');

        // ── Global SEO ───────────────────────────────────────
        Route::get('/seo',  [GlobalSeoController::class, 'index'])->name('seo.index');
        Route::put('/seo',  [GlobalSeoController::class, 'update'])->name('seo.update');

        // ── Homepage Management ───────────────────────────────
        Route::prefix('homepage')->name('homepage.')->group(function () {
            Route::get('/',        [HomepageController::class, 'index'])->name('index');
            Route::get('/settings',[HomepageController::class, 'settings'])->name('settings');
            Route::put('/settings',[HomepageController::class, 'updateSettings'])->name('settings.update');

            Route::resource('hero',         HeroSlideController::class)->except(['show']);
            Route::post('hero/reorder',     [HeroSlideController::class, 'reorder'])->name('hero.reorder');

            Route::resource('banners',      HomepageBannerController::class)->except(['show']);
            Route::resource('services',     HomepageServiceController::class)->except(['show']);
            Route::resource('counters',     HomepageCounterController::class)->except(['show']);
            Route::resource('testimonials', HomepageTestimonialController::class)->except(['show']);
            Route::resource('featured',     HomepageFeaturedController::class)->except(['show']);
            Route::resource('logos',        HomepageLogoController::class)->except(['show']);
            Route::resource('cta',          HomepageCtaController::class)->except(['show']);
        });
    });
