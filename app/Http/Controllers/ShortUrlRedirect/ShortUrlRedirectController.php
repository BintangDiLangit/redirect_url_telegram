<?php

namespace App\Http\Controllers\ShortUrlRedirect;

use App\Http\Controllers\Controller;
use App\Models\RedirectUrl;
use App\Models\ShortUrlRedirect;
use Illuminate\Http\Request;

class ShortUrlRedirectController extends Controller
{
    // public function redirect($code)
    // {
    //     $url = ShortUrlRedirect::where('code', $code)->with('film')->first();

    //     if (!$url || $url->status != 'active') {
    //         return abort(404);
    //     }

    //     // Jika bukan crawler, increment hits dan redirect
    //     $url->increment('hits');
    //     return view('redirect', compact('url'));
    // }
    public function redirect($code)
    {
        $url = RedirectUrl::where('code', $code)->first();

        if (!$url || $url->status != 'active') {
            return abort(404);
        }

        // Jika bukan crawler, increment hits dan redirect
        $url->increment('hits');
        return view('redirect', compact('url'));
    }
}
