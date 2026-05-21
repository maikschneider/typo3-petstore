<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Petstore Category',
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
            'label' => 'Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'required' => true,
            ],
        ],
        'description' => [
            'label' => 'Description (text)',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 40,
            ],
        ],
        'parent_category' => [
            'label' => 'Parent Category (select/foreign_table self-reference)',
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
            'label' => 'Icon (file — single image)',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'jpg,jpeg,png,gif,webp,svg',
            ],
        ],
        'sort_order' => [
            'label' => 'Sort Order (number/integer)',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'badge_color' => [
            'label' => 'Badge Color (color)',
            'config' => [
                'type' => 'color',
                'default' => '#3B82F6',
            ],
        ],
    ],
];
