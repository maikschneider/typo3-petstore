<?php

declare(strict_types=1);

use MaikSchneider\TcaApi\Enum\AccessRole;
use MaikSchneider\TcaApi\Filter\ExactFilter;
use MaikSchneider\TcaApi\Filter\SearchFilter;

return [
    'general' => [
        'table' => 'tx_typo3petstore_domain_model_customer',
        'resourceName' => 'customers',
        'resourceType' => 'Customer',
        'operations' => ['list', 'show', 'create', 'update', 'delete'],
    ],
    'filters' => [
        'username' => ExactFilter::class,
        'q' => [
            SearchFilter::class,
            [
                'columns' => ['username', 'first_name', 'last_name', 'email'],
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
