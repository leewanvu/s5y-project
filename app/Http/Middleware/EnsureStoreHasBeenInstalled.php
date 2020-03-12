<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;

class EnsureStoreHasBeenInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $shop = $request->get('store', '');

        if (empty($shop)) {
            return redirect('/');
        }

        $store = Store::where('name', $shop)->first();

        if (! $store) {
            return redirect()->route('home')->with([
                'message' => "Please install the {$shop} before!",
                'shop' => $shop
            ]);
        }

        if (! $this->hasSupport($request, $store)) {
            return redirect()->route('shopify.not-support.get', [
                'name' => $store->name,
                'scope' => $store->scope // TODO: get exactly scope later
            ]);
        }

        $request->store = $store;

        return $next($request);
    }

    /**
     * Check the store's scope has support
     *
     * @param \Illuminate\Http\Request $request
     * @return boolean
     */
    private function hasSupport(Request $request, Store $store)
    {
        $scopes = explode(',', $store->scope);

        if ($request->is('products/*') && $request->isMethod('get')) {
            return in_array('read_products', $scopes);
        }

        return true;
    }
}
