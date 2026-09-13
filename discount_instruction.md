# Инструкция по созданию системы массовых скидок в Laravel + Filament

Данная инструкция описывает процесс создания функционала для массового применения скидок на товары в зависимости от их текущей цены и выбранных брендов.

## Шаг 1. Создание миграций и моделей

Нам потребуется таблица для хранения правил скидок и связующая таблица для связи скидок с брендами.

Выполните команду в терминале:
```bash
php artisan make:model Discount -m
```

### 1.1 Миграция для таблицы discounts
Откройте созданный файл миграции `database/migrations/xxxx_xx_xx_xxxxxx_create_discounts_table.php` и приведите метод `up` к следующему виду:

```php
public function up(): void
{
    Schema::create('discounts', function (Blueprint $table) {
        $table->id();
        $table->decimal('price_from', 10, 2)->default(0)->comment('Цена от');
        $table->decimal('price_to', 10, 2)->nullable()->comment('Цена до (null = бесконечность)');
        $table->integer('percent')->comment('Процент скидки');
        $table->boolean('is_active')->default(false)->comment('Статус активности');
        $table->timestamps();
    });

    Schema::create('brand_discount', function (Blueprint $table) {
        $table->id();
        $table->foreignId('discount_id')->constrained()->cascadeOnDelete();
        $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
    });
}
```

Выполните миграцию:
```bash
php artisan migrate
```

### 1.2 Модель Discount
Откройте `app/Models/Discount.php` и добавьте связи и необходимые свойства:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }
}
```

---

## Шаг 2. Логика применения и отмены скидок (Observer)

Лучше всего вынести логику пересчета цен в Observer, чтобы скидки применялись автоматически при сохранении правила в админке.

Создайте Observer:
```bash
php artisan make:observer DiscountObserver --model=Discount
```

Откройте `app/Observers/DiscountObserver.php` и добавьте код:

```php
<?php

namespace App\Observers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DiscountObserver
{
    /**
     * Вызывается ПОСЛЕ сохранения скидки (создание или обновление).
     * Важно: если скидка меняет статус активности, мы должны пересчитать цены.
     */
    public function saved(Discount $discount): void
    {
        // При создании/обновлении нам нужно переприменить логику только если скидка активна.
        // Но так как бренды привязываются после создания модели (sync),
        // лучше вызывать применение скидки непосредственно из Filament после сохранения формы.
        // Смотрите Шаг 3 (после сохранения записи).
    }

    /**
     * Если скидку удаляют, нужно откатить изменения цен.
     */
    public function deleting(Discount $discount): void
    {
        if ($discount->is_active) {
            $this->revertDiscount($discount);
        }
    }

    /**
     * Метод для применения скидки.
     */
    public static function applyDiscount(Discount $discount): void
    {
        $brandIds = $discount->brands()->pluck('brands.id')->toArray();
        if (empty($brandIds)) return;

        $query = Product::whereIn('brand_id', $brandIds)
            ->where('price', '>=', $discount->price_from);

        if (!is_null($discount->price_to)) {
            $query->where('price', '<=', $discount->price_to);
        }

        $products = $query->get();

        DB::transaction(function () use ($products, $discount) {
            foreach ($products as $product) {
                // Записываем текущую цену в old_price, а price пересчитываем со скидкой
                $currentPrice = $product->price;
                $discountAmount = $currentPrice * ($discount->percent / 100);
                $newPrice = $currentPrice - $discountAmount;

                $product->update([
                    'old_price' => $currentPrice,
                    'price' => $newPrice
                ]);
            }
        });
    }

    /**
     * Метод для отмены скидки.
     */
    public static function revertDiscount(Discount $discount): void
    {
        // Для отмены нужно найти все товары выбранных брендов, у которых есть old_price.
        // И вернуть им эту old_price в price, а old_price обнулить.
        $brandIds = $discount->brands()->pluck('brands.id')->toArray();
        if (empty($brandIds)) return;

        $products = Product::whereIn('brand_id', $brandIds)
            ->whereNotNull('old_price')
            ->where('old_price', '>', 0)
            ->get();

        DB::transaction(function () use ($products) {
            foreach ($products as $product) {
                $product->update([
                    'price' => $product->old_price,
                    'old_price' => null
                ]);
            }
        });
    }
}
```

Не забудьте зарегистрировать Observer в `app/Providers/AppServiceProvider.php` в методе `boot`:
```php
use App\Models\Discount;
use App\Observers\DiscountObserver;

public function boot(): void
{
    Discount::observe(DiscountObserver::class);
}
```

---

## Шаг 3. Создание Filament Resource для управления скидками

Создайте ресурс:
```bash
php artisan make:filament-resource Discount
```

Откройте `app/Filament/Resources/DiscountResource.php` и настройте его:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Observers\DiscountObserver;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Скидки';
    protected static ?string $pluralLabel = 'Скидки';
    protected static ?string $modelLabel = 'Скидка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Настройки скидки')
                    ->schema([
                        Forms\Components\TextInput::make('price_from')
                            ->label('Цена от (руб.)')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\TextInput::make('price_to')
                            ->label('Цена до (руб.)')
                            ->numeric()
                            ->helperText('Оставьте пустым, если до бесконечности')
                            ->nullable(),

                        Forms\Components\TextInput::make('percent')
                            ->label('Скидка (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(99)
                            ->required(),

                        Forms\Components\Select::make('brands')
                            ->label('Бренды')
                            ->relationship('brands', 'title')
                            ->multiple()
                            ->preload()
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Включить скидку?')
                            ->default(false),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('price_from')
                    ->label('Цена от')
                    ->money('RUB'),
                Tables\Columns\TextColumn::make('price_to')
                    ->label('Цена до')
                    ->money('RUB')
                    ->placeholder('Бесконечность'),
                Tables\Columns\TextColumn::make('percent')
                    ->label('Скидка')
                    ->suffix('%'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Активность')
                    // Перехватываем изменение тогла в таблице
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                            DiscountObserver::applyDiscount($record);
                        } else {
                            DiscountObserver::revertDiscount($record);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
```

### 3.1 Перехват сохранения при Создании и Редактировании

Так как связи многие-ко-многим (brands) сохраняются *после* самой модели, логику применения скидок при сохранении формы лучше вынести в классы Pages.

Откройте `app/Filament/Resources/DiscountResource/Pages/CreateDiscount.php`:
```php
<?php

namespace App\Filament\Resources\DiscountResource\Pages;

use App\Filament\Resources\DiscountResource;
use Filament\Resources\Pages\CreateRecord;
use App\Observers\DiscountObserver;

class CreateDiscount extends CreateRecord
{
    protected static string $resource = DiscountResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->is_active) {
            DiscountObserver::applyDiscount($this->record);
        }
    }
}
```

Откройте `app/Filament/Resources/DiscountResource/Pages/EditDiscount.php`:
```php
<?php

namespace App\Filament\Resources\DiscountResource\Pages;

use App\Filament\Resources\DiscountResource;
use Filament\Resources\Pages\EditRecord;
use App\Observers\DiscountObserver;

class EditDiscount extends EditRecord
{
    protected static string $resource = DiscountResource::class;

    protected function beforeSave(): void
    {
        // Перед сохранением проверяем старое состояние активности
        $this->oldState = $this->record->is_active;
    }

    protected function afterSave(): void
    {
        $newState = $this->record->is_active;

        if (!$this->oldState && $newState) {
            // Если включили
            DiscountObserver::applyDiscount($this->record);
        } elseif ($this->oldState && !$newState) {
            // Если выключили
            DiscountObserver::revertDiscount($this->record);
        } elseif ($this->oldState && $newState) {
            // Если отредактировали, но она осталась активной - лучше сначала откатить старую скидку, а потом применить новую
            // Это сложный кейс, поэтому в идеале лучше выключать скидку перед редактированием параметров,
            // но можно сделать так (опционально):
            // DiscountObserver::revertDiscount($this->record);
            // DiscountObserver::applyDiscount($this->record);
        }
    }
}
```

## Как это работает:
1. Вы заходите в админку, раздел "Скидки" (Discounts).
2. Нажимаете "Создать". Вводите цену от `0`, цену до оставляете пустой (или вводите `1000`).
3. Указываете `7`% и выбираете бренды.
4. Включаете тумблер `Включить скидку`. При сохранении запустится код, который пройдет по товарам выбранных брендов с ценой в вашем диапазоне, запишет их текущую цену в `old_price` и установит новую `price` со скидкой 7%.
5. Если вы позже выключите скидку через тумблер (в таблице или в редактировании), система найдет товары этих брендов с заполненным `old_price`, вернет это значение в `price` и очистит `old_price`.
