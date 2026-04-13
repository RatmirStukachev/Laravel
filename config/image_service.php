<?php


return [
    'thumbPath' => env('IMAGE_THUMB_DIRECTORY', 'thumb').'/',
    'noThumb' => env('IMAGE_NO_THUMB', '/storage/no-thumb.png'),
    'watermark' => env('IMAGE_WATERMARK', 'storage/watermark.png'),
    'webp' => env('IMAGE_WEBP', false),
    // Форматы которые не нужно нарезать
    'noMime' => [
        'svg+xml'
    ]

];
