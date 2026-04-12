# SC-PROJECT-LOG-AGENT — SR Logistics ERP
> **Rule:** Add new session entries at the TOP of the Session Log section. One `Edit` call per session. Never recreate this file.

| Field | Value |
|---|---|
| Project | SR Logistics ERP — Service Centre Module |
| Laravel | 12.0 / PHP 8.2 |
| Local URL | http://sr-v1.test/service-centre/dashboard |
| Project Path | `C:\herd\sr-v1` |
| Views | `resources/views/sc/` |
| Controller | `app/Http/Controllers/ServiceCentreController.php` |
| Route Prefix | `service-centre` → route names: `sc.*` |
| CSS Common | `public/css/style.css` (SC block appended at bottom) |
| CSS Per-Page | `public/css/sc-{page}.css` |
| Log Owner | Amit · Arobit |
| Last Updated | 11 Apr 2026 |

---

## Coding Rules (Permanent)

- No inline `<style>` blocks in any Blade view. Page CSS → `public/css/sc-{page}.css`. Shared SC styles → `style.css` (appended at bottom).
- No inline `<script>` before `@yield('js')`. All jQuery code → `@section('js')` — placed AFTER layout script includes to avoid load-order issues.
- `Select2` for all vehicle dropdowns — class `.select2-vehicle`, always initialized inside `@section('js')`.
- `SweetAlert2` for all confirmations, alerts, and validation messages. Already loaded in `layouts/app.blade.php`.
- KM reading is always a **read-only label** (auto-populated on vehicle select) — never an editable input.
- SC operational pages use `.sc-no-sidebar` layout — `margin-left:0; padding:20px;`. No leftbar include.
- All SC views `@extends('layouts.app')`. jQuery, Bootstrap 5, Select2, SweetAlert2, MDB already in master layout.
- **Do NOT touch existing architecture** — no changes to existing controllers, models, or migrations without explicit discussion.
- Frontend-first phase — all Blade views are static HTML. Backend (Eloquent queries, form POST) comes later.
- CSS naming: `.sc-{component}` prefix for all SC module styles.
- Route naming: `sc.{module}.{page}` — e.g. `sc.dashboard`, `sc.workshop.job-list`, `sc.external.dispatch`.
- Controller methods return `view('sc.{page}')` with no data bindings during frontend phase.
- **DB naming convention (Amit's):** Compound model/table names merged without underscores — `vehicletyremapping`, `tyrelog`, `sctyrejob` — never `vehicle_tyre_mapping`.
- **UI labels must match SR Logistics fleet terminology** — e.g. "Make" not "Brand", "Fitment Date" not "Issue Date", "KM Life" not "Fixed Run KM".

---

## Architecture

- Single `ServiceCentreController` for all SC pages — consistent with project pattern (`FleetDashboardController`, `TyreController`).
- Route prefix `service-centre`, names `sc.*` — inside existing `auth` middleware. No new middleware group.
- Views: `resources/views/sc/` — mirrors route prefix.
- SC common styles appended to `style.css`. No separate `sc-common.css` — single HTTP request.
- Existing models in project: `Vehicle`, `Tyre`, `Tyrelog`, `Tyreposition`, `Vehicletyremapping`, `Vehicletyremappinglog`, `Vehiclebattery`, `Vehiclebatterylog`, `Warehouse`, `Branch`.

### Sub-Module Structure (Confirmed)

| Sub-Module | Scope | Route Pattern |
|---|---|---|
| **Workshop** | IN-HOUSE — SR Logistics' own workshop, technicians, tools, parts | `sc.workshop.*` |
| **ServiceCenter** | EXTERNAL — Vehicle sent to brand ASC (warranty) or third-party SC | `sc.external.*` |
| **Service Requests** | Common intake — spawns Workshop or ServiceCenter job | `sc.*` (existing) |
| **Maintenance** | PM calendar, alerts, reports | `sc.maintenance.*` |
| **Inventory** | Spare parts, tyres, batteries, PO, GRN — single module, location filter | `sc.inventory.*` |

---

## Session Log (Latest First)

---

### Session 8 — 11 Apr 2026
**Summary:** Gate Token print redesigned (compact A6 slip, all fields, @media print CSS). PO & GRN detail pages built. PO list fixed (missing Deliver To on Apollo PO row, item Category column added to New PO modal). GRN list links wired to detail pages. Tyre and Battery inventory upgraded: location context bar, PO reference column, "Fit to Vehicle" modal with vehicle selector + position, "Raise PO" action for scrap/replace rows. PO and GRN detail routes added.

#### Files Created

| File | Description |
|---|---|
| `resources/views/sc/po-detail.blade.php` | PO Detail page — PO header, approval timeline, items table (with category), GRN history section |
| `resources/views/sc/grn-detail.blade.php` | GRN Detail page — GRN header, items received table, stock impact section |

#### Files Updated

| File | Change |
|---|---|
| `resources/views/sc/in-token.blade.php` | `#prnToken` rebuilt as compact print slip — token #, vehicle, SR ref, date/time, KM, driver, SC, signature lines. `#btnPrintToken` JS handler added. `#btnGenerateToken` now populates all print fields. |
| `public/css/sc-in-token.css` | Added `.prn-token-*` card CSS + `@media print` block — hides `.layout-wrapper`, shows `#prnToken` fullscreen |
| `resources/views/sc/po-list.blade.php` | Fixed Apollo Tyres row (missing Deliver To cell). All PO# cells now link to po-detail. New PO modal items table gains Category column (Spare Part / Tyre / Battery / Consumable). |
| `resources/views/sc/grn.blade.php` | All GRN# and PO# links wired to detail pages (`inventory.grn-detail`, `inventory.po-detail`) |
| `resources/views/sc/tyre-inventory.blade.php` | Location ctx bar added. PO Ref column added. "Fit to Vehicle" button opens `#fitTyreModal` (vehicle Select2 + position + KM + date). "Raise PO" action on scrap rows. PO Ref field in Add Stock modal. |
| `resources/views/sc/battery-inventory.blade.php` | Same pattern as tyre: location ctx, PO ref col, `#fitBatteryModal` (vehicle + position + date). |
| `routes/web.php` | Added `inventory.po-detail` (`/purchase-orders/{id}`) and `inventory.grn-detail` (`/goods-receipt/{id}`) routes |
| `app/Http/Controllers/ServiceCentreController.php` | Added `poDetail($id)` and `grnDetail($id)` methods |

#### Inventory ↔ Fleet Linkage Design

| Connection | How it works (frontend-first) |
|---|---|
| Tyre stock → Fleet | "Fit to Vehicle" modal in Tyre Inventory — selects vehicle + wheel position + date + KM. On confirm: tyre status = Fitted, vehicle tyre record updated. |
| Battery stock → Fleet | "Fit to Vehicle" modal in Battery Inventory — selects vehicle + position (Primary/Auxiliary) + date. On confirm: battery status = Fitted, vehicle battery record updated. |
| PO → Tyre/Battery stock | PO items now have Category (Tyre/Battery/Spare Part/Consumable). Add Stock modals have optional PO Ref field linking back to the PO. |
| Scrap/Replace items → PO | "Raise PO" (shopping cart) action button on scrap/replace-condition tyre and battery rows links to PO list. |
| GRN → Stock Impact | GRN detail page shows "Stock Impact" section — each received item shows previous qty → new qty per location. |

---

### Session 7 — 11 Apr 2026
**Summary:** Multi-location support added across Inventory and Service Centre modules. Inventory now supports multiple Warehouses (WH-BLR, WH-HYD, WH-PNE) and multiple Service Centres (SC-BLR, SC-HYD). Location context bar added globally. Stock Transfer page built. SC Dashboard and Job Card List gain SC context selector. Insurance form Select2 bug fixed.

#### Architecture Decision — Multi-Location

| Entity | Before | After |
|---|---|---|
| Warehouses | Single implied warehouse | Multiple: WH-BLR / WH-HYD / WH-PNE |
| Service Centres | Single implied SC | Multiple: SC-BLR / SC-HYD |
| Stock | No location field | Each stock item belongs to one location |
| POs | No deliver-to location | Raised for a specific deliver-to location |
| GRN | No location | Receives into the PO's location |
| Job Cards | No SC field | Each job card belongs to an SC |
| Transfers | No transfer concept | WH→SC, WH→WH, SC→SC stock transfers |

#### Location Code Pattern

| Code | Type | Full Name |
|---|---|---|
| WH-BLR | Warehouse | Warehouse — Bangalore |
| WH-HYD | Warehouse | Warehouse — Hyderabad |
| WH-PNE | Warehouse | Warehouse — Pune |
| SC-BLR | Service Centre | SC — Bangalore Workshop |
| SC-HYD | Service Centre | SC — Hyderabad Workshop |

#### Files Created

| File | Description |
|---|---|
| `resources/views/sc/stock-transfer.blade.php` | Stock Transfer page — table with From/To loc badges, New Transfer modal (multi-item), Receive Transfer modal |
| `public/css/sc-inventory-dashboard.css` | Updated — `.sc-inv-module-card` + stock status badges |

#### Files Updated

| File | Change |
|---|---|
| `public/css/style.css` | **Location context CSS block** appended — `.loc-ctx-bar`, `.loc-ctx-pill` (wh/sc/all with active state), `.loc-badge` table chips, `.loc-stat-grid/.loc-stat-card` per-location cards |
| `public/css/sc-inventory.css` | Added `.sc-po-grn`, `.sc-po-closed`, `.sc-tr-pending/transit/received/cancelled` badges |
| `resources/views/sc/inventory-dashboard.blade.php` | Rebuilt — location pill switcher, per-location stat cards (5 locations), Low Stock table with `.loc-badge`, Recent Transfers table, Recent POs with Deliver To column |
| `resources/views/sc/spare-parts.blade.php` | Added location context bar (dropdown), updated Location filter with optgroups, replaced bare text location cells with `.loc-badge` chips, added Transfer Stock quick modal, fixed Add Item location options |
| `resources/views/sc/po-list.blade.php` | Added location context bar, `Deliver To` column in table + header, location badge in PO rows, `Deliver To` field in New PO modal |
| `resources/views/sc/stock-transfer.blade.php` | New — see above |
| `resources/views/sc/dashboard.blade.php` | SC context bar (wrench icon, SC selector: All / SC-BLR / SC-HYD) |
| `resources/views/sc/job-card-list.blade.php` | SC context bar added |
| `resources/views/sc/insurance.blade.php` | **BUG FIX** — Empty Select2 dropdowns (vehicle select had no options). Added static vehicle options. Fixed `dropdownParent` — filter bar uses `$('body')`, modal uses `$('#newClaimModal')` |
| `routes/web.php` | Added `inventory.stock-transfer` route |
| `app/Http/Controllers/ServiceCentreController.php` | Added `stockTransfer()` method |
| `resources/views/includes/header.blade.php` | Added Stock Transfers link to Inventory nav |

#### Open Items (Session 7)

| ID | Item | Owner |
|---|---|---|
| OI-701 | **Tyre and Battery inventory** — Add location context bar to tyre-inventory.blade.php and battery-inventory.blade.php (same pattern as spare-parts — deferred) | Next pass |
| OI-702 | **GRN location** — GRN page needs "Receiving Location" column and filter | Next pass |
| OI-703 | **Location master** — Real DB table: `locations` (id, code, name, type: warehouse/service_centre, address, branch_id). Currently hardcoded in frontend. | Backend phase |
| OI-501 | **Inventory Billing** — Vendor Invoices + Payment Records pages pending | Next session |

---

### Session 6 — 11 Apr 2026
**Summary:** Inventory module separated from Service Centre as a standalone top-level navigation item. New Inventory Dashboard created. Routes moved out of `sc.` group into own `inventory.` prefix. All cross-references updated. Zero broken route calls remaining.

#### Files Created

| File | Description |
|---|---|
| `resources/views/sc/inventory-dashboard.blade.php` | Inventory Dashboard — 8 stat cards (stock overview + procurement), 6 module quick-link cards, Low Stock table, Recent POs table |
| `public/css/sc-inventory-dashboard.css` | Module card styles (`.sc-inv-module-card`, icon circle, name, meta), stock status badges (`.sc-stock-warning/critical/out`) |

#### Files Updated

| File | Change |
|---|---|
| `routes/web.php` | Inventory routes extracted from `sc.` prefix group into new `Route::prefix('inventory')->name('inventory.')` group. New `inventory.dashboard` route added. Controller stays `ServiceCentreController` (frontend phase). |
| `app/Http/Controllers/ServiceCentreController.php` | Added `inventoryDashboard()` method returning `view('sc.inventory-dashboard')` |
| `resources/views/includes/header.blade.php` | Removed Inventory column from Service megamenu. Added new top-level **Inventory** nav item (between Service and Finance) with 3 columns: Stock Management, Procurement, Billing & Payments (placeholder). Fixed Finance menu — "Inventory (Service-Level Only)" column replaced with "Inventory Payments" linking to correct `inventory.*` routes. |
| `resources/views/sc/spare-parts.blade.php` | Breadcrumb: `Service Centre` → `Inventory` (→ `route('inventory.dashboard')`) |
| `resources/views/sc/tyre-inventory.blade.php` | Breadcrumb: `Service Centre` → `Inventory` |
| `resources/views/sc/battery-inventory.blade.php` | Breadcrumb: `Service Centre` → `Inventory` |
| `resources/views/sc/po-list.blade.php` | Breadcrumb updated. `route('sc.inventory.goods-receipt')` → `route('inventory.goods-receipt')` |
| `resources/views/sc/grn.blade.php` | Breadcrumb updated. All 3× `route('sc.inventory.purchase-orders')` → `route('inventory.purchase-orders')` |
| `resources/views/sc/alerts.blade.php` | `route('sc.inventory.spare-parts')` → `route('inventory.spare-parts')` |
| `resources/views/sc/dashboard.blade.php` | Low Stock Alerts button + Quick Actions: all `sc.inventory.*` → `inventory.*` |

#### Architecture Change

| Before | After |
|---|---|
| Inventory was the 4th column in the **Service** megamenu | Inventory is a **standalone top-level menu** between Service and Finance |
| Routes: `sc.inventory.*` (inside `service-centre` prefix group) | Routes: `inventory.*` (own `inventory/` prefix group, same `auth` middleware) |
| URL: `/service-centre/inventory/spare-parts` | URL: `/inventory/spare-parts` |
| No Inventory Dashboard | Dashboard at `/inventory/dashboard` (`inventory.dashboard`) |

#### Open Items (Session 6)

| ID | Item | Owner |
|---|---|---|
| OI-501 | **Inventory Billing** — Vendor Invoices and Payment Records pages not yet built. Placeholder links exist in header. | Next session |
| OI-502 | **Finance integration** — Inventory billing/payment to reflect under Finance module. Cross-module reference format TBD. | Design session |
| OI-401 | Workshop billing model (carried from Session 4) | Amit |

---

### Session 5 — 11 Apr 2026
**Summary:** Completed all remaining SC Blade views. Insurance page corrected from policy management to claims tracking (user clarification). External SC module completed with Billing and Vehicle Return pages. Architectural decision: Inventory to become a separate top-level menu alongside Service and Finance.

#### Files Created

| File | Description |
|---|---|
| `resources/views/sc/pm-calendar.blade.php` | PM Calendar — stats, filters, KM progress bar table, Log PM modal, Schedule PM modal |
| `resources/views/sc/alerts.blade.php` | SC Alerts hub — two-column layout: Overdue JCs, PM Due, Insurance Expiry, Low Stock |
| `resources/views/sc/reports.blade.php` | SC Reports — 4 groups (Workshop, Maintenance, Inventory, External SC), View/Excel/PDF buttons |
| `resources/views/sc/external-dispatch.blade.php` | External Dispatch list — stats, table with TAT colour coding, New Dispatch modal |
| `resources/views/sc/external-tracker.blade.php` | Kanban tracker — 5 lanes (Dispatched → Under Diagnosis → Repair Started → Ready → Returned), Update Status modal |
| `resources/views/sc/external-billing.blade.php` | External SC invoices — billing table, Record Invoice modal, Record Payment modal, Dispute modal |
| `resources/views/sc/external-return.blade.php` | Vehicle Collection — Ready to Collect cards, Return History table, Process Collection modal with checklist |
| `public/css/sc-pm-calendar.css` | PM status badges, KM progress bars, service type chips, service-type-toggle grid |
| `public/css/sc-alerts.css` | Alert dot/row/severity badge CSS |
| `public/css/sc-reports.css` | Report card hover styles, section labels |
| `public/css/sc-external.css` | Shared across all 4 external SC pages — type badges, dispatch status, billing status, Kanban, TAT, return card, checklist grid |

#### Files Rebuilt / Updated

| File | Change |
|---|---|
| `resources/views/sc/insurance.blade.php` | **FULL REBUILD** — was incorrectly built as Policy Tracker. Rebuilt as Insurance Claims page: Claim #, Vehicle, Incident Date, Claim Type, Policy Ref (read-only from Fleet), Job Card Ref, Surveyor, Claim Amt, Settlement Amt, Status. Modals: File New Claim, Claim Detail + Timeline, Update Status, Record Settlement. |
| `public/css/sc-insurance.css` | **FULL REBUILD** — old policy/renewal badges replaced. New: `.sc-ins-filed/survey/approved/settled/rejected` + `.sc-ins-type-od/tp/theft/fire` + detail box + description box |
| `public/css/sc-external.css` | Extended — added Return page styles: `.sc-ext-return-card`, `.sc-ext-chk-grid`, `.sc-ext-inv-summary`, `.sc-ext-section-label` |

#### Design Decisions (Session 5)

| Decision | Reason |
|---|---|
| **Insurance = Claims only, not Policy management** | Policy management (Add Policy, Renew, expiry tracking) belongs in Fleet module. SC only logs claims filed for accident repairs, tracks surveyor visits, claim amounts, and settlement. Policy Ref is a read-only text field in SC — Fleet owns the source. |
| **External SC billing dispute flow** | Added a "Flag Dispute" modal (reason, amount, resolution target) to cover cases where external SC overcharges or quality issues arise. Dispute status blocks payment until resolved. |
| **External Return checklist** | Collection checklist uses the same `.sc-insp-btn` toggle pattern as Out-Token inspection — cycle states: blank → OK → Fail → N/A. Consistent interaction pattern across the module. |
| **Inventory to become separate top-level menu** | User decision: Inventory covers warehouse + SC operations + billing/payment records (referenced under Finance). Removing from SC sub-module. Separate menu with own navigation alongside Service and Finance. Implementation in next session. |

#### Open Items (Session 5)

| ID | Item | Owner |
|---|---|---|
| OI-401 | **Billing model** — Workshop billing: customer invoice (GST) vs internal cost-centre? | Amit |
| OI-402 | **ORS → JC link** — How is ORS reference tracked on a job card raised after vehicle tow-in? | Amit |
| OI-403 | **SC System Document** — Full system document once UI phase stabilises | Build later |
| OI-501 | **Inventory as separate menu** — Define full navigation tree and page scope for standalone Inventory module. Remove Inventory links from SC sidebar. | Next session |
| OI-502 | **Finance integration** — Inventory billing/payment records to be reflected under Finance module. Define cross-module reference format. | Design session |

---

### Session 4 — 11 Apr 2026
**Summary:** All Workshop + Inventory SC Blade views built. Multiple bugs fixed across tab system, photo dropzone, Out-Token wizard, and Activity Log. Global SC CSS patterns consolidated into `style.css`. Type column removed from Job Card List (design decision). Vehicle cell standardised across all SC tables.

#### Files Created

| File | Description |
|---|---|
| `resources/views/sc/job-card-list.blade.php` | Workshop job cards list — filter bar, sortable table, Close Job modal, status badges |
| `resources/views/sc/job-card-details.blade.php` | 8-tab details page — Overview, Labour, Parts, Checklist, Photos, Billing, Activity Log, Notes |
| `resources/views/sc/technician-dashboard.blade.php` | Kanban board (hidden — route commented out, view kept) |
| `resources/views/sc/billing.blade.php` | Invoice list, Record Payment modal |
| `resources/views/sc/delivery.blade.php` | Delivery queue + 4-step Out-Token wizard modal |
| `resources/views/sc/onroad-service.blade.php` | ORS call log, Log Breakdown modal with own/3rd-party toggle |
| `resources/views/sc/spare-parts.blade.php` | Parts inventory table, Add Item + Adjust Stock modals |
| `resources/views/sc/tyre-inventory.blade.php` | Tyre stock — links to existing `tyre.dashboard` |
| `resources/views/sc/battery-inventory.blade.php` | Battery stock — warranty expiry indicator |
| `resources/views/sc/po-list.blade.php` | Purchase Orders — New PO modal with dynamic line items |
| `resources/views/sc/grn.blade.php` | Goods Received Notes — links to PO module |
| `public/css/sc-job-card-list.css` | Job card list + shared status/type badge CSS |
| `public/css/sc-job-card-details.css` | Details page — info boxes, status flow, billing summary, activity log, checklist, photo grid |
| `public/css/sc-technician-dashboard.css` | Kanban lane + tech card styles (hidden — kept) |
| `public/css/sc-billing.css` | Invoice status badges |
| `public/css/sc-delivery.css` | Delivery queue + Out-Token wizard stepper + inspection toggle CSS |
| `public/css/sc-onroad-service.css` | ORS type badges, row critical highlight |
| `public/css/sc-inventory.css` | Shared across all 5 inventory pages — stock/PO/GRN/tyre/battery badges |

#### Files Updated

| File | Change |
|---|---|
| `resources/views/includes/header.blade.php` | Technician Dashboard link hidden with Blade comment. Driver links reverted to `href="driver.php"` (team will fix). |
| `routes/web.php` | Technician Dashboard route commented out: `// HIDDEN (not in use yet)` |
| `resources/views/sc/job-card-list.blade.php` | Type column removed (design decision — Workshop JCs are always workshop). Vehicle column rebuilt with `.sc-veh-cell`. Colgroup widths added. Compact date format. |
| `resources/views/sc/job-card-details.blade.php` | Tabs rebuilt with `.sc-tab-container` + `.sc-tab-panel-wrap` wrapper. `href="#"` added to tab links. Inner `.sc-card` wrappers removed from Labour/Parts/Log/Notes tabs (was double-nesting). |
| `resources/views/sc/delivery.blade.php` | Out-Token wizard fully rebuilt — Steps 2 (Out Inspection), 3 (KM & Receiver), 4 (Acknowledge) added. Full JS stepper navigation with validation, KM diff calc, inspection toggles, summary population, 3-checkbox acknowledgement gate before token issue. Vehicle `<br>` cells fixed to `.sc-veh-cell`. |
| `resources/views/sc/onroad-service.blade.php` | Vehicle `<br>` cells fixed to `.sc-veh-cell`. |
| `public/css/sc-job-card-details.css` | Added `.sc-log-*` CSS classes (was only `.sc-tl-*` — blade used different names, causing Activity Log to render blank). |
| `public/css/style.css` | **Tab bar redesign** — `.sc-tab-container`, `.sc-tab-panel-wrap` added. Active tab gets white bg + navy underline. **Global vehicle cell** — `.sc-veh-cell`, `.sc-reg-badge`, `.sc-veh-model` moved from `sc-job-card-list.css` to `style.css`. **Global stepper** — `.sc-stepper` block added covering both `.sc-step.active` (in-token) and `.sc-step.sc-step-active` (delivery modal) patterns. In-token stepper had zero CSS before this. |

#### Bugs Fixed (Session 4)

| Bug | Root Cause | Fix |
|---|---|---|
| Activity Log renders blank | Blade used `.sc-log-*` class names; CSS only defined `.sc-tl-*` (old naming from previous iteration) | Added full `.sc-log-*` CSS block to `sc-job-card-details.css` |
| Tab bar unstyled / disconnected from panel | No container wrapper — tab bar and panels were floating elements with no shared background | Wrapped in `.sc-tab-container` (bordered card) + `.sc-tab-panel-wrap` (white padded area) |
| Out-Token wizard stuck at Step 1 | Steps 2–4 had no HTML panels and JS had no stepper navigation logic | Full rebuild — 4 panels + complete jQuery stepper with step validation |
| Photo dropzone click not working | Input had `class="d-none"` — `display:none` prevents browser file picker from triggering | Changed to `style="position:absolute;opacity:0;width:0;height:0;"` (invisible but accessible) + `<label for="photoInput">` wrapper |
| Vehicle column "broken" in tables | Using bare `<br><small>` creates tall ragged cells, no consistent width | Replaced with `.sc-veh-cell` flex-column wrapper globally |
| In-token page stepper unstyled | `.sc-stepper` CSS only existed in `sc-delivery.css` (modal-scoped), in-token loads different CSS | Moved stepper CSS to `style.css` with dual-pattern support |

#### Design Decisions (Session 4)

| Decision | Reason |
|---|---|
| **Type column removed from Job Card List** | "On-Road" job cards don't make sense — a job card = vehicle physically in workshop. On-road incidents are tracked in ORS module separately. If an ORS vehicle is towed in, a new JC is raised with the ORS number in the SR field. |
| **Technician Dashboard hidden (not deleted)** | Not needed in current phase. Route commented with `// HIDDEN`, header link in Blade comment, CSS + view intact. |
| **Workshop billing — internally owned** | SR Logistics owns the workshop; billing model may be cost-centre / internal charge-back rather than customer-facing invoice with GST. GST line is left in Billing tab UI as a placeholder pending decision. See Open Item below. |
| **Global SC patterns in style.css** | `.sc-reg-badge`, `.sc-veh-cell`, `.sc-veh-model`, `.sc-stepper` used across 6+ pages — moved to shared CSS to avoid per-page duplication. |

#### Open Items (Session 4)

| ID | Item | Owner |
|---|---|---|
| OI-401 | **Billing model** — Workshop is internally owned. Does billing mean customer invoice (with GST) or internal cost tracking? Are drivers/fleet owners billed or is it a pure internal expense? | Amit |
| OI-402 | **ORS → Workshop link** — If a breakdown vehicle is towed in and gets a JC, how is the ORS reference tracked? SR field? Or separate ORS field on jobcard table? | Amit |
| OI-403 | **SC System Document** — Full system document (all modules, flows, data model, screen inventory, decisions) requested for later. | Build when UI phase stabilises |

---

### Session 3 — 11 Apr 2026
**Summary:** BA pipeline completed (BRD, Page Inventory, Data Model, Screen Specs). Tyre dashboard division-by-zero fixed. Header fully cleaned — all raw `.php` hrefs removed, wrong `driver.index` route name corrected to `contact.driver.index`.

#### Files Changed

| File | Type | Change |
|---|---|---|
| `resources/views/tyre/dashboard.blade.php` | BUG FIX | 4× `DivisionByZeroError` — wrapped all `round(x * 100 / $all_count)` with `$all_count > 0 ? ... : 0` ternary (lines 103, 125, 149, 173) |
| `resources/views/includes/header.blade.php` | BUG FIX | `route('driver.index')` → `route('contact.driver.index')` (driver routes are inside `contact.` prefix group). All remaining raw `.php` hrefs → `href="#"`: `vehicle-document-status.php`, `fitness-status.php`, `fuel-logs.php`, `trips.php`, `create-invoice.php`, `invoice-list.php`, `create-receipt.php`, `money-receipts.php`, `add-customer.php`. Mobile logo `index.php` → `route('home')`. |
| `docs/ba/01-BRD.md` | CREATED | Business Context, Objectives & KPIs, Roles, AS-IS/TO-BE processes, 24 FRs (REQ-001 to REQ-024), NFRs, Constraints, 9 Open Items, 5 Gaps, 7 Assumptions |
| `docs/ba/02-Page-Inventory.md` | CREATED | All 23 pages: navigation tree, SCR-001 to SCR-023 table, UX states, role access, build priority P1–P6 |
| `docs/ba/03-Data-Model.md` | CREATED | 12 existing tables (read-only), 15 new tables with full column specs, ERD summary, number formats, open gaps |
| `docs/ba/04-Screen-Specs-Workshop.md` | CREATED | SCR-005 to SCR-010 screen specs (Job Cards List, Job Card Details 8-tab, Technician Dashboard, Workshop Billing, Delivery, On-Road) |
| `docs/ba/05-Screen-Specs-External-Maintenance-Inventory.md` | CREATED | SCR-011 to SCR-023 screen specs (External SC, Maintenance, Inventory pages) |

#### Bugs Fixed (Session 3)

| Bug | Root Cause | Fix |
|---|---|---|
| `DivisionByZeroError` at `tyre/dashboard.blade.php:103` | `$all_count = 0` when no tyres in DB — divides by zero in percentage calc | Guard: `$all_count > 0 ? round(...) : 0` on all 4 percentage lines |
| `RouteNotFoundException: Route [driver.index] not defined` | Driver routes are inside `Route::prefix('contacts')->name('contact.')` group — actual name is `contact.driver.index` | Changed header to use `route('contact.driver.index')` |
| Raw `.php` hrefs in header (9 links) | Pre-existing legacy links from before Laravel routing (prototype era) | All replaced with `href="#"` — routes not yet built |

#### BA Open Gaps (Need Amit's Input)

| Gap | Question |
|---|---|
| G-001 | Technician master — use existing `users` table or new `technicians` table? |
| G-002 | GST rate — 18% flat on both labour + parts, or configurable? |
| G-003 | Vendor master — use existing `contacts` table or new `vendors` table? |
| G-005 | PM intervals — Oil: 10,000 KM / Tyre Rotation: 20,000 KM / Alignment: 10,000 KM — confirm? |

---

### Session 2 — 11 Apr 2026
**Summary:** Full tyre module audit under Fleet, vehicle-details tyre section fixed with correct naming. Additional SC routes added (Workshop, External SC, Maintenance, Inventory). BA analysis initiated for Service Module.

#### Files Changed

| File | Type | Change |
|---|---|---|
| `resources/views/fleet/vehicle-details.blade.php` | UPDATED | Tyre accordion uncommented + rebuilt. Now uses `$vehicle->vehicletyremappings()->with(['tyre','tyreposition'])` (correct relationship). All labels corrected to fleet terminology. |
| `routes/web.php` | UPDATED | Added sub-grouped routes: Workshop (6), External SC (4), Alerts, Reports, Maintenance (2), Inventory (5). Total new routes: 19. |
| `app/Http/Controllers/ServiceCentreController.php` | UPDATED | Added 4 new stub methods: `externalDispatch()`, `externalTracker()`, `externalBilling()`, `externalReturn()`. |
| `SC-PROJECT-LOG.html` | REPLACED | Replaced by this file (`SC-PROJECT-LOG-AGENT.md`). |

#### Tyre Naming Corrections Applied

| Old Label | Corrected Label | DB Field |
|---|---|---|
| Tyre Brand | **Make** | `tyre_brand` |
| Tyre Serial Numbers | **Serial No.** | `tyre_serial_number` |
| Issue Date | **Fitment Date** | `fitment_date` (on `vehicletyremapping`) |
| Fixed Run KM | **KM Life** | `fixed_run_km` |
| Fixed Life (Months) | **Month Life** | `fixed_life_months` |
| Actual Run KM | **KM Run** | `actual_run_km` |
| Actual Run Month | **Months Run** | `actual_run_month` |
| Remaining Run KM | **KM Balance** (calculated) | — |
| Alignment Every KM | **Alignment Interval (KM)** | `alignment_interval_km` |
| Last Alignment KM | **Last Alignment at KM** | `last_alignment_km` |
| Last Rotation KM | **Last Rotation at KM** | `last_rotation_km` |

#### New Routes Added (Session 2)

| Route Name | URI | Status |
|---|---|---|
| `sc.workshop.job-list` | GET /service-centre/workshop/job-cards | TODO |
| `sc.workshop.job-details` | GET /service-centre/workshop/job-cards/{id} | TODO |
| `sc.workshop.tech-dashboard` | GET /service-centre/workshop/technicians | TODO |
| `sc.workshop.billing` | GET /service-centre/workshop/billing | TODO |
| `sc.workshop.delivery` | GET /service-centre/workshop/delivery | TODO |
| `sc.workshop.onroad` | GET /service-centre/workshop/onroad | TODO |
| `sc.alerts` | GET /service-centre/alerts | TODO |
| `sc.reports` | GET /service-centre/reports | TODO |
| `sc.external.dispatch` | GET /service-centre/external/dispatch | TODO |
| `sc.external.tracker` | GET /service-centre/external/tracker | TODO |
| `sc.external.billing` | GET /service-centre/external/billing | TODO |
| `sc.external.return` | GET /service-centre/external/return | TODO |
| `sc.maintenance.pm-calendar` | GET /service-centre/maintenance/pm-calendar | TODO |
| `sc.maintenance.insurance` | GET /service-centre/maintenance/insurance | TODO |
| `sc.inventory.spare-parts` | GET /service-centre/inventory/spare-parts | TODO |
| `sc.inventory.tyres` | GET /service-centre/inventory/tyres | TODO |
| `sc.inventory.batteries` | GET /service-centre/inventory/batteries | TODO |
| `sc.inventory.purchase-orders` | GET /service-centre/inventory/purchase-orders | TODO |
| `sc.inventory.goods-receipt` | GET /service-centre/inventory/goods-receipt | TODO |

#### Decisions Made (Session 2)

| # | Decision | Outcome |
|---|---|---|
| 1 | ServiceCenter external fields | Confirmed: ASC Name, Dispatch Date, ASC Job Order #, Expected/Actual Return Date, Work Description, Warranty Claim #, Covered/Uncovered cost, Total Bill, Status |
| 2 | Inventory architecture | **Single module** with location filter (Workshop / Warehouse) |
| 3 | Insurance scope | **Both** — repair cost claims from insurer + policy renewal tracking |
| 4 | On-Road Service | **Both** — own technician dispatch + third-party incident log |
| 5 | User roles | **SC Manager only** for now |
| 6 | Project log format | Replaced HTML log with this `.md` file — minimum token cost per update |

---

### Session 1 — 10 Apr 2026
**Summary:** SC Module foundation. Controller, 20 routes, 4 Blade views, 4 CSS files, header nav updated.

#### Files Created

| File | Description |
|---|---|
| `app/Http/Controllers/ServiceCentreController.php` | 20 stub methods, all return `view('sc.{page}')`. Frontend-only phase. |
| `resources/views/sc/dashboard.blade.php` | SC Dashboard — 8 KPI stat cards, active job card table, today's appointments panel, maintenance alert flags, technician workload bars, low stock table, quick action shortcut buttons. |
| `resources/views/sc/service-request.blade.php` | New Service Request — 4-step wizard (Vehicle → Service Type → Details → Confirm). Select2 vehicle dropdown, KM auto-label, tyre position grid (7 positions), battery panel, priority chips, SweetAlert2 validation & submit. |
| `resources/views/sc/appointment.blade.php` | Appointments — 4 KPI cards, 9-day date strip, 5-filter bar, appointments table (8 row variants). New Appointment modal — 4-step wizard with slot picker. |
| `resources/views/sc/in-token.blade.php` | Gate Entry In-Token — 4-step wizard (Vehicle → KM & Driver → Pre-Inspection → Acknowledgement). 12-item condition checklist (3-state toggle: — / OK / DMG), fuel level slider, 4 photo zones, signature boxes. Token generation GT-XXXX. |
| `public/css/sc-dashboard.css` | Quick action buttons, appointment mini-list, technician workload bar, alert flag rows, stock level chips. |
| `public/css/sc-service-request.css` | Service type selector cards, priority chips, tyre position grid buttons (worn/active states), success box, SR summary card. |
| `public/css/sc-appointment.css` | Date strip calendar (.cal-day active/off-day), appointment type chips, slot picker cards (.slot-pick-card full/available). |
| `public/css/sc-in-token.css` | Token display block, condition checklist items (ok/damaged), fuel bar, gate-in log list, photo zone, success token card. |

#### Files Modified

| File | Change |
|---|---|
| `routes/web.php` | Appended `Route::prefix('service-centre')->name('sc.')->group(...)` with 20 named GET routes inside existing `auth` middleware group. |
| `resources/views/includes/header.blade.php` | Replaced all `href="#"` in Service mega-menu with `route()` calls. Added `request()->routeIs('sc.*')` active state. |
| `public/css/style.css` | Appended SC common styles block: `.sc-no-sidebar`, `.sc-stat-card`, `.sc-card`, `.sc-table-card`, status badges, action buttons, `.sc-stepper`, `.sc-vehicle-box`, PRN print, `.sc-tab-bar`, form control sizing overrides. |

#### Routes Added (Session 1 — Original 20)

| Route Name | URI | Status |
|---|---|---|
| `sc.dashboard` | GET /service-centre/dashboard | ✅ DONE |
| `sc.service-request.index` | GET /service-centre/service-request | ✅ DONE |
| `sc.appointment.index` | GET /service-centre/appointment | ✅ DONE |
| `sc.in-token.index` | GET /service-centre/in-token | ✅ DONE |
| `sc.onroad-service.index` | GET /service-centre/onroad-service | TODO |
| `sc.job-card.index` | GET /service-centre/job-card | TODO |
| `sc.job-card.show` | GET /service-centre/job-card/{id} | TODO |
| `sc.technician-dashboard.index` | GET /service-centre/technician-dashboard | TODO |
| `sc.billing.index` | GET /service-centre/billing | TODO |
| `sc.delivery.index` | GET /service-centre/delivery | TODO |
| `sc.insurance.index` | GET /service-centre/insurance | TODO |
| `sc.pm-calendar.index` | GET /service-centre/pm-calendar | TODO |
| `sc.alerts.index` | GET /service-centre/alerts | TODO |
| `sc.reports.index` | GET /service-centre/reports | TODO |
| `sc.spare-parts.index` | GET /service-centre/spare-parts | TODO |
| `sc.tyre-inventory.index` | GET /service-centre/tyre-inventory | TODO |
| `sc.battery-inventory.index` | GET /service-centre/battery-inventory | TODO |
| `sc.po-list.index` | GET /service-centre/po-list | TODO |
| `sc.grn.index` | GET /service-centre/grn | TODO |

#### Discussions (Session 1)

- **Module naming resolved:** Service Module (top-level nav), Workshop (in-house), ServiceCenter (external ASC/third-party)
- **Inventory architecture:** pending → resolved in Session 2 (single module)
- **ServiceCenter fields:** pending → confirmed in Session 2

---

## Pending Builds (Master List)

| Page | Sub-Module | Key Features | Status |
|---|---|---|---|
| `sc/workshop/job-cards` | Workshop | Job card list, status filters, create from SR, bulk updates | TODO |
| `sc/workshop/job-cards/{id}` | Workshop | 8-tab detail: Overview, Labour, Parts, Checklist, Photos, Billing, Timeline, Notes | TODO |
| `sc/workshop/technicians` | Workshop | Kanban lanes (Available / WIP / On-Break), job assignment, stats | TODO |
| `sc/workshop/billing` | Workshop | Invoice builder — labour + parts + GST, payment modes, print SC bill | TODO |
| `sc/workshop/delivery` | Workshop | Out-token, out-inspection checklist, delivery acknowledgement | TODO |
| `sc/workshop/onroad` | Workshop | Breakdown dispatch, own tech or third-party, location capture, status | TODO |
| `sc/external/dispatch` | ServiceCenter | Dispatch form — ASC Name, vehicle, job order #, warranty claim #, expected return | TODO |
| `sc/external/tracker` | ServiceCenter | Status timeline per vehicle — Dispatched → At SC → Work Done → Invoiced → Returned | TODO |
| `sc/external/billing` | ServiceCenter | Bill reconciliation — covered vs uncovered, approval, payment | TODO |
| `sc/external/return` | ServiceCenter | Vehicle return gate, KM capture, condition check, close SC job | TODO |
| `sc/maintenance/pm-calendar` | Maintenance | Monthly calendar, PM schedule per vehicle, colour-coded status | TODO |
| `sc/maintenance/insurance` | Maintenance | Claim log (repair + renewal), surveyor tracking, approved vs actual cost | TODO |
| `sc/alerts` | Maintenance | Aggregated feed — overdue oil, tyre wear, battery age, doc expiry | TODO |
| `sc/reports` | Maintenance | Charts — job cards by type/month, cost per vehicle, tech efficiency | TODO |
| `sc/inventory/spare-parts` | Inventory | Part master, stock levels, usage log, reorder alerts, location filter | TODO |
| `sc/inventory/tyres` | Inventory | Tyre stock (New/Re-thread/Scrap), location filter, PO linkage | TODO |
| `sc/inventory/batteries` | Inventory | Battery stock, health status, fitment history per vehicle | TODO |
| `sc/inventory/purchase-orders` | Inventory | PO for SC + Warehouses, vendor filter, status: Draft → Approved → Received | TODO |
| `sc/inventory/goods-receipt` | Inventory | GRN against PO, item-level receipt, stock auto-increment on save | TODO |

---

## Recurring Task
After every session: add a new `### Session N — DD Mon YYYY` block at the top of the Session Log. Fill in Files Changed, Routes, Decisions. Update Pending Builds status column.
