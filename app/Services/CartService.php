<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Shop;
use App\Models\Delivery;
use App\Models\Promocode;
use App\Models\PaymentType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ItemService;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    const REGISTER_PROMOCODE_ID = 1;
    protected Cart|Collection $cart;
    protected $userHash;

    public function __construct(
        private ItemService $itemService,
        private PageService $pageService,
    ){
        $this->userHash = $this->getUserHash();
        $this->cart = $this->getCartItems();
    }

    protected function getUserHash()
    {
       return session()->get('user_hash');
    }

    public function addProduct(array $data)
    {
        $productQuantityToAdd = $data['count'] ?? 1;
        
        $cartItem = Cart::firstOrCreate(
            [
                'user_hash' => $this->userHash,
                'product_id' => $data['product_id'],
            ],
            [
                'count' => $productQuantityToAdd,
            ]
        );

        if (!$cartItem->wasRecentlyCreated) {
            $cartItem->increment('count', $productQuantityToAdd);
        }

        $this->cart = $this->getCartItems();

        return [
            'cart_count' => $this->getCartCount(),
            'product_count' => $this->getProductCount($data['product_id'])
        ];
    }

    public function updateCart(array $data)
    {
        try {
            $cartItem = Cart::where('user_hash', $this->userHash)
                ->where('product_id', $data['product_id'])
                ->firstOrFail();

            $count = max(1, min((int)$data['count'], $cartItem->product->balance));
            $updated = $cartItem->update(['count' => $count]);

            if ($updated) {
                $this->cart = $this->getCartItems();

                return [
                    'success' => true,
                    'cart_count' => $this->getCartCount(),
                    'product_count' => $count,
                    'totalSum' => $this->getTotalSum(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Не удалось обновить количество товара'
            ];
        } catch (\Throwable $ex) {
            return [
                'success' => false,
                'message' => 'Товар не найден в корзине'
            ];
        }
    }

    public function getTotalSum(): float
    {
        return $this->cart->sum(function ($item) {
            return $item->product->price * $item->count;
        });
    }

    public function getDiscount(): float
    {
        return $this->cart->sum(function ($item) {
            return $item->product->old_price
                ? ($item->product->old_price - $item->product->price) * $item->count
                : 0;
        });
    }

    public function getSummary(): array
    {
        return [
            'totalSum' => $this->getTotalSum(),
            'cart_count' => $this->getCartCount(),
        ];
    }

    public function getUpdatedBasket(Request $request)
    {
        $cartBlockHtml = view('cart.form', [
            'page' => $this->pageService->getPage('cart'),
            'basket' => $this->getCartItems(),
            'summary' => $this->getSummary(),
            'paymentTypes' => $this->getPaymentTypes(),
            'deliveries' => $this->getDeliveries(),
            'request' => $request,
        ])->render();

        return [
            'success' => true,
            'cartBlockHtml' => $cartBlockHtml,
            'cart_count' => $this->getCartCount(),
            'totalSum' => $this->getTotalSum(),
        ];
    }

    public function removeProduct(Request $request)
    {
        Cart::where('id', $request->cart_id)->delete();
        $this->cart = $this->getCartItems();
    }

    public function getCartItems()
    {
        return Cart::with(['product', 'product.category'])
            ->where('user_hash', $this->userHash)
            ->get();
    }

    public function checkAvailability()
    {
        $cartItems = $this->getCartItems();
        foreach ($cartItems as $item) {
            if ($item->product->balance < $item->count) {
                throw new \Exception('Изменилось доступное количество товара ' . $item->product->title . '  (доступно ' . $item->product->balance . ')');
            }
        }
    }

    public function getDeliveries()
    {
        return Delivery::where('is_active', true)->get();
    }

    public function getCartCount(): int
    {
        return Cart::where('user_hash', $this->userHash)->sum('count');
    }

    public function resetBasket()
    {
        return Cart::where('user_hash', $this->userHash)->delete();
    }

    public function isProductInCart(int $productId): bool
    {
        return $this->cart->contains('product_id', $productId);
    }

    public function getProductCount(int $productId): int
    {
        $cartItem = $this->cart->where('product_id', $productId)->first();
        return $cartItem ? $cartItem->count : 0;
    }

    public function getPaymentTypes()
    {
        return PaymentType::where('is_active', true)->orderBy('pos')->get();
    }
}
