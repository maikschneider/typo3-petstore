<?php

declare(strict_types=1);

$lll = 'LLL:EXT:typo3_petstore/Resources/Private/Language/locallang_customer.xlf:';

return [
    'ctrl' => [
        'title' => $lll . 'title',
        'label' => 'username',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:typo3_petstore/Resources/Public/Icons/customer.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        0 => [
            'showitem' => implode(', ', [
                'username, first_name, last_name, email, password_hash',
                '--div--;Contact, phone, address, date_of_birth',
                '--div--;Account, user_status, loyalty_points, profile_image',
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

        // ── input ────────────────────────────────────────────────────────────
        'username' => [
            'label' => $lll . 'username',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
                'required' => true,
            ],
        ],
        'first_name' => [
            'label' => $lll . 'first_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            ],
        ],
        'last_name' => [
            'label' => $lll . 'last_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            ],
        ],
        'phone' => [
            'label' => $lll . 'phone',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 30,
            ],
        ],

        // ── email ────────────────────────────────────────────────────────────
        'email' => [
            'label' => $lll . 'email',
            'config' => [
                'type' => 'email',
            ],
        ],

        // ── password ─────────────────────────────────────────────────────────
        'password_hash' => [
            'label' => $lll . 'password_hash',
            'config' => [
                'type' => 'password',
                'passwordPolicy' => 'default',
            ],
        ],

        // ── text ─────────────────────────────────────────────────────────────
        'address' => [
            'label' => $lll . 'address',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 40,
            ],
        ],

        // ── select ───────────────────────────────────────────────────────────
        'user_status' => [
            'label' => $lll . 'user_status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $lll . 'user_status.registered', 'value' => 0],
                    ['label' => $lll . 'user_status.active',     'value' => 1],
                    ['label' => $lll . 'user_status.suspended',  'value' => 2],
                ],
                'default' => 0,
            ],
        ],

        // ── number ───────────────────────────────────────────────────────────
        'loyalty_points' => [
            'label' => $lll . 'loyalty_points',
            'config' => [
                'type' => 'number',
                'default' => 0,
                'range' => [
                    'lower' => 0,
                ],
            ],
        ],

        // ── file ─────────────────────────────────────────────────────────────
        'profile_image' => [
            'label' => $lll . 'profile_image',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'jpg,jpeg,png,gif,webp',
            ],
        ],

        // ── datetime ─────────────────────────────────────────────────────────
        'date_of_birth' => [
            'label' => $lll . 'date_of_birth',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'date',
                'format' => 'date',
            ],
        ],
    ],
];
