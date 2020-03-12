<?php

namespace App\Http\Controllers;

use App\Services\CheckStoreHasBeenInstalledService;
use App\Services\ShopifyHandleCallbackService;
use App\SpfApi\AuthApi;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    protected $shopifyHandleCallbackService;
    protected $checkStoreHasBeenInstalledService;

    public function __construct(
        ShopifyHandleCallbackService $shopifyHandleCallbackService,
        CheckStoreHasBeenInstalledService $checkStoreHasBeenInstalledService
    ) {
        $this->shopifyHandleCallbackService = $shopifyHandleCallbackService;
        $this->checkStoreHasBeenInstalledService = $checkStoreHasBeenInstalledService;
    }

    public function install(Request $request)
    {
        $hasBeenInstalled = $this->checkStoreHasBeenInstalledService->setData($request->only('shop'))->handle();

        if ($hasBeenInstalled) {
            return redirect()->route('shopify.products.index', [
                'store' => $request->get('shop')
            ]);
        }

        return redirect()->away((new AuthApi)->generateUrlInstall($request->get('shop')));
    }

    public function handleCallback(Request $request)
    {
        $result = $this->shopifyHandleCallbackService->setData($request->all())->handle();

        if (! $result['status']) {
            return redirect()->route('home')->with([
                'message' => $result['message']
            ]);
        }

        return redirect()->route('shopify.products.index', [
            'store' => $result['data']['name']
        ]);
    }
}
