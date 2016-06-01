<?php

return [

    'hosts' => [
        [
            'host' => env('ELASTICSEARCH_HOST', 'search-vincisearch-btpatpxbixjmgjcmtvsl3xkykq.sa-east-1.es.amazonaws.com'),
            'port' => env('ELASTICSEARCH_PORT', 80)
        ]
    ]
];