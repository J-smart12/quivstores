<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// =================> SiteController <==============
// General open page 
// Index
Route::get('/', [SiteController::class, 'index'])->name('index');
// Search
Route::post('/search', [SiteController::class, 'searchpost'])->name('searchpost');
// Contact us
Route::get('/contact-us', [SiteController::class, 'contactus'])->name('contactus');
// About us
Route::get('/about-us', [SiteController::class, 'aboutus'])->name('aboutus');
// Login
Route::get('/login', [SiteController::class, 'login'])->name('login');
// Register
Route::get('/register', [SiteController::class, 'register'])->name('register');
// Forgot Password
Route::get('/forgot-password', [SiteController::class, 'forgotPassword'])->name('forgot-password');
// Reset Password
Route::get('/reset-password', [SiteController::class, 'resetPassword'])->name('reset-password');
// News
Route::get('/news', [SiteController::class, 'news'])->name('news');
// News Details
Route::get('/news-details', [SiteController::class, 'newsDetails'])->name('news-details');
// Shop / Products
Route::get('/shop', [SiteController::class, 'shop'])->name('shop');
// Shop / Product details
Route::get('/product-details', [SiteController::class, 'productDetails'])->name('product-details');

// ===================> UserController <=============================
// User Authenticated
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    // My cart (add, remove, edit)
    Route::get('/cart', [UserController::class, 'cart'])->name('cart'); // view cart
    Route::post('/add-to-cart', [UserController::class, 'addToCart'])->name('add-to-cart'); // add to cart
    Route::post('/remove-from-cart', [UserController::class, 'removeFromCart'])->name('remove-from-cart'); // remove from cart
    Route::post('/update-cart', [UserController::class, 'updateCart'])->name('update-cart'); // update cart
    // My wishlist
    // Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');
    // Message Admin
    Route::get('/message', [UserController::class, 'message'])->name('message'); // view messages
    Route::post('/send-message', [UserController::class, 'sendMessage'])->name('send-message'); // send message
    // Update information (User details, Address)
    Route::get('/update-information', [UserController::class, 'updateInformation'])->name('update-information');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

// ===================> AdminController <=======================
// Authenticated
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Show / Create / Delete / Edit new product
        Route::get('/product', [AdminController::class, 'product'])->name('product'); // view products
        Route::post('/create-product', [AdminController::class, 'createProduct'])->name('create-product'); // create product
        Route::post('/update-product', [AdminController::class, 'updateProduct'])->name('update-product'); // update product
        Route::post('/delete-product', [AdminController::class, 'deleteProduct'])->name('delete-product'); // delete product
        // Show / Edit / upload logo, email etc... Site details
        Route::get('/site-details', [AdminController::class, 'siteDetails'])->name('site-details'); // view site details
        Route::post('/update-site-details', [AdminController::class, 'updateSiteDetails'])->name('update-site-details'); // update site details
        // View / Reply Client Messages
        Route::get('/client-message', [AdminController::class, 'clientMessage'])->name('client-message'); // view client messages
        Route::post('/reply-message', [AdminController::class, 'replyMessage'])->name('reply-message'); // reply to client message
        // Show / Create / Delete / Edit news
        Route::get('/news', [AdminController::class, 'news'])->name('news'); // view news
        Route::post('/create-news', [AdminController::class, 'createNews'])->name('create-news'); // create news
        Route::post('/update-news', [AdminController::class, 'updateNews'])->name('update-news'); // update news
        Route::post('/delete-news', [AdminController::class, 'deleteNews'])->name('delete-news'); // delete news
        // Optional add / remove site banners
        // Route::get('/banner', [AdminController::class, 'banner'])->name('banner'); // view banners
        // Route::post('/create-banner', [AdminController::class, 'createBanner'])->name('create-banner'); // create banner
        // Route::post('/update-banner', [AdminController::class, 'updateBanner'])->name('update-banner'); // update banner
        // Route::post('/delete-banner', [AdminController::class, 'deleteBanner'])->name('delete-banner'); // delete banner
        // View users cart (add, remove, edit)
        Route::get('/user-cart', [AdminController::class, 'userCart'])->name('user-cart'); // view user cart
});
