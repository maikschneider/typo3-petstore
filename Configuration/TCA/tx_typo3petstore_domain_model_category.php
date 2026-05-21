<?php

declare(strict_types=1);

$lll = 'LLL:EXT:typo3_petstore/Resources/Private/Language/locallang_category.xlf:';

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
        'iconfile' => 'EXT:typo3_petstore/Resources/Public/Icons/category.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'name, description, parent_category, icon, sort_order, badge_color, hidden',
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
                'size' => 50,
                'max' => 255,
                'required' => true,
            ],
        ],
        'description' => [
            'label' => $lll . 'description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 40,
            ],
        ],
        'parent_category' => [
            'label' => $lll . 'parent_category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_typo3petstore_domain_model_category',
                'items' => [
                    ['label' => '— none —', 'value' => 0],
                ],
                'default' => 0,
            ],
        ],
        'icon' => [
            'label' => $lll . 'icon',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'jpg,jpeg,png,gif,webp,svg',
            ],
        ],
        'sort_order' => [
            'label' => $lll . 'sort_order',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'badge_color' => [
            'label' => $lll . 'badge_color',
            'config' => [
                'type' => 'color',
                'default' => '#3B82F6',
            ],
        ],
    ],
];
