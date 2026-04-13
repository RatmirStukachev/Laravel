<?php

namespace App\ViewComposers;

use App\Models\SiteMenu;
use Illuminate\View\View;
use App\Services\ItemService;
use Illuminate\Support\Facades\Cache;

class ProductBlockComposer
{
    const ONE_MINUTE = 60;
    protected $delivery_block;

    public function __construct(private ItemService $itemService)
    {
        Cache::forget('delivery_block');
        $this->delivery_block = Cache::flexible(
            key: 'delivery_block',
            ttl: [
                self::ONE_MINUTE,
                config('cache.stores.delivery_block'),
            ],
            callback: function () {
                return $this->itemService->getPageBlock(key: 'product_delivery');
            });
    }

    public function compose(View $view): View
    {
        return $view->with([
            'delivery_block' => $this->delivery_block,
        ]);
    }
}
