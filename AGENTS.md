# Culturapp — Agent Notes

Culturapp is a Laravel 12 + Blade + Tailwind CSS web app for managing cultural houses (sedes), courses, enrollments, and news in Manizales, Colombia. Spanish-language UI throughout.

## Commands

- **Full dev stack (recommended):** `composer dev` — runs php artisan serve, queue:listen, pail (logs), and Vite concurrently
- **Setup from scratch:** `composer run setup` — installs PHP+Node deps, copies .env, generates key, migrates, builds assets
- **Tests:** `composer test` or `php artisan test` — clears config cache first
- **Single test file:** `php artisan test --filter=SedeAuthorizationTest`
- **Lint:** `./vendor/bin/pint` (Laravel Pint, configured via composer)
- **Frontend build:** `npm run build` | **Frontend dev:** `npm run dev`

## Architecture

- **Stack:** Laravel 12 (PHP 8.2+), Blade templates, Alpine.js, Tailwind CSS 3, Vite 7
- **Auth:** Laravel Breeze (Blade stack) — see `routes/auth.php`
- **DB:** MySQL in production (`.env.example` default), SQLite as fallback (`config/database.php` defaults to sqlite). Tests use in-memory SQLite (`phpunit.xml`).
- **Locale:** `APP_LOCALE=es` (Spanish). Uses `laravel-lang/common` for Spanish translations.

## Role-based access

Three roles stored in `users.role` enum: `super_admin`, `admin`, `citizen`
- **super_admin** — full access to all sedes, user management, CRUD for courses/news
- **admin** — scoped to their `sede_id`, can manage courses/news in that sede only
- **citizen** — can enroll in courses, view public content

Authorization is done via `User::canManageSede($sedeId)` in controllers, not middleware. `CheckRole` middleware exists but is not registered in routes — controllers handle auth inline.

## Key domain models & relationships

- `Sede` → hasMany `Course`, `News`
- `Course` → belongsTo `Sede`, `Category`; hasMany `Enrollment`, `Activity`; belongsToMany `User` (managers via `course_user` pivot)
- `Enrollment` → belongsTo `User` (student), `Course`; hasMany `Grade`
- `Activity` → belongsTo `Course`; hasMany `Grade`
- `User` → hasMany `Enrollment`; belongsToMany `Course` (as manager); belongsTo `Sede` (as admin)
- Enrollment statuses: `pending`, `enrolled`, `approved`, `failed`, `dropped` (added via later migration)
- Course statuses: `open`, `in_progress`, `finished`, `cancelled`
- `User.is_flagged` — flagged citizens get `pending` enrollment status instead of auto-`enrolled`

## Route conventions

- Public: `GET /sedes`, `GET /sedes/{sede}`, `GET /cursos/{course}`, `GET /noticias`
- Authenticated: `/dashboard`, `/mis-cursos/*` (teacher LMS), `/profile`
- Admin: `/admin/manage/{sede}`, `/admin/cursos` (resource), `/admin/noticias` (resource), `/admin/usuarios`
- Admin route names use Spanish: `admin.cursos.index`, `admin.noticias.store`, etc.
- Route model binding uses English parameter names (`course`, `sede`, `news`) even though URL segments and route names are Spanish (`cursos`, `sedes`, `noticias`)

## Gotchas

- **Course hours auto-calc:** `Course::booted()` hook calculates `hours` from `days` (array of ISO day-of-week integers 1-7), `start_time`, `end_time`, `start_date`, `end_date`. Don't set `hours` manually.
- **Course `days` field** is cast to `array` — stores ISO weekday numbers (1=Monday, 7=Sunday).
- **Image uploads** go to `public` disk — `php artisan storage:link` must be run for images to display.
- **Seeder creates test users** with known passwords (see `UserSeeder`): `admin@culturapp.com` / `admin123` (super_admin), `gestor_chipre@culturapp.com` / `chipre123` (admin for sede_id=6).
- **Vite entry points:** only `resources/css/app.css` and `resources/js/app.js` — configured in `vite.config.js`.
- **No CI pipeline** — no `.github/workflows` exists.
- **Tailwind custom colors** match the MZL brand palette: `mzl-blue`, `mzl-teal`, `mzl-orange`, `mzl-pink`, `mzl-yellow`. Font: Nunito.
