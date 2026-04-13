<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Page;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PageResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PageResource extends Resource
{
    const NAME = 'Страницы';
    protected static ?string $model = Page::class;
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;
    protected static ?string $modelLabel = 'Страница';
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
                                                ->required()
                                                ->label('Название')
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
                                                ])
                                                ->required(),
                                        ])->columns(2),
                                        Forms\Components\Section::make('')->schema([
                                            TextInput::make('h1')->label('H1'),
                                        ])->columns(1),
                                        Forms\Components\Section::make('')->schema([
                                            TinyEditor::make('content')->label('Контент'),
                                        ])->columns(1),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Активна')
                                            ->default(false),
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
                    ->searchable(),
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->sortable()
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
