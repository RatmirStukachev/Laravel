**Инструкция по доработке выбора категории товара в админке**

Чтобы в админке (в Filament) в поле «Категория» можно было выбирать как активные, так и системные (неактивные) категории, не затрагивая при этом логику отображения категорий на сайте, нужно добавить новый метод для получения полного дерева категорий и использовать его только в форме товара.

**Шаг 1. Откройте файл модели категорий**
Откройте файл `app/Models/Category.php`.

**Шаг 2. Добавьте новую связь для получения всех дочерних элементов**
В классе `Category` (примерно после метода `child()`, который находится на строке 109) добавьте новый метод `childAll()`. Он нужен для того, чтобы подтягивать все категории без фильтрации по активности.

Добавьте этот код:
```php
    public function childAll(): hasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderByPos();
    }
```

**Шаг 3. Добавьте метод для получения полного дерева категорий**
В этом же файле `app/Models/Category.php` спуститесь в самый низ, где находятся методы `getCategoryTree` и `getProductCategoryTree` (примерно на строке 252). Сразу после метода `getProductCategoryTree()` (или перед ним) добавьте новый метод `getAllProductCategoryTree()`.

В этом методе мы используем только что созданную связь `childAll`, чтобы загрузить все категории, включая неактивные, и добавляем пометку "[Системная]" к неактивным категориям, чтобы их было проще отличить в выпадающем списке.

Добавьте этот код:
```php
    public static function getAllProductCategoryTree(): array
    {
        $categories = self::query()
            ->where('level', 1)
            ->with(['childAll', 'childAll.childAll'])
            ->orderBy('pos')
            ->get();

        $options = [];

        foreach ($categories as $category) {
            $title = $category->title . (! $category->is_active ? ' [Системная]' : '');
            $options[$category->id] = $title;

            foreach ($category->childAll as $childCategory) {
                $childTitle = $childCategory->title . (! $childCategory->is_active ? ' [Системная]' : '');
                $options[$childCategory->id] = '⤷ '.$childTitle;

                foreach ($childCategory->childAll as $grandChildCategory) {
                    $grandChildTitle = $grandChildCategory->title . (! $grandChildCategory->is_active ? ' [Системная]' : '');
                    $options[$grandChildCategory->id] = ' ⤷⤷ '.$grandChildTitle;
                }
            }
        }

        return $options;
    }
```
Сохраните файл `app/Models/Category.php`.

**Шаг 4. Измените форму создания и редактирования товара**
Откройте файл `app/Filament/Resources/ProductResource.php`.

Найдите блок кода для поля `category_id` в методе `form` (примерно на строках 74-85). Он выглядит так:
```php
                                           Forms\Components\Select::make('category_id')
                                                ->label('Категория')
                                                ->options(Category::getProductCategoryTree())
                                                ->optionsLimit(500)
                                                ->required()
                                                ->getSearchResultsUsing(function (string $search) {
                                                    // Фильтруем категории по поисковому запросу
                                                    return collect(Category::getProductCategoryTree())
                                                        ->filter(function ($categoryName) use ($search) {
                                                            return mb_stripos($categoryName, $search) !== false;
                                                        })
                                                        ->toArray();
                                                })
```

Замените в нем `getProductCategoryTree()` на `getAllProductCategoryTree()`. Должно получиться так:
```php
                                           Forms\Components\Select::make('category_id')
                                                ->label('Категория')
                                                ->options(Category::getAllProductCategoryTree())
                                                ->optionsLimit(500)
                                                ->required()
                                                ->getSearchResultsUsing(function (string $search) {
                                                    // Фильтруем категории по поисковому запросу
                                                    return collect(Category::getAllProductCategoryTree())
                                                        ->filter(function ($categoryName) use ($search) {
                                                            return mb_stripos($categoryName, $search) !== false;
                                                        })
                                                        ->toArray();
                                                })
```

**Шаг 5 (Опционально). Фильтр в таблице товаров**
Если вы хотите, чтобы в таблице списка товаров (в фильтре) тоже отображались системные категории, найдите в `app/Filament/Resources/ProductResource.php` метод `table`, блок `filters` (строка 213):
```php
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                ->label('Категория')
                ->options(function() {
                    $categoryTree = Category::getProductCategoryTree();

                    return $categoryTree;
                })
```

Также замените `getProductCategoryTree()` на `getAllProductCategoryTree()`:
```php
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                ->label('Категория')
                ->options(function() {
                    $categoryTree = Category::getAllProductCategoryTree();

                    return $categoryTree;
                })
```
Сохраните файл `app/Filament/Resources/ProductResource.php`.

Готово! После этих изменений при добавлении товара вручную в выпадающем списке категорий будут доступны все категории (как активные, так и системные с пометкой `[Системная]`).
