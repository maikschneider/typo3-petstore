<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Petstore Pet',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'iconfile' => 'EXT:core/Resources/Public/Icons/T3Icons/svgs/mimetypes/mimetypes-text-text.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        0 => [
            'showitem' => implode(', ', [
                '--div--;General, name, latin_name, status, gender, category_id, tags',
                '--div--;Details, description, care_notes, is_vaccinated, features',
                '--div--;Physical, price, weight_kg, stock_quantity, highlight_color, birth_date, feeding_time',
                '--div--;Availability, available_from, owner_website, contact_email, url_slug, external_id',
                '--div--;Media, photos, health_certificate',
                '--div--;Relations, categories, related_pets, orders',
                '--div--;Extra, metadata, extra_settings',
                '--div--;System, hidden, sys_language_uid, l10n_parent',
            ]),
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_typo3petstore_domain_model_pet',
                'foreign_table_where' => 'AND {#tx_typo3petstore_domain_model_pet}.{#pid}=###CURRENT_PID### AND {#tx_typo3petstore_domain_model_pet}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
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
        'name' => [
            'label' => 'Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'required' => true,
            ],
        ],
        'latin_name' => [
            'label' => 'Latin / Scientific Name (input)',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
            ],
        ],

        // ── text ─────────────────────────────────────────────────────────────
        'description' => [
            'label' => 'Description (text + RTE)',
            'config' => [
                'type' => 'text',
                'rows' => 8,
                'cols' => 40,
                'enableRichtext' => true,
            ],
        ],
        'care_notes' => [
            'label' => 'Care Notes (text — plain textarea)',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 40,
            ],
        ],

        // ── number ───────────────────────────────────────────────────────────
        'price' => [
            'label' => 'Price (number/decimal)',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'default' => 0,
            ],
        ],
        'weight_kg' => [
            'label' => 'Weight in kg (number/decimal)',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'default' => 0,
            ],
        ],
        'stock_quantity' => [
            'label' => 'Stock Quantity (number/integer)',
            'config' => [
                'type' => 'number',
                'default' => 1,
                'range' => [
                    'lower' => 0,
                ],
            ],
        ],

        // ── select ───────────────────────────────────────────────────────────
        'status' => [
            'label' => 'Status (select/selectSingle — fixed items)',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Available', 'value' => 'available'],
                    ['label' => 'Pending', 'value' => 'pending'],
                    ['label' => 'Sold', 'value' => 'sold'],
                ],
                'default' => 'available',
            ],
        ],
        'category_id' => [
            'label' => 'Category (select/selectSingle — foreign table)',
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
        'related_pets' => [
            'label' => 'Related Pets (select/selectMultipleSideBySide — MM self-reference)',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_typo3petstore_domain_model_pet',
                'MM' => 'tx_typo3petstore_pet_related_mm',
                'size' => 5,
                'maxitems' => 20,
            ],
        ],

        // ── radio ────────────────────────────────────────────────────────────
        'gender' => [
            'label' => 'Gender (radio)',
            'config' => [
                'type' => 'radio',
                'items' => [
                    ['label' => 'Male', 'value' => 'male'],
                    ['label' => 'Female', 'value' => 'female'],
                    ['label' => 'Unknown', 'value' => 'unknown'],
                ],
                'default' => 'unknown',
            ],
        ],

        // ── check ────────────────────────────────────────────────────────────
        'is_vaccinated' => [
            'label' => 'Vaccinated (check/toggle)',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    ['label' => ''],
                ],
            ],
        ],
        'features' => [
            'label' => 'Features (check/multi-checkbox)',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['label' => 'Microchipped'],
                    ['label' => 'Neutered'],
                    ['label' => 'House Trained'],
                    ['label' => 'Good with Kids'],
                ],
            ],
        ],

        // ── datetime ─────────────────────────────────────────────────────────
        'birth_date' => [
            'label' => 'Birth Date (datetime/date)',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'date',
                'format' => 'date',
            ],
        ],
        'available_from' => [
            'label' => 'Available From (datetime/unix timestamp)',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'feeding_time' => [
            'label' => 'Feeding Time (datetime/time)',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'time',
                'format' => 'time',
            ],
        ],

        // ── file ─────────────────────────────────────────────────────────────
        'photos' => [
            'label' => 'Photos (file — multiple images)',
            'config' => [
                'type' => 'file',
                'allowed' => 'jpg,jpeg,png,gif,webp',
                'maxitems' => 10,
            ],
        ],
        'health_certificate' => [
            'label' => 'Health Certificate (file — single PDF)',
            'config' => [
                'type' => 'file',
                'allowed' => 'pdf',
                'maxitems' => 1,
            ],
        ],

        // ── link ─────────────────────────────────────────────────────────────
        'owner_website' => [
            'label' => 'Owner Website (link)',
            'config' => [
                'type' => 'link',
            ],
        ],

        // ── color ────────────────────────────────────────────────────────────
        'highlight_color' => [
            'label' => 'Highlight Color (color)',
            'config' => [
                'type' => 'color',
                'default' => '',
            ],
        ],

        // ── email ────────────────────────────────────────────────────────────
        'contact_email' => [
            'label' => 'Contact Email (email)',
            'config' => [
                'type' => 'email',
            ],
        ],

        // ── slug ─────────────────────────────────────────────────────────────
        'url_slug' => [
            'label' => 'URL Slug (slug)',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['name'],
                    'fieldSeparator' => '-',
                    'prefixParentPageSlug' => false,
                ],
                'fallbackCharacter' => '-',
            ],
        ],

        // ── uuid ─────────────────────────────────────────────────────────────
        'external_id' => [
            'label' => 'External ID (uuid)',
            'config' => [
                'type' => 'uuid',
            ],
        ],

        // ── json ─────────────────────────────────────────────────────────────
        'metadata' => [
            'label' => 'Metadata (json)',
            'config' => [
                'type' => 'json',
            ],
        ],

        // ── flex ─────────────────────────────────────────────────────────────
        'extra_settings' => [
            'label' => 'Extra Settings (flex)',
            'config' => [
                'type' => 'flex',
                'ds' => [
                    'default' => '
<T3DataStructure>
    <sheets>
        <sDEF>
            <ROOT>
                <type>array</type>
                <sheetTitle>Breed Details</sheetTitle>
                <el>
                    <settings.breed>
                        <label>Breed (input)</label>
                        <config>
                            <type>input</type>
                            <size>30</size>
                        </config>
                    </settings.breed>
                    <settings.origin_country>
                        <label>Origin Country (input)</label>
                        <config>
                            <type>input</type>
                            <size>30</size>
                        </config>
                    </settings.origin_country>
                    <settings.coat_length>
                        <label>Coat Length (select)</label>
                        <config>
                            <type>select</type>
                            <renderType>selectSingle</renderType>
                            <items type="array">
                                <numIndex index="0" type="array">
                                    <numIndex index="0">Short</numIndex>
                                    <numIndex index="1">short</numIndex>
                                </numIndex>
                                <numIndex index="1" type="array">
                                    <numIndex index="0">Medium</numIndex>
                                    <numIndex index="1">medium</numIndex>
                                </numIndex>
                                <numIndex index="2" type="array">
                                    <numIndex index="0">Long</numIndex>
                                    <numIndex index="1">long</numIndex>
                                </numIndex>
                            </items>
                        </config>
                    </settings.coat_length>
                    <settings.special_diet>
                        <label>Special Diet Required (check)</label>
                        <config>
                            <type>check</type>
                            <renderType>checkboxToggle</renderType>
                            <items type="array">
                                <numIndex index="0" type="array">
                                    <numIndex index="0"></numIndex>
                                </numIndex>
                            </items>
                        </config>
                    </settings.special_diet>
                </el>
            </ROOT>
        </sDEF>
    </sheets>
</T3DataStructure>',
                ],
            ],
        ],

        // ── category (system categories) ─────────────────────────────────────
        'categories' => [
            'label' => 'TYPO3 System Categories (category)',
            'config' => [
                'type' => 'category',
            ],
        ],

        // ── group (MM relation to tags) ───────────────────────────────────────
        'tags' => [
            'label' => 'Tags (group + MM many-to-many)',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_typo3petstore_domain_model_tag',
                'MM' => 'tx_typo3petstore_pet_tag_mm',
                'size' => 5,
                'maxitems' => 20,
            ],
        ],

        // ── inline (1:N orders) ───────────────────────────────────────────────
        'orders' => [
            'label' => 'Orders (inline 1:N)',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_typo3petstore_domain_model_order',
                'foreign_field' => 'pet_id',
                'maxitems' => 100,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'useSortable' => false,
                ],
            ],
        ],
    ],
];
