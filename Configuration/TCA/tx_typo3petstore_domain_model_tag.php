<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Petstore Tag',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:core/Resources/Public/Icons/T3Icons/svgs/mimetypes/mimetypes-text-text.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'name, color, description, hidden',
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'name' => [
            'label' => 'Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
                'required' => true,
            ],
        ],
        'color' => [
            'label' => 'Tag Color (color)',
            'config' => [
                'type' => 'color',
                'default' => '#6B7280',
            ],
        ],
        'description' => [
            'label' => 'Description (text)',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 40,
            ],
        ],
    ],
];
