# SCREEN WALK REPORT — Warehouse Master Module
**Tester:** SWA Agent  
**Date:** 2026-04-16  
**Base URL:** http://sr-v1.test  
**Module:** Warehouse Master  

---

## SCREEN 1 — Warehouse Master List
**URL:** `http://sr-v1.test/warehouse/master`  
**Route:** `warehouse.master.index`

| # | Check | Status | Notes |
|---|-------|--------|-------|
| 1 | Page loads without 500/404 | ⬜ TO TEST | Visit URL and confirm HTTP 200 |
| 2 | Auth redirect when not logged in | ⬜ TO TEST | Logout → visit URL → expect redirect to /login |
| 3 | Page title = "Warehouse Master" | ⬜ TO TEST | Check `<title>` or `<h1>` in page |
| 4 | Breadcrumb present (Admin Console → Warehouse) | ⬜ TO TEST | Visible breadcrumb trail |
| 5 | Warehouse Name column visible | ⬜ TO TEST | Table header present |
| 6 | Warehouse Code column visible (WH-xxx) | ⬜ TO TEST | |
| 7 | Type column visible (badge: Central/Regional/Site/Yard) | ⬜ TO TEST | Color-coded badge |
| 8 | State column visible | ⬜ TO TEST | Shows state name via relationship |
| 9 | Manager column visible | ⬜ TO TEST | Shows `contact_name` (not blank) |
| 10 | Contact Number column visible | ⬜ TO TEST | |
| 11 | Storage Type column visible | ⬜ TO TEST | |
| 12 | Status column visible (Active/Inactive badge) | ⬜ TO TEST | |
| 13 | Edit button links to edit page | ⬜ TO TEST | Click → goes to `/warehouse/master/{id}/edit` |
| 14 | Delete button triggers SweetAlert2 confirm | ⬜ TO TEST | Click → Swal confirm dialog appears |
| 15 | Confirming delete removes row from list | ⬜ TO TEST | Row disappears after confirm |
| 16 | Cancelling delete keeps row in list | ⬜ TO TEST | Row stays after cancel |
| 17 | "Add Warehouse" button navigates to create page | ⬜ TO TEST | |
| 18 | Success flash toast shown after store/update redirect | ⬜ TO TEST | SweetAlert2 toast appears top-center |
| 19 | Filter tabs (All/Central/Regional/Site/Yard) work | ⬜ TO TEST | Click each tab, list filters |
| 20 | Stats strip shows correct Total/Active/Inactive counts | ⬜ TO TEST | |
| 21 | Empty state shown when no warehouses exist | ⬜ TO TEST | |
| 22 | No JS console errors | ⬜ TO TEST | Open DevTools → Console |
| 23 | No PHP errors in page source | ⬜ TO TEST | View source — no "Warning:" text |

---

## SCREEN 2 — Create Warehouse
**URL:** `http://sr-v1.test/warehouse/master/create`  
**Route:** `warehouse.master.create`

| # | Check | Status | Notes |
|---|-------|--------|-------|
| 1 | Page loads without 500/404 | ⬜ TO TEST | |
| 2 | Breadcrumb present | ⬜ TO TEST | |
| 3 | Warehouse Name field present | ⬜ TO TEST | |
| 4 | Warehouse Type dropdown (Central/Regional/Site/Yard) | ⬜ TO TEST | All 3 options visible |
| 5 | Address textarea present | ⬜ TO TEST | |
| 6 | State Select2 dropdown loads all states | ⬜ TO TEST | Open → states listed |
| 7 | Selecting a State triggers AJAX city load | ⬜ TO TEST | Select state → city dropdown populates |
| 8 | City Select2 supports tags (type new city) | ⬜ TO TEST | Type "NewCity" → appears as option |
| 9 | Manager dropdown shows employee contacts only | ⬜ TO TEST | Open → shows employees |
| 10 | Contact Number field is digits-only (numberonly) | ⬜ TO TEST | Type letters → rejected |
| 11 | Storage Type dropdown (Rack/Floor/Open Yard) | ⬜ TO TEST | |
| 12 | Status dropdown (Active/Inactive) | ⬜ TO TEST | |
| 13 | Required field validation fires on empty submit | ⬜ TO TEST | Click Save → errors highlight |
| 14 | Name required error shown | ⬜ TO TEST | |
| 15 | State required error shown | ⬜ TO TEST | |
| 16 | City required error shown | ⬜ TO TEST | |
| 17 | Warehouse Type required error shown | ⬜ TO TEST | |
| 18 | Address required error shown | ⬜ TO TEST | |
| 19 | Valid form submits → redirects to list with success toast | ⬜ TO TEST | |
| 20 | New warehouse appears in list after save | ⬜ TO TEST | |
| 21 | New city typed in form → auto-inserted in cities table | ⬜ TO TEST | Check DB: `SELECT * FROM cities WHERE name='NewCity'` |
| 22 | Existing city → not duplicated in cities table | ⬜ TO TEST | |
| 23 | Submit spinner shows on form submit | ⬜ TO TEST | Button shows loading state |
| 24 | No console JS errors | ⬜ TO TEST | |

---

## SCREEN 3 — Edit Warehouse
**URL:** `http://sr-v1.test/warehouse/master/{id}/edit`  
**Route:** `warehouse.master.edit`

| # | Check | Status | Notes |
|---|-------|--------|-------|
| 1 | Page loads without 500/404 | ⬜ TO TEST | |
| 2 | Breadcrumb present | ⬜ TO TEST | |
| 3 | Warehouse Code chip shown in header (e.g. WH-001) | ⬜ TO TEST | Badge/chip in page title area |
| 4 | All fields pre-filled with existing data | ⬜ TO TEST | |
| 5 | State dropdown shows existing state selected | ⬜ TO TEST | |
| 6 | City Select2 shows existing city_name pre-selected | ⬜ TO TEST | |
| 7 | Selecting different state clears and reloads cities | ⬜ TO TEST | |
| 8 | Manager shows existing manager if set | ⬜ TO TEST | |
| 9 | Status shows existing status | ⬜ TO TEST | |
| 10 | Valid update saves and redirects to list with toast | ⬜ TO TEST | |
| 11 | Old values updated in DB | ⬜ TO TEST | |
| 12 | Duplicate name (another WH) shows validation error | ⬜ TO TEST | |
| 13 | Same name (own WH) allowed — no unique error | ⬜ TO TEST | |
| 14 | No console JS errors | ⬜ TO TEST | |

---

## DEFECTS TO WATCH FOR

| ID | Risk | Description |
|----|------|-------------|
| D1 | HIGH | Select2 city tags not submitting text value — check `name="city_name"` on select renders as plain text in POST, not numeric ID |
| D2 | MEDIUM | AJAX city load fails if `getCitiesByState` route is missing from web.php |
| D3 | MEDIUM | Manager dropdown empty if no contacts with `cotype.slug = 'employee'` exist in DB |
| D4 | LOW | `wh-code` badge class missing from `form.css` (already fixed in this sprint) |
| D5 | LOW | Flash toast not showing — check `#flashSuccess` hidden div is present in index blade |

---

## HOW TO RUN AUTOMATED TESTS

```bash
# From project root: /path/to/sr-v1

# Run all Warehouse tests (Unit + Feature)
php artisan test tests/Unit/WarehouseTest.php tests/Feature/WarehouseFeatureTest.php --verbose

# Run unit tests only
php artisan test tests/Unit/WarehouseTest.php

# Run feature tests only
php artisan test tests/Feature/WarehouseFeatureTest.php

# Run all project tests
php artisan test
```

**Expected result:** All tests PASS (green). Zero failures.

---

## QA GATE 3 SIGN-OFF

| Agent | Status |
|-------|--------|
| UTA (Unit Tests) — `tests/Unit/WarehouseTest.php` | ⬜ Run & verify |
| FTA (Feature Tests) — `tests/Feature/WarehouseFeatureTest.php` | ⬜ Run & verify |
| SWA (Screen Walk) — this document | ⬜ Manual walkthrough at http://sr-v1.test |
| LVA (Ledger Verify) | ✅ N/A — Warehouse module has no financial postings |

**Gate 3 passes when:** UTA + FTA show 0 failures AND SWA manual checklist shows no P0 defects.
