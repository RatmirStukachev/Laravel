<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Characteristic;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CharacteristicResource;
use Filament\Resources\RelationManagers\RelationManager;

class ProductCharacteristicsRelationManager extends RelationManager
{
    protected static ?string $pluralLabel = 'Характеристики категории';
    protected static ?string $recordTitleAttribute = 'title';
    protected static string $relationship = 'characteristics';
    protected static ?string $title = 'Характеристики';

    public function form(Form $form): Form
    {
        return CharacteristicResource::form($form);
    }

    protected function getTableQuery(): Builder
    {
        /** @var Product $product */
        $product = $this->getOwnerRecord();
        $categoryIds = $product->getCategoryIds();        

        return Characteristic::query()
            ->distinct()
            ->select('characteristics.id', 'characteristics.title', 'characteristics.measure')
            ->join('category_characteristic', function($join) use ($categoryIds) {
                $join->on('characteristics.id', '=', 'category_characteristic.characteristic_id')
                    ->whereIn('category_characteristic.category_id', $categoryIds)
                    ->where('category_characteristic.is_active', true);
            });                    
    }

    public function table(Table $table): Table
    {
        /** @var Product $product */
        $product = $this->getOwnerRecord();

        return $table
            ->modelLabel('характеристика')
            ->emptyStateHeading('Нет характеристик')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->hidden(App::isProduction()),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('measure')
                    ->label('Единица измерения'),
                Tables\Columns\TextInputColumn::make('value')
                    ->label('Значение')
                    ->state(function (Characteristic $record) use ($product): string {
                        $characteristic = $product->characteristics()
                            ->where('characteristic_id', $record->id)
                            ->first();

                        if (!$characteristic) {            
                            $product->characteristics()->syncWithoutDetaching([
                                $record->id => ['value' => '']
                            ]);
                            return '';
                        }

                        return $characteristic->pivot->value ?? '';
                    })
                    ->afterStateUpdated(function (Characteristic $record, $state) use ($product) {
                        $product->characteristics()->syncWithoutDetaching([
                            $record->id => ['value' => $state]
                        ]);
                    }),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
