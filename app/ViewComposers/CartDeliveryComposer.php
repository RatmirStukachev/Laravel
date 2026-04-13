<?php

namespace App\ViewComposers;

use App\Models\SiteMenu;
use Illuminate\View\View;
use App\Services\ItemService;
use Illuminate\Support\Facades\Cache;

class CartDeliveryComposer
{
    const ONE_MINUTE = 60;
    protected $cart_delivery;

    public function __construct(private ItemService $itemService)
    {
        Cache::forget('cart_delivery');
        $this->cart_delivery = Cache::flexible(
            key: 'cart_delivery',
            ttl: [
                self::ONE_MINUTE,
                config('cache.stores.cart_delivery'),
            ],
            callback: function () {
                return $this->itemService->getPageBlock(key: 'cart_delivery');
            });
    }

    public function compose(View $view): View
    {
        return $view->with([
            'cart_delivery' => $this->cart_delivery,
        ]);
    }
}
