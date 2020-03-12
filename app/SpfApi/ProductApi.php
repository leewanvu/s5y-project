<?php

namespace App\SpfApi;

use App\ApfApi\BaseApi;
use Exception;

class ProductApi extends BaseApi
{
    /**
     * Get products
     *
     * @param string $shop
     * @param string $token
     * @return array
     */
    public function getProducts(string $shop, string $token) : array
    {
        try{
            $response = $this->client->request('GET', "https://{$shop}.myshopify.com/admin/api/{$this->apiVersion}/products.json",
                [
                    'headers' => [
                        'X-Shopify-Access-Token' => $token
                    ]
                ]
            );

            $contents = json_decode($response->getBody()->getContents(), true);

            return $contents['products'] ?? [];
        } catch (Exception $e) {
            report($e);
            return [];
        }
    }
}
