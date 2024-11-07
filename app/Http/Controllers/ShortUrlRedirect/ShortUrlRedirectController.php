<?php

namespace App\Http\Controllers\ShortUrlRedirect;

use App\Http\Controllers\Controller;
use App\Models\ShortUrlRedirect;
use Illuminate\Http\Request;

class ShortUrlRedirectController extends Controller
{
    public function redirect($code)
    {
        $url = ShortUrlRedirect::where('code', $code)->first();

        if ($url) {
            if ($url->status != 'active'){
                return abort(404);
            }

            $url->increment('hits');
            return redirect($url->url);
        }

        return abort(404);
    }
}
