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
        <div class="container pb-30">	
            <div class="row row-contacts-page-contacts-list justify-content-between sm-gutters pt-20">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-7 col-12 col pb-15 order-lg-1 order-1">
                    <div class="mb-20">
                        @if (isset($contacts->contacts_phones) && count($contacts->contacts_phones) > 0)
                            <div class="mb-10 semibold color-orange">Телефоны</div>
                        @endif
                        @if (isset($contacts->contacts_phones) && count($contacts->contacts_phones) > 0)
                            @foreach($contacts->contacts_phones as $phone)
                                <div class="row sm-gutters align-items-center mt-5">
                                    @if($phone['phone'])
                                        <div class="col-auto _h6 bold col">
                                            <a href="{{ zContactsService::getPhoneLink($phone['phone']) }}" class="block nul color-black"><span class="dashed dash">{{ $phone['phone'] }}</span></a>
                                        </div>
                                        @if($phone['is_viber'] === true)
                                            <div class="col-auto col">
                                                <a href="{{ zContactsService::getPhoneViberLink($phone['phone']) }}" class="social-colored-icon__link colored vi" target="_blank" rel="nofollow">
                                                    <svg x="0" y="0" viewBox="0 0 100 100"><path d="m58 10h-16c-15.4 0-28 12.6-28 28v12c0 10.8 6.3 20.7 16 25.3v13.4c0 1.2 1.5 1.8 2.3.9l11.6-11.6h14.1c15.4 0 28-12.6 28-28v-12c0-15.4-12.6-28-28-28zm10.5 52.5-4.1 4c-4.3 4.2-15.4-.6-25.2-10.6s-14.1-21.2-10-25.4l4-4c1.5-1.5 4-1.4 5.7.1l5.8 6c2.1 2.1 1.2 5.7-1.5 6.5-1.9.6-3.2 2.7-2.6 4.6 1 4.4 6.6 10 10.8 11.1 1.9.4 4-.6 4.7-2.5.9-2.7 4.5-3.5 6.5-1.4l5.8 6c1.6 1.4 1.6 3.9.1 5.6zm-14.9-33.5c-.4 0-.8 0-1.2.1-.7.1-1.4-.5-1.5-1.2s.5-1.4 1.2-1.5c.5-.1 1-.1 1.5-.1 7.3 0 13.3 6 13.3 13.3 0 .5 0 1-.1 1.5-.1.7-.8 1.3-1.5 1.2s-1.3-.8-1.2-1.5c0-.4.1-.8.1-1.2.1-5.8-4.7-10.6-10.6-10.6zm8 10.7c0 .7-.6 1.3-1.3 1.3s-1.3-.6-1.3-1.3c0-2.9-2.4-5.3-5.3-5.3-.7 0-1.3-.6-1.3-1.3s.6-1.3 1.3-1.3c4.3-.1 7.9 3.5 7.9 7.9zm10.2 4.3c-.2.7-.9 1.2-1.7 1-.7-.2-1.1-.9-.9-1.6.3-1.2.4-2.4.4-3.7 0-8.8-7.2-16-16-16-.4 0-.8 0-1.2 0-.7 0-1.4-.5-1.4-1.2s.5-1.4 1.2-1.4c.5 0 1-.1 1.4-.1 10.3 0 18.7 8.4 18.7 18.7 0 1.4-.2 2.9-.5 4.3z"></path></svg>
                                                </a>
                                            </div>			
                                        @endif
                                        @if($phone['is_whatsapp'] === true)
                                            <div class="col-auto col">
                                                <a href="{{ zContactsService::getPhoneWhatsappLink($phone['phone']) }}" class="social-colored-icon__link colored wh" target="_blank" rel="nofollow">
                                                    <svg viewBox="0 0 14 15">
                                                        <path d="M11.9512 2.70841C10.6341 1.39591 8.87805 0.666748 7.02439 0.666748C3.17073 0.666748 0.0487797 3.77786 0.0487797 7.61814C0.0487797 8.83342 0.390244 10.0487 0.97561 11.0695L0 14.6667L3.70732 13.6945C4.73171 14.2292 5.85366 14.5209 7.02439 14.5209C10.878 14.5209 14 11.4098 14 7.56953C13.9512 5.77092 13.2683 4.02091 11.9512 2.70841ZM10.3902 10.0973C10.2439 10.4862 9.56097 10.8751 9.21951 10.9237C8.92683 10.9723 8.53659 10.9723 8.14634 10.8751C7.90244 10.7779 7.56098 10.6806 7.17073 10.4862C5.41463 9.75703 4.29268 8.00703 4.19512 7.86119C4.09756 7.76397 3.46342 6.93758 3.46342 6.06258C3.46342 5.18758 3.90244 4.79869 4.04878 4.60425C4.19512 4.4098 4.39024 4.4098 4.53658 4.4098C4.63415 4.4098 4.78049 4.4098 4.87805 4.4098C4.97561 4.4098 5.12195 4.36119 5.26829 4.70147C5.41463 5.04175 5.7561 5.91675 5.80488 5.96536C5.85366 6.06258 5.85366 6.1598 5.80488 6.25703C5.7561 6.35425 5.70731 6.45147 5.60975 6.54869C5.51219 6.64591 5.41463 6.79175 5.36585 6.84036C5.26829 6.93758 5.17073 7.0348 5.26829 7.18064C5.36585 7.37508 5.70732 7.9098 6.2439 8.39591C6.92683 8.97925 7.46341 9.17369 7.65854 9.27092C7.85366 9.36814 7.95122 9.31953 8.04878 9.2223C8.14634 9.12508 8.48781 8.73619 8.58537 8.54175C8.68293 8.3473 8.82927 8.39592 8.97561 8.44453C9.12195 8.49314 10 8.93064 10.1463 9.02786C10.3415 9.12508 10.439 9.17369 10.4878 9.2223C10.5366 9.36814 10.5366 9.70841 10.3902 10.0973Z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        @if($phone['is_telegram'] === true)
                                            <div class="col-auto col">
                                                <a href="{{ zContactsService::getTelegramLinkViaPhone($phone['phone']) }}" class="social-colored-icon__link colored tg" target="_blank" rel="nofollow">
                                                    <svg viewBox="0 0 14 13">
                                                        <path d="M14 0.847309L11.7855 12.4084C11.7855 12.4084 11.4756 13.21 10.6244 12.8255L5.51495 8.76862L5.49126 8.75667C6.18143 8.11491 11.5333 3.13184 11.7673 2.90597C12.1294 2.55615 11.9046 2.34789 11.4841 2.61214L3.57869 7.81102L0.528786 6.74834C0.528786 6.74834 0.0488212 6.57154 0.00264736 6.18712C-0.044134 5.80206 0.544582 5.5938 0.544582 5.5938L12.9781 0.542789C12.9781 0.542789 14 0.0778286 14 0.847309Z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <div class="col-xl-3 col-lg-5 col-md-12 col-12 col pb-15 order-lg-2 order-3">
                    @if (isset($contacts->company_address) && $contacts->company_address)
                        <div class="mb-20">
                            <div class="mb-10 semibold color-orange">Адрес</div> 
                            <div class="_h6 semibold mb-10">{{ $contacts->company_address }}</div>
                        </div>
                    @endif
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-5 col-12 col pb-15 order-lg-3 order-2">
                    @if (isset($contacts->contacts_emails) && count($contacts->contacts_emails) > 0)
                        <div class="mb-20">
                            <div class="mb-10 semibold color-orange">E-mail</div>
                            @foreach($contacts->contacts_emails as $mail)
                                <div class="_h6 mt-5"><a href="{{ zContactsService::getEmailLink($mail['email']) }}" class="color-orange semibold nul"><span class="dashed dash">{{ $mail['email'] }}</span></a></div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-20 col-lg-show">
                        @if (isset($contacts->instagram) && $contacts->instagram)
                            <div class="mb-10 color-orange">Мы в соц. сетях</div>
                        @endif
                        @if (isset($contacts->instagram) && $contacts->instagram)
                            <div class="row sm-gutters mt-5">
                                <div class="col-auto">                                
                                    <a href="{{ zContactsService::getInstagramLink($contacts->instagram) }}" class="white-social-icon__link gray fcm">
                                        <img src="{{ asset('assets/i/ig-colored-icon.svg') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-5 col-xxs-5 col-12 col pb-15 col-lg-hide order-lg-4 order-4">
                    <div class="mb-20">
                        @if (isset($contacts->instagram) && $contacts->instagram)
                            <div class="mb-10 semibold color-orange">Мы в соц. сетях</div>
                        @endif
                        @if (isset($contacts->instagram) && $contacts->instagram)
                            <div class="row sm-gutters mt-5">
                                <div class="col-auto">
                                    <a href="{{ zContactsService::getInstagramLink($contacts->instagram) }}" class="white-social-icon__link gray fcm">
                                        <img src="{{ asset('assets/i/ig-colored-icon.svg') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 order-5">
                    @if (isset($contacts->company_creds) && $contacts->company_creds)
                        <div class="mb-20">
                            <div class="mb-10 semibold color-orange">Реквизиты</div>
                            <div class="_h6 semibold mb-10">{!! $contacts->company_creds !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="s-line s-contacts-map">
        <div class="container">
            @if (isset($contacts->coords) && $contacts->coords)
                <script> 
                    var coordsMap = "{!! $contacts->coords !!}"; 
                    var coodsAddress = "{!! $contacts->coords_name !!}";
                </script>
            @endif
            <div class="bordered-map">
                <div id="map" class="ymap"></div>
            </div>
        </div>
    </section>

    <section class="s-line s-index-callback-frame">
        <div class="container xl-pt-0 xl-pb-30 md-pt-0 md-pb-0 pt-0 pb-0">
            @include('feedback.call')
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/map.js') }}"></script>
@endsection

@section('schema_org')
    <script type="application/ld+json">
        {
          "@@context": "http://schema.org",
          "@@type": "Organization",
          "name": "{{ env('APP_NAME') }}",
          "url": "{{ env('APP_URL') }}",
          "logo": "{{ asset('assets/i/perf-by-logo.png') }}",
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ $contacts->company_address }}",
            "addressLocality": "Минск",
            "addressCountry": "Беларусь"
          },
          "contactPoint": [{
            "@@type" : "ContactPoint",
            "telephone": "{{ isset($contacts->contacts_phones[0]['phone'] )
                ? $contacts->contacts_phones[0]['phone'] 
                : '' 
            }}"
          }]
        }
    </script>
@endsection