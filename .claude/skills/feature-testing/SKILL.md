---
name: feature-testing
description: Test a newly added feature step by step, including normal cases, edge cases, failure cases, existing functionality, and regression checks. Record expected and actual results before considering the feature complete.
---

# Feature Testing

After adding or changing a feature, test it before saying the feature is complete.

## 1. Basic test
Check that the feature works in the normal expected case.

For low-stock:
- Create/use a product with known stock.
- Set a threshold.
- Check whether the correct product appears as low stock.

## 2. Boundary tests
Test values around the threshold.

Example:
Threshold = 10

Test:
- Stock = 11 → should NOT be low stock
- Stock = 10 → SHOULD be low stock
- Stock = 9 → SHOULD be low stock

## 3. Threshold tests
Change the threshold and check that the results change immediately.

Example:
- Threshold = 10
- Change threshold to 20
- Products between 10 and 20 should now appear.

## 4. Multiple-product test
Test several products at the same time.

Example:
- Product A = 5
- Product B = 10
- Product C = 25
- Threshold = 10

Check that only A and B are shown.

## 5. Stock-change test
Check that alerts change when stock changes.

Example:
- Product starts at 15
- Threshold = 10
- Sell 6
- Stock becomes 9
- Product should now appear as low stock.

## 6. Recovery test
Check that an alert disappears when stock goes above the threshold.

Example:
- Stock = 9
- Threshold = 10
- Increase stock to 15
- Product should no longer be low stock.

## 7. Zero-stock test
Test:
- Stock = 0
- Threshold = 10

Check that the product is handled correctly.

## 8. Negative-stock test
If the existing system allows negative stock, test it.
Do not change existing stock rules just for this test.

Check whether negative stock is included in the low-stock result.

## 9. Empty-result test
Use a threshold where no products are low stock.

Check that:
- The page still works.
- No incorrect product appears.
- The empty state is handled properly.

## 10. Existing functionality test
After adding the feature, test important existing functionality.

At minimum check:
- Product listing
- Adding a sale
- Stock reduction
- Sales history
- Login/permissions if affected

The existing stock calculation must still work exactly as before.

## 11. Regression test
Compare important behaviour before and after the feature.

Especially check:
- Sale is still saved.
- Product stock still changes correctly.
- Existing sales data is not changed incorrectly.
- Existing pages still load.
- Existing reports still work if affected.

## 12. Invalid-input test
Test invalid values for the new feature.

Examples:
- Empty threshold
- Non-numeric threshold
- Negative threshold
- Zero threshold
- Very large threshold

Check that invalid input is rejected or handled according to the existing application rules.

Do not invent validation rules if the repository does not define them.

## 13. UI test
Check:
- Alert is visible when expected.
- Correct product name is shown.
- Correct stock quantity is shown.
- Normal products are not incorrectly marked.
- Changing the threshold updates the displayed result.

## 14. Database test
After important actions, check the database when relevant.

For low-stock:
- Confirm the existing `products.quantity` value is correct.
- The alert feature should read/use the existing stock value.
- The feature must not accidentally change stock.

## 15. Test result format

For every important test, record:

Test:
Expected:
Actual:
Result: PASS / FAIL

Example:

Test: Stock exactly equals threshold
Expected: Product appears as low stock
Actual: Product appears
Result: PASS

## 16. Final rule

Do not say "feature works" based on one successful test.

The feature is complete only after:
- Normal test passes
- Boundary tests pass
- Edge cases are checked
- Invalid cases are checked
- Existing functionality is checked
- No regression is found

If a test fails, investigate the cause before changing code.

Do not change unrelated code just to make a test pass.

Process:

ADD → TEST → FIND PROBLEMS → FIX → TEST AGAIN → VERIFY
