<?php

namespace App\Http\Middleware;

use App\Lib\AuthRedirection;
use App\Models\Session;
use Closure;
use Illuminate\Http\Request;
use Shopify\Utils;

class EnsureShopifyInstalled
{
    /**
     * Checks if the shop in the query arguments is currently installed.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $shop = $request->query('shop') ? Utils::sanitizeShopDomain($request->query('shop')) : null;

        $appInstalled = $shop && Session::where('shop', $shop)->where('access_token', '<>', null)->exists();
        $isExitingIframe = preg_match('/^ExitIframe/i', $request->path());

        if (($appInstalled || $isExitingIframe)) {
            return $next($request);
        } else {
            if ($shop) {
                return AuthRedirection::redirect($request);
            } else {
                //TODO: need check if this right redirect or need show 404 ???
                return redirect(route('crm'));
            }
        }

        //        return ($appInstalled || $isExitingIframe) ? $next($request) : AuthRedirection::redirect($request);
    }
}
