# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with this repository.

## Project Overview

**Ciabay CMS** — A Laravel 13 CMS and e-commerce platform for Ciabay S.A., a Paraguayan agricultural machinery dealer (Case IH concesionario). Spanish-language, server-rendered with Blade + Alpine.js + Tailwind CSS. Migrated from a static PHP/HTML site at `/opt/homebrew/var/www/ciabayweb/`.

## Commands

```bash
# Full setup from scratch
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm run build

# Dev server (port 8082) — local URL: http://localhost:8082/
# When served under Apache at http://localhost/ciabay-laravel/public/, set APP_URL accordingly
php artisan serve --port=8082

# Frontend dev
npm run dev       # Vite dev server with HMR
npm run build     # Production build

# Tests
php artisan test
php artisan test tests/Feature/ExampleTest.php

# Database reset with sample data (includes catalog seed for Case IH)
php artisan migrate:fresh --seed

# Queue worker
php artisan queue:listen --tries=1 --timeout=0

# Clear caches
php artisan optimize:clear
```

## Credentials

- **Admin**: `admin@ciabay.com.py` / `password` (seeded via `AdminUserSeeder`)
- **Secondary admin (local)**: `keuch2@gmail.com` / `password`
- **DB (local)**: MySQL `ciabay_laravel`, user `root`, no password
- **Dev URL**: `http://localhost:8082` (artisan serve) **or** `http://localhost/ciabay-laravel/public/` (Apache)
- **Production credentials**: stored in `.deploy/credentials.env` (gitignored). See "Deployment" section below.

## Architecture

Server-rendered Laravel CMS. No SPA framework — Blade templates with Alpine.js for interactivity and Tailwind CSS for admin styling. Public site uses the legacy static-site stylesheet at `public/assets/css/styles.css`.

### Key Packages
- **spatie/laravel-permission** — Role-based access control (super-admin / admin / editor / store-manager)
- **spatie/laravel-medialibrary** — File/media management (used by `MediaController` for the library picker)
- **Laravel Breeze** — Authentication scaffold (login redirects to `/admin`)
- **SortableJS** (CDN) — Drag & drop for blocks and nav items
- **Alpine.js** (CDN) — Client-side interactivity on both admin and public sites

### Models (17)
`User`, `Page`, `Block`, `Navigation`, `NavigationItem`, `Branch`, `Brand`, `ContactSubmission`, `BlogCategory`, `BlogPost`, `Product`, `ProductCategory`, `Order`, `Setting`, `SeoMeta`, `CatalogCategory`, `CatalogProduct`

`User` has an `isStaff()` helper used across public controllers to decide whether to serve drafts/inactive content.

### Controllers
- **Admin** (19): `DashboardController`, `PageController` (with block CRUD+reorder), `BlogPostController`, `BranchController`, `BrandController`, `BrandCatalogController` (dashboard), `CatalogCategoryController`, `CatalogProductController`, `ProductController`, `ProductCategoryController`, `OrderController`, `ContactSubmissionController`, `MediaController`, `NavigationController`, `SettingsController`, `ThemeController`, `UserController`
- **Public** (6): `HomeController`, `PageController` (slug catch-all), `ContactController`, `BlogController`, `StoreController`, `BrandCatalogController`

### Seeders (11)
`RolesAndPermissionsSeeder`, `AdminUserSeeder`, `SettingsSeeder`, `NavigationSeeder`, `BranchSeeder` (8 sucursales), `BrandSeeder` (6 marcas), `SamplePagesSeeder` (10 pages composed from blocks), `BlogSeeder` (3 categories + 3 posts), `ProductSeeder` (Red Case IH Tienda merchandise), `CatalogSeeder` (example Case IH brand catalog), plus `DatabaseSeeder` orchestrator.

### Block-Based Page System
Pages are composed of ordered content blocks stored in the `blocks` table with JSON `data` column. `app/Services/BlockRenderer.php` resolves block type to a Blade partial at `resources/views/blocks/`. The block set matches the original static-site design; every public page (except the Tienda and catalog pages, which have dedicated controllers) renders through `public/page.blade.php` → `BlockRenderer::renderAll($page->blocks)`.

**Block types (32)** — listed in `PageController::getBlockTypes()`:
- Hero: `hero-carousel`, `hero-overlay`, `page-hero` (variants: default/impl/insumos/mvv/historia)
- Content: `text-intro`, `intro-banner`, `rich-text`, `narrative-paragraphs`, `image-text` (with `impl-repuestos` variant)
- Grids: `stats-grid`, `unidades-negocio`, `features-grid` (with `insumos-valor` variant), `brands-grid`, `brand-showcase`, `logo-grid` (variants: specialized/marcas), `category-grid`, `category-feature`, `value-grid` (variants: historia/mvv), `pillars` (variants: default/mvv-pillars/direccionadores)
- Callouts / CTA: `cta-section`, `callout-card`, `cross-sell`, `quote`
- Other: `timeline` (with `historia` variant), `testimonials`, `branches-cards`, `branches-map`, `map-embed`, `contact-info`, `contact-form`, `gallery`, `agriculture-title`, `agriculture-image`
- Tienda Online: `redcase-hero`, `redcase-products`, `redcase-cta`

**`BlockRenderer::OUTSIDE_MAIN`** — these block types render outside the `<main class="main-content">` wrapper so their background bleeds edge-to-edge: `hero-carousel`, `hero-overlay`, `page-hero`, `redcase-hero`, `agriculture-title`, `agriculture-image`.

**To add a new block type:**
1. Create `resources/views/blocks/{type}.blade.php` (public render)
2. Create `resources/views/admin/blocks/forms/{type}.blade.php` (admin form, Alpine-based with hidden JSON input named `block_data_{id}`)
3. Add key + label to `PageController::getBlockTypes()` in `app/Http/Controllers/Admin/PageController.php`
4. If the block must render flush/edge-to-edge, add it to `OUTSIDE_MAIN` in `BlockRenderer`

### Visual Block Editor
Admin page editor at `/admin/pages/{page}/edit` uses Alpine.js form partials per block type. Each form serializes to a hidden input `block_data_{blockId}`. The `saveBlock()` JS reads from that hidden input (or falls back to a raw JSON textarea when no form partial exists). Endpoints:
- `POST /admin/pages/{page}/blocks` — Create
- `PUT /admin/pages/{page}/blocks/{block}` — Update data
- `DELETE /admin/pages/{page}/blocks/{block}` — Delete
- `POST /admin/pages/{page}/blocks/reorder` — Reorder

**Important**: the block editor JS generates endpoint URLs via Laravel's `route()` / `url()` helpers at render time. **Never hardcode absolute paths** like `/admin/...` in JS — they break when the app is served under a path prefix (e.g. `/ciabay-laravel/public/`).

### E-Commerce Flow (Tienda Online)
`Product` → `Order` → WhatsApp redirect. `POST /tienda-online/pedido` creates an `Order`, returns a WhatsApp URL. No payment gateway.
- Public list: `/tienda-online` (renders through a page with blocks: `redcase-hero`, `redcase-products`, `redcase-cta`)
- Public detail: `/tienda-online/{slug}` (`public/store/show.blade.php`, dark theme, Alpine gallery)
- Admin CRUD: `/admin/products` (with `ProductCategoryController` for categories under `/admin/product-categories`)

### Brand Catalogs module
**Completely separate from the Tienda Online** — own tables, models, controllers, views, routes. No coupling.
- Models: `CatalogCategory`, `CatalogProduct` (brand-scoped via `brand_id` with unique `(brand_id, slug)`)
- Brand extensions: `catalog_enabled`, `catalog_hero_image`, `catalog_intro`, `catalog_contact_whatsapp`, `catalog_contact_message`
- Public URLs (registered BEFORE catch-all `/{slug}`):
  - `/catalogo/{brandSlug}` — hero + category submenu + product grid (dark theme)
  - `/catalogo/{brandSlug}/{productSlug}` — product detail with gallery + "Contactar a un vendedor" button (when `contact_enabled`)
- Admin entry: `/admin/brands/{brand}/catalog` dashboard with two inline CRUDs:
  - Categories: `/admin/brands/{brand}/catalog/categories/*`
  - Products: `/admin/brands/{brand}/catalog/products/*` (with main image + gallery + library picker)
- WhatsApp placeholders supported in `catalog_contact_message`: `{producto}`, `{url}`, `{marca}`
- `CatalogSeeder` creates an example Case IH catalog on fresh installs (4 categories, 8 products)

### Draft / Staff Preview
Authenticated admins (detected via `User::isStaff()`) bypass the `published()` / `active()` filters on public show controllers (`PageController`, `BlogController`, `StoreController`, `BrandCatalogController`, `HomeController`, `ContactController`, and the `redcase-products` block). An orange "VISTA PREVIA" banner renders in `layouts/public.blade.php` whenever the controller passes `$isDraft = true`. Admin edit pages (for Pages, Products, Blog Posts, Catalog Products) expose a "Vista previa en nueva pestaña" button that opens the corresponding public URL with staff bypass active.

### Media library + library picker
- `/admin/media` lists files from **both** `storage/app/public/` (user uploads) and `public/assets/images/` (seeded assets, read-only). Tabs + search + origin badges.
- `MediaController::browse()` returns the same list as JSON (endpoint `/admin/media/browse`).
- `resources/views/admin/partials/media-picker.blade.php` is a global Alpine modal included in the admin layout. Any admin form can trigger it via `$dispatch('open-media-picker', { onSelect: (path) => {...} })`.
- `resources/views/admin/blocks/partials/image-upload.blade.php` is the shared widget used inside every block form (and inside Alpine repeaters). It has three buttons: **Subir imagen** (file input), **Elegir de biblioteca** (opens picker modal), **Quitar**.
- Individual CRUDs (Products, Branches, Brand catalog fields) accept an optional `library_image` text field which is used when no new file is uploaded. Old uploaded files are deleted from `storage/` when replaced (but files under `assets/` are preserved).

### Theme (colors + typography)
`/admin/theme` — editable color pickers and font selectors that write to the `settings` table under the `theme` group. `ThemeController::cssVariables()` emits CSS custom properties in the public layout's `<head>` (`<style id="theme-overrides">`), and `ThemeController::fontImports()` injects `<link>` tags for the Google Fonts URLs defined there. The base CSS in `public/assets/css/styles.css` references `var(--color-primary)`, `var(--color-accent)`, etc. — those are overridden by theme overrides.

### Settings System
`Setting` model = key-value store for site config (WhatsApp number, branding, analytics, theme colors/fonts). Managed at `/admin/settings`. Values with `type = 'image'` (site_logo, site_logo_white, site_favicon) show an upload widget + path textarea in the form. The public layout reads `Setting::get('site_logo')` and `Setting::get('site_favicon')` for branding.

### Routing
`routes/web.php`:
- Public specific routes first (home, contacto, blog, tienda-online, catalogo)
- Admin routes under `/admin` middleware group
- **Catch-all `/{slug}` MUST be the last route** — dispatches to `PageController@show`
- **New public routes must be registered BEFORE the catch-all** or they will 404

### Navigation
`NavigationItem::getResolvedUrlAttribute()` resolves internal slugs via `url()` helper so navigation works under path-prefixed deploys. The admin at `/admin/navigation/{id}/edit` supports drag-to-reorder of top-level items AND sub-items via SortableJS; JS endpoints generated server-side via `route()` helpers (never hardcoded absolute paths).

### Queue
Uses `database` driver. Run `php artisan queue:table` and migrate if adding queued jobs.

### Polymorphic SEO
`SeoMeta` attaches to both `Page` and `BlogPost` via morph relationship.

## Design System

```css
--color-primary: #112f83   /* Azul Ciabay (theme-overridable) */
--color-secondary: #e8e8e8 /* Gris claro */
--color-accent: #6da339    /* Verde Case IH */
--color-text: #333333
--color-cta: #d32f2f       /* Rojo para CTAs destacados */
```

- **Font**: Montserrat (Google Fonts, weights 300–700) by default; editable via `/admin/theme`
- **Admin UI**: Tailwind CSS, rounded-xl cards, blue-600 accents, dark sidebar. Alpine.js + SortableJS from CDN.
- **Public site**: custom CSS from original static site at `public/assets/css/styles.css`. Do NOT rebuild Tailwind to re-theme the public site — use CSS variables via the Theme settings.
- Static assets (CSS/JS/images) in `public/assets/` — not managed by Vite.

## Known Gotchas

1. **Path-prefixed deploys** — When served under Apache at `http://localhost/ciabay-laravel/public/`, any JS code that hardcodes `/admin/...` paths will break. Always use `route()` or `url()` helpers at render time and pass the URL into JS. Same applies to absolute href/src in Blade templates.
2. **Alpine required on public layout** — The public `<head>` loads Alpine via CDN because the product gallery (`public/store/show.blade.php`), the brand-catalog gallery, the WhatsApp order modal, and some hero blocks rely on `x-data` / `x-show`. Without Alpine, all images stack or all modal states become visible.
3. **Tailwind JIT build is stale** — `public/build/assets/app-*.css` was generated before many admin feature classes existed (`bg-gray-700`, etc.). Until someone runs `npm run build`, new admin UIs should use inline styles for the classes that are definitely absent from the compiled CSS, or keep to classes already present.
4. **Blade `@` in JSON-LD** — Use `@@context`, `@@type` inside `<script type="application/ld+json">` to escape Blade.
5. **Blog posts** — Column is `author_id` (not `user_id`) — FK to `users`.
6. **Brands** — Column is `website_url` (not `website`).
7. **Block types** — No `Block::TYPES` constant — use `PageController::getBlockTypes()`.
8. **Static assets** — `public/assets/` holds original site CSS/JS/images. Vite only manages `resources/css` and `resources/js`.
9. **JS variable `top` is reserved** — Don't declare `const top = ...` at script top-level; it collides with `window.top` and breaks the script. Use e.g. `topList`.
10. **Laravel uses `storage/app/public/...` for uploads** — `asset('storage/...')` produces the right public URL. Legacy seeded assets live at `public/assets/images/...` and are served directly. The helper `$resolveImg` pattern found in many views handles both cases plus external URLs.
11. **Catch-all and Tienda/Catálogo** — `/tienda-online` is resolved by the catch-all (renders a block-based page), but `/tienda-online/{slug}` and `/catalogo/{slug}` and `/catalogo/{slug}/{product}` have dedicated routes registered earlier in `routes/web.php`.

## Deployment

Production server: `ssh -p5221 root@200.58.105.211` (domain `ciabay.com`). Credentials are in `.deploy/credentials.env` which is **gitignored**.

- `deploy.sh` — runs on the server: `git pull`, `composer install --no-dev`, `php artisan migrate --force`, `storage:link`, `config:cache`, `route:cache`, `view:cache`.
- `.deploy/credentials.env` — production DB + SSH credentials. Never commit.
- GitHub origin: `https://github.com/keuch2/ciabay.git`
