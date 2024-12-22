<?php

return [
    'retrieval_interval_minutes' => env('NEWS_RETRIEVAL_INTERVAL_MINUTES'),

    'sources' => [
        'news_api' => [
            'api_key' => env('NEWSAPI_APIKEY'),
            'endpoint' => env('NEWSAPI_ENDPOINT'),
        ],

        'new_york_times' => [
            'api_key' => env('NEWYORKTIMES_APIKEY'),
            'endpoint' => env('NEWYORKTIMES_ENDPOINT'),
        ],

        'guardian' => [
            'api_key' => env('GUARDIANAPI_APIKEY'),
            'endpoint' => env('GUARDIANAPI_ENDPOINT'),
        ],
    ],
];
