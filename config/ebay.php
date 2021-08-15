<?php

return [
    'credentials' => [
        'appId' => env('EBAY_APP_ID', ''),
        'devId' => env('EBAY_DEV_ID', ''),
        'cert' => env('EBAY_CERT', ''),
    ],
    'settings' => [
        'globalId' => env('EBAY_GLOBAL_ID', 'EBAY-GB'),
        'siteId' => env('EBAY_SITE_ID', '3'),
        'debug' => env('EBAY_DEBUG', false),
        'endpoint' => env('EBAY_AUTH_ENDPOINT'),
        'findingServiceUrl' => env('EBAY_FINDING_SERVICE_URL'),
        'shoppingUrl' => env('EBAY_SHOPPING_URL'),
        'itemsPerCategory' => env('EBAY_ITEMS_CATEGORY'),
        'itemsPerGet' => env('EBAY_ITEMS_GET'),
        'itemsPerFinish' => env('EBAY_ITEMS_FINISH'),
        'usedMonths' => env('EBAY_USED_MONTHS')
    ],
    'keywords' => [
        'item_to_delete' => [
            'damaged', 'spares', 'repair', 'lhd', 'import', 'project', 'non runner', 'mot failure', 'fault', 'breaking'
        ],
        'item_not_used' => [
            'damaged', 'spares', 'repair', 'lhd', 'import', 'project', 'non runner', 'mot failure', 'fault', 'breaking'
        ],
        'to_remove' => [
            'no reserve', 'part exchange', 'no mot', 'low miles'
        ]
    ],
    'earliest_year' => env('EBAY_EARLIEST_YEAR', 2000)
];
