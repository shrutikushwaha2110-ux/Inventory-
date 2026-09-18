# Assignment Brief — Plain-Terms Summary

## ⚠️ Read this first: gap between the brief and what's actually built

This brief assumes a **warehouse/location + stock-transfer** system. This repo does not
have one.

Checked the whole codebase for `warehouse`, `location`, `transfer` — the only matches are
an unrelated HTTP `Location:` redirect header and file-upload error strings. There is:
- no location/warehouse table,
- no per-location stock (`products.quantity` is one global number per product),
- no transfer table or transfer logic anywhere.

The only thing that changes stock today is a **sale** (`add_sale.php` → `fn_a39()`), not a
transfer between locations. The low-stock-alert feature that exists (`low_stock.php`) is
global, not per-location.

**What this means:** the feature we built and tested satisfies a stripped-down piece of
"Section 4" (a configurable threshold, a queryable alert list, invalid-input handling) —
but it does **not** satisfy the per-location requirement, and it cannot demo point 3
(transfers moving stock across a threshold) because transfers don't exist in this app at
all. Before presenting this as "done," you need to confirm with whoever gave you this
brief whether:
- this is a *later phase* you haven't started yet (location + transfer still to be built), or
- the brief is for a different/updated version of the app than the one in this folder.

Everything below explains the brief itself in plain terms — it does not change the gap
above.

---

## What "Section 4" actually is (you called it "work done")

This isn't a to-do list — it's the **Definition of Done** / **acceptance criteria**. It's
what someone will actually sit down and test live, in front of you, to decide if the
feature is finished. In plain terms, it wants to see five things:

1. **Per-location alerts.** If a product's stock at a specific warehouse location drops
   below a threshold, it shows up in an alert list you can query — demonstrated for at
   least 3 products across at least 2 locations. (Not just "low stock overall" — low stock
   *at a specific place*.)
2. **A real configurable threshold.** Not hardcoded per product in the code — something
   you can change at runtime, and watch the alert list change live when you do.
3. **Transfers update alerts immediately.** If you move stock from Location A to Location
   B, and that transfer drops A below the threshold (or pushes B above it), the alert list
   reflects that instantly and correctly — for both locations.
4. **Nothing pre-existing breaks.** Recording a transfer, checking a product's balance,
   viewing transfer history — all of that has to work exactly like it did before your
   change. You'll be asked to show old-behavior vs new-behavior side by side.
5. **A CLAUDE.md you wrote**, describing the architecture, data model, and conventions you
   figured out by reading the code. This is graded as proof you understood the system —
   not as documentation formatting.

## What "Deliverables" actually means (the second list)

This is the literal list of things you hand in / bring to present:

1. **The working feature, live-demoed**, covering all four functional points above (1–4
   from Section 4).
2. **A 1-page "first guess vs. reality" doc** — what you assumed about the system before
   reading the code, versus what you actually found once you dug in. Needs specifics
   (function names, table names, concrete behavior), not general impressions.
3. **Be ready for a notes-free oral exam (viva)** on the existing balance/transfer logic —
   they can ask you to explain it from memory, at a whiteboard, with no code in front of
   you.

## Quick self-check before you present

- [ ] Can I show a product low at Location A but fine at Location B? *(Not possible today — no location concept exists.)*
- [ ] Can I change a threshold and watch results update live? *(Yes — this part works, globally.)*
- [ ] Can I record a transfer and watch an alert appear/disappear because of it? *(Not possible today — no transfer feature exists.)*
- [ ] Do old flows (sales, product balance, sales history) still work unchanged? *(Yes, verified — see `LOW_STOCK_TEST_RESULTS.md`.)*
- [ ] Do I have a CLAUDE.md describing what I reverse-engineered? *(Yes — `claude.md` in this repo.)*
- [ ] Do I have a "first guess vs. reality" doc? *(Not yet — not written.)*
- [ ] Could I explain the sale/stock-decrease logic (`fn_a39`) at a whiteboard with no notes? *(Worth rehearsing — see `claude.md`'s "Obfuscated function map" and "Stock and sales flow" sections.)*
