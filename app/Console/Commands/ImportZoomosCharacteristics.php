<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ZoomosImportService;

class ImportZoomosCharacteristics extends Command
{
    protected $signature = 'zoomos:import-characteristics';

    protected $description = 'Import characteristics from Zoomos API';

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

        $this->info('Starting Zoomos characteristics import...');
        Log::info('Starting Zoomos characteristics import...');

        $stats = $this->importService->importCharacteristics($apiKey);

        $this->info('Characteristics import completed');
        Log::info('Zoomos characteristics import stats', $stats);

        $this->table(
            ['Metric', 'Count'],
            [
                ['Created', $stats['created'] ?? 0],
                ['Updated', $stats['updated'] ?? 0],
                ['Linked', $stats['linked'] ?? 0],
                ['Skipped', $stats['skipped'] ?? 0],
                ['Processed', $stats['processed'] ?? 0],
            ]
        );

        return self::SUCCESS;
    }
}
