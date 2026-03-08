<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\FrontGalleryController;
use App\Http\Controllers\FrontBlogController;

// ── Veřejné stránky ────────────────────────────────────────────
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/galerie', [FrontGalleryController::class, 'index'])->name('gallery.index');
Route::get('/galerie/{id}', [FrontGalleryController::class, 'show'])->name('gallery.show');
Route::post('/galerie/{id}/hodnoceni', [FrontGalleryController::class, 'rate'])->name('gallery.rate');
Route::post('/galerie/{id}/komentar', [FrontGalleryController::class, 'comment'])->name('gallery.comment');
Route::get('/blog', [FrontBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{id}/komentar', [FrontBlogController::class, 'comment'])->name('blog.comment');
Route::get('/kontakt', [PublicController::class, 'contact'])->name('contact');
Route::post('/kontakt', [PublicController::class, 'sendContact'])->name('contact.send');
Route::get('/vip', [PublicController::class, 'vip'])->name('vip');

// ── Autentizace ────────────────────────────────────────────────
Route::get('/prihlaseni', [LoginController::class, 'showLogin'])->name('login');
Route::post('/prihlaseni', [LoginController::class, 'login']);
Route::post('/odhlaseni', [LoginController::class, 'logout'])->name('logout');
Route::get('/registrace', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/registrace', [RegisterController::class, 'register']);

// ── 2FA ────────────────────────────────────────────────────────
Route::get('/2fa/overeni', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('/2fa/overeni', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::get('/2fa/nastaveni', [TwoFactorController::class, 'setup'])->name('2fa.setup');
Route::post('/2fa/aktivovat', [TwoFactorController::class, 'activate'])->name('2fa.activate');
Route::post('/2fa/deaktivovat', [TwoFactorController::class, 'deactivate'])->name('2fa.deactivate');

// ── Stripe ─────────────────────────────────────────────────────
Route::get('/predplatne/pokladna', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/predplatne/uspech', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/predplatne/zruseno', [StripeController::class, 'cancel'])->name('stripe.cancel');
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');

// ── Admin ──────────────────────────────────────────────────────
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Uživatelé
Route::get('/admin/uzivatele', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/uzivatele/{id}', [UserController::class, 'show'])->name('admin.users.show');
Route::get('/admin/uzivatele/{id}/upravit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/uzivatele/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/uzivatele/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
Route::post('/admin/uzivatele/{id}/ban', [UserController::class, 'ban'])->name('admin.users.ban');
Route::post('/admin/uzivatele/{id}/unban', [UserController::class, 'unban'])->name('admin.users.unban');

// Předplatné
Route::get('/admin/predplatne', [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
Route::get('/admin/predplatne/{id}', [SubscriptionController::class, 'show'])->name('admin.subscriptions.show');
Route::post('/admin/predplatne/{id}/zrusit', [SubscriptionController::class, 'cancel'])->name('admin.subscriptions.cancel');
Route::get('/admin/plany', [SubscriptionController::class, 'plans'])->name('admin.plans.index');
Route::get('/admin/plany/vytvorit', [SubscriptionController::class, 'createPlan'])->name('admin.plans.create');
Route::post('/admin/plany', [SubscriptionController::class, 'storePlan'])->name('admin.plans.store');
Route::get('/admin/plany/{id}/upravit', [SubscriptionController::class, 'editPlan'])->name('admin.plans.edit');
Route::put('/admin/plany/{id}', [SubscriptionController::class, 'updatePlan'])->name('admin.plans.update');
Route::delete('/admin/plany/{id}', [SubscriptionController::class, 'destroyPlan'])->name('admin.plans.destroy');

// Galerie
Route::get('/admin/galerie', [GalleryController::class, 'index'])->name('admin.gallery.index');
Route::get('/admin/galerie/ke-schvaleni', [GalleryController::class, 'pending'])->name('admin.gallery.pending');
Route::get('/admin/galerie/vytvorit', [GalleryController::class, 'create'])->name('admin.gallery.create');
Route::post('/admin/galerie', [GalleryController::class, 'store'])->name('admin.gallery.store');
Route::get('/admin/galerie/{id}/upravit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
Route::put('/admin/galerie/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
Route::delete('/admin/galerie/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
Route::post('/admin/galerie/{id}/schvalit', [GalleryController::class, 'approve'])->name('admin.gallery.approve');
Route::post('/admin/galerie/{id}/zamítnout', [GalleryController::class, 'reject'])->name('admin.gallery.reject');

// Blog
Route::get('/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
Route::get('/admin/blog/vytvorit', [BlogController::class, 'create'])->name('admin.blog.create');
Route::post('/admin/blog', [BlogController::class, 'store'])->name('admin.blog.store');
Route::get('/admin/blog/{id}/upravit', [BlogController::class, 'edit'])->name('admin.blog.edit');
Route::put('/admin/blog/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
Route::delete('/admin/blog/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

// Komentáře
Route::get('/admin/komentare', [CommentController::class, 'index'])->name('admin.comments.index');
Route::post('/admin/komentare/{id}/schvalit', [CommentController::class, 'approve'])->name('admin.comments.approve');
Route::delete('/admin/komentare/{id}', [CommentController::class, 'destroy'])->name('admin.comments.destroy');

// Theme Builder
Route::get('/admin/vzhled', [ThemeController::class, 'index'])->name('admin.theme.index');
Route::post('/admin/vzhled', [ThemeController::class, 'update'])->name('admin.theme.update');
Route::post('/admin/vzhled/reset', [ThemeController::class, 'reset'])->name('admin.theme.reset');
Route::post('/admin/vzhled/komponenty', [ThemeController::class, 'updateComponents'])->name('admin.theme.components');
Route::post('/admin/vzhled/exportovat', [ThemeController::class, 'export'])->name('admin.theme.export');
Route::post('/admin/vzhled/importovat', [ThemeController::class, 'import'])->name('admin.theme.import');

// Rozšíření
Route::get('/admin/rozsireni', [ExtensionController::class, 'index'])->name('admin.extensions.index');
Route::post('/admin/rozsireni/{key}/aktivovat', [ExtensionController::class, 'activate'])->name('admin.extensions.activate');
Route::post('/admin/rozsireni/{key}/deaktivovat', [ExtensionController::class, 'deactivate'])->name('admin.extensions.deactivate');
Route::get('/admin/rozsireni/{key}/nastaveni', [ExtensionController::class, 'settings'])->name('admin.extensions.settings');
Route::post('/admin/rozsireni/{key}/nastaveni', [ExtensionController::class, 'saveSettings'])->name('admin.extensions.save');