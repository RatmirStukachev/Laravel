<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$zoomosId = \App\Models\Product::whereNotNull('zoomos_id')->value('zoomos_id');
if ($zoomosId) {
    $apiKey = config('services.zoomos.api_key');
    $url = "https://api.zoomos.by/item/{$zoomosId}";
    $response = Http::timeout(60)->get($url, ['key' => $apiKey]);
    echo "Detailed data keys: \n";
    print_r(array_keys($response->json()));
    if (isset($response->json()['images'])) {
        echo "Has images!\n";
    }

    $url2 = "https://api.zoomos.by/pricelist";
    $response2 = Http::timeout(60)->get($url2, ['key' => $apiKey]);
    $items = $response2->json();
    if (!empty($items)) {
        echo "Pricelist item keys:\n";
        print_r(array_keys($items[0]));
        if (isset($items[0]['images'])) {
            echo "Has images!\n";
        }
        if (isset($items[0]['gallery'])) {
            echo "Has gallery!\n";
        }
    }
} else {
    echo "No zoomos_id found\n";
}
