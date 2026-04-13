<footer class="s-footer">
    <div class="footer-middle">
        <div class="container pt-50">
            <div class="row row-footer-middle">
                <div class="col-left col-12 col">
                    <div class="row align-items-center justify-content-md-start justify-content-center">
                        <div class="col-logo col pb-30">
                            <a {{ request()->is('/') ? '' : 'href=/' }}  class="logo__link block__link">
                                <img src="{{ asset('assets/i/perf-by-logo-f.png') }}" alt="" class="img block">
                            </a>
                        </div>
                        <div class="col-nav col pb-30 col-lg-hide">
                            @if (isset($slaveMenuItems) && $slaveMenuItems?->isNotEmpty())
                                <ul class="main-menu row">
                                    @foreach($slaveMenuItems as $menu)  
                                        <li class="col-auto @if(request()->is($menu->slug)) _active @endif"><a href="/{{ $menu->slug }}" class="__link"><span class="dashed dash">{{ $menu->title}}</span></a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    @if (isset($contacts->company_info) && $contacts->company_info)
                        <div class="color-gray footer-law">
                            {!! $contacts->company_info !!}
                        </div>
                    @endif
                </div>
                <div class="col-right col-12 col col-sm-hide">
                    @if (isset($contacts->company_address_pickup_footer) && $contacts->company_address_pickup_footer)
                        <div class="_h6 mb-30">
                            <div>Самовывоз</div>
                            <div>{{ $contacts->company_address_pickup_footer }}</div>
                        </div>
                    @endif
                    @if (isset($contacts->work_time_footer) && $contacts->work_time_footer)
                        <div class="_h6 mb-30">
                            <div>Режим работы самовывоза</div>
                            <div>{{ $contacts->work_time_footer }}</div>
                        </div>
                    @endif
                    @if(isset($contacts->contacts_phones) && count($contacts->contacts_phones) > 0)
                        <div class="_h5 bold mb-20">
                            @foreach($contacts->contacts_phones as $phone)
                                @if ($phone['is_dropdown'] === true)
                                    <div class="mb-10">
                                        <div class="row align-items-center sm-gutters">
                                            @if($phone['phone'])
                                                <div class="col-auto col">
                                                    <a href="{{ zContactsService::getPhoneLink($phone['phone']) }}" class="color-black nul semibold">
                                                        <span class="dashed dash">
                                                            {{ $phone['phone'] }}
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="col-auto col">
                                                <div class="row row-social-icons-list">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container pt-20 pb-40">
            <div class="row row-f-bottom align-items-center justify-content-between">
                <div class="col-md-6 col-12 col col-copy">
                    <div class="row justify-content-md-start justify-content-center">
                        @if (!empty(zText::getSettingValue('content', 'copyright')))
                            <div class="col-auto">
                                <div class="copyright align-md-left align-center pt-20">
                                    &copy; {{ zText::getSettingValue('content', 'copyright') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-12 col col-developer">
                    <div class="row justify-content-md-end justify-content-center">
                        <div class="col-auto">
                            <div class="developer align-md-right align-center pt-20">
                                <div class="w-icon-left">
                                    Разработка сайта <a href="https://zmitroc.by" target="_blank">ZmitroC.by</a>&trade; 
                                    <!-- Developed by <a href="https://zmitroc.dev" target="_blank">ZmitroC.dev</a>&trade; -->
                                    <div class="icon fcm">
                                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg"><path d="M0 0H10V2H8V4H6V2H2V4H0V0Z"/><path d="M4 6V4H6V6H4Z"/><path d="M4 8V6H2V8H0V10H10V6H8V8H4Z"/></svg>
                                        <!-- <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path d="M1 0H0V1H1V0Z"/><path d="M12 0H11V1H12V0Z"/><path d="M3 1H1V2H3V1Z"/><path d="M11 1H9V2H11V1Z"/><path d="M10.9584 5.46361V4.30908H9.91676V3.15453H8.87513V2H7.83352V3.15453H4.16346V2H3.12182V3.15453H2.08022V4.30908H1.04163V5.46361H0V11H1.04163V7.53977H2.08324V11H3.12487V7.53977H4.16651V8.69429H5.20811V9.84885H7.00509V8.69429H7.83654V7.53977H8.87818V11H9.91981V7.53977H10.9614V11H12V5.46361H10.9584ZM8.87818 4.30908V5.46361H7.07513V4.30908H8.87818ZM3.12182 4.30908H4.92487V5.46361H3.12182V4.30908Z"/><path d="M5 11H3V12H5V11Z"/><path d="M9 11H7V12H9V11Z"/></svg> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>