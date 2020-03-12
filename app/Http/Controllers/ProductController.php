<?php

namespace App\Http\Controllers;

use App\Services\Product\ListStoreProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $listStoreProductService;

    public function __construct(ListStoreProductService $listStoreProductService)
    {
        $this->listStoreProductService = $listStoreProductService;
    }

    public function index(Request $request)
    {
        $products = $this->listStoreProductService->setData($request->store->toArray())->handle();
// dd($products);
        return view('products', [
            'products' => $products
        ]);
    }
}
