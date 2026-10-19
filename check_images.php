<?php
$urls = [
  "https://api.zoomos.by/img/item/2524510/0",
  "https://api.zoomos.by/img/item/2524510/1",
  "https://api.zoomos.by/img/item/2524510/2",
  "https://api.zoomos.by/img/item/2524510/3",
];
foreach($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    echo "URL: $url -> Redirected to: " . $info['url'] . " -> Size: " . $info['download_content_length'] . "\n";
    curl_close($ch);
}
