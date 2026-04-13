<?php

namespace App\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class MenuCategoriesComposer
{
    const ONE_MINUTE = 60;
    protected $menuCategories;

    public function __construct()
    {
        Cache::forget('menu_categories');
        $this->menuCategories = Cache::flexible(
            key: 'menu_categories',
            ttl: [
                self::ONE_MINUTE,
                config('cache.stores.categories'),
            ],
            callback: function () {
                return Category::isActive()
                    ->select(['id', 'title', 'slug', 'h1','level','parent_id', 'pos', 'is_active'])
                    ->with([
                        'children',
                        'children.parent',
                        'children.children',
                        'children.children.parent.parent'
                    ])
                    ->where('header_menu', 1)
                    ->orderBy('pos')
                    ->orderBy('title')
                    ->get();
            });
    }

    public function compose(View $view): View
    {
        return $view->with('menuCategories', $this->menuCategories);
    }
}
