# TYPO3 Petstore

A demo TYPO3 extension and showcase dataset for [maikschneider/tca-api](https://github.com/maikschneider/tca-api). Install it, run `ddev init-typo3`, and a fully wired Petstore API with an [API Platform Admin](https://api-platform.com/docs/admin/) frontend is ready in seconds.

<!-- screenshot -->

## API endpoints

| Method | Endpoint | Resource |
|---|---|---|
| `GET / POST` | `/_api/pets` | Pet collection |
| `GET / PUT / DELETE` | `/_api/pets/{id}` | Single pet |
| `GET / POST` | `/_api/categories` | Category collection |
| `GET / POST` | `/_api/tags` | Tag collection |
| `GET / POST` | `/_api/orders` | Order collection |
| `GET / POST` | `/_api/customers` | Customer collection |

All endpoints are public. Responses are Hydra JSON-LD. The API prefix is configurable via the TCA API site set.

## Requirements

| Dependency | Version |
|---|---|
| TYPO3 | `^13.4 \|\| ^14.3` |
| PHP | `^8.2` |
| maikschneider/tca-api | `dev-main` |

## Demo setup

```bash
composer require maikschneider/typo3-petstore
ddev start
ddev init-typo3
```

`init-typo3` sets up a fresh TYPO3 installation, imports all demo fixtures (18 pets, 8 customers, 12 orders, categories, tags), and copies the fixture images to fileadmin. After that the API and the Admin UI are immediately usable.

**Credentials:** `admin` / `Passw0rd!`

## License

GPL-2.0-or-later
