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

    <section class="s-line">
        <div class="container pb-60">
            @if ($news?->isNotEmpty())	
                <div class="w-news-list">
                    <div class="row row-news-list lg-md-gutters sm-gutters">
                        @foreach ($news as $oneNews)
                            <div class="col-xxl-3 col-xl-4 col-md-4 col-xxs-6 col-12 col md-mb-20 mb-10">
                                @include('items.news')
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($news && $news->isNotEmpty())
                {{ $news->appends(request()->query())->onEachSide(1)->links('vendor.pagination') }}
            @endif
        </div>
        @if(!request()->has('page') || request()->input('page') <= 1)
            <div class="seo-content container pb-20 pt-20">
                @include('seo.content')
            </div>
        @endif
    </section>
@endsection