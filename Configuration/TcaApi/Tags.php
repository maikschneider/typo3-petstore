<?php

declare(strict_types=1);

use MaikSchneider\TcaApi\Enum\AccessRole;
use MaikSchneider\TcaApi\Filter\SearchFilter;

return [
    'general' => [
        'table' => 'tx_typo3petstore_domain_model_tag',
        'resourceName' => 'tags',
        'resourceType' => 'Tag',
        'operations' => ['list', 'show', 'create', 'update', 'delete'],
    ],
    'filters' => [
        'q' => [
            SearchFilter::class,
            [
                'columns' => ['name', 'description'],
                'match' => 'partial',
            ],
        ],
    ],
    'security' => [
        'list' => AccessRole::PUBLIC,
        'show' => AccessRole::PUBLIC,
        'create' => AccessRole::PUBLIC,
        'update' => AccessRole::PUBLIC,
        'delete' => AccessRole::PUBLIC,
    ],
];
