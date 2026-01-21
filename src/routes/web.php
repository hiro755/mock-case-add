<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\ChatController;

Auth::routes(['verify' => true]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/item/{id}', [ProductController::class, 'show'])->name('item.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.all');

Route::middleware('auth')->group(function () {

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/mylist', [ProductController::class, 'myList'])->name('mylist');

    Route::post('/products/{id}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/mypage', [ProductController::class, 'myProducts'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->name('purchase.address');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

    Route::get('/payment/card/{item_id}', [PaymentController::class, 'showCardForm'])->name('payment.card.show');
    Route::post('/payment/card', [PaymentController::class, 'card'])->name('payment.card');
    Route::get('/payment/card/complete/{item_id}', function ($item_id) {
        $product = \App\Models\Product::findOrFail($item_id);
        return view('payments.card-complete', compact('product'));
    })->name('payment.card.complete');

    Route::get('/payment/convenience/confirm/{item_id}', [PaymentController::class, 'showConvenienceConfirm'])->name('payment.convenience.confirm');
    Route::post('/payment/convenience', [PaymentController::class, 'convenience'])->name('payment.convenience');
    Route::get('/payment/convenience/complete/{item_id}', function ($item_id) {
        $product = \App\Models\Product::findOrFail($item_id);
        return view('payments.convenience-complete', compact('product'));
    })->name('payment.convenience.complete');

    Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address/update/{id}', [AddressController::class, 'update'])->name('address.update');

    Route::get('/chat/{product}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{product}', [ChatController::class, 'store'])->name('chat.store');
    Route::match(['get', 'post'], '/chat/{product}/complete', [ChatController::class, 'complete'])->name('chat.complete');
    Route::post('/chat/{product}/rate', [ChatController::class, 'rate'])->name('chat.rate');

    Route::get('/chat/{product}/edit/{message}', [ChatController::class, 'edit'])->name('chat.edit');
    Route::put('/chat/{product}/update/{message}', [ChatController::class, 'update'])->name('chat.update');
    Route::delete('/chat/{product}/destroy/{message}', [ChatController::class, 'destroy'])->name('chat.destroy');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/profile/setup');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/setup', [ProfileSetupController::class, 'edit'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'update'])->name('profile.setup.submit');
});