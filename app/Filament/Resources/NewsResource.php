<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class NewsResource extends Resource
{
    const NAME = 'Новости';
    protected static ?string $model = News::class;
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Новость';

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
                                            })
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Ссылка')
                                            ->unique(ignorable: fn ($record) => $record)
                                            ->validationMessages([
                                                'unique' => 'Slug должен быть уникальным',
                                            ])
                                            ->maxLength(255)
                                            ->required(),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('date')
                                                    ->label('Дата')
                                                    ->default(now())
                                                    ->columnSpan(1),
                                            ]),
                                        TinyEditor::make('content')
                                            ->label('Контент')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Изображение (544x272)')
                                            ->image()
                                            ->columnSpanFull()
                                            ->directory('news'),
                                        Forms\Components\TextInput::make('pos')
                                            ->label('Позиция (Опционально)')
                                            ->default(1000)
                                            ->columnSpanFull(),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Активно'),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Ссылка')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return $state ? $state->format('d.m.Y') : '';
                    }),
                Tables\Columns\TextInputColumn::make('pos')
                    ->label('Позиция')
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->label('Активно')
                    ->sortable(),
            ])
            ->defaultSort('date', 'desc')
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
