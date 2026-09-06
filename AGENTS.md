# AGENTS.md

## 1. Purpose

This file defines the permanent working rules for AI coding agents operating on the UCO (Used Cooking Oil) project.

The agent must treat this file as the primary implementation contract for repository-level behavior. Feature-specific prompts may add requirements, but they must not silently override finalized architecture, database structures, or business rules documented here.

When instructions conflict, use this priority:

1. Explicit instruction in the current task.
2. Finalized rules in this `AGENTS.md`.
3. Relevant project documentation under `docs/` if available.
4. Existing application behavior and established code patterns.
5. General framework conventions.

Never invent business rules merely to complete an implementation.

---

## 2. Project Overview

UCO is a multi-program Used Cooking Oil management system covering:

- Organization and program membership.
- PKK / collector operations.
- Resident collection visits.
- Shipment and logistics.
- Driver mobile workflow.
- Receiving at warehouse.
- Quality Control.
- Inventory.
- Storage containers.
- Blending.
- User, group, route, and permission management.
- Operational summaries and rankings.

The project is a server-rendered web application. It is not an API-first application.

---

## 3. Technology Stack

Use the existing stack unless the current task explicitly changes it:

- PHP 8.2.
- CodeIgniter 4.
- Current upgraded project baseline: CodeIgniter 4.7.x.
- MySQL 8.
- Nginx.
- Docker for local development.
- Bootstrap 5.
- Bootstrap Icons.
- jQuery / existing JavaScript patterns.
- DataTables where already used for administrative listings.

Do not introduce a new framework or major dependency without explicit instruction.

In particular, do not introduce:

- Laravel patterns into CodeIgniter code.
- React.
- Vue.
- Tailwind CSS.
- An API architecture when the requested flow is a normal controller + view flow.

---

## 4. CodeIgniter Application Rules

Follow the existing CodeIgniter 4 repository structure.

Typical locations:

```text
app/Controllers/
app/Models/
app/Views/
app/Config/
public/
writable/
```

Use namespaces appropriate to the file location.

Example for a mobile controller:

```php
namespace App\Controllers\Mobile;
```

If a controller extends `BaseController`, import or resolve the correct `BaseController` for its namespace. Do not assume a namespaced controller can see another namespace's `BaseController` automatically.

Before creating a new class, model, helper, or service:

1. Search for an existing implementation.
2. Reuse existing project conventions.
3. Avoid duplicate abstractions.

---

## 5. Implementation Style

The default implementation style is conventional CodeIgniter MVC.

For a normal save operation, prefer this flow:

```text
Request
  -> Controller
  -> Validation
  -> Business rule validation
  -> Database transaction when required
  -> Model / database write
  -> Commit or rollback
  -> Flash / JSON message depending on existing page flow
  -> Redirect or frontend update
```

Do not automatically create REST endpoints.

If the existing page saves using JavaScript/AJAX, follow the existing AJAX pattern. If it saves by normal form submission, follow the existing normal form pattern.

Do not rewrite a working module into a different architectural style merely for code cleanliness.

---

## 6. No-Assumption Rule

Business logic must not be guessed.

Before asking the developer for information, first inspect:

- Existing controllers.
- Existing models.
- Existing routes.
- Existing views.
- Existing database schema.
- Existing status records.
- Relevant project documentation.

If a required business decision still cannot be determined safely, report exactly what is missing instead of inventing a value.

Examples of values that must not be invented:

- `status_id`.
- `status_code`.
- `page_id`.
- `action_id`.
- `organization_program_id`.
- Foreign-key values.
- Group IDs not already established.
- Upload destination rules.
- Redirect destination.
- Numbering formats not documented by the task or existing code.

---

## 7. Finalized Database Protection Rule

Several UCO table structures and business flows have already been discussed and finalized.

Do not:

- Rename finalized columns.
- Remove finalized columns.
- Change a primary key.
- Change a foreign-key relationship.
- Change a finalized business relationship.
- Drop a table.
- Replace an established table with a different design.

unless the current task explicitly requests a schema redesign.

If a proposed implementation appears to require a schema change, explain the required change before applying it when the task has not already authorized that change.

Do not generate migrations merely because CodeIgniter supports migrations. Use the project's existing database-change workflow unless a migration is explicitly requested.

---

## 8. Database Conventions

Database engine: MySQL 8.

Be compatible with strict SQL behavior, including `ONLY_FULL_GROUP_BY`.

Do not fix grouping errors by weakening MySQL SQL modes. Fix the query correctly using one of:

- Proper grouping.
- Aggregate expressions.
- A subquery.
- A derived table.
- Another SQL structure that preserves correct semantics.

For foreign keys:

- Referencing and referenced columns must use compatible data types.
- Signed/unsigned attributes must match.
- Length/type must be compatible.
- Auto-increment columns must be indexed correctly.

When copying or recreating a table, preserve keys before applying `AUTO_INCREMENT`.

---

## 9. Audit Fields

Where a table already has audit fields, preserve and populate them consistently.

Common fields include:

```text
created_date
modified_date
created_by
modified_by
```

Use the logged-in user's session `users_id` for `created_by` / `modified_by` where applicable.

Do not add audit columns to finalized tables unless explicitly requested.

---

## 10. Multi-Program Architecture

UCO is a multi-program system.

Program-scoped data must respect the active program context.

The active program is obtained from the existing session mechanism. The project commonly uses a session program value for data scoping.

Rules:

- Never expose records from another program accidentally.
- Apply program scope to queries when the underlying entity is program-specific.
- Do not hardcode a program ID.
- Reuse the program selected/stored by the login/session flow.
- When an organization is used inside a program-specific transaction, use `organization_program_id`, not merely `organization_id`, where the schema expects it.

---

## 11. User, Group, and Program Role Model

Authorization is based on the established user/group/program relationship rather than legacy role strings such as `users.title = DRIVER`.

Use the existing group/program membership model.

Established rules include:

- Admin group has full-access bypass according to the existing permission implementation.
- Driver role uses the group/program permission architecture.
- Do not restore legacy `users.title` role checks where the newer group/program mechanism already replaced them.

Do not invent new group IDs. Read them from existing configuration/data when required.

---

## 12. Permission Architecture

The permission system uses the established tables:

```text
page
action
privilege
usersgroupprogram
route
```

Permission checks are based on the route/page/action mapping and the logged-in user's group/program context.

The permission filter must respect:

- `page_id`.
- `action_id`.
- HTTP method where relevant.
- Active program.
- Admin bypass rule.

Common actions include:

```text
index
admin
create
edit
delete
view
datatables
```

DataTables endpoints also require the correct permission action and route mapping.

Do not solve a `403` by disabling the permission filter.

If an endpoint is new, inspect the existing route and permission architecture before adding it.

---

## 13. Routing Rules

CodeIgniter routing must match the actual controller namespace and method.

For mobile controllers under:

```text
app/Controllers/Mobile/
```

ensure the route resolves to the correct `App\Controllers\Mobile\...` class.

For POST actions, explicitly verify the POST route exists when auto-routing is not intended.

Example failure to avoid:

```text
Can't find a route for 'POST: auth/ceklogin'
```

Do not add permissive routing solely to bypass a missing explicit route.

---

# DOMAIN MODEL

## 14. Organization

`organization` is the organization master.

Finalized core fields:

```text
organization_id
organization_code
organization_name
pic_name
address
phone
email
picture
latitude
longitude
note
modified_date
modified_by
```

Address data may include province/city/district/village components according to the existing implementation.

Do not create a parallel `company` implementation when the UCO flow has already moved to `organization`.

---

## 15. Organization Program

Organizations participate in programs through `organization_program`.

Core fields:

```text
organization_program_id
organization_id
program_id
organization_type_id
status_id
created_date
modified_date
created_by
modified_by
```

`organization_program_id` is the program-specific organization identity used by operational modules.

Organization types used by the project include concepts such as:

- Supplier.
- Buyer.
- PKK.
- Storage.
- Koperasi.
- Bank Sampah.

Use existing master data rather than inserting duplicate type values.

---

## 16. Organization User

The project has an `organization_user` relationship for associating users with an organization-program context.

Core fields:

```text
organization_user_id
organization_program_id
users_id
active
created_date
modified_date
created_by
modified_by
```

The combination of:

```text
organization_program_id + users_id
```

must remain unique according to the established application rule.

When editing a user:

- If password input is empty/null, do not replace the existing password.
- Validate duplicate organization/user membership and return an understandable error.

Do not treat `organization_user` and `collector` as automatically interchangeable; they serve different application responsibilities unless a future redesign explicitly changes this.

---

# COLLECTOR / PKK

## 17. Collector

The finalized collector module keeps a dedicated `collector` table.

Core fields:

```text
collector_id
users_id
organization_program_id
active
created_date
modified_date
created_by
modified_by
```

`collector` is the operational mapping between a user account and the PKK / organization-program context where that user performs collection activity.

Relationship concept:

```text
users
  -> collector
      -> organization_program
          -> organization (PKK / Kelurahan)
```

`collector_id` remains the collector identity recorded by collection transactions so the system can identify which collector performed a visit.

Do not remove `collector` or replace `collector_id` in collection transactions unless a future task explicitly changes the finalized design.

---

## 18. Resident

Finalized resident structure:

```text
resident_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
resident_code
resident_name
phone
province
city
district
village
address
latitude
longitude
active
created_date
modified_date
created_by
modified_by
```

Resident code generation follows the agreed concept:

```text
RES + YYYYMMDD + short random numeric suffix
```

Do not invent an unnecessarily long random suffix.

Before inserting, still enforce database/application uniqueness according to the existing schema.

---

## 19. Collection Visit

Finalized structure:

```text
collection_visit_id
visit_number
collector_id
resident_id
visit_date
visit_time
qty
unit
status_id
note
created_date
modified_date
created_by
modified_by
```

Visit number generation follows the agreed concept:

```text
CV + YYYYMMDD + short random numeric suffix
```

Do not invent an exact suffix length when it has not been defined by existing code.

A collection visit belongs to:

- One collector.
- One resident.

Collection quantity and unit must be stored on the visit record.

Use the status master for collection-visit workflow states.

Do not hardcode an unknown collection `status_id`.

---

## 20. Status Master for Collection

Collection visit statuses belong in the existing status master.

Relevant status master fields include:

```text
module
status_code
status_name
```

If collection-specific status data is missing, add the required status master records as part of an explicitly authorized implementation rather than using magic numeric IDs.

Application logic should prefer stable `status_code` semantics where practical and resolve the corresponding database ID.

---

## 21. Collection Visit Attachment

Finalized structure:

```text
collection_visit_attachment_id
collection_visit_id
file_path
file_name
file_type
file_size
created_date
created_by
```

Attachments belong to an existing `collection_visit`.

Do not invent an upload directory when the current code/task has not established it. Inspect existing project upload conventions first.

Validate uploaded files using the established CodeIgniter upload mechanism and application constraints.

---

## 22. Collector and User Collection Summaries

`collector_balance` is not used in the finalized collector architecture.

Do not create, restore, query, update, or depend on `collector_balance` for the Collector / PKK workflow unless a future task explicitly redesigns this architecture.

Collector personal dashboard/statistics use the existing user-level collection summary tables. These tables already exist and must not be recreated or replaced with `collector_balance`.

### `users_collection_balance`

Finalized fields:

```text
users_id
total_qty
total_visit
last_visit_date
last_visit_time
modified_date
```

Purpose:

- Fast/current aggregate for the logged-in Collector user's dashboard.
- Stores cumulative collection quantity and visit count for the user.
- Stores the user's latest collection visit date/time.

### `users_collection_daily_summary`

Finalized fields:

```text
users_collection_daily_summary_id
users_id
summary_date
total_visit
total_qty
created_date
modified_date
```

Purpose:

- Daily collection summary per `users_id`.
- Used for Collector user daily statistics/history/dashboard data when required.

### `users_collection_monthly_summary`

Finalized fields:

```text
users_collection_monthly_summary_id
users_id
summary_year
summary_month
total_visit
total_qty
created_date
modified_date
```

Purpose:

- Monthly collection summary per `users_id`.
- Used for Collector user monthly statistics/dashboard data when required.

Relationship concept:

```text
users
  -> collector
      -> collection_visit
          -> users_collection_balance
          -> users_collection_daily_summary
          -> users_collection_monthly_summary
```

The collector transaction still records `collector_id`, but user-level summaries are keyed by `users_id`.
Resolve the correct `users_id` through the logged-in Collector / `collector` relationship; do not substitute `collector_id` into a `users_id` field.

After a successful `collection_visit`, update the relevant existing user-level balance/daily/monthly summary as part of the same consistent business transaction flow.
Do not update these summaries when the source `collection_visit` is rolled back.

---

## 23. Organization Collection Summaries

Daily summary:

```text
organization_collection_daily_summary
```

Core fields:

```text
id
organization_program_id
summary_date
total_qty
total_visit
created_date
```

Monthly summary:

```text
organization_collection_monthly_summary
```

Core fields:

```text
id
organization_program_id
year
month
total_qty
total_visit
created_date
```

These tables are organization-level summaries/caches derived from operational collection data.

The aggregation key is `organization_program_id`, representing the PKK / Kelurahan organization-program context. A summary combines collection activity from all collectors assigned to that same `organization_program_id`.

Conceptually:

```text
collection_visit
  -> collector
      -> organization_program_id
          -> organization_collection_daily_summary
          -> organization_collection_monthly_summary
```

After a successful collection transaction, update the applicable organization daily/monthly summary according to the existing implementation. Do not update summary data when the source transaction is rolled back.

Do not use these summary tables as a substitute for `collection_visit` when transaction-level detail is required.

---

## 24. Collector Dashboard

The Collector / PKK mobile application is used by a collector to perform oil collection from residents.

The logged-in Collector user's personal dashboard uses the existing user-level collection summaries:

```text
users_collection_balance
users_collection_daily_summary
users_collection_monthly_summary
```

Use these tables for Collector personal totals/statistics according to the existing UI and feature requirements.
Do not replace them with `collector_balance`, and do not recalculate all personal dashboard aggregates from `collection_visit` when the finalized summary tables already provide the required values.

The collector relationship still determines both identities required by the flow:

```text
collector.users_id
    -> personal Collector summaries

collector.organization_program_id
    -> PKK / Kelurahan organization summaries
```

Organization-level totals combine transactions from all collectors mapped to the same `organization_program_id` and use the organization collection summary tables.

PKK / Kelurahan ranking is organization-level ranking, not ranking between individual collectors.

Keep these scopes separate:

```text
Collector personal dashboard
    -> users_collection_*

PKK / Kelurahan organization summary and ranking
    -> organization_collection_*
```

Derive all numbers from the correct user or organization summary scope and the active program context.

---

# SHIPMENT / LOGISTICS

## 25. Shipment

Finalized shipment structure:

```text
shipment_id
shipment_number
purchase_order_id
shipment_type
driver_id
vehicle_id
planned_departure_at
actual_departure_at
planned_arrival_at
actual_arrival_at
completed_at
total_stop
status_id
note
created_date
modified_date
created_by
modified_by
```

Supported shipment types:

```text
COLLECTION
INBOUND
OUTBOUND
TRANSFER
```

Shipment number convention currently follows the established generator concept:

```text
001/SJ/<RomanMonth>/<yy>
```

Reuse the existing generator. Do not implement another numbering scheme in parallel.

---

## 26. Shipment Detail

Finalized fields:

```text
shipment_detail_id
shipment_id
sequence_no
activity_type
organization_program_id
warehouse_id
departure_at
arrival_at
qty
unit
status_id
note
created_date
modified_date
created_by
modified_by
```

Supported activity types:

```text
PICKUP
DROPOFF
TRANSFER
```

`organization_program_id` and `warehouse_id` are used according to shipment/activity type and may be nullable only where the finalized business flow allows it.

Default shipment-detail status follows the existing project status configuration; the project has historically used detail `status_id = 11`, but implementation must prefer resolving/confirming the existing status master rather than spreading magic IDs into new code.

---

## 27. COLLECTION Shipment Rules

A `COLLECTION` shipment must satisfy all of the following:

- Minimum two route/detail rows.
- At least one `PICKUP`.
- Exactly one `DROPOFF`.
- `DROPOFF` must be the final route.
- Duplicate pickup organization is not allowed.

When validating the last route in PHP, do not assume sequential indexes. Use logic equivalent to `array_key_last()` when appropriate.

---

## 28. INBOUND Shipment Rules

`INBOUND` flow:

```text
Supplier organization -> Warehouse
```

Rules:

- Pickup uses an organization of the appropriate supplier context.
- Dropoff uses a warehouse.

---

## 29. OUTBOUND Shipment Rules

`OUTBOUND` flow:

```text
Warehouse -> Buyer organization
```

Rules:

- Pickup uses a warehouse.
- Dropoff uses a buyer organization.

---

## 30. TRANSFER Shipment Rules

`TRANSFER` flow:

```text
Warehouse -> Warehouse
```

Use warehouse references for both ends according to the finalized transfer flow.

---

## 31. Shipment Status Rules

Established shipment status codes include:

```text
RTDT   = Ready to Depart
SDLPN  = On Delivery
SMBR   = Arrived Buyer
SCMPL  = Completed
```

Use status codes/business meaning rather than scattering raw numeric IDs.

Shipment editing is only allowed while the shipment is in the established editable workflow states, currently:

```text
RTDT
SDLPN
```

Do not broaden editable states without explicit instruction.

---

## 32. Shipment Save Transaction

Saving a shipment with details is a multi-table operation and must use a database transaction.

Required behavior:

```text
begin transaction
  validate header
  validate routes
  insert/update shipment
  insert/update shipment_detail
commit
```

On failure:

```text
rollback
```

Never leave a saved shipment header with an incomplete detail set because a later detail insert failed.

---

## 33. Shipment Tracking

Finalized tracking structure:

```text
tracking_id
shipment_id
photo
latitude
longitude
notes
status_id
created_date
created_by
```

Tracking records belong to a shipment and may capture mobile driver evidence such as photo and location.

---

# DRIVER MOBILE

## 34. Driver Mobile Workflow

Driver mobile UI is a mobile-web interface.

The index shows shipment cards with information such as:

- Shipment number.
- Route summary.
- Progress, for example `0 / 2 tujuan`.
- Current shipment status.

The detail page shows:

- Driver.
- Vehicle / plate.
- Route progress.
- Destination sequence.
- Activity type.
- Organization or warehouse destination.
- Relevant times.

When the driver presses the action equivalent to **Mulai Tujuan**:

- Update the relevant `shipment_detail` status.
- Do not incorrectly update the whole `shipment` when the action is destination-specific.

The destination flow can expose actions such as:

- Mulai Tujuan.
- Sudah Sampai.
- Batalkan.

Cancellation/reversal must restore the correct route/detail status according to the established workflow.

Photo preview should follow the existing page's JavaScript pattern.

---

# RECEIVING & QC

## 35. Receiving

Finalized receiving structure:

```text
receiving_id
receiving_number
program_id
warehouse_id
shipment_id
received_date
status_id
note
created_date
modified_date
created_by
modified_by
deleted_date
deleted_by
is_deleted
```

Business relationship:

```text
1 shipment with multiple PKK/collector pickups
    -> 1 receiving at the warehouse
```

Receiving is the warehouse receipt document for the shipment, not one receiving record per collector pickup.

---

## 36. Quality Control

Use `qc_inspection` as the QC structure for the current architecture rather than recreating the legacy `quality_control` design.

Core fields:

```text
qc_id
shipment_id
qc_type
result
ffa
mi
photo
notes
status_id
created_date
modified_date
created_by
modified_by
```

Supported QC types:

```text
INCOMING
OUTGOING
BLENDING
```

Supported result semantics:

```text
PASSED
FAILED
```

Do not reinterpret FFA/MI rules without explicit business requirements.

---

# INVENTORY

## 37. Item

Finalized item concept:

```text
item_id
item_code
item_name
unit
created_date
```

The UCO item represents the used cooking oil commodity handled by the inventory flow.

---

## 38. Storage Container

Finalized storage-container fields:

```text
container_id
container_code
container_name
container_type_id
warehouse_id
capacity
capacity_unit
status_id
created_date
modified_date
created_by
modified_by
```

Container type master:

```text
container_type_id
type_name
```

Common type concepts include:

- Tank.
- IBC.
- Drum.
- Jerigen.

Use existing master values rather than duplicating them.

---

## 39. Inventory Transaction

`inventory_transaction` is the movement ledger.

Finalized fields:

```text
inventory_transaction_id
program_id
warehouse_id
container_id
item_id
transaction_type
reference_type
reference_id
qty
unit
note
created_date
created_by
```

Transaction types include:

```text
RECEIVING
OUTBOUND
TRANSFER
ADJUSTMENT
BLENDING
```

Reference types include:

```text
RECEIVING
SHIPMENT
ADJUSTMENT
BLENDING
```

Inventory movement should be traceable back to its source document through `reference_type` + `reference_id`.

---

## 40. Inventory Balance

Finalized balance structure:

```text
id
program_id
warehouse_id
container_id
item_id
oil_grade
current_qty
modified_date
```

Oil-grade values include:

```text
INSPECT
OUTSPEC
```

`inventory_balance` is the current-state balance/cache. `inventory_transaction` remains the movement history/ledger.

Balance updates and transaction inserts must remain consistent.

When both are changed by one business operation, use a database transaction.

---

## 41. Container Grade Rule

A tank/container follows the established single-grade inventory concept for its current stored oil.

Do not silently mix incompatible grades in the same container.

If a business process requires grade transformation or combining source oil, use the blending/QC flow rather than directly manipulating the balance.

---

# BLENDING

## 42. Blending

Finalized blending header:

```text
blending_id
blending_number
warehouse_id
program_id
planned_qty
actual_qty
status_id
created_date
created_by
```

Blending detail:

```text
detail_id
blending_id
source_container_id
qty_source
target_container_id
qty_target
```

Blending is used to combine/manage oil so the resulting stock can satisfy downstream/buyer QC requirements.

Blending must remain traceable through inventory transactions.

Do not directly change balances without recording the corresponding inventory movement.

---

# FRONTEND

## 43. General Frontend Rules

Use the existing HTML structure and CSS classes before creating new styling systems.

Administrative pages generally follow the existing Bootstrap/card/form patterns.

For create/edit forms:

- Use Bootstrap-compatible form markup.
- Preserve the existing card layout.
- Keep validation messages understandable.
- Follow existing button styles.
- Reuse existing JavaScript conventions.

For DataTables:

- Follow the existing server-side/client-side implementation already used by the module.
- Ensure the corresponding `datatables` route/action permission exists.

---

## 44. Collector / PKK Mobile UI

Collector/PKK interface is mobile-first web UI.

Its primary operational flow is:

```text
Collector login
  -> resolve collector, users_id, and organization_program_id
  -> collect oil from resident
  -> save collection_visit
  -> save collection_visit_attachment when applicable
  -> update users_collection_balance
  -> update users_collection_daily_summary
  -> update users_collection_monthly_summary
  -> update organization daily/monthly collection summary
  -> show Collector personal dashboard and PKK / Kelurahan ranking
```

The Collector personal dashboard uses `users_collection_*` data for the logged-in `users_id`.
PKK / Kelurahan totals and ranking use `organization_collection_*` data for the collector's `organization_program_id`, aggregating all collectors under that organization-program context.
`collector_balance` is not used.

Primary theme color:

```text
#17A2B8
```

Buttons may use harmonious supporting colors, but the visual language must remain consistent with the primary theme.

The established bottom-navigation concept contains:

```text
Home
Top Rank
History
Profile
```

Prefer mobile cards and compact forms rather than desktop-oriented tables.

The **Tambah Warga Baru** flow is displayed as a modal/pop-up in the mobile collector experience rather than unnecessarily navigating away when implemented on that page.

Bootstrap version currently used by the mobile interface includes Bootstrap 5.3.x and Bootstrap Icons.

---

# FILE UPLOAD & CSV

## 45. File Upload Rules

Use CodeIgniter's uploaded-file handling and validate:

- Upload success/validity.
- Extension/type according to feature requirements.
- File size according to configured limits.
- Destination path.
- Generated/safe file name where needed.

The Docker PHP environment has required upload configuration support through project PHP configuration such as `uploads.ini`.

Do not assume PHP's old default 2 MB upload limit is the intended application limit; inspect the project's configured PHP values.

---

## 46. CSV Import Rules

CSV imports must account for UTF-8 BOM in the first column name.

Example historical problem:

```text
﻿organization_name
```

instead of:

```text
organization_name
```

Normalize/strip BOM before mapping headers.

Do not silently map an unknown CSV heading to another field.

Validate required fields and accumulate meaningful row-level error messages according to the existing import style.

---

# DOCKER / LOCAL DEVELOPMENT

## 47. Docker Rules

The UCO local environment uses Docker services for the application stack.

Typical services include:

- PHP 8.2 FPM.
- Nginx.
- MySQL 8.
- phpMyAdmin when enabled.

The application source is mounted into the PHP/Nginx containers according to the existing `docker-compose` configuration.

From inside the PHP container, connect to MySQL using the Docker service hostname configured by the project, not `localhost`, because `localhost` refers to the PHP container itself.

Do not hardcode host-machine port mappings into CodeIgniter database configuration used from container-to-container communication.

Required PHP extensions in the established environment include at least:

```text
intl
mbstring
PDO
pdo_mysql
zip
gd
```

When adding a PHP extension, update the Docker image reproducibly rather than manually modifying a running container only.

---

## 48. Writable Directories

CodeIgniter writable paths must exist and be writable by the application runtime.

This includes directories such as:

```text
writable/cache
writable/logs
writable/session
```

Do not solve a permission problem by making the entire project globally writable.

---

# SECURITY & DATA INTEGRITY

## 49. Transactions

Use database transactions for any business operation that must succeed atomically across multiple writes.

Examples:

- Shipment + shipment detail.
- Collection visit + attachment + user collection summaries + organization collection summaries.
- Receiving + inventory movement/balance when implemented as one operation.
- Blending + inventory movements/balances.

Pattern:

```text
begin
write source transaction
write dependent records
update summaries/balances
commit
```

On any failure:

```text
rollback everything
```

---

## 50. Foreign-Key Integrity

Never work around an FK error by inserting dummy IDs.

When an FK error occurs:

1. Inspect both column definitions.
2. Inspect referenced data.
3. Confirm program scope.
4. Confirm entity type.
5. Confirm insertion order.

Example: if a field requires `organization_program_id`, do not supply a raw `organization_id`.

---

## 51. Authentication and Password Editing

Never overwrite an existing password with an empty value during edit.

Rule:

```text
password provided
    -> validate and update password

password empty/null
    -> preserve existing password
```

Use the project's established password hashing mechanism.

Do not store plaintext passwords.

---

## 52. Session and Authentication Failures

When a protected page detects that a user is no longer authenticated, follow the established application login flow.

Do not return a generic permission error such as:

```text
User belum login.
```

when the correct user experience is to return/redirect to the login view according to the application's authentication architecture.

Keep authentication failure distinct from authorization/permission failure.

---

# AGENT WORKFLOW

## 53. Before Implementing a Task

For every non-trivial task, inspect the relevant implementation before editing.

Minimum checklist:

```text
1. Identify the relevant module.
2. Read the controller.
3. Read the model(s).
4. Read the view(s).
5. Check routes.
6. Check permission mapping when protected.
7. Check relevant DB structure/FKs.
8. Check relevant status master values.
9. Identify existing project conventions.
10. Implement the smallest correct change.
```

Do not rewrite unrelated files.

---

## 54. When Modifying Existing Code

Preserve working behavior outside the requested change.

Do not:

- Rename public methods unnecessarily.
- Change route URLs without instruction.
- Change form field names without updating all consumers.
- Refactor unrelated modules.
- Replace working queries merely because another style is preferred.
- Add abstractions that the project does not need.

Prefer a focused patch over a broad rewrite.

---

## 55. When Fixing a Bug

Find the root cause before applying a workaround.

Examples:

- Missing POST route -> fix route, not form method.
- Wrong controller namespace -> fix namespace/route resolution.
- `ONLY_FULL_GROUP_BY` -> fix SQL query.
- `organization_program_id cannot be null` -> fix organization-program resolution.
- FK incompatible columns -> fix schema type compatibility.
- `btnTambahWarga is null` -> verify DOM placement/selector before changing framework code.
- CSV first header not matching -> inspect/remove BOM.
- Docker DB `No such file or directory` -> verify DB host/socket/network configuration instead of changing application business logic.

---

## 56. Status Handling

Prefer semantic status codes over numeric status IDs in business logic whenever the existing schema/model makes that practical.

Good:

```text
resolve status_code = RTDT
```

Avoid spreading:

```text
status_id = 10
status_id = 11
```

through new code without context.

Numeric IDs may be used where the existing application already establishes them, but new logic must not invent them.

---

## 57. Number Generation

Reuse existing number generators.

Known numbering concepts include:

```text
Shipment:
001/SJ/<RomanMonth>/<yy>

Resident:
RES<YYYYMMDD><short random numeric suffix>

Collection visit:
CV<YYYYMMDD><short random numeric suffix>
```

Number generation must avoid collisions.

Do not create long random strings when the finalized requirement calls for a short numeric suffix.

---

## 58. Source of Truth

For transactional domains, distinguish transaction/source tables from cache/summary tables.

Examples:

```text
collection_visit
    -> source collection transaction

users_collection_balance
users_collection_daily_summary
users_collection_monthly_summary
    -> user-level derived balance/summaries for Collector dashboard/statistics

organization_collection_daily_summary
organization_collection_monthly_summary
    -> organization-level derived summaries/cache for PKK / Kelurahan totals and ranking
```

`collector_balance` is not part of the finalized Collector / PKK architecture and must not be used as a source or cache.
Do not confuse `users_collection_balance` with the removed/unused `collector_balance` concept.

and:

```text
inventory_transaction
    -> movement ledger

inventory_balance
    -> current balance/cache
```

Never treat a summary/cache table as the only transaction history.

---

## 59. Documentation Discipline

When a task introduces a genuinely finalized architecture or business rule that should affect future AI work, update the appropriate project documentation.

Do not stuff every feature detail into `AGENTS.md`.

Recommended separation:

```text
AGENTS.md
    permanent agent rules and finalized cross-project architecture

docs/PRD.md
    product requirements

docs/ARCHITECTURE.md
    architecture and module relationships

docs/DATABASE.md
    current database schema

docs/modules/*.md
    detailed module flows

prompts/*.md
    implementation tasks for coding agents
```

---

## 60. Final Agent Constraints

The coding agent must always follow these constraints:

1. Do not make undocumented business assumptions.
2. Do not silently change finalized database structures.
3. Do not remove the `collector` architecture from the collection module unless explicitly instructed.
4. Do not replace `organization_program_id` with `organization_id` where program-specific identity is required.
5. Do not bypass the permission system to fix authorization errors.
6. Do not disable strict MySQL SQL modes to make broken queries work.
7. Do not create API endpoints unless the task requires an API.
8. Do not introduce new frontend frameworks.
9. Do not update inventory balances without a traceable inventory transaction where the flow requires ledger movement.
10. Do not update summary/cache tables if their source transaction fails.
11. Do not partially save multi-table transactions.
12. Do not overwrite passwords when edit password input is empty.
13. Do not hardcode unknown foreign keys or status IDs.
14. Do not alter unrelated working code.
15. Prefer the smallest correct implementation that matches existing project patterns.
16. Keep Collector personal summaries (`users_collection_*`) separate from PKK / Kelurahan organization summaries (`organization_collection_*`); never replace either scope with `collector_balance`.

---

## 61. Definition of Done

A task is complete only when the implementation is consistent with:

- Current CodeIgniter structure.
- Finalized UCO business rules.
- Database constraints.
- Program scope.
- Permission architecture.
- Existing frontend patterns.
- Transactional integrity.

Before considering implementation complete, check for:

```text
- PHP syntax errors
- incorrect namespaces
- missing routes
- incorrect HTTP methods
- missing permission mappings
- missing program scope
- invalid foreign keys
- duplicate records where uniqueness is required
- transaction rollback behavior
- incorrect status transitions
- broken redirects/AJAX responses
- frontend selector errors
- SQL strict-mode errors
```

The goal is not merely code that runs. The goal is code that remains consistent with the finalized UCO architecture and business flow.

---

## 62. Final Mobile Frontend Stylesheet Rules

The mobile frontend for Driver and Collector uses different existing stylesheets.
These paths and their separation are finalized project decisions.

### Driver Mobile

Driver mobile pages use:

```text
/teamplate/assets/mobile.css
```

### Collector Mobile

Collector mobile pages use:

```text
teamplate/assets/collector.css
```

### Mandatory Rules

1. Do not replace these stylesheets with a shared mobile stylesheet.
2. Do not merge Driver and Collector mobile CSS.
3. Do not switch Driver pages to `collector.css`.
4. Do not switch Collector pages to `mobile.css`.
5. Do not rename or relocate these stylesheet paths unless explicitly instructed.
6. Do not refactor existing mobile frontend code merely to standardize Driver and Collector styling.
7. Existing Driver and Collector mobile frontend implementations are considered aligned with the project and must be preserved.
8. When implementing new mobile features, extend the existing frontend structure and stylesheet for the relevant account type instead of replacing it.
9. Changes to existing working mobile UI should be limited to what is required by the requested feature.
10. Do not introduce a new CSS framework or a new shared mobile design system unless explicitly requested.

When working on Driver mobile UI, inspect and follow the existing patterns in `/teamplate/assets/mobile.css`.

When working on Collector mobile UI, inspect and follow the existing patterns in `teamplate/assets/collector.css`.
