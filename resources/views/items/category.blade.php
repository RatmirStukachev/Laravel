<div class="slide">
    <div class="w-category-list-item">
        <a href="{{ $category->getLink() }}" class="block__link color-black nul">
            <div class="frame">
                <div class="w-title mb-5">
                    <div class="title _h6 semibold">
                        {{ $category->h1 ?: $category->title }}
                    </div>
                </div>
                <div class="w-image">
                    <div class="image">
                        <picture>
                            <img src="{{(new zImage($category->image, [204, 136], ['contain']))->resize()}}" alt="{{ $category->title }}" title="{{ $category->title }}" class="img block" loading="lazy">
                        </picture>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>