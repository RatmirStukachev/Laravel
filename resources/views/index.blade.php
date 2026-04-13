@extends('layouts.main')

@section('content')
    @if($sliders?->isNotEmpty())
        <section class="s-line s-index-slider sm-pt-20 pt-0">
            <div class="owl-carousel owl-index-slider dots-center">
                @foreach($sliders as $slider)
                    <div class="slide">
                        <div class="container">                    
                            <div class="slider-image" style="background-image: url('{{ (new zImage($slider->image, [1200, 310], ['contain'], true))->resize()   }}');">
                                <div class="slider-image mobile" style="background-image: url('{{ (new zImage($slider->image_mobile, [545, 700], ['contain'], true))->resize() }}');">
                                    <div class="row row-content align-items-sm-center align-items-start">
                                        <div class="col-12 sm-pt-20 sm-pb-20 pt-50">
                                            <div class="content-offset color-white align-sm-left align-center">
                                                @if ($slider->title)
                                                    <div class="_h1 bold title">{{ $slider->title }}</div>
                                                @endif
                                                @if ($slider->desc)
                                                    <div class="description _h6 mt-15">
                                                        {!! $slider->desc !!}
                                                    </div>
                                                @endif
                                                @if ($slider->link && $slider->link_name)
                                                    <div class="row justify-content-sm-start justify-content-center mt-15">
                                                        <div class="col-auto"><a href="{{ $slider->link }}" class="button block">{{ $slider->link_name }}</a></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($categories?->isNotEmpty())
        <section class="s-line s-index-category-slider s-items-slider">
                <div class="container pt-30 pb-0">
                    <div class="w-category-list">
                    <div class="owl-carousel owl-categorys-list-slider">
                        @foreach ($categories as $category)
                            @include('items.category')
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($newProducts?->isNotEmpty())
        <section class="s-line s-index-catalog-slider s-items-slider">
            <div class="container pt-30 pb-60">
                <div class="row align-items-end mb-20">
                    <div class="col-sm-auto col-12 mb-5">
                        @if(isset($new_products_title['title']) && $new_products_title['title'])
                            <div class="s-name _h2 bold align-center">{{ $new_products_title['title'] }}</div>
                        @endif
                    </div>
                    <div class="col-sm-auto col-12 mb-10">
                        <div class="_h6 upper align-center">
                            @if(isset($new_products_title['link']) && $new_products_title['link'])
                                <a href="{{ $new_products_title['link'] }}" class="color-orange nul"><span class="dashed dash">посмотреть все</span></a>
                            @endif
                        </div>
                    </div>
                </div>				
                <div class="w-catalog-list">
                    <div class="owl-carousel owl-catalog-list-slider">
                        @foreach($newProducts as $product)
                            <div class="slide">
                                @include('product.preview')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($second_block['blocks']) && count($second_block['blocks']) > 0)
        <section class="s-line s-index-catalog-slider s-items-slider">
            <div class="container">
                <div class="w-index-benefits-list-frame">
                    <div class="frame">
                        <div class="row md-sm-gutters md-gutters">
                            @foreach($second_block['blocks'] as $block)
                                <div class="col-xxl-3 col-md-6 col-12 col md-mb-40 mb-30">
                                    <div class="w-index-benefit-list-item w-icon-left">
                                        <div class="icon">
                                            <picture>
                                                <img src="{{(new zImage($block['svg'], [24, 24], ['contain']))->resize()}}" alt="slide" title="slide" class="img block" loading="lazy">
                                            </picture>
                                        </div>
                                        <div class="text">
                                            @if ($block['title'])
                                                <div class="_h6 bold">{{ $block['title'] }}</div>
                                            @endif
                                            @if ($block['desc'])
                                                <div class="description mt-5 color-gray">{{ $block['desc'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($popularProducts?->isNotEmpty())
        <section class="s-line s-index-catalog-slider s-items-slider">
            <div class="container pt-30 pb-60">
                <div class="row align-items-end mb-20">
                    <div class="col-sm-auto col-12 mb-5">
                        @if(isset($popular_products_title['title']) && $popular_products_title['title'])
                            <div class="s-name _h2 bold align-center">{{ $popular_products_title['title'] }}</div>
                        @endif
                    </div>
                    <div class="col-sm-auto col-12 mb-10">
                        <div class="_h6 upper align-center">
                            @if(isset($popular_products_title['link']) && $popular_products_title['link'])
                                <a href="{{ $popular_products_title['link'] }}" class="color-orange nul"><span class="dashed dash">посмотреть все</span></a>
                            @endif
                        </div>
                    </div>
                </div>				
                <div class="w-catalog-list">
                    <div class="owl-carousel owl-catalog-list-slider">
                        @foreach($popularProducts as $product)
                            <div class="slide">
                                @include('product.preview')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($slide_block['image']) && $slide_block['image'])
        <section class="s-line s-index-offer-image-link">
            <div class="container pb-60">
                <a @if(isset($slide_block['link']) && $slide_block['link']) href="{{ $slide_block['link'] }}" @endif class="block__link">
                    <picture>
                        <img src="{{(new zImage($slide_block['image'], [1360, 285], ['contain']))->resize()}}" alt="slide" title="slide" class="img block" loading="lazy">
                        @if(env('WEBP'))
                            <source
                                srcset="{{(new zImage($slide_block['image'], [1360, 285], ['contain'], true))->resize()}}">
                        @endif
                    </picture>
                </a>
            </div>
        </section>
    @endif

    @if ($brands?->isNotEmpty())
        <section class="s-line s-index-brands-slider s-items-slider">
            <div class="container pb-60">
                @if(isset($brands_title['title']) && $brands_title['title'])
                    <div class="s-name _h2 bold align-sm-left align-center mb-30">{{ $brands_title['title'] }}</div>
                @endif
                <div class="w-category-list">
                    <div class="owl-carousel owl-brands-list-slider">
                        @foreach ($brands as $brand)
                            <div class="slide">
                                <div class="w-brands-list-item">
                                    <a class="block__link color-black nul">
                                        <picture>
                                            <img src="{{(new zImage($brand->image, [300, 100], ['contain']))->resize()}}" alt="{{ $brand->title}}" title="{{ $brand->title }}" class="img block" loading="lazy">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif


    <section class="s-line s-index-callback-frame">
        <div class="container xl-pt-0 xl-pb-30 md-pt-0 md-pb-0 pt-0 pb-0">
            @include('feedback.call')				
        </div>
    </section>

    @if ($news?->isNotEmpty())
        <section class="s-line s-index-catalog-slider s-items-slider">
            <div class="container pt-30 pb-60">
                <div class="row align-items-end mb-20">
                    <div class="col-sm-auto col-12 mb-5">
                        @if(isset($news_title['title']) && $news_title['title'])
                            <div class="s-name _h2 bold align-center">{{ $news_title['title'] }}</div>
                        @endif
                    </div>
                    <div class="col-sm-auto col-12 mb-10">
                        <div class="_h6 upper align-center">
                            <a href="{{ route('news-list') }}" class="color-orange nul"><span class="dashed dash">посмотреть все</span></a>
                        </div>
                    </div>
                </div>				
                <div class="w-news-list">
                    <div class="owl-carousel owl-news-list-slider">
                        @foreach ($news as $oneNews)
                            <div class="slide">
                                @include('items.news')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection