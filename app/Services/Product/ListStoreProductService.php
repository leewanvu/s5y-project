<?php

namespace App\Services\Product;

use App\Services\BaseService;
use App\SpfApi\ProductApi;

class ListStoreProductService extends BaseService
{
    protected $productApi;

    public function __construct(ProductApi $productApi)
    {
        $this->productApi = $productApi;
    }

    public function handle()
    {
        return $this->productApi->getProducts($this->data['name'], $this->data['access_token']);
    }
}
