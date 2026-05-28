# AGENTS.md

## Project

Laravel 13 app ("Stitch 360 / CendolBata"), a culture performance platform. Currently fresh Laravel install + `/mockup` design prototypes — most app code has not been built yet.

## Repo layout

| Path | Purpose |
|---|---|
| `app/` | Laravel app (Models, Http/Controllers, Providers) |
| `mockup/` | HTML/CSS/JS design prototypes — **check before building any feature** |
| `.agents/` | PRD (`prd.md`), design system (`design.md`), task instructions (`task-instruction.md`) |
| `resources/views/` | Blade templates |
| `tests/` | PHPUnit tests (Unit + Feature) |

## Key conventions (must follow)

- **Language:** Indonesian for database table/field names and documentation (`GEMINI.md` line 41)
- **Color semantics:** Success (green `#198754`) = Cendol (appreciation), Danger (red `#dc3545`) = Bata (incident reporting) (`.agents/design.md`)
- **Data access:** Repository Pattern — JSON files in `storage/app/data/` for prototyping, Eloquent/MySQL for production (swapped via `AppServiceProvider`)
- **Design:** Bootstrap 5.3 (npm import via `resources/css/app.css` + `resources/js/app.js`) with custom `.stat-card`, `.feed-card`, `.btn-action`, `.icon-box` classes (see `.agents/design.md`)
- **Auth:** Laravel Breeze (Blade stack) — login via username atau email
- **Style:** Laravel Pint for PHP, EditorConfig (4-space indent, LF line endings)

## Commands

| Command | What it does |
|---|---|
| `composer setup` | Full first-time setup (install deps, .env, key, migrate, npm install, build) |
| `composer dev` | Run all dev servers (artisan serve, queue, logs, Vite) via concurrently |
| `composer test` | Config clear + `php artisan test` (PHPUnit) |
| `npm run build` / `npm run dev` | Vite build / dev server |
| `php artisan test --filter=Tests\Unit\ExampleTest` | Single test class |
| `php artisan test --filter=test_the_application_returns_a_successful_response` | Single test method |

## Testing

- In-memory SQLite (`:memory:`) — no external DB needed
- Standard Laravel `phpunit.xml` with Unit + Feature suites
- Run focused: `php artisan test --filter={testName}`

## Before building a feature

1. Read `.agents/prd.md` (product requirements)
2. Read `.agents/design.md` (design system — colors, spacing, components)
3. Open matching HTML file in `mockup/` as visual reference
4. Create migration (Indonesian table names), Model with Repository, Controller, Blade view
5. For prototyping, store data in `storage/app/data/*.json` — switch to DB later via Repository
