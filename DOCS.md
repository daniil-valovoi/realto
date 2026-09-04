# Realto — Project Documentation

Realto is a Miami-area real estate platform where users can list, search, rent, and buy properties. Built with vanilla PHP, vanilla JS (ES modules), SCSS, and MariaDB.

---

## Table of Contents

1. [Getting Started](#getting-started)
2. [Architecture Overview](#architecture-overview)
3. [Directory Structure](#directory-structure)
4. [Database Schema](#database-schema)
5. [Authentication & Sessions](#authentication--sessions)
6. [PHP API Endpoints](#php-api-endpoints)
7. [PHP Block Scripts](#php-block-scripts)
8. [JavaScript Modules](#javascript-modules)
9. [Pages](#pages)
10. [Shared Blocks (HTML/PHP partials)](#shared-blocks-htmlphp-partials)
11. [Styling (SCSS)](#styling-scss)
12. [Key Data Flows](#key-data-flows)

---

## Getting Started

### 1. Import the database

Import `database-setup.sql` (found in the repo root) into MariaDB/MySQL:

```bash
mysql -u root -p < "database-setup.sql"
```

Or import it via phpMyAdmin / any GUI client.

### 2. Configure the DB connection

Open `scripts/php/api/database-connection.php` and fill in your credentials:

```php
$database_host = "localhost";
$database_login = "your_username";
$database_password = "your_password";
$database_name = "your_database_name";
```

### 3. Seed mock data

Navigate to `scripts/php/functions/populate-db/` in the browser (while the PHP server is running) and open:

```
populate-all-data.php
```

This runs all three population scripts in the correct order — users → properties → listings.  
All mock users are created with the default password: **`password123`**

You can use these accounts to test the role-based access:

| Email | Role |
|---|---|
| `admin@gmail.com` | Admin |
| `test@test.com` | User |

### 4. Start the servers

Use XAMPP/MAMP for a quicker start or start the PHP and MariaDB servers separately, then navigate to the localhost address your software provided.

---

## Architecture Overview

```
Browser (HTML/CSS/JS)
    │
    │  AJAX (fetch + header: ajax-request: true)
    │  Form POST / GET
    ▼
PHP (Apache / shared hosting under public_html/realto/)
    │
    │  mysqli prepared statements
    ▼
MariaDB (database-setup.sql schema)
```

- **No framework** — plain PHP with `require_once` includes.
- **AJAX detection** — PHP checks `$_SERVER['HTTP_AJAX_REQUEST']` to decide whether to return JSON or render HTML.
- **JS modules** — `type="module"` ES modules for sign-in, user data, dashboard tabs, search results, etc.
- **Routing** — URL-based (`?id=`, `?tab=`, `?variant=`); no dedicated router.

---

## Directory Structure

```
realto/
├── blocks/                  # Shared HTML/PHP UI blocks
├── images/                  # Static and user-generated images
├── pages/                   # Page files
│   ├── dashboard/           # Dashboard tab partials
│   │   └── admin/           # Admin-only tab partials
│   └── *.php                # Top-level pages
├── scripts/
│   ├── javascript/
│   │   ├── api-requests/    # JS fetch wrappers for PHP API endpoints
│   │   ├── blocks/          # UI component scripts
│   │   │   └── dashboard/   # Dashboard-specific display modules
│   │   ├── functions/       # Shared JS utilities
│   │   └── page-specific/   # Per-page JS <script> injections
│   └── php/
│       ├── api/             # API endpoint PHP files
│       ├── blocks/          # Form-handling PHP blocks
│       │   └── dashboard/   # Dashboard form/display handlers
│       └── functions/       # Shared PHP utilities
└── styles/                  # SCSS source + compiled CSS
    ├── blocks/              # Per-component SCSS partials
    └── styles.scss          # Main SCSS entry point
```

---

## Database Schema

### Tables

| Table | Purpose |
|---|---|
| `users` | User accounts (id, role_id, name, email, bcrypt password, profile_picture, phone) |
| `roles` | `1=user`, `2=admin` |
| `properties` | Core property data (address, zip, district, type, footage, beds, baths, floor, lot_size, parking, status, main_image_id) |
| `property_images` | Property photos (filenames only, files stored on disk) |
| `property_types` | `1=house`, `2=apartment` |
| `property_statuses` | `1=active`, `2=inactive`, `3=rented`, `4=sold` |
| `districts` | 10 Miami-area districts (Coconut Grove, Brickell, etc.) |
| `listings` | Base listing record (links property + user + offer_type + status) |
| `for_rent` | Rental-specific data (price/mo, security_deposit, minimal_rent_time, pet_friendly) |
| `for_sale` | Sale-specific data (price) |
| `offer_types` | `1=for rent`, `2=for sale` |
| `favorites` | User-saved properties (user_id + property_id + listing_type) |
| `messages` | User-to-user messages (sender, recipient, optional property_id, content, optional image) |
| `user_images` | User-uploaded images (profile pictures, message attachments) |
| `support_tickets` | User reports/support messages linked to a listing |

Foreign keys like property_id in listings or user_id in properties allows for cascade updates and deletions.

### Key Relationships

- `properties.user_id` → `users.user_id`
- `properties.main_image_id` → `property_images.image_id`
- `listings.property_id` → `properties.property_id`
- `for_rent.listing_id` / `for_sale.listing_id` → `listings.listing_id`
- `favorites.user_id` + `favorites.property_id` → `users` + `properties`
- `messages.sender_id` / `recipient_id` → `users.user_id`

---

## Authentication & Sessions

### Flow

1. User submits sign-in/sign-up form → `sign-in.php` via AJAX POST.
2. On success, `createSession($userId)` is called:
   - Sets `$_SESSION` variables (`logged_in`, `user_id`, `first_name`, `last_name`, `email`, `profile_picture`, `role`).
   - Calls `createSignature($userId)` → sets `user_token` cookie (30 days, HttpOnly).
3. On subsequent page loads, `check-session.php` / `fetch-user-data.php`:
   - If `$_SESSION['logged_in']` is set → uses session directly.
   - Else if `user_token` cookie exists → parses `userId_HMAC`, validates signature, rebuilds session from DB.
4. `displayLoggedInUserData()` (JS) fetches `/fetch-user-data.php` and populates `[data-logged-in-user-*]` elements and toggles `.restricted-content--auth` / `.restricted-content--not-auth` visibility.

### Token Format

`{userId}_{HMAC-SHA256(userId, secretKey)}`

> ⚠️ The secret key is hardcoded as `'qwerty123'` in `signature.php` — must be changed before any real deployment.

### Access Control

| Function | Effect |
|---|---|
| `restrictAccess()` | Blocks non-logged-in users (JS redirect with alert) |
| `restrictAdminAccess()` | Blocks non-admin users (JS redirect with alert) |

---

## PHP API Endpoints

All in `scripts/php/api/`. Detect AJAX via `$_SERVER['HTTP_AJAX_REQUEST']` and return JSON when present.

| File | Method | Purpose |
|---|---|---|
| `database-connection.php` | — | Creates global `$connection` (mysqli). Credentials are blank placeholders. |
| `api-functions.php` | — | Shared helpers (see below) |
| `sign-in.php` | POST | Handles `log-in` and `sign-up`; validates inputs, hashes passwords, calls `createSession()` |
| `create-session.php` | — | `createSession($userId)` — fetches user from DB, sets `$_SESSION`, creates cookie token |
| `check-session.php` | GET | Validates session or cookie token; returns `{logged_in, user}` JSON |
| `fetch-user-data.php` | GET | Same as `check-session.php` — used by JS on page load |
| `fetch-listings.php` | GET `?variant=` | Returns up to 10 listings for home-page slider variants (family-houses, short-term-rentals, affordable-apartments, new-to-realto, luxury-rentals) |
| `fetch-districts.php` | GET | Returns all districts |
| `fetch-types.php` | GET | Returns all property types |
| `fetch-statuses.php` | GET | Returns all property statuses |
| `fetch-roles.php` | GET | Returns all roles |
| `fetch-dashboard-tabs.php` | GET `?tab=` | Renders the requested dashboard tab PHP file via output buffering and returns its HTML as JSON `{content}` |
| `add-listing.php` | GET | Returns the current user's active properties (for listing creation form population) |
| `handle-action.php` | POST | delete/activate/deactivate on a user, property, or listing — enforces ownership for regular users, unrestricted for admins |

### `api-functions.php` — Shared Helpers

| Function | Description |
|---|---|
| `returnData($data)` | Returns JSON if AJAX, otherwise returns value for PHP use |
| `returnJsonOnly($data)` | Returns JSON only if AJAX; does nothing otherwise |
| `fetchData($query, $params, $singleColumn, $singleResult)` | Prepared SELECT; supports full row array, single row, or single column value |
| `insertData($query, $params)` | Prepared INSERT; returns `insert_id` |
| `updateData($query, $params)` | Prepared UPDATE; returns bool |
| `deleteData($query, $params)` | Prepared DELETE; returns bool or null |
| `moveFile($validatedFile, $destinationPath, $userId)` | Moves an uploaded file to destination with a `{userId}_{uniqid}.ext` filename |
| `restrictAccess()` | Blocks non-logged-in access |
| `restrictAdminAccess()` | Blocks non-admin access |

---

## PHP Block Scripts

In `scripts/php/blocks/`. Handle form submissions and data rendering, included from page files.

| File | Purpose |
|---|---|
| `validator.php` | `Validator` class (see below) |
| `add-property-exp.php` | Processes property creation POST: validates all fields, DB transaction (INSERT property + images + set main_image_id), rollback on failure |
| `add-listing.php` | Processes listing creation POST: validates type (rent/sale), prevents duplicates, INSERTs into `listings` + `for_rent`/`for_sale` |
| `search-results.php` | Builds dynamic search query from GET params (`property-type`, `offer-type`, `district`); returns `{empty, listings}` |
| `property-page.php` | `displayProperty()` — full property+listing+user JOIN query; also handles AJAX request for image gallery |

### `dashboard/` blocks

| File | Purpose |
|---|---|
| `display-listings.php` | Returns user's listings (or all for admin) as `{empty, listings}` JSON |
| `display-properties.php` | Returns user's properties (or all for admin) as `{empty, properties}` JSON |
| `display-users.php` | Admin only — returns all users as JSON |
| `profile-and-settings.php` | Handles `general-information` (name, profile picture) and `login-and-security` (email, password) form submissions |
| `delete-account.php` | Deletes the current user's account after password confirmation |
| `logout.php` | Destroys session and clears cookie |

### `Validator` class

| Method | Description |
|---|---|
| `validateString($field, $value, $min, $max, $required)` | Trims, length-checks, returns `htmlspecialchars`-sanitized value |
| `validateNumeric($field, $value, $min, $max, $required)` | Checks `is_numeric`, casts to int, range-checks |
| `validateEmail($field, $value, ...)` | Length + `FILTER_VALIDATE_EMAIL`, returns sanitized value |
| `validateSelection($field, $value, $allowedValues, $required)` | Whitelist check against provided array |
| `validateFiles($field, $filesArray, $minFiles, $maxFiles, $allowedTypes, $maxSize)` | Multi-file upload validation (count, MIME type, size) |
| `validateFile($field, $file, $allowedTypes, $maxSize)` | Single file upload validation |
| `validateMainImage($field, $validatedImages, $mainImageIndex)` | Verifies main image index is within uploaded images |
| `hasErrors()` / `getErrors()` / `clearErrors()` | Error state management |

---

## JavaScript Modules

### `functions/user-data.js`

| Export | Description |
|---|---|
| `displayLoggedInUserData()` | Fetches `/fetch-user-data.php`, populates all `[data-logged-in-user-*]` elements (name, id, role, email, profile picture), toggles auth-gated content |

### `api-requests/fetch-listings.js`

Attaches click handlers to `.variant-pills__button` elements; fetches listings by variant from `/fetch-listings.php?variant=`; caches results; renders property cards into `.slider__list`. Auto-clicks first button on load.

### `api-requests/fetch-districts.js`

`addDistricts()` — fetches districts and populates a `<select>` or list.  
`footerDistricts()` — populates footer district links.

### `blocks/sign-in-popup.js`

Handles sign-in/sign-up modal: toggles fields, disables hidden inputs, submits to `/sign-in.php` via AJAX POST, on success calls `displayLoggedInUserData()`.

### `blocks/dashboard-tabs.js`

Fetches tab HTML from `/fetch-dashboard-tabs.php?tab=`, injects into `.dashboard__main`, caches responses, then calls `displayProperties()`/`displayListings()`/`displayUsers()` as needed.

### `blocks/dashboard/listings.js`

`displayListings()` — fetches from `display-listings.php`, renders listing cards with activate/deactivate/delete buttons.  
`handleAction()` (internal) — POSTs to `handle-action.php`; reloads page on success.

### `blocks/dashboard/properties.js` / `users.js`

Same pattern as `listings.js` — fetch, render, wire action buttons.

### `blocks/search-results.js`

Fetches and renders filtered listings from `search-results.php` using form query params; imports `addDistricts` to populate district dropdown.

### `blocks/add-listing.js`

Fetches user's active properties, populates property `<select>`, shows a preview card for selected property, toggles rent vs sale form fields on type change.

### `blocks/add-property.js`

Image upload preview and main-image selection UI for the add-property form.

### `blocks/chats-popup.js`

Initializes chat input placeholder (via CSS custom property) and auto-scrolls message list on chat open.

### `blocks/gallery.js`

Property image gallery — thumbnail click swaps main image.

### `blocks/slider.js`

Generic horizontal slider with prev/next navigation for home-page sections.

### `blocks/variant-pills.js`

Active-state toggling for `.variant-pills__button` elements.

### `blocks/property-page.js`

Fetches property image gallery via AJAX and initializes the gallery component.

### `js-scripts.php` (script loader)

Included in the footer. Outputs shared `<script>` tags and conditionally `require_once`s the page-specific script file based on `$_SERVER['PHP_SELF']`.

---

## Pages

All pages include `header.php` (which starts the session) and `footer.php`.

| File | Description |
|---|---|
| `home.php` | Landing page: hero search, listing variant sliders, district links |
| `search-results.php` | Filterable property grid (type, offer type, district) |
| `property-page.php?id=` | Full property detail: images, specs, agent info, message/support forms |
| `add-property.php` | Form to create a new property with image upload |
| `add-listing.php` | Form to attach a for-sale or for-rent listing to an existing property |
| `dashboard.php` | Single-page dashboard with dynamically loaded tabs |
| `dashboard/listings.php` | User's listings — activate/deactivate/delete |
| `dashboard/properties.php` | User's properties |
| `dashboard/liked-listings.php` | User's favorited properties |
| `dashboard/profile-and-settings.php` | Name, profile picture, email, password settings |
| `dashboard/logout.php` | Session destroy + redirect |
| `dashboard/delete-account.php` | Account deletion with password confirmation |
| `dashboard/admin/manage-listings.php` | Admin listing management |
| `dashboard/admin/manage-properties.php` | Admin property management |
| `dashboard/admin/manage-users.php` | Admin user management |

---

## Shared Blocks (HTML/PHP partials)

In `blocks/`. Included via `require_once` into page files.

| File | Description |
|---|---|
| `header.php` | `<!DOCTYPE html>` + `<head>` + site header nav. Starts session, imports `user-data.js`, links stylesheet. Toggles Sign In / Your Account based on auth state. |
| `footer.php` | Footer with district links, nav links, copyright. |
| `sign-in-popup.php` | `<dialog id="signInPopup">` with log-in / sign-up tabs and shared form. |
| `chats-popup.php` | `<dialog>` with conversations list + chat view + write-message input. |
| `support-tickets-popup.php` | `<dialog>` for submitting support tickets. |
| `write-message.php` | Reusable message input partial. |
| `search-filters.php` | Filter sidebar for search results (property type, offer type, district). |

---

## Styling (SCSS)

Entry point: `styles/styles.scss` — imports all partials in order. Compiled to `styles.css` and `styles.min.css`.

### Base partials

| File | Description |
|---|---|
| `_variables.scss` | CSS custom properties: color palette, border-radius, shadow, font, container widths, button/input heights, transition duration |
| `_globals.scss` | Base element styles |
| `_normalize.scss` | CSS reset |
| `_fonts.scss` | `@font-face` for Inter |
| `_mixins.scss` | SCSS mixins (e.g., `mobile` breakpoint) |
| `_utils.scss` | Utility classes (visually-hidden, container, display-none, etc.) |
| `_media.scss` | Breakpoint definitions |

### Key component partials (`blocks/`)

| File | Component |
|---|---|
| `_property-card.scss` | Listing card (sliders, search results) |
| `_listing.scss` | Dashboard listing row |
| `_popup.scss` | `<dialog>` modal |
| `_sign-in.scss` | Sign-in/sign-up form |
| `_dashboard.scss` | Dashboard layout and tabs |
| `_listing-form.scss` | Add listing / add property form |
| `_search-filters.scss` | Filter sidebar |
| `_chats.scss` / `_chat.scss` / `_message.scss` | Messaging UI |
| `_header.scss` / `_footer.scss` | Site header and footer |
| `_slider.scss` | Horizontal listing slider |
| `_gallery.scss` | Property image gallery |
| `_field.scss` | Form input field wrapper |

---

## Key Data Flows

### Sign Up / Log In

```
User fills form (sign-in-popup.php)
  → JS sendForm() → POST /sign-in.php {action, email, password, ...}
    → Validator validates inputs
    → log-in: verify bcrypt password → createSession()
    → sign-up: check email uniqueness → insertData() → createSession()
      → createSession(): set $_SESSION + createSignature() → set user_token cookie
    → returnData({status: true})
  → JS handleResponse() → displayLoggedInUserData() → show user name/picture in header
```

### Property Search

```
User applies filters (search-results.php)
  → JS displayListings() → GET /search-results.php?property-type=&offer-type=&district=
    → PHP builds WHERE clauses from validated GET params
    → JOINs: properties + listings + for_sale + for_rent + property_images + districts + property_types
    → returnData({empty, listings})
  → JS renders property cards into .search-results__grid
```

### Add Property

```
User fills add-property form
  → POST /add-property-exp.php (standard form submit, not AJAX)
    → Validator validates all fields
    → getId() maps type/status/district names → IDs
    → DB transaction:
        INSERT INTO properties
        foreach image: move_uploaded_file() + INSERT INTO property_images
        UPDATE properties SET main_image_id = ?
    → On success: JS redirect to dashboard.php
```

### Add Listing

```
User selects property, fills listing form (add-listing.php)
  → On load: JS fetchProperties() → GET /add-listing.php → populates property <select>
  → User submits → POST /add-listing.php (standard form submit)
    → Validate property ownership, listing type, prices
    → Check no duplicate listing (same property + offer_type)
    → INSERT INTO listings → INSERT INTO for_rent OR for_sale
    → Redirect to property-page.php?id=
```

### Dashboard Tab Loading

```
User clicks a dashboard tab
  → JS dashboard-tabs.js → GET /fetch-dashboard-tabs.php?tab={tabName}
    → PHP: ob_start() → require_once tab PHP file → ob_get_clean()
    → Returns {content: "...html..."}
  → JS injects content into .dashboard__main
  → Calls displayProperties() / displayListings() / displayUsers() as needed
    → Each fetches its own data endpoint and renders item cards with action buttons
```

### Handle Action (activate / deactivate / delete)

```
User clicks action button in dashboard
  → JS handleAction() → POST /handle-action.php {action, target-type, target-id}
    → restrictAccess() check
    → Validate element type and action via whitelist
    → role=user: queries include AND user_id = ? (ownership enforced)
    → role=admin: no ownership restriction
    → Executes UPDATE (status_id) or DELETE
    → returnData({success, message})
  → JS reloads page on success
```

### Session Persistence (cookie)

```
Every page load: header.php calls displayLoggedInUserData() (JS)
  → GET /fetch-user-data.php
    → If $_SESSION['logged_in']: return session data directly
    → Elif user_token cookie exists:
        parse userId + HMAC
        checkSignature(userId) — recompute HMAC, compare
        If valid: SELECT user FROM DB → rebuild $_SESSION
        return {logged_in: true, user: {...}}
    → Else: return {logged_in: false}
```
