<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Petstore Order',
        'label' => 'customer_name',
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
            'showitem' => implode(', ', [
                'pet_id, quantity, total_price, status, complete',
                '--div--;Customer, customer_name, customer_email, customer_phone, shipping_address',
                '--div--;Dates, ship_date, delivery_date',
                '--div--;System, hidden',
            ]),
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

        // ── group (M:1 pet reference) ─────────────────────────────────────────
        'pet_id' => [
            'label' => 'Pet (group — M:1 record reference)',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_typo3petstore_domain_model_pet',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ],
        ],

        // ── number ───────────────────────────────────────────────────────────
        'quantity' => [
            'label' => 'Quantity (number/integer)',
            'config' => [
                'type' => 'number',
                'default' => 1,
                'range' => [
                    'lower' => 1,
                ],
            ],
        ],
        'total_price' => [
            'label' => 'Total Price (number/decimal)',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'default' => 0,
            ],
        ],

        // ── select ───────────────────────────────────────────────────────────
        'status' => [
            'label' => 'Order Status (select/selectSingle — fixed items)',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Placed', 'value' => 'placed'],
                    ['label' => 'Approved', 'value' => 'approved'],
                    ['label' => 'Delivered', 'value' => 'delivered'],
                    ['label' => 'Cancelled', 'value' => 'cancelled'],
                ],
                'default' => 'placed',
            ],
        ],

        // ── check ────────────────────────────────────────────────────────────
        'complete' => [
            'label' => 'Order Complete (check/toggle)',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    ['label' => ''],
                ],
            ],
        ],

        // ── input ────────────────────────────────────────────────────────────
        'customer_name' => [
            'label' => 'Customer Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
            ],
        ],
        'customer_phone' => [
            'label' => 'Customer Phone (input)',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 50,
            ],
        ],

        // ── email ────────────────────────────────────────────────────────────
        'customer_email' => [
            'label' => 'Customer Email (email)',
            'config' => [
                'type' => 'email',
            ],
        ],

        // ── text ─────────────────────────────────────────────────────────────
        'shipping_address' => [
            'label' => 'Shipping Address (text)',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 40,
            ],
        ],

        // ── datetime ─────────────────────────────────────────────────────────
        'ship_date' => [
            'label' => 'Ship Date (datetime/datetime)',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'datetime',
            ],
        ],
        'delivery_date' => [
            'label' => 'Delivery Date (datetime/date)',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'date',
                'format' => 'date',
            ],
        ],
    ],
];
