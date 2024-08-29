<?php

namespace App\Http\Controllers;

//use App\Services\Shopify\ShopifyService;
use Shopify\Utils;

class AuthRedirectController extends Controller
{
    public function index()
    {
        //        \Log::debug("AuthRedirectController ExitIframe");

        $hmac = Utils::validateHmac(
            request()->only('embedded', 'hmac', 'host', 'id_token', 'locale', 'session', 'shop', 'timestamp'),
            config('shopify.api_secret')
        );
        if (! $hmac) {
            \Log::debug('Wrong hmac');
            abort(404);
        }

        $url_parts = parse_url(urldecode(\request()->get('redirectUri')));

        $url_parts['query'] = http_build_query(['shop' => \request()->get('shop')]);
        $redirectUrl = $url_parts['scheme'].'://'.$url_parts['host'].$url_parts['path'].'?'.$url_parts['query'];

        return view(
            'redirect',
            [
                'apiKey' => config('shopify.api_key'),
                'appBridgeVersion' => 'latest',
                'authUrl' => $redirectUrl,
                'host' => \request()->get('host'),
                'shopDomain' => \request()->get('shop'),
            ]
        );

    }
}
