<?php

namespace App\Http\Controllers\ShortUrlRedirect;

use App\Http\Controllers\Controller;
use App\Models\ShortUrlRedirect;
use Illuminate\Http\Request;

class ShortUrlRedirectController extends Controller
{
    public function redirect($code)
    {
        $url = ShortUrlRedirect::where('code', $code)->with('film')->first();

        if (!$url || $url->status != 'active') {
            return abort(404);
        }

        // Deteksi apakah crawler
        $isCrawler = preg_match('/facebookexternalhit|Twitterbot|WhatsApp|Slackbot/', request()->userAgent());

        if ($isCrawler) {
            return view('redirect', compact('url'));
        }

        // Jika bukan crawler, increment hits dan redirect
        $url->increment('hits');
        return redirect($url->url);
    }
}
