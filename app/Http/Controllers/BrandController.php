<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Page;
use App\Services\ItemService;
use App\Services\PageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    public function __construct(
        private PageService $pageService,
        private ItemService $itemService,
    ) {}

    public function showBrand(Request $request, Brand $brand)
    {
        abort_if(! $brand->is_active, Response::HTTP_NOT_FOUND);

        $page = new Page();
        $page->title = $brand->title;
        $page->h1 = $brand->title;
        $page->slug = $brand->slug;
        $page->seo = null;

        $this->pageService->setBrandPage($brand, $page);

        $products = $this->itemService->getProductsForBrand($brand, $request);
        $categories = $this->itemService->getCategoriesForCatalog();

        return view('brand', compact('page', 'brand', 'products', 'categories'));
    }
}
