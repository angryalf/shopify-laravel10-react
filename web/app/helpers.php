<?php

use Shopify\Utils;

if (! function_exists('verify_webhook')) {
    function verify_webhook($data, $hmac_header, $app_secret_key)
    {
        try {
            $calculated_hmac = base64_encode(hash_hmac('sha256', $data, $app_secret_key, true));

            return hash_equals($hmac_header, $calculated_hmac);
        } catch (\Exception $e) {
            Log::debug("verify_webhook Error {$e->getMessage()} Line {$e->getLine()} File {$e->getFile()} ");
        }
    }
}

if (! function_exists('getShopifyAppUrl')) {
    function getShopifyAppUrl($shop): string
    {
        $url = Utils::getEmbeddedAppUrl(base64_encode($shop.'/'));

        return $url;
    }
}
