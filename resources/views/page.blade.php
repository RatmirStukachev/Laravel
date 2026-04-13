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
            <article class="article _h6 ul-checkbox-aside _js-article-fancy-images _js-article-table-mobile-scroll" data-images-fancy="fancy125">
                {!! $page->content !!}
            </article>
            <div class="w-yandex-share pt-30 pb-20">
                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,viber,whatsapp,skype,telegram"></div>
            </div>
        </div>
    </section>
@endsection