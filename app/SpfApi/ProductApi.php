<?php

namespace App\SpfApi;

use App\ApfApi\BaseApi;
use Exception;

class ProductApi extends BaseApi
{
    public function getProducts(string $shop, string $token)
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
