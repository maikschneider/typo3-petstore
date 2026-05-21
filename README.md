# TYPO3 Petstore

A demo TYPO3 extension that serves as the **official showcase dataset for [maikschneider/tca-api](https://github.com/maikschneider/tca-api)**. It ships five fully configured REST API endpoints, 18 realistic demo records, a complete site page structure, and covers every TCA field type and relation pattern available in TYPO3 13/14.

## API endpoints

Install the extension, run the data bootstrap command, and these endpoints are ready:

| Method | Endpoint | Resource |
|---|---|---|
| `GET` | `/api/pets` | Pet collection |
| `GET` | `/api/pets/{id}` | Single pet |
| `GET` | `/api/categories` | Category collection |
| `GET` | `/api/tags` | Tag collection |
| `GET` | `/api/orders` | Order collection |
| `GET` | `/api/customers` | Customer collection |

The API prefix is configurable via the TCA API site set. All responses are Hydra JSON-LD.

## What it includes

- **REST API** — five resources auto-exposed by `maikschneider/tca-api`, zero custom code
- **TCA reference** — every field type available in TYPO3 13/14 in one place (see Pet model)
- **Realistic demo data** — 7 categories, 14 tags, 18 pets, 8 customers, 12 orders
- **Page structure** — 18-page sitemap for a complete pet store website
- **CLI bootstrap** — two commands to populate any TYPO3 instance in seconds

## Requirements

| Dependency | Version |
|---|---|
| TYPO3 | `^13.4 \|\| ^14.3` |
| PHP | `^8.2` |
| maikschneider/tca-api | `dev-main` |

## Installation

```bash
composer require maikschneider/typo3-petstore
```

Run the database compare in the Install Tool (or `vendor/bin/typo3 database:updateschema`) to create the tables, then configure the TCA API site set on your site root.

## Bootstrap

```bash
# 18-page site structure with content elements
vendor/bin/typo3 petstore:setup:pages

# Demo records — creates a new sys_folder automatically
vendor/bin/typo3 petstore:setup:data

# Or import into an existing folder
vendor/bin/typo3 petstore:setup:data --pid=42
```

## Models

| Model | Table | Notable fields |
|---|---|---|
| **Pet** | `tx_typo3petstore_domain_model_pet` | All TCA field types (see below) |
| **Category** | `tx_typo3petstore_domain_model_category` | Self-referencing parent, color, file |
| **Tag** | `tx_typo3petstore_domain_model_tag` | input, color, text |
| **Order** | `tx_typo3petstore_domain_model_order` | group relation to Pet, email, datetime |
| **Customer** | `tx_typo3petstore_domain_model_customer` | password, email, select, file |

### TCA field types on Pet

`input` · `text` (RTE + plain) · `number` (integer + decimal) · `select` (single / multi / sideBySide) · `radio` · `check` (toggle + multi) · `datetime` (date / datetime / time) · `file` · `link` · `color` · `email` · `slug` · `uuid` · `json` · `flex` · `category` · `group` (MM) · `inline` (1:N) · `language`

### Relation patterns

| Pattern | Where |
|---|---|
| M:1 via `select` | Pet → Category |
| M:N via `group` + MM table | Pet ↔ Tag |
| 1:N via `inline` | Pet → Orders |
| Self-reference via `select` | Category → parent Category |
| M:1 via `group` | Order → Pet |

## Fixtures

```
Resources/Private/Fixtures/
├── Pages.csv            # 18 pages — full pet store sitemap
├── ContentElements.csv  # Hero and body content for key pages
├── Categories.csv       # 7 animal categories
├── Tags.csv             # 14 tags (family-friendly, rescue, show-quality, …)
├── Pets.csv             # 18 pets across all categories
├── Customers.csv        # 8 demo customers
└── Orders.csv           # 12 orders covering all statuses
```

## Quality tools

```bash
composer sca           # run all checks
composer php:fixer     # php-cs-fixer auto-fix
composer php:stan      # PHPStan (level 7)
```

## License

GPL-2.0-or-later
