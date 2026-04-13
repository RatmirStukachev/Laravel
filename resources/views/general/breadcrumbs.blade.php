@if(isset($breadcrumbs))
    <div class="w-breadcrumbs pt-5 pb-5" itemscope
        itemtype="http://schema.org/BreadcrumbList">
        @foreach($breadcrumbs as $k => $v)
            @if(!$loop->last)
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="@if($k != 'Главная' && substr($v, -1, 1) == '/'){{substr($v, 0, -1)}}@else{{ $v }}@endif"
                        itemprop="item"
                        class="__link">
                        <span itemprop="name">{{ $k }}</span>
                        <meta itemprop="position" content="{{ $loop->iteration }}">
                    </a>
                </span>
                <span class="hr"></span>
            @else
                <span class="page-name"
                        itemprop="itemListElement"
                        itemscope
                        itemtype="http://schema.org/ListItem"
                        itemprop="item">
                        <span itemprop="name">{{ $k }}</span>
                        <meta itemprop="position" content="{{ $loop->iteration }}">
                </span>
            @endif
        @endforeach
        &nbsp;
        @if(auth()->check() && auth()->user()->isAdmin())
            <div style="float: right; padding: 1px 0 2px 1px;">
                <a href="/admin/{{ $page->getTable()}}/{{ $page->id }}/edit" class="__link" target="_blank" style="color: green">Редактировать</a>
            </div>
        @endif
    </div>
@endif
