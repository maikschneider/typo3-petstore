<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Petstore',
    'description' => 'Demo extension showcasing all TCA field types and relation patterns via the classic Swagger Petstore domain model.',
    'category' => 'example',
    'author' => 'Maik Schneider',
    'author_email' => 'schneider.maik@me.com',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.99.99',
            'tca_api' => '',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
