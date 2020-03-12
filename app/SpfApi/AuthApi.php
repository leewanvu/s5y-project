<?php

namespace App\SpfApi;

use App\ApfApi\BaseApi;
use App\Contract\SpfApi\AuthApi as SpfApiAuthApi;
use Exception;

class AuthApi extends BaseApi implements SpfApiAuthApi
{
    /**
     * Generate url install to the app
     *
     * @param string $shop
     * @return string
     */
    public function generateUrlInstall(string $shop): string
    {
        return implode('?', [
            "https://{$shop}.myshopify.com/admin/oauth/authorize",
            http_build_query([
                'client_id' => $this->apiKey,
                'scope' => implode(',', config('shopify.scopes')),
                'redirect_uri' => config('shopify.redirect_uri')
            ])
        ]);
    }

    /**
     * Verify request
     *
     * @param mixed $data
     * @return bool
     */
    public function verifyRequest($data) : bool
    {
        $tmp = [];
        if (is_string($data)) {
            $each = explode('&',$data);
            foreach($each as $e) {
                list($key, $val) = explode('=', $e);
                $tmp[$key] = $val;
            }
        } elseif(is_array($data)) {
            $tmp = $data;
        } else {
            return false;
        }

        // Timestamp check; 1 hour tolerance
        if(($tmp['timestamp'] - time() > 3600)) {
            return false;
        }

        if(array_key_exists('hmac', $tmp)) {
            // HMAC Validation
            $queryString = http_build_query([
                'code'      => $tmp['code'],
                'shop'      => $tmp['shop'],
                'timestamp' => $tmp['timestamp']
            ]);
            $match       = $tmp['hmac'];
            $calculated  = hash_hmac('sha256', $queryString, $this->secretKey);

            return $calculated === $match;
        }

        return false;
    }

    /**
     * Get access token
     *
     * @param string $shop hostname (store-name.myshopify.com)
     * @param string $code
     * @return array
     */
    public function getAccessToken(string $shop, string $code) : array
    {
        try{
            $response = $this->client->request('POST', "https://{$shop}/admin/oauth/access_token.json",
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        'code' => $code,
                        'client_id' => $this->apiKey,
                        'client_secret' => $this->secretKey
                    ])
                ]
            );

            return ['status' => true, 'data' => json_decode($response->getBody()->getContents(), true)];
        } catch (Exception $exception) {
            report($exception);
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
