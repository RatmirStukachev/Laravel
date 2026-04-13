<div class="col-cart-content col-12 col">
    <div class="w-cart-page-white-frame mb-20">
        <div class="frame">
            <div class="row justify-content-sm-end justify-content-start">
                <div class="col-auto sm-pt-15">
                    <div class="color-gray">{{ $summary['cart_count'] }} {{ pluralize($summary['cart_count'], ['товар', 'товара', 'товаров']) }}</div>
                </div>
            </div>
            <div class="pt-15">
                <hr>
            </div>
            @foreach ($basket as $cart)
                <div class="w-cart-list-item pt-20">
                    <div class="row row-cart-list-item md-gutters">
                        <div class="col-image col">
                            <div class="w-image">
                                <div class="image">
                                    <a href="{{ route('product', $cart->product) }}" class="block__link image__link">
                                        <picture>
                                            <img src="{{(new zImage($cart->product?->image, [130, 130], ['contain']))->resize()}}" alt="{{ $cart->product?->title }}" title="{{ $cart->product?->title  }}" class="img block">
                                            @if(env('WEBP'))
                                                <source
                                                    srcset="{{(new zImage($cart->product?->image, [130, 130], ['contain'], true))->resize()}}">
                                            @endif
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-content col">											
                            <div class="row row-content md-gutters align-items-center justify-content-sm-between justify-content-start">
                                <div class="col-name col">
                                    <div class="w-mobile-content-right-offset w-mobile-content-min-height">
                                        <div class="row align-items-center md-gutters">
                                            <div class="col-auto mb-5">
                                                <div class="color-gray">Код {{ $cart->product?->article }}</div>
                                            </div>
                                            <div class="col-auto">                                                    
                                                <div class="w-stickers">
                                                    <div class="row">
                                                        @if ($cart->product?->hasDiscount())
                                                            <div class="col-auto col mb-5">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 1.60786C19.8242 2.66108 21.3391 4.17593 22.3923 6.00016C23.4455 7.8244 24 9.89373 24 12.0002C24 14.1066 23.4455 16.1759 22.3922 18.0001C21.339 19.8244 19.8241 21.3392 17.9999 22.3924C16.1756 23.4456 14.1063 24 11.9998 24C9.89336 24 7.82402 23.4455 5.9998 22.3922C4.17558 21.339 2.66075 19.8241 1.60756 17.9998C0.554376 16.1756 -5.35076e-05 14.1062 3.87318e-09 11.9998L0.00600014 11.611C0.0732039 9.53859 0.676257 7.51897 1.75637 5.74902C2.83648 3.97907 4.35678 2.51919 6.16907 1.51172C7.98136 0.504243 10.0238 -0.0164528 12.0972 0.000396292C14.1706 0.0172454 16.2043 0.571064 18 1.60786ZM15 13.1998C14.5226 13.1998 14.0648 13.3894 13.7272 13.727C13.3896 14.0645 13.2 14.5224 13.2 14.9998C13.2 15.4771 13.3896 15.935 13.7272 16.2725C14.0648 16.6101 14.5226 16.7997 15 16.7997C15.4774 16.7997 15.9352 16.6101 16.2728 16.2725C16.6104 15.935 16.8 15.4771 16.8 14.9998C16.8 14.5224 16.6104 14.0645 16.2728 13.727C15.9352 13.3894 15.4774 13.1998 15 13.1998ZM16.4484 7.55142C16.2234 7.32645 15.9182 7.20008 15.6 7.20008C15.2818 7.20008 14.9766 7.32645 14.7516 7.55142L7.5516 14.7514C7.33301 14.9777 7.21206 15.2808 7.21479 15.5954C7.21753 15.9101 7.34373 16.211 7.56622 16.4335C7.78871 16.656 8.08968 16.7822 8.40432 16.785C8.71896 16.7877 9.02208 16.6667 9.2484 16.4482L12.8484 12.8482L16.4484 9.2482C16.6734 9.02317 16.7997 8.718 16.7997 8.39981C16.7997 8.08162 16.6734 7.77645 16.4484 7.55142ZM9 7.19982C8.52261 7.19982 8.06477 7.38946 7.72721 7.72702C7.38964 8.06459 7.2 8.52242 7.2 8.99981C7.2 9.47719 7.38964 9.93502 7.72721 10.2726C8.06477 10.6102 8.52261 10.7998 9 10.7998C9.47739 10.7998 9.93523 10.6102 10.2728 10.2726C10.6104 9.93502 10.8 9.47719 10.8 8.99981C10.8 8.52242 10.6104 8.06459 10.2728 7.72702C9.93523 7.38946 9.47739 7.19982 9 7.19982Z" fill="#FF5F00"></path></svg>
                                                            </div>
                                                        @endif
                                                        @if ($cart->product?->is_new)
                                                            <div class="col-auto col mb-5">
                                                                <div class="product-color-sticker color001">
                                                                    NEW
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($cart->product?->is_hit)
                                                            <div class="col-auto col mb-5">
                                                                <div class="product-color-sticker color002">
                                                                    ХИТ
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="title _h6 semibold mb-10"><a href="{{ route('product', $cart->product) }}" class="name__link color-black nul">{{ $cart->product?->h1 ?: $cart->product?->title }}</a></div>
                                        {{-- <div class="color-gray md-mb-0 mb-10">цвет белый</div> --}}
                                    </div>
                                </div>
                                <div class="col-pcs col mb-10">
                                    <div class="_js-pcscontrolls pcscontrolls">
                                        <a class="btn fcm left minus _js-b-minus">
                                            <svg width="15" height="15" viewBox="0 0 34 5" xmlns="http://www.w3.org/2000/svg"><path d="M0.333496 2.75008C0.333496 2.19755 0.55299 1.66764 0.943691 1.27694C1.33439 0.886241 1.8643 0.666748 2.41683 0.666748H31.5835C32.136 0.666748 32.6659 0.886241 33.0566 1.27694C33.4473 1.66764 33.6668 2.19755 33.6668 2.75008C33.6668 3.30262 33.4473 3.83252 33.0566 4.22322C32.6659 4.61392 32.136 4.83341 31.5835 4.83341H2.41683C1.8643 4.83341 1.33439 4.61392 0.943691 4.22322C0.55299 3.83252 0.333496 3.30262 0.333496 2.75008Z"></path></svg>
                                        </a>
                                        <input type="text" 
                                            value="{{ $cart->count }}"
                                            data-product-id="{{ $cart->product?->id }}"
                                            class="input__default _js-input-cart"
                                            data-max="{{ $cart->product?->balance }}"
                                            inputmode="numeric"
                                        >
                                        <a class="btn fcm right plus _js-b-plus">
                                            <svg width="15" height="15" viewBox="0 0 34 34" xmlns="http://www.w3.org/2000/svg"><path d="M0 17.0833C0 16.5308 0.219494 16.0009 0.610195 15.6102C1.0009 15.2195 1.5308 15 2.08333 15H31.25C31.8025 15 32.3324 15.2195 32.7231 15.6102C33.1138 16.0009 33.3333 16.5308 33.3333 17.0833C33.3333 17.6359 33.1138 18.1658 32.7231 18.5565C32.3324 18.9472 31.8025 19.1667 31.25 19.1667H2.08333C1.5308 19.1667 1.0009 18.9472 0.610195 18.5565C0.219494 18.1658 0 17.6359 0 17.0833Z"></path><path d="M17.0833 0C17.6359 0 18.1658 0.219493 18.5565 0.610194C18.9472 1.00089 19.1667 1.5308 19.1667 2.08333V31.25C19.1667 31.8025 18.9472 32.3324 18.5565 32.7231C18.1658 33.1138 17.6359 33.3333 17.0833 33.3333C16.5308 33.3333 16.0009 33.1138 15.6102 32.7231C15.2195 32.3324 15 31.8025 15 31.25V2.08333C15 1.5308 15.2195 1.00089 15.6102 0.610194C16.0009 0.219493 16.5308 0 17.0833 0Z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-price col mb-10">
                                    <div class="w-price-group">
                                        <div class="w-price">
                                            @if ($cart->product?->hasDiscount())
                                                <div class="w-old-price">
                                                    <div class="row align-items-center sm-gutters">
                                                        <div class="col-auto">
                                                            <div class="color-orange semibold old-price">{{ format_price($cart->product?->old_price * $cart->count) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="old-price-sticker">-{{ discount($cart->product) }}%</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="w-price">
                                                <div class="_h5 bold">{{ $cart->product?->price * $cart->count }} <span class="_h7">{{ $cart->product?->category?->measure ? 'BYN/' . $cart->product->category->measure : 'BYN' }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (isset($delivery_block['delivery']) && (!empty($delivery_block['delivery']) || !empty($delivery_block['pickup'])))
                                <div class="row">
                                    <div class="col-auto mt-5">
                                        @if ($delivery_block['delivery'])
                                            <div class="w-icon-left w-delivery-type-aside-icon mt-10">
                                                <div class="icon"><svg viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.0298 8.3678H17.0298V4.3678H3.02979C1.92979 4.3678 1.02979 5.2678 1.02979 6.3678V17.3678H3.02979C3.02979 19.0278 4.36979 20.3678 6.02979 20.3678C7.68979 20.3678 9.02979 19.0278 9.02979 17.3678H15.0298C15.0298 19.0278 16.3698 20.3678 18.0298 20.3678C19.6898 20.3678 21.0298 19.0278 21.0298 17.3678H23.0298V12.3678L20.0298 8.3678ZM19.5298 9.8678L21.4898 12.3678H17.0298V9.8678H19.5298ZM6.02979 18.3678C5.47978 18.3678 5.02979 17.9178 5.02979 17.3678C5.02979 16.8178 5.47978 16.3678 6.02979 16.3678C6.57979 16.3678 7.02979 16.8178 7.02979 17.3678C7.02979 17.9178 6.57979 18.3678 6.02979 18.3678ZM8.24979 15.3678C7.69979 14.7578 6.91979 14.3678 6.02979 14.3678C5.13979 14.3678 4.35979 14.7578 3.80979 15.3678H3.02979V6.3678H15.0298V15.3678H8.24979ZM18.0298 18.3678C17.4798 18.3678 17.0298 17.9178 17.0298 17.3678C17.0298 16.8178 17.4798 16.3678 18.0298 16.3678C18.5798 16.3678 19.0298 16.8178 19.0298 17.3678C19.0298 17.9178 18.5798 18.3678 18.0298 18.3678Z" fill="#CBCBCB"></path></svg></div>
                                                <div class="text">{{ $delivery_block['delivery'] }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-auto mt-5">
                                        @if ($delivery_block['pickup'])
                                            <div class="w-icon-left w-delivery-type-aside-icon mt-10">
                                                <div class="icon"><svg viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 12.5C11.4 12.5 10.5 11.6 10.5 10.5C10.5 9.4 11.4 8.5 12.5 8.5C13.6 8.5 14.5 9.4 14.5 10.5C14.5 11.6 13.6 12.5 12.5 12.5ZM18.5 10.7C18.5 7.07 15.85 4.5 12.5 4.5C9.15 4.5 6.5 7.07 6.5 10.7C6.5 13.04 8.45 16.14 12.5 19.84C16.55 16.14 18.5 13.04 18.5 10.7ZM12.5 2.5C16.7 2.5 20.5 5.72 20.5 10.7C20.5 14.02 17.83 17.95 12.5 22.5C7.17 17.95 4.5 14.02 4.5 10.7C4.5 5.72 8.3 2.5 12.5 2.5Z" fill="#CBCBCB"></path></svg></div>
                                                <div class="text">{{ $delivery_block['pickup']}}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-delete col">
                            <a class="delete-btn fcm _js-remove-product-cart" data-cart-id="{{ $cart->id }}">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 5H4.16667H17.5"/><path d="M6.6665 5.00002V3.33335C6.6665 2.89133 6.8421 2.4674 7.15466 2.15484C7.46722 1.84228 7.89114 1.66669 8.33317 1.66669H11.6665C12.1085 1.66669 12.5325 1.84228 12.845 2.15484C13.1576 2.4674 13.3332 2.89133 13.3332 3.33335V5.00002M15.8332 5.00002V16.6667C15.8332 17.1087 15.6576 17.5326 15.345 17.8452C15.0325 18.1578 14.6085 18.3334 14.1665 18.3334H5.83317C5.39114 18.3334 4.96722 18.1578 4.65466 17.8452C4.3421 17.5326 4.1665 17.1087 4.1665 16.6667V5.00002H15.8332Z"/><path d="M8.3335 9.16669V14.1667"/><path d="M11.6665 9.16669V14.1667"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="w-cart-page-white-frame mb-20">
        <div class="frame">
            <div class="s-name _h2 bold align-sm-left align-center mt-15">Мои данные</div>
            <div class="row md-gutters">
                <div class="col-md-4 col-sm-6 col-12 mt-20">
                    <div class="input label-top">
                        <label class="label block mb-5">Фамилия</label>
                        <input name="surname" type="text" value="{{ request()->input('surname') }}" class="input__default gray small" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mt-20">
                    <div class="input label-top">
                        <label class="label block mb-5">Имя <span class="color-red">*</span></label>
                        <input name="name" type="text" value="{{ request()->input('name') }}" class="input__default gray small" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mt-20">
                    <div class="input label-top">
                        <label class="label block mb-5">Отчество</label>
                        <input name="middle_name" type="text" value="{{ request()->input('middle_name') }}" class="input__default gray small" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mt-20">
                    <div class="input label-top">
                        <label class="label block mb-5">Номер телефона <span class="color-red">*</span></label>
                        <input name="phone" type="text" value="{{ request()->input('phone') }}" class="input__default gray small" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mt-20">
                    <div class="input label-top">
                        <label class="label block mb-5">E-mail</label>
                        <input name="email" type="text" value="{{ request()->input('email') }}" class="input__default gray small" placeholder="">
                    </div>
                </div>
            </div>
            
            
            
            
            <div class="delivery-block">                
                <div class="s-name _h3 bold align-sm-left align-center mt-15 mb-20">Адрес доставки</div>
                <div class="row md-gutters">
                    <div class="col-md-4 col-sm-6 col-12 mt-20">
                        <div class="input label-top">
                            <label class="label block mb-5">Ваш город <span class="color-red">*</span></label>
                            <input name="city" type="text" class="input__default gray small" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mt-20">
                        <div class="input label-top">
                            <label class="label block mb-5">Улица <span class="color-red">*</span></label>
                            <input name="street" type="text" class="input__default gray small" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mt-10">
                        <div class="row sm-gutters">
                            <div class="col-6 mt-10">
                                <div class="input label-top">
                                    <label class="label block mb-5">Дом <span class="color-red">*</span></label>
                                    <input name="house" type="text" class="input__default gray small" placeholder="">
                                </div>
                            </div>
                            <div class="col-6 mt-10">
                                <div class="input label-top">
                                    <label class="label block mb-5">Квартира <span class="color-red">*</span></label>
                                    <input name="flat" type="text" class="input__default gray small" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mt-10">
                        <div class="row sm-gutters">
                            <div class="col-6 mt-10">
                                <div class="input label-top">
                                    <label class="label block mb-5">Корпус</label>
                                    <input name="block" type="text" class="input__default gray small" placeholder="">
                                </div>
                            </div>
                            <div class="col-6 mt-10">
                                <div class="input label-top">
                                    <label class="label block mb-5">Этаж <span class="color-red">*</span></label>
                                    <input name="floor" type="text" class="input__default gray small" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-20">
                        <div class="input label-top">
                            <label class="label block mb-5">Комментарии</label>
                            <textarea name="message" type="text" class="textarea__default gray small"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-20"><span class="color-red">*</span> обязательные для заполнения</div>
            </div>
        </div>
    </div>
    <div class="row row-cart-page-pay-and-delivery lg-md-gutters sm-gutters">
        <div class="col-md-6 col-12 col pb-20">
            <div class="w-cart-page-white-frame _js-payment-block">
                <div class="frame">
                    @if ($paymentTypes->isNotEmpty())
                        <div class="s-name _h2 bold align-sm-left align-center mt-15 mb-10">Способы оплаты</div>
                        @foreach ($paymentTypes as $paymentType)
                            <div class="custom-selector radio mt-10">
                                <label class="label block pointer">
                                    <div class="input">
                                        <input type="radio" 
                                            name="payment_type_id"
                                            value="{{ $paymentType->id }}" 
                                            class="selector hidden _js-payment-type"
                                            @if (request()->input('payment_type_id') == $paymentType->id)
                                                checked
                                            @endif
                                            >
                                        <div class="styled-figure">
                                            <div class="border">
                                                <div class="inset-figure"></div>
                                            </div>
                                        </div>
                                        <div class="label label-inner">{{ $paymentType->title }}</div>
                                    </div> 
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12 col pb-20 ">
            <div class="w-cart-page-white-frame _js-delivery-block">
                @if ($deliveries->isNotEmpty())
                    <div class="frame">
                        <div class="s-name _h2 bold align-sm-left align-center mt-15 mb-10">Способы доставки</div>
                        @foreach ($deliveries as $delivery)
                            <div class="custom-selector radio mt-10">
                                <label class="label block pointer">
                                    <div class="input">
                                        <input type="radio" 
                                            name="delivery_id"
                                            value="{{ $delivery->id }}"
                                            class="selector hidden _js-delivery"
                                            data-delivery-price="{{ $delivery->getActualPrice($summary['totalSum']) }}"
                                            @if (request()->input('delivery_id') == $delivery->id)
                                                checked
                                            @endif
                                            >
                                        <div class="styled-figure">
                                            <div class="border">
                                                <div class="inset-figure"></div>
                                            </div>
                                        </div>
                                        <div class="label label-inner">{{ $delivery->title }}</div>
                                    </div> 
                                </label>
                            </div>
                        @endforeach
                        @if (isset($cart_delivery['content']) && !empty($cart_delivery['content']))
                            <div class="color-gray small-text mt-20">
                                {!! $cart_delivery['content'] !!}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-aside-price col-12 col pb-20">
    <div class="w-cart-page-white-frame">
        <div class="frame">
            <div class="row justify-content-start">
                <div class="col-auto pt-15">
                    <div class="">{{ $summary['cart_count'] }} {{ pluralize($summary['cart_count'], ['товар', 'товара', 'товаров']) }}</div>
                </div>
            </div>
            <div class="pt-15">
                <hr>
            </div>
            <div class="row align-items-center justify-content-between sm-gutters pt-10 _h6">
                <div class="col-auto pt-5">Стоимость</div>
                <div class="col-auto pt-5 _js-price">{{ format_price($summary['totalSum']) }}</div>
            </div>
            <div class="row align-items-center justify-content-between sm-gutters pt-10 _h6">
                <div class="col-auto pt-5">Стоимость доставки</div>
                <div class="col-auto pt-5 _js-delivery-price">
                    @if(isset($currentDelivery) && $currentDelivery)
                        {{ format_price($currentDelivery->getActualPrice($summary['totalSum'])) }}
                    @else
                        0 BYN
                    @endif
                </div>
            </div>
            <div class="pt-15">
                <hr>
            </div>
            <div class="row align-items-center justify-content-between sm-gutters pt-10 _h4 bold">
                <div class="col-auto pt-5">Итого</div>
                <div class="col-auto pt-5 _js-total-price">{{ format_price($summary['totalSum']) }}</span></div>
            </div>
            <div class="custom-selector check pt-15">
                <label class="label block pointer">
                    <div class="input">
                        <input type="checkbox" name="agree" class="selector hidden">
                        <div class="styled-figure">
                            <div class="border">
                                <div class="inset-figure"></div>
                            </div>
                        </div>
                        <div class="label label-inner small-text">Нажимая кнопку «Оформить заказ», я соглашаюсь на <a @if(\App\Services\Support\TextService::getSettingValue('content', 'privacy')) href="{{ route('page', ['slug' => \App\Services\Support\TextService::getSettingValue('content', 'privacy') ]) }}"@endif >обработку персональных данных</a> и с <a @if(\App\Services\Support\TextService::getSettingValue('content', 'public_offerta')) href="{{ route('page', ['slug' => \App\Services\Support\TextService::getSettingValue('content', 'public_offerta') ]) }}"@endif >договором публичной оферты</a></a></div>
                    </div> 
                </label>
            </div>
            <div class="w-button pt-15">
                <button type="submit" class="button block green">Оформить заказ</button>
            </div>
        </div>
    </div>
</div>
