<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\App;
use App\Filament\Resources\OrderResource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use App\Models\Product;
use Filament\Forms\Set;

class OrderProductsRelationManager extends RelationManager
{
    protected static ?string $pluralLabel = 'Товары в заказе';
    protected static ?string $recordTitleAttribute = 'title';
    protected static string $relationship = 'orderProducts';
    protected static ?string $title = 'Товары в заказе';


    public function form(Form $form): Form
    {
        return OrderResource::form($form);
    }

    protected function getTableQuery(): Builder
    {
        /** @var Order $order */
        $order = $this->getOwnerRecord();    
        
        return OrderProduct::query()->where('order_id', $order->id);

    }

    public function table(Table $table): Table
    {
        /** @var Order $order */
        $product = $this->getOwnerRecord();

        return $table
            ->modelLabel('Товар в заказе')
            ->emptyStateHeading('Нет товаров в заказе')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->hidden(App::isProduction()),
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->label('Название товара'),
                Tables\Columns\TextColumn::make('article')
                    ->label('Артикул'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена'),
                Tables\Columns\TextInputColumn::make('count')
                    ->label('Количество')
                    ->afterStateUpdated(function ($record, $state) {
                        $record->total_price = $record->price * $state;
                        $record->save();
                        
                        $this->recalculateOrderTotals($record->order);
                    }),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Стоимость'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить товар')
                    ->form([
                        Select::make('product_id')
                            ->label('Товар')
                            ->options(
                                Product::query()
                                    ->where('is_active', true)
                                    ->where('balance', '>', 0)
                                    ->where('price', '>', 0)
                                    ->pluck('title', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state) {
                                    $product = Product::find($state);
                                    $set('price', $product->price);
                                    $set('title', $product->title);
                                    $set('article', $product->article);
                                }
                            }),
                        TextInput::make('count')
                            ->label('Количество')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                        Hidden::make('price'),
                        Hidden::make('title'),
                        Hidden::make('article'),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['total_price'] = $data['price'] * $data['count'];
                        return $data;
                    })
                    ->after(function ($record) {
                        $this->recalculateOrderTotals($record->order);
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Удалить')
                    ->color('danger')
                    ->after(function ($record) {
                        $this->recalculateOrderTotals($record->order);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            // После массового удаления пересчитываем итоги для текущего заказа
                            $order = $this->getOwnerRecord();
                            $this->recalculateOrderTotals($order);
                        }),
                ]),
            ]);
    }

    protected function recalculateOrderTotals(Order $order): void
    {
        $totalPrice = $order->orderProducts->sum('total_price');
        $totalCount = $order->orderProducts->sum('count');
        
        $order->update([
            'total_amount' => $totalPrice,
            'count' => $totalCount,
        ]);

        // Обновляем данные в родительской форме
        $this->getOwnerRecord()->refresh();
        $this->dispatch('refreshProducts');
    }
}
