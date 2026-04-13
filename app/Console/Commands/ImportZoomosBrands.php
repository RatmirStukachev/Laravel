<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ZoomosImportService;

class ImportZoomosBrands extends Command
{
    protected $signature = 'zoomos:import-brands';

    protected $description = 'Import brands from Zoomos API';

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

        $this->info('Starting Zoomos brands import...');
        Log::info('Starting Zoomos brands import...');

        $stats = $this->importService->importBrands($apiKey);

        $this->info('Brands import completed');
        Log::info('Zoomos brands import stats', $stats);

        $this->table(
            ['Metric', 'Count'],
            [
                ['Created', $stats['created'] ?? 0],
                ['Updated', $stats['updated'] ?? 0],
                ['Skipped', $stats['skipped'] ?? 0],
                ['Processed', $stats['processed'] ?? 0],
            ]
        );

        return self::SUCCESS;
    }
}
