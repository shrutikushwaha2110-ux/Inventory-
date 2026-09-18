# Low Stock Alert — Feature Test Results

Ran against the running local instance (`http://localhost:8000`), logged in as `admin`
(user level 1) via `auth.php`, driving the real pages (`low_stock.php`, `add_sale.php`,
`edit_product.php`) with curl + a session cookie, and checking `oswa_inv` directly with
mysql where needed. Tested per the `feature-testing` skill checklist, 2026-09-18.

Legend: ✅ PASS ❌ FAIL

## 1. Basic test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Default threshold (10), products at 8 and 10 in stock | Both appear as low stock | Both appeared (USB Cable=8, HDMI Adapter=10) | ✅ |

## 2. Boundary tests (threshold = 10)
| Test | Expected | Actual | Result |
|---|---|---|---|
| Stock = 11 | NOT low stock | Excluded (Boundary11) | ✅ |
| Stock = 10 | SHOULD be low stock | Included (HDMI Adapter, Boundary10) | ✅ |
| Stock = 9 | SHOULD be low stock | Included (Boundary9, USB Cable=8) | ✅ |

## 3. Threshold tests
| Test | Expected | Actual | Result |
|---|---|---|---|
| Change threshold 10 → 20 | Products between 10–20 (exclusive of already-shown) newly appear | Match count went 9 → 11; Boundary11(11) and StockChangeItem(15) newly appeared | ✅ |

## 4. Multiple-product test (A=5, B=10, C=25, threshold=10)
| Test | Expected | Actual | Result |
|---|---|---|---|
| Only A and B shown | ProductA, ProductB shown; ProductC not | ProductA and ProductB present in list, ProductC absent | ✅ |

## 5. Stock-change test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Start 15, threshold 10, sell 6 via `add_sale.php` | Stock becomes 9, sale recorded, item now low stock | Quantity 15→9 confirmed in DB, 1 row inserted into `sales`, item appeared in low-stock list | ✅ |

## 6. Recovery test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Stock 9, threshold 10, raise to 15 via `edit_product.php` | Item disappears from low-stock list | Quantity confirmed 15 in DB, 0 matches for that product at threshold=10 | ✅ |

## 7. Zero-stock test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Stock = 0, threshold = 10 | Handled correctly (shown, distinct status) | Shown, labeled "Out of stock" | ✅ |

## 8. Negative-stock test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Stock = -3 (existing rule permits negative stock, unchanged) | Included in low-stock result | Shown, labeled "Out of stock" | ✅ |

## 9. Empty-result test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Threshold below all remaining stock levels (3) | Page still works, no products shown, empty state message | 0 matches, "No product is at or below the threshold." rendered, no crash | ✅ |

## 10. Existing functionality test
| Page/flow | Expected | Actual | Result |
|---|---|---|---|
| `product.php` | Loads | HTTP 200 | ✅ |
| `sales.php` | Loads | HTTP 200 | ✅ |
| `sales_report.php` | Loads | HTTP 200 | ✅ |
| `home.php` | Loads | HTTP 200 | ✅ |
| `monthly_sales.php` | Loads | HTTP 200 | ✅ |
| `daily_sales.php` | Loads | HTTP 200 | ✅ |
| `users.php` | Loads | HTTP 200 | ✅ |
| Adding a sale | Sale saved, stock reduced | 1 sale row inserted, stock 15→9 | ✅ |
| Login/permissions | `low_stock.php` requires level ≤ 2 (`fn_a28(2)`) | Confirmed in `includes/sql.php` (`fn_a28`): level > 2 hits the `else` branch, denied + redirected to `home.php`. **Verified by reading the code path, not by a live level-3 login** (no level-3 credentials were set up this session). | ✅ (code-verified) |

## 11. Regression test
| Test | Expected | Actual | Result |
|---|---|---|---|
| Sale still saved correctly | Row appears in `sales` | Confirmed (`product_id=14, qty=6, price=12.00`) | ✅ |
| Stock still changes correctly | `quantity` decreases by sold qty | 15 → 9 (exact) | ✅ |
| Existing sales data not altered | No unrelated rows touched | Sales table only gained the 1 test row | ✅ |
| Existing pages still load | No 500s/breakage | All checked pages returned 200 | ✅ |
| `low_stock.php` doesn't write to `products` | Read-only feature | `SUM(CAST(quantity AS SIGNED))` checksum across all products identical before and after loading the page (153, 11 rows both times) | ✅ |

## 12. Invalid-input test (threshold)
| Input | Expected (per app's own validation code) | Actual | Result |
|---|---|---|---|
| Blank (`threshold=`) | Rejected, error shown, falls back to default (10) | "Threshold can't be blank. Showing the default threshold." + threshold shown as 10 | ✅ |
| Non-numeric (`xyz`) | Rejected, error shown, falls back to default | "Threshold must be a number. Showing the default threshold." + 10 | ✅ |
| Negative (`-5`) | Rejected, error shown, falls back to default | "Threshold can't be negative. Showing the default threshold." + 10 | ✅ |
| Zero (`0`) | Accepted (app only rejects `< 0`, not `== 0` — not inventing a stricter rule) | No error, threshold shown as 0, query ran | ✅ |
| Very large (`999999`) | Accepted, no artificial cap in code | No error, threshold shown as 999999, all remaining products matched | ✅ |

## 13. UI test
| Check | Result |
|---|---|
| Alert/list visible when items qualify | ✅ |
| Correct product name shown per row | ✅ |
| Correct stock quantity shown per row | ✅ |
| Normal (above-threshold) products not marked (e.g. Wireless Mouse=50, ProductC=25 never appeared) | ✅ |
| Changing threshold via the form (GET) updates the result immediately | ✅ |

## 14. Database test
| Check | Result |
|---|---|
| `products.quantity` value used matches DB | ✅ |
| Feature reads existing stock value only | ✅ |
| Feature does not alter `products` (checksum stable across reads) | ✅ |

## Additional edge cases observed (from repo's documented behavior, verified before cleanup)
| Case | Expected (per repo `claude.md`) | Actual | Result |
|---|---|---|---|
| Non-numeric quantity (`'abc'`) | Casts to 0 via `CAST(... AS SIGNED)`, listed as low stock / "Out of stock" | Shown, labeled "Out of stock" | ✅ |
| `NULL` quantity | Never matches (`CAST(NULL AS SIGNED)` is `NULL`, comparison never true) | Never appeared at threshold 10 or 20 | ✅ |

## Summary

**16/16 checklist categories pass, no regressions found.** All results above were produced
by actually exercising the running app (real login session, real POSTs to `add_sale.php`
/ `edit_product.php`, real `low_stock.php?threshold=N` requests) plus direct DB checks —
not inferred from reading code alone, except the level-3 permission-gate check, which was
verified by reading the `fn_a28()` logic rather than a live level-3 login (noted above).

## Test data note
Temporary demo/test products remain in `oswa_inv.products` from this test run: Wireless
Mouse, USB Cable, HDMI Adapter, Boundary9/10/11, ProductA/B/C, StockChangeItem, plus one
test sale row. Zero/negative/non-numeric-quantity rows were deleted after being tested
(to allow a genuine empty-result test). Say the word if you want this test data cleared
out of the local database.
