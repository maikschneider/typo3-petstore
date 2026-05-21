# TYPO3 Petstore

A demo TYPO3 extension based on the [Swagger Petstore](https://petstore.swagger.io/) domain model. Its primary purpose is to serve as a **TCA reference and demo data bootstrapper** — every TCA field type and every relation pattern appears at least once.

## What it is

- **Pure data layer** — TCA models only, no frontend output, no Extbase, no plugins
- **TCA reference** — covers all field types available in TYPO3 13/14 in one place
- **Fixture commands** — two CLI commands to bootstrap pages and demo records into any TYPO3 instance

## Models

| Model | Table | Key fields / types demonstrated |
|---|---|---|
| **Pet** | `tx_typo3petstore_domain_model_pet` | All field types (see below) |
| **Category** | `tx_typo3petstore_domain_model_category` | Self-referencing parent, color, file |
| **Tag** | `tx_typo3petstore_domain_model_tag` | input, color, text |
| **Order** | `tx_typo3petstore_domain_model_order` | group relation to Pet, email, datetime |
| **Customer** | `tx_typo3petstore_domain_model_customer` | password, email, select, file |

### TCA field types on Pet

`input` · `text` (RTE + plain) · `number` (integer + decimal) · `select` (single/multi/sideBySide) · `radio` · `check` (toggle + multi) · `datetime` (date / datetime / time) · `file` · `link` · `color` · `email` · `slug` · `uuid` · `json` · `flex` · `category` · `group` (MM) · `inline` (1:N) · `language`

### Relation patterns

| Pattern | Where |
|---|---|
| M:1 via `select` | Pet → Category |
| M:N via `group` + MM table | Pet ↔ Tag |
| 1:N via `inline` | Pet → Orders |
| Self-reference via `select` | Category → parent Category |
| M:1 via `group` | Order → Pet |

## Requirements

| Dependency | Version |
|---|---|
| TYPO3 | `^13.4 \|\| ^14.3` |
| PHP | `^8.2` |

## Installation

```bash
composer require maikschneider/typo3-petstore
```

Run the database compare in the Install Tool (or `vendor/bin/typo3 database:updateschema`) to create the tables.

## CLI commands

### Page structure

Creates the full petstore sitemap (18 pages) and content elements.

```bash
vendor/bin/typo3 petstore:setup:pages
```

| Option | Default | Description |
|---|---|---|
| `--root-pid` | `0` | Parent PID for the petstore root page |
| `--force` | — | Create even if a "Petstore" page already exists |

### Demo data

Imports categories, tags, pets, customers, and orders into a sys\_folder.

```bash
# Creates a new "Petstore Demo Data" sys_folder automatically
vendor/bin/typo3 petstore:setup:data

# Import into an existing folder
vendor/bin/typo3 petstore:setup:data --pid=42
```

| Option | Default | Description |
|---|---|---|
| `--pid` / `-p` | — | Target sys\_folder UID. Creates a new folder when omitted. |

## Fixtures

All fixture data lives in `Resources/Private/Fixtures/` as plain CSV files:

```
Resources/Private/Fixtures/
├── Pages.csv            # 18 pages — sitemap for a pet store website
├── ContentElements.csv  # Content elements for key pages
├── Categories.csv       # 5 animal categories
├── Tags.csv             # 8 tags (family-friendly, hypoallergenic, …)
├── Pets.csv             # 8 pets across all categories
├── Customers.csv        # 3 demo customers
└── Orders.csv           # 4 demo orders
```

The files are intentionally minimal and designed to be extended.

## Quality tools

```bash
# Run all checks
composer sca

# Individual
composer php:fixer    # php-cs-fixer auto-fix
composer php:stan     # PHPStan (level 7)
```

## License

GPL-2.0-or-later
