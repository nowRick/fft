<?php

return [
    'cbr' => [
        'url' => env('CBR_URL', 'https://www.cbr.ru/scripts/XML_daily.asp'),
        'cache_ttl' => env('CBR_CACHE_TTL', 60), // in minutes
        'precision' => env('CBR_PRECISION', 14),
        'days' => env('CBR_DAYS', 180),
    ],
];
