@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="pt-10 mt-20">Заказ успешно оформлен</h1>
        <div class="_h3">
            <p class="mt-20 mb-20">Номер заказа: <span class="bold color-green">{{ $order->id }}</span></p>
            <p class="mb-40 pb-40">С вами скоро свяжется наш менеджер</p>
        </div>
    </div>
@endsection