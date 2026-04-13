<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ZoomosImportService;

class ImportZoomosCreateProducts extends Command
{
    protected $signature = 'zoomos:import-create';

    protected $description = 'Create missing products and update desc + characteristics for existing';

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

        $this->info('Starting Zoomos create-only import...');
        Log::info('Starting Zoomos create-only import...');
        $this->newLine();

        $progressBar = null;

        $stats = $this->importService->createMissingProducts($apiKey, function ($processed, $total) use (&$progressBar) {
            if (!$progressBar) {
                $progressBar = $this->output->createProgressBar($total);
                $progressBar->setFormat('verbose');
            }

            $progressBar->setProgress($processed);
        });

        if ($progressBar) {
            $progressBar->finish();
            $this->newLine(2);
        }

        Log::info('Zoomos create-only import stats', $stats);
        $this->info('Create-only import completed!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Created', $stats['created']],
                ['Skipped', $stats['skipped']],
                ['Total processed', $stats['total']],
            ]
        );

        return self::SUCCESS;
    }
}


