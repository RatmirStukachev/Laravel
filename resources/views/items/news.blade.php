<div class="w-news-list-item">
    <a href="{{ route('one-news', ['slug' => $oneNews->slug]) }}" class="block__link color-black nul">
        <div class="frame">
            <div class="w-image">
                <div class="image">
                    <picture>
                        <img src="{{(new zImage($oneNews->image, [544, 272], ['contain']))->resize()}}" alt="slide" title="slide" class="img block" loading="lazy">
                    </picture>
                </div>
            </div>
            <div class="w-bottom">
                @if ($oneNews->formatted_date)
                    <div class="date color-gray">{{ $oneNews->formatted_date }}</div>
                @endif
                @if ($oneNews->title)
                    <div class="name _h6 bold mt-5">{{ $oneNews->title }}</div>
                @endif
                <div class="w-more-link mt-10">
                    <div class="color-orange upper nul"><span class="dashed dash">Подробнее</span></div>
                </div>
            </div>
        </div>
    </a>
</div>