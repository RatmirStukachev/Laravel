@extends('layouts.main')

@section('content')
    <section class="s-line">
        <div class="container pb-60">	
            <div class="align-center pt-40">
                <div class="w-image number xl-pt-35 pt-20">
                    <img src="{{ asset('assets/i/404-image001.png') }}" alt="">
                </div>
                <div class="w-image title xl-pt-35 pt-20">
                    <img src="{{ asset('assets/i/404-image002.png') }}" alt="">
                </div>
                <div class="w-description _h2 bold xl-pt-35 pt-20">
                    <div>Страница не&nbsp;найдена!</div>
                    <div>Возможно ее&nbsp;больше не&nbsp;существует!</div>
                </div>
                <div class="w-button pt-20">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <a href="{{ route('index') }}" class="button block" style="min-width: 290px;">Вернуться на Главную </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection