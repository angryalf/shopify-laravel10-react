<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopifyWebhooks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = file_get_contents('php://input');
        $hmacHeader = $request->header('x-shopify-hmac-sha256');

        if (! verify_webhook($data, $hmacHeader, env('SHOPIFY_API_SECRET'))) {
            return response()->json(
                'Unauthorized',
                401
            );
        }
        $store = $request->header('x-shopify-shop-domain');

        if (! empty($store)) {
            $shop = Session::where('name', $store)->first();

            if ($shop) {
                $request->merge(['merchant' => $shop]);
            }
        }

        return $next($request);
    }
}
