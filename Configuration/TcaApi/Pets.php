<?php

declare(strict_types=1);

use MaikSchneider\TcaApi\Enum\AccessRole;
use MaikSchneider\TcaApi\Filter\ExactFilter;
use MaikSchneider\TcaApi\Filter\SearchFilter;

return [
    'general' => [
        'table' => 'tx_typo3petstore_domain_model_pet',
        'resourceName' => 'pets',
        'resourceType' => 'Pet',
        'operations' => ['list', 'show', 'create', 'update', 'delete'],
    ],
    'filters' => [
        'status' => ExactFilter::class,
        'q'      => [
            SearchFilter::class,
            [
                'columns' => ['name', 'latin_name', 'description', 'care_notes'],
                'match'   => 'partial',
            ],
        ],
    ],
    'security' => [
        'list'   => AccessRole::PUBLIC,
        'show'   => AccessRole::PUBLIC,
        'create' => AccessRole::PUBLIC,
        'update' => AccessRole::PUBLIC,
        'delete' => AccessRole::PUBLIC,
    ],
];
