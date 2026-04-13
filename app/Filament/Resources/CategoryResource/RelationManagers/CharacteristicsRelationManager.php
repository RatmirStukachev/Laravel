<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Filament\Resources\CharacteristicResource;
use App\Models\Characteristic;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CharacteristicsRelationManager extends RelationManager
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
        /** @var Category $category */
        $category = $this->getOwnerRecord();    
        
        return Characteristic::query()
            ->select([
                'characteristics.id',
                'characteristics.title', 
                'category_characteristic.is_active', 
                'category_characteristic.in_filter', 
            ])
            ->join('category_characteristic', function ($join) use ($category) {
                $join->on('characteristics.id', '=', 'category_characteristic.characteristic_id')
                    ->where('category_characteristic.category_id', $category->id);
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
                Tables\Columns\CheckboxColumn::make('in_filter')
                    ->label('Фильтр'),          
                Tables\Columns\CheckboxColumn::make('is_active')
                    ->label('Активна'),             
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Добавить характеристику')
                    ->color('warning')
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Характеристика'),
                        Forms\Components\Checkbox::make('in_filter')
                            ->label('Фильтр'),
                        Forms\Components\Checkbox::make('is_active')
                            ->label('Активно')
                            ->default(true),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Удалить')
                    ->color('danger')
                    ->after(function ($record) {
                        /** @var \App\Models\Category $category */
                        $category = $this->getOwnerRecord();
                        
                        $categoryIds = $category->getAllChildrenIds();
                        
                        $productIds = \App\Models\Product::whereIn('category_id', $categoryIds)
                            ->pluck('id')
                            ->toArray();
                        
                        if (!empty($productIds)) {
                            DB::table('product_characteristic')
                                ->where('characteristic_id', $record->id)
                                ->whereIn('product_id', $productIds)
                                ->delete();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}