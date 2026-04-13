<?php

namespace App\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class MetricsComposer
{
    const ONE_MINUTE = 60;

    protected $metrics;

    public function __construct()
    {
        $this->metrics = Cache::flexible(
            key: 'metrics',
            ttl: [
                self::ONE_MINUTE,
                config('cache.stores.metrics'),
            ],
            callback: function () {
                return Setting::where('data_key', 'metrics')->first();
            });
    }

    public function compose(View $view): View
    {
        return $view->with('metrics', $this->getMetrics());
    }

    private function getMetrics(): object
    {
        return (object) $this->metrics->data_val;
    }
}
