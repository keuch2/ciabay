# Ciabay CMS — Copilot Instructions

This is a Laravel 13 CMS and e-commerce platform for **Ciabay S.A.**, a Paraguayan agricultural machinery dealer (Case IH). The site is Spanish-language, server-rendered with Blade templates, Alpine.js for interactivity, and Tailwind CSS for styling. No SPA framework.

## Quick Start

```bash
# Setup
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm run build

# Dev server
php artisan serve --port=8082

# Credentials
# admin@ciabay.com.py / password
```

## Code Standards

- Use Blade templates for all views. No React/Vue.
- Alpine.js (`x-data`, `x-model`, etc.) for client-side interactivity.
- Tailwind CSS utility classes for styling. No custom CSS framework.
- Spanish for all user-facing strings (labels, messages, seeders).
- English for code (variable names, method names, comments when needed).
- Follow existing patterns — check similar files before creating new ones.
- Keep comments minimal; prefer self-documenting code.

## Repository Structure

```
app/
├── Http/Controllers/
│   ├── Admin/           # 12 admin controllers (CRUD for all modules)
│   │   ├── PageController.php      # Pages + block CRUD + reorder (AJAX)
│   │   ├── BlogPostController.php
│   │   ├── BranchController.php
│   │   ├── BrandController.php
│   │   ├── ProductController.php
│   │   ├── OrderController.php
│   │   ├── ContactSubmissionController.php
│   │   ├── MediaController.php
│   │   ├── NavigationController.php
│   │   ├── SettingsController.php
│   │   ├── UserController.php
│   │   └── DashboardController.php
│   ├── PublicSite/      # 5 public controllers
│   │   ├── HomeController.php
│   │   ├── PageController.php      # Dynamic slug catch-all
│   │   ├── ContactController.php
│   │   ├── BlogController.php
│   │   └── StoreController.php
│   └── Auth/            # Laravel Breeze controllers (redirects to /admin)
├── Models/              # 15 Eloquent models
│   ├── Page.php, Block.php         # Block-based page system
│   ├── Navigation.php, NavigationItem.php
│   ├── Branch.php, Brand.php
│   ├── BlogCategory.php, BlogPost.php
│   ├── Product.php, ProductCategory.php, Order.php
│   ├── ContactSubmission.php
│   ├── Setting.php                 # Key-value site config
│   ├── SeoMeta.php                 # Polymorphic SEO
│   └── User.php
├── Services/
│   └── BlockRenderer.php           # Resolves block type → Blade partial
resources/views/
├── layouts/
│   ├── public.blade.php            # Full public layout (SEO, nav from DB, WhatsApp float)
│   └── admin.blade.php             # Admin layout (sidebar, Tailwind)
├── blocks/                         # 17 public block templates
│   ├── hero-carousel.blade.php
│   ├── hero-overlay.blade.php
│   ├── text-intro.blade.php
│   ├── rich-text.blade.php
│   ├── image-text.blade.php
│   ├── stats-grid.blade.php
│   ├── unidades-negocio.blade.php
│   ├── features-grid.blade.php
│   ├── brands-grid.blade.php
│   ├── cta-section.blade.php
│   ├── quote.blade.php
│   ├── pillars.blade.php
│   ├── timeline.blade.php
│   ├── testimonials.blade.php
│   ├── branches-map.blade.php
│   ├── contact-form.blade.php
│   └── gallery.blade.php
├── admin/
│   ├── blocks/forms/               # 17 visual block editor forms (Alpine.js)
│   ├── pages/, branches/, brands/, products/, orders/, contacts/
│   ├── blog/posts/, settings/, users/, media/, navigation/
│   └── dashboard.blade.php
├── public/                         # Public-facing views
│   ├── home.blade.php, page.blade.php, contact.blade.php
│   ├── blog/index.blade.php, blog/show.blade.php
│   └── store/index.blade.php
database/
├── migrations/                     # 19 migrations
├── seeders/                        # 10 seeders (Roles, Admin, Settings, Navigation,
│                                   #   Branches, Brands, SamplePages, Blog, Products)
public/assets/                      # Static assets copied from original PHP site
├── css/normalize.css, css/styles.css
├── js/main.js, js/contact-form.js
└── images/                         # All site images
```

## Key Architecture Patterns

### Block-Based Page System
Pages are composed of ordered content blocks stored in the `blocks` table. `BlockRenderer::render()` resolves a block type string (e.g. `hero-carousel`) to a Blade partial at `resources/views/blocks/{type}.blade.php`. Block data is stored as JSON in the `data` column.

**To add a new block type:**
1. Create `resources/views/blocks/{type}.blade.php` (public render template)
2. Create `resources/views/admin/blocks/forms/{type}.blade.php` (admin visual form)
3. Add the type key + label to `PageController::getBlockTypes()` in `app/Http/Controllers/Admin/PageController.php`

### Visual Block Editor
The admin page editor (`admin/pages/edit.blade.php`) uses Alpine.js-powered form partials per block type. Each form partial serializes its data to a hidden input `block_data_{blockId}`. The `saveBlock()` JS function reads from this hidden input (or falls back to raw JSON textarea for types without a form partial) and PUTs to `/admin/pages/{page}/blocks/{block}`.

### E-Commerce Flow
Products → Orders → WhatsApp redirect. `POST /tienda-online/pedido` creates an `Order` and returns a WhatsApp URL. No payment gateway.

### Settings System
`Setting` model is a key-value store. Managed at `/admin/settings`. Used for WhatsApp number, site branding, Google Analytics ID, etc.

### Routing
- `routes/web.php` loads auth routes **before** the `/{slug}` catch-all.
- **New public routes must be registered before the catch-all** or they will 404.
- Admin routes are grouped under `/admin` prefix with `auth` middleware.

### AJAX Block Endpoints
```
POST   /admin/pages/{page}/blocks           — Create block
PUT    /admin/pages/{page}/blocks/{block}    — Update block data
DELETE /admin/pages/{page}/blocks/{block}    — Delete block
POST   /admin/pages/{page}/blocks/reorder   — Reorder blocks (drag & drop)
```

### Polymorphic SEO
`SeoMeta` attaches to both `Page` and `BlogPost` via morph relationship.

## Key Packages

- **spatie/laravel-permission** — Role-based access (admin roles + permissions)
- **spatie/laravel-medialibrary** — File/media management
- **Laravel Breeze** — Auth scaffold (login redirects to `/admin`)
- **SortableJS** (CDN) — Drag & drop block reorder in admin
- **Alpine.js** (CDN) — Client-side interactivity for block forms, navigation editor

## Database

- MySQL database: `ciabay_laravel`
- Queue driver: `database`
- 19 migrations, 15 models, 10 seeders

## Design System

```css
--color-primary: #003d82    /* Azul principal Ciabay */
--color-secondary: #e8e8e8  /* Gris claro */
--color-accent: #d32f2f     /* Rojo Case IH */
--color-text: #333333
```

- **Font**: Montserrat (Google Fonts) — weights 300–700
- **Admin UI**: Tailwind CSS utility classes, rounded-xl cards, blue-600 accents
- **Public site**: Custom CSS from original site (`public/assets/css/styles.css`)

## Known Gotchas

1. **Blade `@` in JSON-LD**: Use `@@context`, `@@type` etc. inside `<script type="application/ld+json">` to prevent Blade directive interpretation.
2. **Blog posts**: Column is `author_id` (not `user_id`) — foreign key to `users` table.
3. **Brands**: Column is `website_url` (not `website`).
4. **Block::TYPES**: Does not exist as a constant — use `PageController::getBlockTypes()`.
5. **Assets**: Static CSS/JS/images live in `public/assets/` (not Vite-managed). The original site's styles are preserved there.
