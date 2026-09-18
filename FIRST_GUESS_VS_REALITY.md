# First Guess vs. Reality — Ghost Repo Project 3

## FIRST GUESS
On first opening a stripped, obfuscated inventory/sales app called "the warehouse that
runs out silently," the natural assumption was that a warehouse/location concept was
*already there but hidden* — stripped naming schemes often disguise real structure rather
than remove it. Specific first guesses:

- There's probably a `location` or `warehouse_id` column on `products`, just renamed to
  something like `x51` or folded into `categorie_id`.
- `group.php` / `user_groups` (with `group_level`) sounded like it could double as a
  location/branch grouping, not just user roles.
- Given a `sales` table exists, there might be an equivalent `transfers` or `movements`
  table already present but never linked from any page — i.e. backend-only, UI not wired
  up yet.
- "Balance" and "history" seemed likely to be computed from a ledger/transaction log
  rather than read directly off a single column, since that's the more common pattern in
  inventory systems.

## REALITY
Every one of those guesses was checked directly against the code/schema and turned out
to be wrong:

- **No hidden location column.** The live schema (`SHOW TABLES` / `mysqldump --no-data`)
  had exactly 6 tables before this feature: `categories`, `media`, `products`, `sales`,
  `user_groups`, `users`. `products` had 8 columns total (`id, name, quantity, buy_price,
  sale_price, categorie_id, media_id, date`) — no location field, disguised or otherwise.
- **`user_groups` is genuinely just roles.** `group.php` renders `group_name` /
  `group_level` / `group_status` in a table titled "Groups" with values "Admin" (1),
  "special" (2), "User" (3) — a permission-level system consumed by `fn_a28()`, unrelated
  to physical locations. Confirmed by reading `group.php` in full and the `user_groups`
  schema, not inferred.
- **No hidden transfer table or function.** A repo-wide case-insensitive grep for
  `warehouse|location|transfer` across every `.php` file returned exactly 3 files, and
  every hit was unrelated: `header('Location: ' . $x113, ...)` in `includes/functions.php`
  (an HTTP redirect header) and two "The file location was not available." error strings
  in `includes/upload.php`. Reading all ~30 functions in `includes/sql.php` in full
  confirmed the only stock-mutating function is `fn_a39($qty, $productId)`, a single
  `UPDATE products SET quantity = quantity - qty` — one location implied, one direction,
  no source/destination pair anywhere.
- **Balance is not computed — it's read straight off a column.** `fn_a24()`, `fn_a15()`,
  and the original `fn_a43()` all just `SELECT ... p.quantity ...` from `products`. There
  is no ledger, no sum-of-transactions, nothing computed. "History" is limited to the
  `sales` table itself (`id, product_id, qty, price, date`) — there was no separate
  stock-movement history table before this feature added `transfers`.

## Net effect on scope
The first guess implied this might be a "surface the hidden feature and wire up a UI"
task. The reality was a genuine "add a new capability from zero" task: three new tables,
five new SQL functions, one rewritten page, two new pages. The minimum-change constraint
was applied by leaving the entire pre-existing sales/stock flow (`products.quantity`,
`fn_a39`, `add_sale.php`, `edit_sale.php`, `product.php`) completely untouched and building
the location/transfer model as an additive, parallel structure instead.
