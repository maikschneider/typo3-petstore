<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Petstore Customer',
        'label' => 'username',
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
            'label' => 'Username (input)',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
                'required' => true,
            ],
        ],
        'first_name' => [
            'label' => 'First Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            ],
        ],
        'last_name' => [
            'label' => 'Last Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            ],
        ],
        'phone' => [
            'label' => 'Phone (input)',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 30,
            ],
        ],

        // ── email ────────────────────────────────────────────────────────────
        'email' => [
            'label' => 'Email Address (email)',
            'config' => [
                'type' => 'email',
            ],
        ],

        // ── password ─────────────────────────────────────────────────────────
        'password_hash' => [
            'label' => 'Password (password — hashed)',
            'config' => [
                'type' => 'password',
                'passwordPolicy' => 'default',
            ],
        ],

        // ── text ─────────────────────────────────────────────────────────────
        'address' => [
            'label' => 'Address (text)',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 40,
            ],
        ],

        // ── select ───────────────────────────────────────────────────────────
        'user_status' => [
            'label' => 'User Status (select/selectSingle — fixed items)',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Registered', 'value' => 0],
                    ['label' => 'Active', 'value' => 1],
                    ['label' => 'Suspended', 'value' => 2],
                ],
                'default' => 0,
            ],
        ],

        // ── number ───────────────────────────────────────────────────────────
        'loyalty_points' => [
            'label' => 'Loyalty Points (number/integer)',
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
            'label' => 'Profile Image (file — single image)',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'jpg,jpeg,png,gif,webp',
            ],
        ],

        // ── datetime ─────────────────────────────────────────────────────────
        'date_of_birth' => [
            'label' => 'Date of Birth (datetime/date)',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'date',
                'format' => 'date',
            ],
        ],
    ],
];
