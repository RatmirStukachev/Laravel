<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Company;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Promocode;
use App\Enums\CustomerEnum;
use App\Models\PaymentType;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FastOrderRequest;

class OrderService
{
    public function __construct(
        private CartService $cartService,
    ) {}

    public function createOrder(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $totalSum = $this->cartService->getSummary($request);

            $order = Order::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'middle_name' => $request->middle_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
                'total_amount' => $totalSum['totalSum'],
                'delivery_price' => $request->delivery_price,
                'count' => $this->cartService->getCartCount(), 
                'delivery_id' => $request->delivery_id,
                'payment_type_id' => $request->payment_type_id,
            ]);

            if (in_array((int)$request->delivery_id, [Delivery::DELIVERY_TO_ADDRESS, Delivery::DELIVERY_TO_CITY])) {
                $order->update([
                    'city' => $request->city,
                    'street' => $request->street,
                    'house' => $request->house,
                    'block' => $request->block,
                    'flat' => $request->flat,
                    'floor' => $request->floor,
                    'entrance' => $request->entrance,
                ]);
            }

            $basket = $this->cartService->getCartItems();

            foreach ($basket as $cart) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'title' => $cart->product->title,
                    'article' => $cart->product->article,
                    'price' => $cart->product->price,
                    'count' => $cart->count,
                    'total_price' => $cart->product->price * $cart->count,
                ]);
                
                $cart->product->decrement('balance', $cart->count);
            }

            $this->cartService->resetBasket();

            DB::commit();
            
            return $order;

        } catch (\Throwable $ex) {
            DB::rollBack();

            Log::error(['Ошибка при создании заказа: ' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()]);
        }
    }

    public function getDeliveryTypes()
    {
        return Delivery::where('is_active', true)->orderBy('pos')->get();
    }

    public function getPaymentTypes()
    {
        return PaymentType::where('is_active', true)->orderBy('pos')->get();
    }

    public function getPaymentTypesForCustomer(string $customerType)
    {
        return PaymentType::getByCustomerType($customerType);
    }
}
