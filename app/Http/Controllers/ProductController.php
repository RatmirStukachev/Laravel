<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\PageService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private PageService $pageService,
        private ItemService $itemService,
    ){
    }
    
    public function getProduct(Product $product)
    {
        abort_if($product->is_active === false || !$product->isCategoriesActive(), Response::HTTP_NOT_FOUND);

        $page = $this->pageService->setProductPage($product);
  
        return view('product', compact('page'));
    }
}
