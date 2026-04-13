<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CategoryResource extends Resource
{
    const NAME = 'Категории';
    protected static ?string $model = Category::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Категория';

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
                                        Section::make('')->schema([
                                            Forms\Components\TextInput::make('title')
                                                ->label('Название')
                                                ->required()
                                                ->maxLength(255)
                                                ->lazy()
                                                ->afterStateUpdated(function ($state, callable $set, $livewire) {
                                                    if (!$livewire->getRecord() || empty($livewire->data['slug'])) {
                                                        $set('slug', Str::slug($state));
                                                    }
                                                }),
                                            Forms\Components\TextInput::make('slug')
                                                ->label('Ссылка')
                                                ->maxLength(255)
                                                ->required(),
                                        ])->columnSpan(2),

                                        Section::make('')->schema([
                                            Forms\Components\Select::make('parent_id')
                                                ->label('Родитель')
                                                ->searchable()
                                                ->options(Category::getCategoryTree())
                                                ->optionsLimit(500)
                                                ->placeholder('Категория первого уровня')
                                                ->default(null),

                                            Forms\Components\TextInput::make('level')
                                                ->hidden()
                                                ->label('Уровень категории'),
                                            Forms\Components\TextInput::make('h1')
                                                ->label('H1'),
                                        ])->columns(2),

                                        Forms\Components\TextInput::make('measure')
                                            ->label('Единица измерения')
                                            ->columnSpanFull(),

                                        FileUpload::make('image')
                                            ->label('Изображение (460x460)')
                                            ->columnSpanFull()
                                            ->image()
                                            ->directory('categories'),
                                        TinyEditor::make('content')
                                            ->label('Контент внизу страницы')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('pos')
                                            ->label('Позиция (Опционально)')
                                            ->columnSpanFull()
                                            ->default(1000),
                                        Section::make('')->schema([
                                            Forms\Components\Checkbox::make('header_menu')
                                                ->label('В верхнем меню'),
                                            Forms\Components\Checkbox::make('is_index')
                                                ->label('Главная страница'),                                                
                                            Forms\Components\Checkbox::make('is_active')
                                                ->label('Активно'),
                                        ])->columnSpan(2),
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
                    ])
                    ->columnSpan(['lg' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->wrap()
                    ->label('Ссылка'),
                Tables\Columns\TextColumn::make('parent.title')
                    ->sortable()
                    ->wrap()
                    ->label('Родитель')
                    ->searchable(),
                Tables\Columns\CheckboxColumn::make('header_menu')
                    ->sortable()
                    ->label('В верхнем меню'),
                Tables\Columns\CheckboxColumn::make('is_index')
                    ->sortable()
                    ->label('Главная страница'),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->sortable()
                    ->label('Активно'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                ->label('Категория')
                ->options(function() {

                    return Category::getCategoryTree();
                })
                ->query(function (Builder $query, array $data): Builder {    
                    return $data['value'] ? $query->where('id', $data['value']) : $query;
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
            RelationManagers\CharacteristicsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
