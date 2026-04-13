<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProductResource extends Resource
{
    const NAME = 'Товары';
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Товар';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Tabs::make('Content')
                            ->tabs([
                                Tab::make('Основные')
                                    ->schema([
                                        Forms\Components\Section::make('')->schema([
                                            Forms\Components\TextInput::make('title')
                                                ->label('Название')
                                                ->lazy()
                                                ->afterStateUpdated(function ($state, callable $set, $livewire) {
                                                    if (!$livewire->getRecord() || empty($livewire->data['slug'])) {
                                                        $set('slug', Str::slug($state));
                                                    }
                                                })
                                                ->maxLength(255)
                                                ->required(),
                                            Forms\Components\TextInput::make('slug')
                                                ->label('Ссылка')
                                                ->unique(ignorable: fn ($record) => $record)
                                                ->validationMessages([
                                                    'unique' => 'Slug должен быть уникальным',
                                                ])
                                                ->maxLength(255)
                                                ->required(),
                                        ])->columns(),
                                        Section::make('')->schema([
                                            Forms\Components\TextInput::make('article')
                                                ->label('Артикул'),
                                            Forms\Components\TextInput::make('balance')
                                                ->required()
                                                ->label('Остаток товара'),
                                        ])->columns(2),
                                        Forms\Components\TextInput::make('h1')
                                            ->columnSpanFull()
                                            ->label('H1'),
                                        Forms\Components\Section::make('')->schema([
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
                                                ->searchable(),
                                           Forms\Components\Select::make('brand_id')
                                                ->label('Бренд')
                                                ->relationship('brand', 'title')
                                                ->required()
                                                ->preload()
                                                ->searchable(),
                                        ])->columns(2),
                                        Forms\Components\Section::make('Цены')->schema([
                                            Forms\Components\TextInput::make('price')
                                                ->required()
                                                ->label('Цена'),
                                            Forms\Components\TextInput::make('old_price')
                                                ->label('Старая цена'),
                                        ])->columns(2),
                                        FileUpload::make('image')
                                            ->label('Главное изображение (435x435)')
                                            ->image()
                                            ->columnSpanFull()
                                            ->directory('products'),
                                        Forms\Components\TextInput::make('pos')
                                            ->label('Позиция (Опционально)')
                                            ->columnSpanFull()
                                            ->default(1000),
                                        Section::make('')->schema([
                                            Forms\Components\Checkbox::make('is_active')
                                                ->label('Активно'),
                                            Forms\Components\Checkbox::make('is_new')
                                                ->label('Новинка'),
                                            Forms\Components\Checkbox::make('is_hit')
                                                ->label('Хит'),
                                            ])->columnSpan(4),
                                        Section::make('')->schema([
                                            Forms\Components\TextInput::make('zoomos_id')
                                                ->label('Zoomos ID'),
                                        ]),
                                        
                                    ]),
                                Tab::make('Подробное описание')
                                    ->schema([
                                        TinyEditor::make('desc')
                                            ->label('Описание товара')
                                            ->columnSpanFull(),
                                        TinyEditor::make('content')
                                            ->label('Контент')
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Доп Изображения')
                                    ->schema([
                                        FileUpload::make('add_images')
                                        ->label('Изображение(435x435)')
                                        ->multiple()
                                        ->image()
                                        ->reorderable()
                                        ->columnSpanFull()
                                        ->directory('products'),
                                    ]),
                                Tab::make('Похожие товары')
                                    ->schema([
                                        Forms\Components\Section::make('')
                                            ->schema([
                                                Forms\Components\Select::make('similars')
                                                    ->label('Похожие товары')
                                                    ->multiple()
                                                    ->relationship('similars', 'title')
                                                    ->getSearchResultsUsing(function (string $search, $get) {
                                                        return Product::query()
                                                            ->where('is_active', true)
                                                            ->where('id', '!=', $get('id'))
                                                            ->where(function ($query) use ($search) {
                                                                $query->where('title', 'like', "%{$search}%")
                                                                    ->orWhere('h1', 'like', "%{$search}%")
                                                                    ->orWhere('article', '=', "$search");
                                                            })
                                                            ->limit(15)
                                                            ->pluck('title', 'id')
                                                            ->toArray();
                                                    })
                                                    ->helperText('Поиск по названию, артикулу и коду товара')
                                                    ->columnSpanFull()
                                            ]),
                                    ]),
                                Tab::make('SEO')
                                    ->schema([
                                        Forms\Components\Section::make('SEO')
                                            ->schema([
                                                Forms\Components\Textarea::make('title')->label('Title'),
                                                Forms\Components\Textarea::make('description')->label('Description'),
                                            ])->relationship('seo'),
                                    ]),
                            ]),
                    ])->columnSpan(['lg' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->wrap()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('article')
                    ->searchable()
                    ->label('Код товара'),
                Tables\Columns\TextColumn::make('category.title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Категория'),
                Tables\Columns\TextColumn::make('brand.title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Бренд'),
                Tables\Columns\CheckboxColumn::make('is_popular')
                    ->label('Популярный'),
                Tables\Columns\CheckboxColumn::make('is_hit')
                    ->label('Хит продаж'),
                Tables\Columns\CheckboxColumn::make('is_new')
                    ->label('Новинка'),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->sortable()
                    ->label('Активен'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                ->label('Категория')
                ->options(function() {
                    $categoryTree = Category::getProductCategoryTree();

                    return $categoryTree;
                })
                ->query(function (Builder $query, array $data): Builder {
                    $category = Category::find($data['value']);
                    $categoryIds = $category?->getAllChildrenIds();
                    return $data['value'] ? $query->whereIn('category_id', $categoryIds) : $query;
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductCharacteristicsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
