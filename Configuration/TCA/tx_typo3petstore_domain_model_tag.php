<?php

declare(strict_types=1);

$lll = 'LLL:EXT:typo3_petstore/Resources/Private/Language/locallang_tag.xlf:';

return [
    'ctrl' => [
        'title' => $lll . 'title',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:typo3_petstore/Resources/Public/Icons/tag.svg',
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
            'label' => $lll . 'name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
                'required' => true,
            ],
        ],
        'color' => [
            'label' => $lll . 'color',
            'config' => [
                'type' => 'color',
                'default' => '#6B7280',
            ],
        ],
        'description' => [
            'label' => $lll . 'description',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 40,
            ],
        ],
    ],
];
