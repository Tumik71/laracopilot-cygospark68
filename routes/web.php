<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\VipController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StripeController;

// =====================
// VEŘEJNÉ STRÁNKY
// =====================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PublicController::class, 'blogPost'])->name('blog.show');
Route::get('/galerie', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/video-chat', [PublicController::class, 'videoChat'])->name('video.chat');
Route::get('/vip', [PublicController::class, 'vipInfo'])->name('vip.info');
Route::get('/kontakt', [PublicController::class, 'contact'])->name('contact');
Route::post('/kontakt', [PublicController::class, 'sendContact'])->name('contact.send');

// =====================
// VIP / STRIPE
// =====================
Route::get('/vip/prihlaseni', [StripeController::class, 'showLogin'])->name('vip.login');
Route::post('/vip/prihlaseni', [StripeController::class, 'login'])->name('vip.login.post');
Route::post('/vip/odhlaseni', [StripeController::class, 'logout'])->name('vip.logout');
Route::get('/vip/registrace', [StripeController::class, 'showRegister'])->name('vip.register');
Route::post('/vip/registrace', [StripeController::class, 'register'])->name('vip.register.post');
Route::get('/vip/predplatne', [StripeController::class, 'subscribe'])->name('vip.subscribe');
Route::post('/vip/checkout', [StripeController::class, 'checkout'])->name('vip.checkout');
Route::get('/vip/uspech', [StripeController::class, 'success'])->name('vip.success');
Route::get('/vip/zruseni', [StripeController::class, 'cancel'])->name('vip.cancel');
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');
Route::get('/vip/obsah', [StripeController::class, 'vipContent'])->name('vip.content');
Route::get('/vip/video/{id}', [StripeController::class, 'vipVideo'])->name('vip.video');

// =====================
// ADMIN AUTENTIZACE
// =====================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// =====================
// ADMIN DASHBOARD
// =====================
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

// =====================
// ADMIN BLOG
// =====================
Route::get('/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
Route::get('/admin/blog/vytvorit', [BlogController::class, 'create'])->name('admin.blog.create');
Route::post('/admin/blog', [BlogController::class, 'store'])->name('admin.blog.store');
Route::get('/admin/blog/{id}/upravit', [BlogController::class, 'edit'])->name('admin.blog.edit');
Route::put('/admin/blog/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
Route::delete('/admin/blog/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

// =====================
// ADMIN GALERIE
// =====================
Route::get('/admin/galerie', [GalleryController::class, 'index'])->name('admin.gallery.index');
Route::get('/admin/galerie/pridatfoto', [GalleryController::class, 'create'])->name('admin.gallery.create');
Route::post('/admin/galerie', [GalleryController::class, 'store'])->name('admin.gallery.store');
Route::get('/admin/galerie/{id}/upravit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
Route::put('/admin/galerie/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
Route::delete('/admin/galerie/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

// =====================
// ADMIN VIDEO
// =====================
Route::get('/admin/video', [VideoController::class, 'index'])->name('admin.video.index');
Route::get('/admin/video/pridat', [VideoController::class, 'create'])->name('admin.video.create');
Route::post('/admin/video', [VideoController::class, 'store'])->name('admin.video.store');
Route::get('/admin/video/{id}/upravit', [VideoController::class, 'edit'])->name('admin.video.edit');
Route::put('/admin/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
Route::delete('/admin/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');

// =====================
// ADMIN VIP OBSAH
// =====================
Route::get('/admin/vip', [VipController::class, 'index'])->name('admin.vip.index');
Route::get('/admin/vip/pridat', [VipController::class, 'create'])->name('admin.vip.create');
Route::post('/admin/vip', [VipController::class, 'store'])->name('admin.vip.store');
Route::get('/admin/vip/{id}/upravit', [VipController::class, 'edit'])->name('admin.vip.edit');
Route::put('/admin/vip/{id}', [VipController::class, 'update'])->name('admin.vip.update');
Route::delete('/admin/vip/{id}', [VipController::class, 'destroy'])->name('admin.vip.destroy');

// =====================
// ADMIN PŘEDPLATITELÉ
// =====================
Route::get('/admin/predplatitele', [SubscriberController::class, 'index'])->name('admin.subscribers.index');
Route::delete('/admin/predplatitele/{id}', [SubscriberController::class, 'destroy'])->name('admin.subscribers.destroy');