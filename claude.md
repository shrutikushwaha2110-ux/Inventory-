# Ghost Repo — Project 3
## Notes for us + Claude when opening this repo cold

Read this first. The repository is intentionally stripped/obfuscated, so this file records
what we verified from the supplied code and schema, plus the location/transfer feature
added on top of it.

## What this is
Small PHP/MySQL inventory and sales web application, now extended with a **location-based
stock model and inter-location transfer feature**.
The original code has no useful README/comments and user-defined names were changed to
meaningless names. This file records the repository structure, data model, verified
behaviour, important mappings, and known uncertainties — for both the original app and the
location/transfer addition.

## How the application is structured
Simple flow:
Browser → PHP pages → MySQL database
JavaScript/AJAX is used for browser-side interactions.
PHP contains the server-side logic.
MySQL stores products, sales, users, categories, groups, media — plus, as of this feature,
locations, per-location stock, and transfers.

## Main folders/files
- `includes/load.php` — loads configuration and helper files.
- `includes/config.php` — database configuration; database name is `oswa_inv`.
  Also defines `LOW_STOCK_THRESHOLD`, the default low stock threshold (global, not per-location).
- `includes/database.php` — MySQLi database wrapper (`ClassB2`). No transaction support
  (no begin/commit/rollback methods) — multi-step writes in this codebase are done as
  sequential separate queries (see `add_sale.php`), and the new transfer code follows the
  same convention.
- `includes/session.php` — login/session handling (`ClassB3`).
- `includes/functions.php` — validation, escaping, dates, redirects and calculations.
- `includes/sql.php` — SQL/query helper functions, including the new location/transfer ones.
- `includes/upload.php` — media upload/delete helpers.
- `layouts/header.php` — login check, current user and role-based navigation.
- `layouts/footer.php` — footer and scripts.
- `layouts/admin_menu.php`, `special_menu.php`, `user_menu.php` — role menus. Both
  `admin_menu.php` and `special_menu.php` now have a "Transfers" submenu (Transfer History,
  Add Transfer).
- `libs/js/functions.js` — AJAX product search, sale lookup and total calculation.
- `libs/css/main.css` — styling.
- `ajax.php` — product search/sale lookup endpoint (unchanged, unrelated to transfers).
- `low_stock.php` — **rewritten** to be location-aware (see below).
- `add_transfer.php` — **new**. Records a stock transfer between two locations.
- `transfer_history.php` — **new**. Shows current stock-by-location and full transfer history.

## Database model
Original tables (unchanged):
- `products` — product information + a legacy global `quantity` column (see below).
- `sales` — sale history.
- `categories` — product categories.
- `users` — application users.
- `user_groups` — user roles/groups (levels 1/2/3 — this is a **role** system, not
  locations; verified by reading `group.php` and the `user_groups` schema before assuming
  otherwise).
- `media` — product/media records.

New tables (added for this feature):
- `locations` (`id`, `name`) — same shape/convention as `categories`.
- `product_stock` (`id`, `product_id`, `location_id`, `quantity`) — the actual per-location
  on-hand quantity. `UNIQUE(product_id, location_id)` — one row per product/location pair.
  This is the source of truth for everything location-aware.
- `transfers` (`id`, `product_id`, `source_location_id`, `destination_location_id`, `qty`,
  `date`) — one row per recorded transfer.

Relationships:
- `products.categorie_id → categories.id`
- `sales.product_id → products.id`
- `users.user_level → user_groups.group_level`
- `product_stock.product_id → products.id`, `product_stock.location_id → locations.id`
- `transfers.product_id → products.id`, `transfers.source_location_id → locations.id`,
  `transfers.destination_location_id → locations.id`
All new FKs use `ON DELETE CASCADE ON UPDATE CASCADE`, matching the existing pattern
(`FK_products`, `SK` on the original schema).

## Stock and sales flow (original, unchanged)
Current **global** stock is stored in `products.quantity` (`varchar(50)`).
Verified flow: `add_sale.php` → inserts sale into `sales` → calls `fn_a39()` → decreases
`products.quantity`.
This flow, and every function/page in it, is **completely untouched** by the location/
transfer feature. `products.quantity` is not read or written anywhere in the new code —
it remains whatever it was, a separate/legacy global total.

Important: this is the stock-changing flow that existed before this feature and still
works exactly the same way.

## Location-based stock model (new)
`products.quantity` (global) and `product_stock.quantity` (per-location) are two
**independent** numbers. Nothing keeps them in sync — that's intentional, to avoid
touching the existing sales flow. A product's location-aware balance is the sum (or
individual rows) of its `product_stock` rows; its legacy/global balance is still
`products.quantity`, used only by the original sale flow and `product.php`/`fn_a24()`.

- `fn_a44($product_id)` — all `product_stock` rows for one product, joined to `locations`
  for the location name. Used for a per-product balance-by-location view.
- `fn_a48()` — all `product_stock` rows for every product, joined to both `products` and
  `locations`. Used by `transfer_history.php`'s "Current Stock by Location" panel.

## Transfer model (new)
- `fn_a46($product_id, $source_location_id, $destination_location_id, $qty)` — records a
  transfer. Does three sequential (non-transactional, matching `add_sale.php`'s style)
  queries:
  1. `INSERT INTO product_stock (...) VALUES (product, source, -qty) ON DUPLICATE KEY
     UPDATE quantity = quantity - qty` — decrements the source (or creates a negative row
     if none existed, matching `fn_a39()`'s existing willingness to let quantity go
     negative — no floor was added here that doesn't already exist elsewhere).
  2. Same pattern for the destination, adding instead of subtracting.
  3. `INSERT INTO transfers (...)` — records the transfer itself.
  Returns `true` only if all three queries succeeded.
- `add_transfer.php` — the page. Plain `<select>` dropdowns for product/source/destination
  (not the AJAX search box `add_sale.php` uses — kept intentionally simpler since only a
  handful of products/locations exist; this is a deliberate scope-minimizing choice, not
  an oversight). Access level `fn_a28(3)`, same as the sales pages. One added validation
  rule beyond required-field checking: source and destination can't be the same location
  (necessary for the feature to make sense; no other business rule was invented).
- `fn_a47()` — transfer history: all transfers joined to product/source/destination names,
  newest first. Same shape as `fn_a11()` for sales history.
- `transfer_history.php` — the page. Two panels: "Current Stock by Location" (via
  `fn_a48()`) and "All Transfers" (via `fn_a47()`). Access level `fn_a28(3)`.

## Low-stock alert flow (rewritten to be location-aware)
- `includes/config.php` — `LOW_STOCK_THRESHOLD` (default `10`), the default threshold.
  Still a single **global** value — the assignment brief explicitly allows a single
  configurable threshold rather than a per-location one, so this wasn't changed.
- `includes/sql.php` — `fn_a45($threshold)`, the location-aware replacement for the old
  `fn_a43($threshold)`. Joins `product_stock` → `products` → `locations`, same
  `CAST(quantity AS SIGNED) <= threshold` comparison `fn_a43` already used (reused
  as-is, not reinvented). `fn_a43()` itself is untouched and still exists, but
  `low_stock.php` no longer calls it — nothing else in the repo calls `fn_a43()`, so it
  is now dead code, kept rather than deleted per "don't remove existing functionality."
- `low_stock.php` — now shows one row per (product, location) that's at/below threshold:
  Location, Product Title, Quantity, Threshold, Status. Same threshold-override-via-GET
  (`?threshold=N`) and same invalid-input handling as before (blank/non-numeric/negative →
  red alert + fallback to default; zero and very large values are valid, no invented
  stricter rule). Status label logic (`quantity <= 0` → "Out of stock", else → "Low
  stock") is unchanged from the original page.

## Sale pages (unchanged)
- `sales.php`, `add_sale.php`, `edit_sale.php`, `delete_sale.php`,
  `sales_report.php`, `sale_report_process.php`, `monthly_sales.php`, `daily_sales.php`.
- **Confirmed pre-existing bug, not touched**: `edit_sale.php` calls `fn_a39($newQty,
  $productId)` on update without first reversing the old quantity — editing a sale's
  quantity does not correctly rebalance `products.quantity`.
- **Confirmed pre-existing behaviour, not touched**: `delete_sale.php` only deletes the
  `sales` row; it never restores `products.quantity`.

## Other pages
Products: `product.php`, `add_product.php`, `edit_product.php`, `delete_product.php` — all
unchanged, still operate purely on `products.quantity` (the global/legacy column).
Low stock: `low_stock.php` — now location-aware (see above).
Transfers: `add_transfer.php`, `transfer_history.php` — new.
Categories: `categorie.php`, `edit_categorie.php`, `delete_categorie.php`.
Media: `media.php`, `delete_media.php`.
Login/dashboard: `index.php`, `login_v2.php`, `home.php`, `admin.php`, `logout.php`.
Users: `users.php`, `add_user.php`, `edit_user.php`, `delete_user.php`.
Groups: `group.php`, `add_group.php`, `edit_group.php`, `delete_group.php` (user **roles**,
not physical locations).
Account: `profile.php`, `edit_account.php`, `change_password.php`.

## Roles
Database group levels:
1 = Admin
2 = special
3 = User

`header.php` selects the menu based on the user's level.
`fn_a28()` is the page access/permission check. `add_transfer.php` and
`transfer_history.php` use `fn_a28(3)`, the same level `sales.php`/`add_sale.php` use, so
all three roles can reach them (level-3 access to transfers was a deliberate choice
matching the sales pages' access level, since transfers are a stock-movement operation
like sales — not independently specified by the brief).

## Obfuscated function map
Original functions (unchanged — see prior revisions of this file for how each was traced):
`fn_a39`, `fn_a24`, `fn_a43` (now unused, see above), `fn_a10`, `fn_a18`, `fn_a19`,
`fn_a11`, `fn_a20`, `fn_a17`, `fn_a21`, `fn_a6`, `fn_a27`, `fn_a1`, `fn_a2`, `fn_a5`,
`fn_a28`, `fn_a12`, `fn_a14`, `fn_a13`, `fn_a38`, `fn_a9`, `fn_a16`, `fn_a15`, `fn_a7`,
`fn_a3`, `fn_a36`, `fn_a33`, `fn_a35`, `fn_a22`, `fn_a42`, `fn_a8`, `fn_a34`, `fn_a37`,
`fn_a32`, `fn_a25`, `fn_a4`, `fn_a31`.

New functions (this feature, `includes/sql.php`):
- `fn_a44($x128)` — per-location stock rows for one product; `$x128` = product id.
- `fn_a45($x126)` — low-stock rows across all locations at/below a threshold; `$x126` =
  threshold. Replaces `fn_a43()` as what `low_stock.php` calls.
- `fn_a46($x129,$x130,$x131,$x132)` — records a transfer; `$x129` = product id, `$x130` =
  source location id, `$x131` = destination location id, `$x132` = quantity.
- `fn_a47()` — full transfer history, joined to product/source/destination names.
- `fn_a48()` — current stock for every product at every location, joined to names.

## Classes and important variables
`ClassB2` = database wrapper (see above — no transaction support).
`ClassB3` = session/login wrapper.
Important variables (new, continuing the existing `$xNNN` convention): `$x126` = threshold
(reused from the original low-stock feature); `$x127` = query results in `low_stock.php`;
`$x128` = product id param to `fn_a44`; `$x129`–`$x132` = product/source/destination/qty
params to `fn_a46`; `$x133` = balance-by-location rows in `transfer_history.php`.

## What is NOT verified / remaining uncertainty
- The original "no warehouse/location/transfer concept" note from earlier revisions of
  this file is now **outdated** — that concept has been added by this feature, as
  described above. It was correct at the time it was written (verified by a repo-wide
  grep that found zero real hits, only an unrelated HTTP `Location:` header and file-
  upload error strings — see `FIRST_GUESS_VS_REALITY.md`).
- `products.quantity` (global) and `product_stock.quantity` (per-location) are
  independent and will drift apart over time (e.g. a sale reduces the global total but
  not any location's stock). This is a known, accepted limitation of the minimum-change
  approach — reconciling them was out of scope and would have required touching the
  existing sale flow, which the brief explicitly said must keep working exactly as before.
- Level-3 (non-admin) access to `add_transfer.php`/`transfer_history.php` and to
  `low_stock.php` was verified by reading `fn_a28()`'s code path (level > argument → the
  `else` branch → denied + redirected), not by an actual level-3 login — no level-3
  session was established this run.
- `fn_a46()`'s three queries are not wrapped in a database transaction (the `ClassB2`
  wrapper has no transaction methods, and no other multi-step write in this codebase uses
  one either). If the PHP process died between the source-decrement and destination-
  increment queries, the two locations could end up inconsistent. This is an accepted
  limitation matching the existing codebase's own non-transactional style (e.g.
  `add_sale.php` has the same theoretical gap between its INSERT and its `fn_a39()` call).
- Other pre-existing uncertainties noted before this feature and still unresolved:
  editing a sale's old-quantity handling (now confirmed buggy, see "Sale pages" above),
  arithmetic on `products.quantity` being stored as text.

## Working rules
- Read code before making a claim.
- If uncertain, say it is uncertain and test it.
- Do not refactor or rename unrelated code.
- Preserve existing behaviour.
- Do not fix unrelated bugs during this assignment.
- Keep this file updated when a verified understanding changes.

## Working understanding
The application is a PHP/MySQL inventory system with two coexisting stock models: the
original global `products.quantity` (used by the sales flow, untouched) and the new
per-location `product_stock.quantity` (used by the low-stock-by-location feature and
transfers). Transfers move quantity between `product_stock` rows for the same product and
record a `transfers` row; they never touch `products.quantity` or the `sales` table. The
obfuscated names in this file are mappings based on code behaviour, not renamed source
code.
