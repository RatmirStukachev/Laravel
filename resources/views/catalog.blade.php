@extends('layouts.main')

@section('content')
    <section class="s-line s-page-branding md-pt-20 pt-10">
        <div class="container">
            <div class="w-breadcrumbs-mobile-scroll-shadow pb-10">
                @include('general.breadcrumbs')
            </div>
            <h1 class="_h1 pagetitle bold mb-20">{{ $page->h1 ?: $page->title }}</h1>
        </div>
    </section>

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
    @if(!request()->has('page') || request()->input('page') <= 1)
        <div class="seo-content container pb-20 pt-20">
            @include('seo.content')
        </div>
    @endif
@endsection