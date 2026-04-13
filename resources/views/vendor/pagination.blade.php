@if ($paginator->hasPages())
    <div class="w-pagination md-mt-20 mt-30">
        <div class="row sm-gutters justify-content-center align-items-center">
            @if ($paginator->previousPageUrl())
                <div class="col-sm-auto col">
                    <span class="_arrow _prev"><a
                            href="@if ($paginator->currentPage() == 2){{str_replace(['?page=1', '&page=1'],'',$paginator->previousPageUrl())}} @else {{ $paginator->previousPageUrl() }} @endif"
                            class="link w-arrow prev"><div class="_arrow _prev"></div></a></span>
                </div>
            @endif
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <div class="col-sm-auto col">
                        <a href="" class="link">...</a>
                    </div>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <div class="col-sm-auto col">
                                <a class="link _active">{{ $page }}</a>
                            </div>
                        @else
                            <div class="col-sm-auto col">
                                <a href="@if($page == 1){{str_replace(['?page=1', '&page=1'],'',$url)}}@else{{$url}}@endif"
                                   class="link" @if($page >= 2) rel="canonical" @endif>{{ $page }}</a>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <div class="col-sm-auto col">
                    <span class="_arrow _next">
                        <a href="{{ $paginator->nextPageUrl() }}" class="link w-arrow next" @if($paginator->currentPage() >= 1) rel="canonical" @endif>
                            <div class="_arrow _next"></div>
                        </a>
                    </span>
                </div>
            @endif
        </div>
    </div>
@endif
