<?php

use App\Http\Controllers\RedirectUrlClickbait;
use App\Http\Controllers\RedirectUrlController;
use App\Http\Controllers\ShortUrlRedirect\ShortUrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/', function () {
//     return abort(500, 'private route');
// });

Route::get('/r/{code}', [ShortUrlRedirectController::class, 'redirect']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    Route::resource('redirect-ads', RedirectUrlController::class);
    Route::resource('redirect-clickbait', RedirectUrlClickbait::class);
});

require __DIR__ . '/auth.php';
