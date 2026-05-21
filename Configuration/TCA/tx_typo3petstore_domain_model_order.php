<?php

declare(strict_types=1);

$lll = 'LLL:EXT:typo3_petstore/Resources/Private/Language/locallang_order.xlf:';

return [
    'ctrl' => [
        'title' => $lll . 'title',
        'label' => 'customer_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:typo3_petstore/Resources/Public/Icons/order.svg',
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

        // ── group ────────────────────────────────────────────────────────────
        'pet_id' => [
            'label' => $lll . 'pet_id',
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
            'label' => $lll . 'quantity',
            'config' => [
                'type' => 'number',
                'default' => 1,
                'range' => [
                    'lower' => 1,
                ],
            ],
        ],
        'total_price' => [
            'label' => $lll . 'total_price',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'default' => 0,
            ],
        ],

        // ── select ───────────────────────────────────────────────────────────
        'status' => [
            'label' => $lll . 'status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $lll . 'status.placed',    'value' => 'placed'],
                    ['label' => $lll . 'status.approved',  'value' => 'approved'],
                    ['label' => $lll . 'status.delivered', 'value' => 'delivered'],
                    ['label' => $lll . 'status.cancelled', 'value' => 'cancelled'],
                ],
                'default' => 'placed',
            ],
        ],

        // ── check ────────────────────────────────────────────────────────────
        'complete' => [
            'label' => $lll . 'complete',
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
            'label' => $lll . 'customer_name',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
            ],
        ],
        'customer_phone' => [
            'label' => $lll . 'customer_phone',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 50,
            ],
        ],

        // ── email ────────────────────────────────────────────────────────────
        'customer_email' => [
            'label' => $lll . 'customer_email',
            'config' => [
                'type' => 'email',
            ],
        ],

        // ── text ─────────────────────────────────────────────────────────────
        'shipping_address' => [
            'label' => $lll . 'shipping_address',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 40,
            ],
        ],

        // ── datetime ─────────────────────────────────────────────────────────
        'ship_date' => [
            'label' => $lll . 'ship_date',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'datetime',
            ],
        ],
        'delivery_date' => [
            'label' => $lll . 'delivery_date',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'date',
                'format' => 'date',
            ],
        ],
    ],
];
