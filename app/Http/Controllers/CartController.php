<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\ItemService;
use App\Services\PageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function __construct(
        private PageService $pageService,
        private CartService $cartService,
        private ItemService $itemService,
    ){}
    public function getCart(Request $request)
    {
        $page = $this->pageService->getPage('cart');
        $basket = $this->cartService->getCartItems();
        $summary = $this->cartService->getSummary($request);
        $deliveries = $this->itemService->getDeliveries();
        $paymentTypes = $this->itemService->getPaymentTypes();
        $productsCanLike = $this->itemService->getProductsCanLike();

        if ($basket->isEmpty()) {
            return redirect()->route('index');
        }        

        return view('cart', compact('page', 'basket', 'summary', 'deliveries', 'paymentTypes', 'productsCanLike',));
    }

    public function addProduct(Request $request): JsonResponse
    {
        $result = $this->cartService->addProduct($request->all());
        
        return response()->json($result, Response::HTTP_OK);
    }

    public function updateCart(Request $request): JsonResponse
    {
        $result = $this->cartService->updateCart($request->all());
        
        if (!$result['success']) {
            return response()->json($result, Response::HTTP_BAD_REQUEST);
        }

        return response()->json(
            $this->cartService->getUpdatedBasket($request), 
            Response::HTTP_OK
        );
    }
    
    public function removeCart(Request $request): JsonResponse
    {        
        $this->cartService->removeProduct($request);
  
        return response()->json(
            $this->cartService->getUpdatedBasket($request), 
            Response::HTTP_OK
        );
    }
}
