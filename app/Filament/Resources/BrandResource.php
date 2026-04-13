<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrandResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrandResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BrandResource extends Resource
{
    const NAME = 'Бренды';
    protected static ?string $model = Brand::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Бренд';

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
                                                ->dehydrated()
                                                ->hidden()
                                                ->unique(ignorable: fn ($record) => $record)
                                                ->validationMessages([
                                                    'unique' => 'Slug должен быть уникальным',
                                                ])
                                                ->maxLength(255),
                                            // Forms\Components\TextInput::make('h1')
                                            //     ->label('H1')
                                        
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Лого 300x100')
                                            ->image()
                                            ->columnSpanFull()
                                            ->directory('brands'),

                                        Forms\Components\TextInput::make('pos')
                                            ->label('Позиция (Опционально)')
                                            ->default(1000)
                                            ->columnSpanFull(),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Активно')
                                            ->required(),
                                    ]),
                                // Tab::make('SEO')
                                //     ->schema([
                                //         Forms\Components\Section::make('SEO')
                                //             ->schema([
                                //                 Forms\Components\Textarea::make('title')->label('Title'),
                                //                 Forms\Components\Textarea::make('description')->label('Description'),
                                //             ])->relationship('seo'),
                                //     ]),
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
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextInputColumn::make('pos')
                    ->label('Позиция')
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->label('Активно'),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
