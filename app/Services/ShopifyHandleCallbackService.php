<?php

namespace App\Services;

use App\Models\Store;
use App\SpfApi\AuthApi as ShopifyAuthApi;
use Exception;
use App\Services\BaseService;

class ShopifyHandleCallbackService extends BaseService
{
    protected $shopifyAuthApi;

    public function __construct(ShopifyAuthApi $shopifyAuthApi)
    {
        $this->shopifyAuthApi = $shopifyAuthApi;
    }

    public function handle()
    {
        if (! $this->shopifyAuthApi->verifyRequest($this->data)) {
            return ['status' => false, 'message' => 'Invalid request data!'];
        }

        $result = $this->shopifyAuthApi->getAccessToken($this->data['shop'], $this->data['code']);

        if ($result['status']) {
            $result['data'] = array_merge($result['data'], [
                'name' => $this->getStoreName($this->data['shop'])
            ]);

            $this->createOrUpdateStore($result['data']);
        }

        return $result;
    }

    /**
     * Get store name from hostname (store-name.myshopify.com)
     *
     * @param string $hostname
     * @return void
     */
    private function getStoreName(string $hostname)
    {
        $arr = explode('.', $hostname);

        return $arr[0] ?? '';
    }

    /**
     * Create or update store
     *
     * @param array $data
     * @return \App\Models\Store
     */
    private function createOrUpdateStore(array $data)
    {
        $store = Store::where('name', $data['name'])->first();

        if ($store) {
            $store->fill($data);
            $store->save();

            return $store;
        }

        return Store::create($data);
    }
}
