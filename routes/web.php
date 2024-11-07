<?php

use App\Http\Controllers\ShortUrlRedirect\ShortUrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return abort(500, 'private route');
});

Route::get('/{code}', [ShortUrlRedirectController::class, 'redirect']);
