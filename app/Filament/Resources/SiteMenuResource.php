<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\SiteMenu;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SiteMenuResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SiteMenuResource\RelationManagers;

class SiteMenuResource extends Resource
{
    const NAME = 'Меню';

    protected static ?string $model = SiteMenu::class;
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;
    protected static ?string $modelLabel = 'Пункт Меню';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
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
                        ->unique(ignorable: fn ($record) => $record)
                        ->validationMessages([
                            'unique' => 'Slug должен быть уникальным',
                        ]),
                ])->columns(2),
                Forms\Components\Section::make('Тип')->schema([
                    Forms\Components\Checkbox::make('master')
                        ->label('Верхнее меню')
                        ->default(true),
                    Forms\Components\Checkbox::make('slave')
                        ->label('Нижнее меню')
                        ->default(false),
                ])->columns(5),
                Forms\Components\TextInput::make('pos')
                    ->label('Позиция')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Активно')
                    ->default(false),
            ]);            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('slug')
                    ->label('Ссылка'),
                Tables\Columns\TextInputColumn::make('pos')
                    ->label('Позиция'),
                Tables\Columns\CheckboxColumn::make('master')
                    ->label('Верхнее меню'),
                Tables\Columns\CheckboxColumn::make('slave')
                    ->label('Нижнее меню'),
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
            'index' => Pages\ListSiteMenus::route('/'),
            'create' => Pages\CreateSiteMenu::route('/create'),
            'edit' => Pages\EditSiteMenu::route('/{record}/edit'),
        ];
    }
}
