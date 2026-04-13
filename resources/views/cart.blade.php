@extends('layouts.main')

@section('content')
    <section class="s-line s-page-branding md-pt-20 pt-10">
        <div class="container">
            <div class="w-breadcrumbs-mobile-scroll-shadow pb-10">
                @include('general.breadcrumbs')
            </div>
        </div>
    </section>

    <section class="s-line s-cart-page s-gray-bg">
        <div class="container pt-20 pb-60">
            <h1 class="_h1 pagetitle bold mb-20">{{ $page->h1 ?: $page->title }}</h1>
            <form class="order-form" action="{{ route('order.create') }}" method="post">
                <div class="row row-cart-page lg-md-gutters sm-gutters _js-cart-form">
                    @if ($basket->isNotEmpty())
                        @include('cart.form')
                    @endif
                </div>		
            </form>
        </div>
    </section>

    @if ($productsCanLike?->isNotEmpty())
        <section class="s-line s-items-slider">
            <div class="container pt-60 pb-60">
                <div class="row align-items-end mb-20">
                    <div class="col-sm-auto col-12 mb-5">
                        <div class="s-name _h2 bold align-center">Вам может понравится</div>
                    </div>
                    <div class="col-sm-auto col-12 mb-10">
                        <div class="_h6 upper align-center">
                            {{-- <a href="" class="color-orange nul"><span class="dashed dash">посмотреть все</span></a> --}}
                        </div>
                    </div>
                </div>
                <div class="w-catalog-list">
                    <div class="owl-carousel owl-catalog-list-slider">
                        @foreach ($productsCanLike as $product)
                            <div class="slide">
                                @include('product.preview')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection