<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ArticleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArticleResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ArticleResource extends Resource
{
    const NAME = 'Статьи';
    protected static ?string $model = Article::class;
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Статья';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Скрыть ресурс из навигации
    protected static bool $shouldRegisterNavigation = false;

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
                                            Forms\Components\DatePicker::make('created_at')
                                                ->label('Дата')
                                                ->default(now())
                                                ->columnSpan(1),
                                        ]),
                                    TinyEditor::make('content')
                                        ->label('Контент')
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('image')
                                        ->label('Изображение (1100x250)')
                                        ->image()
                                        ->columnSpanFull()
                                        ->directory('articles'),
                                    Forms\Components\TextInput::make('pos')
                                        ->label('Позиция (Опционально)')
                                        ->default(1000)
                                        ->columnSpanFull(),
                                    Forms\Components\Checkbox::make('is_aside_menu')
                                        ->label('В боковом сквозном блоке'),
                                    Forms\Components\Checkbox::make('is_active')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Ссылка')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('pos')
                    ->label('Позиция')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return $state ? $state->locale('ru')->translatedFormat('j F Y') : '';
                    }),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->label('Активно')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
