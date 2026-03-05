<?php

use App\Http\Controllers\Backend\FeatureController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home.index');
});

// Dashboard Route
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin Authentication Routes
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/verify', [AdminController::class, 'showVerification'])->name('custom.verification.form');
Route::post('/verify', [AdminController::class, 'verificationVerify'])->name('custom.verification.verify');
Route::get('/verify/resend', [AdminController::class, 'resendVerificationCode'])->name('custom.verification.resend');

// Admin Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'profileStore'])->name('profile.store');
    Route::post('/profile/update/password', [AdminController::class, 'updatePassword'])->name('admin.update.password');
});

// Management Routes of admin
Route::middleware('auth')->group(function () {
    // Review Management Routes
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/all/reviews', 'AllReview')->name('all.review');
        Route::get('/add/review', 'AddReview')->name('add.review');
        Route::post('/store/review', 'StoreReview')->name('store.review');
        Route::get('/edit/review/{id}', 'EditReview')->name('edit.review');
        Route::post('/update/review', 'UpdateReview')->name('update.review');
        Route::get('/delete/review/{id}', 'DeleteReview')->name('delete.review');
    });

    // Slider Management Routes
    Route::controller(SliderController::class)->group(function () {
        Route::get('/get/sliders', 'GetSliders')->name('get.slider');
        Route::get('/add/slider', 'AddSlider')->name('add.slider');
        Route::post('/store/slider', 'StoreSlider')->name('store.slider');
        Route::get('/edit/slider/{id}', 'EditSlider')->name('edit.slider');
        Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
        Route::get('/delete/slider/{id}', 'DeleteSlider')->name('delete.slider');
        Route::post('/edit-slider/{id}', 'EditSliderWithTitleAndDescription');
        Route::post('/edit-features/{id}', 'EditFeatures');
        Route::post('/edit-reviews/{id}', 'EditReviews');
        Route::post('/edit-answers/{id}', 'EditAnswers');
    });

    // Feature Management Routes
    Route::controller(FeatureController::class)->group(function () {
        Route::get('/all/features', 'AllFeature')->name('all.feature');
        Route::get('/add/feature', 'AddFeature')->name('add.feature');
        Route::post('/store/feature', 'StoreFeature')->name('store.feature');
        Route::get('/edit/feature/{id}', 'EditFeature')->name('edit.feature');
        Route::post('/update/feature', 'UpdateFeature')->name('update.feature');
        Route::get('/delete/feature/{id}', 'DeleteFeature')->name('delete.feature');
    });
});