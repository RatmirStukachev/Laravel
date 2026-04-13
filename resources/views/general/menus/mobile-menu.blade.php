<section class="s-mobile-menu _js-s-toggle-mobile-menu">
    <div class="w-mobile-menu">
        <div class="mobile-menu-header">
            <div class="row sm-gutters align-items-center">
                <div class="col-auto">
                    <div class="upper">Меню</div>
                </div>
                <div class="col-auto">
                    <div class="burger">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            <a href="" class="close white _js-b-toggle-mobile-menu"></a>
        </div>
        <div class="mobile-menu-body">
            <div class="w-mobile-menu-group-list">
                <div class="w-mobile-menu-group-list-item">
                    <div class="w-mobile-menu-offset-item pt-10">
                        <a href="{{ route('catalog.index') }}" class="button header-catalog-btn row align-items-center justify-content-center sm-gutters">
                            <div class="col-auto col">
                                <div class="burger white">
                                    <div class="line"></div>
                                    <div class="line"></div>
                                    <div class="line"></div>
                                </div>
                            </div>
                            <div class="col-auto col">Каталог</div>
                        </a>
                    </div>
                    @if (isset($menuCategories) && $menuCategories?->isNotEmpty())
                        <ul class="ul-mobile-menu default mt-10">
                            @foreach ($menuCategories as $category)
                                <li class="li-mobile-menu li-dropper _js-li-dropper @if ((request()->route('category')?->id == $category->id) || (request()->route('parent')?->id == $category->id)) _active @endif">
                                    <div class="w-relative-b-dropper">
                                        <a href="{{ $category->getLink() }}" class="mobile-menu__link">{{ $category->h1 ?: $category->title }}</a>
                                        @if ($category->hasChildren())
                                            <div class="b-dropper-overlay wide _js-b-dropper @if ((request()->route('category')?->id == $category->id) || (request()->route('parent')?->id == $category->id)) _toggled @endif"></div>
                                            <div class="b-dropper @if ((request()->route('category')?->id == $category->id) || (request()->route('parent')?->id == $category->id)) _toggled @endif"></div>
                                        @endif
                                    </div>
                                    <div class="inset _js-inset" @if ((request()->route('category')?->id == $category->id) || (request()->route('parent')?->id == $category->id)) style="display: block;" @endif">
                                        <ul class="ul-inset">
                                            @foreach ($category->children as $child)
                                                <li class="li-mobile-menu @if (request()->route('category')?->id == $child->id) _active @endif">
                                                    <a href="{{ $child->getLink() }}" class="mobile-menu__link">{{ $child->h1 ?: $child->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="mt-10">
                        <hr>
                    </div>
                    @if ((isset($mainMenuItems) && $mainMenuItems?->isNotEmpty()) || (isset($menuCategories) && $menuCategories?->isNotEmpty()))
                        <ul class="ul-mobile-menu default mt-10">
                            @foreach ($mainMenuItems as $menu)
                                <li class="li-mobile-menu @if(request()->is($menu->slug)) _active @endif"><a href="/{{ $menu->slug }}" class="mobile-menu__link">{{ $menu->title }}</a></li>
                            @endforeach
                            @foreach ($menuCategories as $category)
                                <li class="li-mobile-menu @if(request()->route('category')?->id == $category->id) _active @endif"><a href="{{ $category->getLink() }}" class="mobile-menu__link">{{ $category->h1 ?: $category->title }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="w-mobile-menu-group-list-item mt-20">
                    <div class="w-mobile-menu-offset-item">
                        @if(isset($contacts->company_address_pickup_header) && $contacts->company_address_pickup_header)
                            <div class="pb-10">
                                <div class="w-icon-left location">
                                    <div class="icon top"><svg viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 12.3498L5.98675 12.8087C5.92287 12.8693 5.84696 12.9174 5.76338 12.9503C5.67979 12.9831 5.59017 13 5.49966 13C5.40914 13 5.31952 12.9831 5.23594 12.9503C5.15235 12.9174 5.07644 12.8693 5.01256 12.8087L5.00844 12.8042L4.99675 12.7931L4.95413 12.7522C4.71177 12.5161 4.47341 12.2765 4.23913 12.0333C3.6509 11.4239 3.08765 10.7934 2.55063 10.1431C1.93738 9.39561 1.31037 8.55063 0.833937 7.71604C0.367812 6.8977 0 6.01111 0 5.19992C0 2.24962 2.4695 0 5.5 0C8.5305 0 11 2.24962 11 5.19992C11 6.01111 10.6322 6.8977 10.1661 7.71539C9.68963 8.55128 9.06331 9.39561 8.44938 10.1431C7.6982 11.0528 6.89588 11.9238 6.04587 12.7522L6.00325 12.7931L5.99156 12.8042L5.98744 12.8081L5.5 12.3498ZM5.5 7.1499C6.04701 7.1499 6.57161 6.94445 6.95841 6.57876C7.3452 6.21307 7.5625 5.71709 7.5625 5.19992C7.5625 4.68276 7.3452 4.18678 6.95841 3.82109C6.57161 3.4554 6.04701 3.24995 5.5 3.24995C4.95299 3.24995 4.42839 3.4554 4.04159 3.82109C3.6548 4.18678 3.4375 4.68276 3.4375 5.19992C3.4375 5.71709 3.6548 6.21307 4.04159 6.57876C4.42839 6.94445 4.95299 7.1499 5.5 7.1499Z" fill="#FF5F00"></path></svg></div>
                                    <div class="text">Самовывоз: {{ $contacts->company_address_pickup_header }} </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($contacts->work_time_header) && $contacts->work_time_header)
                            <div class="pb-10">
                                <div class="w-icon-left time">
                                    <div class="icon top"><svg viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 0C5.64641 0 4.80117 0.168127 4.01256 0.494783C3.22394 0.821439 2.50739 1.30023 1.90381 1.90381C0.684819 3.12279 0 4.77609 0 6.5C0 8.22391 0.684819 9.87721 1.90381 11.0962C2.50739 11.6998 3.22394 12.1786 4.01256 12.5052C4.80117 12.8319 5.64641 13 6.5 13C8.22391 13 9.87721 12.3152 11.0962 11.0962C12.3152 9.87721 13 8.22391 13 6.5C13 5.64641 12.8319 4.80117 12.5052 4.01256C12.1786 3.22394 11.6998 2.50739 11.0962 1.90381C10.4926 1.30023 9.77606 0.821439 8.98744 0.494783C8.19883 0.168127 7.35359 0 6.5 0ZM9.23 9.23L5.85 7.15V3.25H6.825V6.63L9.75 8.385L9.23 9.23Z" fill="#FF5F00"></path></svg></div>
                                    <div class="text">{{ $contacts->work_time_header }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="mobile-menu-background _js-b-toggle-mobile-menu"></div>
</section>