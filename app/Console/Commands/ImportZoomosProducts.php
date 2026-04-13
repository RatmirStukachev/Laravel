<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ZoomosImportService;

class ImportZoomosProducts extends Command
{
    protected $signature = 'zoomos:import';

    protected $description = 'Import products from Zoomos API';

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

        $this->info('Starting Zoomos products import...');
        Log::info('Starting Zoomos products import...');
        $this->newLine();

        $progressBar = null;

        $stats = $this->importService->import($apiKey, function ($processed, $total) use (&$progressBar) {
            if (! $progressBar) {
                $progressBar = $this->output->createProgressBar($total);
                $progressBar->setFormat('verbose');
            }

            $progressBar->setProgress($processed);
        });

        if ($progressBar) {
            $progressBar->finish();
            $this->newLine(2);
        }

        Log::info('Zoomos products import stats', $stats);
        $this->info('Import completed!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Created', $stats['created']],
                ['Updated', $stats['updated']],
                ['Skipped', $stats['skipped']],
                ['Deactivated', $stats['deactivated']],
                ['Total processed', $stats['total']],
            ]
        );

        return self::SUCCESS;
    }
}
