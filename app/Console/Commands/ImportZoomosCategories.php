<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ZoomosImportService;

class ImportZoomosCategories extends Command
{
    protected $signature = 'zoomos:import-categories';

    protected $description = 'Import categories from Zoomos API (map L2->L1 and L3->L2)';

    public function __construct(private ZoomosImportService $importService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $apiKey = config('services.zoomos.api_key');

        if (empty($apiKey)) {
            $this->error('Zoomos API key is not configured. Please set ZOOMOS_API_KEY in your .env file.');

            return self::FAILURE;
        }

        $this->info('Starting Zoomos categories import...');
        Log::info('Starting Zoomos categories import...');

        $stats = $this->importService->importCategories($apiKey);

        Log::info('Zoomos categories import stats', $stats);
        $this->info('Categories import completed');

        $this->table(
            ['Metric', 'Count'],
            [
                ['Created', $stats['created'] ?? 0],
                ['Updated', $stats['updated'] ?? 0],
                ['Reparented', $stats['reparented'] ?? 0],
                ['Processed', $stats['processed'] ?? 0],
            ]
        );

        return self::SUCCESS;
    }
}


