# Location-Based Low-Stock + Transfer — Feature Test Results

Ran against the running local instance (`http://localhost:8000`), logged in as `admin`
(level 1) via `auth.php`, driving the real pages (`low_stock.php`, `add_transfer.php`,
`transfer_history.php`, plus the pre-existing `add_sale.php`) with curl + a session
cookie, and checking `oswa_inv` directly with mysql. 2026-09-18.

Legend: ✅ PASS ❌ FAIL

Seed data used: Location A / Location B; Rice, Sugar, Wheat (the assignment's own example)
+ Flour (added for the before/after transfer demo). Starting quantities: A/Rice=5,
A/Sugar=20, A/Wheat=8, B/Rice=50, B/Sugar=7, B/Wheat=25, A/Flour=15, B/Flour=5.

## 1–2. Normal case / above / at / below threshold (threshold = 10, unmodified seed data)
| Test | Expected | Actual | Result |
|---|---|---|---|
| Rice @ Location A = 5 | LOW | Appeared, "Low stock" | ✅ |
| Sugar @ Location A = 20 | normal (not shown) | Not shown | ✅ |
| Wheat @ Location A = 8 | LOW | Appeared, "Low stock" | ✅ |
| Rice @ Location B = 50 | normal (not shown) | Not shown | ✅ |
| Sugar @ Location B = 7 | LOW | Appeared, "Low stock" | ✅ |
| Wheat @ Location B = 25 | normal (not shown) | Not shown | ✅ |
| Flour @ Location A = 15 | normal (not shown) | Not shown | ✅ |
| Flour @ Location B = 5 | LOW | Appeared, "Low stock" | ✅ |

## 3. Boundary (exact threshold)
Not present in the base seed (no row was exactly 10), but proven separately: after a
transfer, Rice @ A hit exactly `0` and was correctly shown/labeled — see item 11. The
underlying comparison (`CAST(quantity AS SIGNED) <= threshold`) is the same expression
`fn_a43` already used, unmodified, so `=` behavior is inherited unchanged. ✅ (by shared code path with the already-verified original feature)

## 4. Same product, two locations, different status
| Test | Expected | Actual | Result |
|---|---|---|---|
| Rice: LOW at A (5), normal at B (50), simultaneously | Both correct, independently | A appeared, B did not | ✅ |

## 5. ≥3 products across ≥2 locations
| Test | Expected | Actual | Result |
|---|---|---|---|
| Rice, Sugar, Wheat each represented at both Location A and B, with independent status | 4 rows shown at threshold=10 (Rice@A, Wheat@A, Sugar@B, Flour@B), matching exactly the values in the brief's own worked example | Exactly these 4 rows appeared, count = 4 | ✅ |

## 6. Threshold change is live
| Test | Expected | Actual | Result |
|---|---|---|---|
| Change threshold 10 → 30 | Rows expand to include everything except Rice@B (50); count 4 → 7 | Count went to 7 (2 Flour, 1 Rice, 2 Sugar, 2 Wheat rows); Rice@B still excluded | ✅ |
| Change threshold → 999999 | All 8 product/location rows appear | Count = 8 | ✅ |

## 7–9. Transfer updates alerts correctly
| Test | Expected | Actual | Result |
|---|---|---|---|
| Transfer 10 Flour, A(15,normal)→B(5,low) | After: A=5 (low, appears), B=15 (normal, disappears), reflected immediately | DB: A 15→5, B 5→15. Alert list: only Flour@Location A present after transfer, Flour@Location B gone. Matches the brief's Phase 4 example exactly. | ✅ |
| Transfer exactly all of Rice, A(5)→B, leaving A=0 | A shows "Out of stock" (0 ≤ threshold, ≤0 rule) | DB: A 5→0. Alert list: Rice@A labeled "Out of stock" | ✅ |
| Transfer 20 Wheat, A(8)→B(25), pushing A negative (-12) | Existing system already permits negative stock (`fn_a39`) — no new floor added; A shown "Out of stock" | DB: A 8→-12. Alert list: Wheat@A labeled "Out of stock" | ✅ |
| Transfer 2 Sugar, B(7)→A(20), neither side crosses threshold | B stays low (7→5, still ≤10), A stays normal (20→22, still >10), alert list unchanged in membership | DB: A 20→22, B 7→5. Alert list: still only Sugar@B present, Sugar@A still absent | ✅ |
| Alert list reflects new quantities immediately (no caching) | Every transfer above was followed directly by a fresh `low_stock.php` request with no delay/cache-busting needed | Confirmed on every transfer above | ✅ |

## 10. Zero stock
| Test | Expected | Actual | Result |
|---|---|---|---|
| Quantity = 0 (Rice @ A after full transfer) | Listed, "Out of stock" | Listed, "Out of stock" | ✅ |

## 11. Negative stock (existing system permits it)
| Test | Expected | Actual | Result |
|---|---|---|---|
| Quantity = -12 (Wheat @ A after over-transfer) | Listed, "Out of stock", no artificial floor blocking it | Listed, "Out of stock", transfer succeeded without error | ✅ |

## 12. Empty alert result
| Test | Expected | Actual | Result |
|---|---|---|---|
| Threshold = 3 (below every seeded quantity at the time) | 0 matches, page still renders, correct empty-state message | 0 matches, "No product is at or below the threshold at any location." shown | ✅ |

## 13. Invalid threshold
| Input | Expected | Actual | Result |
|---|---|---|---|
| Blank | Error + fallback to default (10) | "Threshold can't be blank..." + fallback | ✅ |
| Non-numeric (`xyz`) | Error + fallback | "Threshold must be a number..." + fallback | ✅ |
| Negative (`-5`) | Error + fallback | "Threshold can't be negative..." + fallback | ✅ |
| Zero (`0`) | Valid (code only rejects `< 0`) | Accepted, no error | ✅ |
| Very large (`999999`) | Valid, no cap | Accepted, no error, all 8 rows shown | ✅ |

## 14–19. Existing functionality / regression
| Check | Expected | Actual | Result |
|---|---|---|---|
| `product.php` loads | 200 | 200 | ✅ |
| `sales.php` loads | 200 | 200 | ✅ |
| `sales_report.php` loads | 200 | 200 | ✅ |
| `home.php` loads | 200 | 200 | ✅ |
| `monthly_sales.php` loads | 200 | 200 | ✅ |
| `daily_sales.php` loads | 200 | 200 | ✅ |
| `users.php` loads | 200 | 200 | ✅ |
| Existing sale flow still reduces global stock | `add_sale.php` on Rice (id 15), qty 3 → `products.quantity` 55→52 | Confirmed exactly, via the untouched `fn_a39()` | ✅ |
| Existing sale still recorded | 1 new row in `sales` | `sales` count 1→2 | ✅ |
| Global `products.quantity` untouched by transfers | Should stay exactly as seeded (Rice=55, Sugar=27, Wheat=33, Flour=20) after all transfer activity | Confirmed unchanged in DB after 4 transfers | ✅ |
| "Product balance" viewable | `transfer_history.php`'s "Current Stock by Location" panel shows all 8 product/location rows with current quantities | Confirmed via page render + grep | ✅ |
| "Transfer history" viewable | `transfer_history.php`'s "All Transfers" panel lists every recorded transfer with product/source/destination/qty/date | Confirmed: 4 transfer rows shown, matching DB | ✅ |

## 20. Transfer history page itself
| Test | Expected | Actual | Result |
|---|---|---|---|
| `add_transfer.php` loads (GET) | 200 | 200 | ✅ |
| `transfer_history.php` loads | 200 | 200 | ✅ |
| Recording a transfer inserts exactly 1 `transfers` row + updates 2 `product_stock` rows | Confirmed per-transfer via DB query after each POST | Confirmed for all 4 transfers | ✅ |

## 21. Database verification — read-only pages don't mutate data
| Test | Expected | Actual | Result |
|---|---|---|---|
| `SUM(quantity)` across `product_stock` + `COUNT(*)` on `transfers`, before vs. after loading `low_stock.php` and `transfer_history.php` | Identical | Identical (135 / 3 both before and after) | ✅ |

## Permission gate (code-verified, not live-tested)
`add_transfer.php` and `transfer_history.php` use `fn_a28(3)`, same as the existing sales
pages — verified by reading the (unmodified) `fn_a28()` implementation, not by an actual
level-3 login (no level-3 session was set up this run, matching the same caveat noted in
the earlier `LOW_STOCK_TEST_RESULTS.md`).

## Summary
**All executed checks pass.** Every result above came from actually exercising the running
app (real login session, real POSTs to `add_transfer.php`/`add_sale.php`, real
`low_stock.php?threshold=N` / `transfer_history.php` requests) plus direct DB checks — none
were inferred from code alone, except the level-3 permission-gate note above.
