@extends('layouts.main')

@section('content')
    <section class="s-line s-page-branding md-pt-20 pt-10">
        <div class="container">
            <div class="w-breadcrumbs-mobile-scroll-shadow pb-10">
                @include('general.breadcrumbs')
            </div>

            <div class="row align-items-center mb-30">
                @if($brand->image)
                    <div class="col-auto">
                        <picture>
                            <img src="{{(new zImage($brand->image, [150, 50], ['contain']))->resize()}}" alt="{{ $brand->title }}" title="{{ $brand->title }}" class="img block">
                        </picture>
                    </div>
                @endif
                <div class="col">
                    <h1 class="_h1 pagetitle bold m-0">{{ $page->h1 ?: $page->title }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="s-line">
        <div class="container pb-60">
            <div class="row lg-md-gutters sm-gutters">
                <div class="col-12 col">
                    <div class="w-catalog-list">
                        <div class="row row-catalog-list lg-md-gutters sm-gutters">
                            @if ($products?->isNotEmpty())
                                @foreach($products as $product)
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-xxs-6 col-12 col md-mb-20 mb-10">
                                        @include('product.preview')
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 col md-mb-20 mb-10">
                                    <p>Товаров этого бренда пока нет.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($products?->isNotEmpty())
                        {{ $products->appends(request()->query())->onEachSide(1)->links('vendor.pagination') }}
                    @endif
                </div>
            </div>

            @if($brand->content && (!request()->has('page') || request()->input('page') <= 1))
                <div class="seo-content pt-20">
                    <article class="article _h6">
                        {!! $brand->content !!}
                    </article>
                </div>
            @endif
        </div>
    </section>
@endsection
