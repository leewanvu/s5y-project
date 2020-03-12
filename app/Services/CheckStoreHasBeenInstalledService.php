<?php

namespace App\Services;

use App\Models\Store;
use App\Services\BaseService;

class CheckStoreHasBeenInstalledService extends BaseService
{
    public function handle()
    {
        $store = Store::where('name', $this->data['shop'])->first();

        if (! $store) {
            return false;
        }

        $scopes = explode(',', $store->scope);

        // If the app has new scopes, should call the url install to update granted access store
        if (! empty(array_diff(config('shopify.scopes'), $scopes))) {
            return false;
        }

        return true;
    }
}
