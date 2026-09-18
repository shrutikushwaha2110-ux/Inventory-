# Inventory & Warehouse Stock System

A small PHP/MySQL inventory and sales web application, extended with a
**location-based stock model and inter-location stock transfers** plus a
**low-stock alert** feature.

This started from a stripped/obfuscated legacy codebase (function and variable
names like `fn_a39`, `$x126` were already like that — not renamed by us) and
was reverse-engineered before any change was made. See [`claude.md`](claude.md)
for the full architecture writeup and [`FIRST_GUESS_VS_REALITY.md`](FIRST_GUESS_VS_REALITY.md)
for what was assumed vs. verified.

## What's here

- Original inventory/sales app: products, categories, sales, users, roles, media.
- **Low-stock alert** (`low_stock.php`) — configurable threshold, now **per location**.
- **Locations** (`locations` table) and **per-location stock** (`product_stock` table),
  independent from the legacy global `products.quantity` used by the original sales flow.
- **Stock transfers** (`add_transfer.php`, `transfer_history.php`) — move stock between
  locations; blocks a transfer if the source location doesn't have enough stock.

## Requirements

- PHP 7+ (tested with PHP 8.5, built-in dev server)
- MySQL/MariaDB
- No build step, no Composer dependencies.

## Setup

1. Create a database and import the schema:
   ```
   mysql -u <user> -p < oswa_inv.sql
   ```
2. Set your DB credentials in `includes/config.php` (`DB_HOST`, `DB_USER`, `DB_PASS`,
   `DB_NAME`). `LOW_STOCK_THRESHOLD` there is the default low-stock threshold (can be
   overridden per-request from the low-stock page).
3. Run it:
   ```
   php -S localhost:8000
   ```
   then open `http://localhost:8000/index.php`.

## Default accounts (schema seed data)

| Username | Role level |
|---|---|
| `admin`   | 1 — Admin |
| `special` | 2 — special |
| `user`    | 3 — User |

Passwords are `sha1()`-hashed in the schema dump — set your own before using this anywhere
beyond a local test instance.

## Low-stock alerts

`low_stock.php` lists every (product, location) pair at or below a threshold. The
threshold defaults to `LOW_STOCK_THRESHOLD` in `includes/config.php` and can be overridden
live via `?threshold=N` on that page. Access requires role level ≤ 2.

## Stock transfers

`add_transfer.php` records a transfer of a product between two locations: it decreases
the source location's quantity and increases the destination's. It checks the source has
enough stock before allowing the transfer — if not, it's rejected and nothing is written.
`transfer_history.php` shows current stock by location and the full transfer log.

## Docs

- [`claude.md`](claude.md) — architecture, schema, data model, and function map as
  reverse-engineered and verified against the actual code/database.
- [`FIRST_GUESS_VS_REALITY.md`](FIRST_GUESS_VS_REALITY.md) — initial assumptions vs.
  what was actually found in the code.
- [`LOW_STOCK_TEST_RESULTS.md`](LOW_STOCK_TEST_RESULTS.md) /
  [`LOCATION_TRANSFER_TEST_RESULTS.md`](LOCATION_TRANSFER_TEST_RESULTS.md) — live test
  results (PASS/FAIL) for the low-stock and location/transfer features.
