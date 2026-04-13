<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('zoomos:import-categories')
    ->hourlyAt('10')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('zoomos:import-brands')
    ->hourlyAt('11')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('zoomos:import-characteristics')
    ->hourlyAt('12')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('zoomos:import-create')
    ->hourlyAt('15')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('zoomos:import-update')
    ->hourlyAt('20')
    ->withoutOverlapping()
    ->runInBackground();

// Schedule::command('excel:import-share-category-map --deactivate-others')
//     ->everyMinute()
//     ->withoutOverlapping()
//     ->runInBackground();