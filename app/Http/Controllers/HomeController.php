<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\PageService;

class HomeController extends Controller
{
    public function __construct(
        private PageService $pageService,
        private ItemService $itemService,
    ){}

    public function index()
    {
        $page = $this->pageService->getPage('/');

        $sliders = $this->itemService->getSliders();
        $newProducts = $this->itemService->getNewProductsForIndex();
        $popularProducts = $this->itemService->getPopularProductsForIndex();        
        $categories = $this->itemService->getCategoriesForIndex();
        $brands = $this->itemService->getBrandsForIndex();
        $news = $this->itemService->getNewsForIndex();

        $new_products_title = $this->itemService->getPageBlock(key: 'main_arrivals');
        $second_block = $this->itemService->getPageBlock(key: 'main_second');
        $popular_products_title = $this->itemService->getPageBlock(key: 'main_popular');
        $slide_block = $this->itemService->getPageBlock(key: 'main_slide');
        $brands_title = $this->itemService->getPageBlock(key: 'main_brands');
        $news_title = $this->itemService->getPageBlock(key: 'main_news');

        return view('index', compact('page', 'sliders', 'newProducts', 'popularProducts', 'categories', 'brands', 'news', 'new_products_title', 'second_block', 
            'popular_products_title', 'slide_block', 'brands_title', 'news_title'));
    }
}
