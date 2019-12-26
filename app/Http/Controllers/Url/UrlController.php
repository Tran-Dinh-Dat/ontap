<?php

namespace App\Http\Controllers\Url;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UrlShort;

class UrlController extends Controller
{
    public function short(Request $request)
    {
        $url = UrlShort::whereUrl($request->url)->first();

        if ($url == null) {
            $short = $this->generateShortUrl();
            UrlShort::create([
                'url' => $request->url,
                'short' => $short
            ]);
            $url = UrlShort::whereUrl($request->url)->first();
        }
        return view('url.short_url')->with('url', $url);
    }

    public function generateShortUrl()
    {
        $result = base_convert(rand(1000, 9999), 10, 36);
        $data = UrlShort::whereShort($result)->first();

        if ($data != null) {
            $this->generateShortUrl();
        }
        return $result;
    }

    public function shortLink($link)
    {
        $url = UrlShort::whereShort($link)->first();
        return redirect($url->url);
    }
}
