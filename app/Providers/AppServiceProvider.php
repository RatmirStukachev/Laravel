<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        DB::listen(function ($query) {
            if ($query->time > 200) {
                logger()
                    ->channel('stack')
                    ->debug('Query longer than 200ms' .
                        'Total time= ' . $query->time .
                        'SQL= ' . $query->sql, $query->bindings);
            }
        });

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Заказы'),
                NavigationGroup::make()
                    ->label('Магазин'),
                NavigationGroup::make()
                    ->label('Контент'),
                NavigationGroup::make()
                    ->label('Настройки'),
            ]);
        });
    }
}
