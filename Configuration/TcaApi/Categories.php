<?php

declare(strict_types=1);

use MaikSchneider\TcaApi\Enum\AccessRole;

return [
    'general' => [
        'table' => 'tx_typo3petstore_domain_model_category',
        'resourceName' => 'categories',
        'resourceType' => 'Category',
        'operations' => ['list', 'show', 'create', 'update', 'delete'],
    ],
    'security' => [
        'list'   => AccessRole::PUBLIC,
        'show'   => AccessRole::PUBLIC,
        'create' => AccessRole::PUBLIC,
        'update' => AccessRole::PUBLIC,
        'delete' => AccessRole::PUBLIC,
    ],
];
