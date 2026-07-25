# Laravel Dashboard with Dynamic RBAC Sidebar Menu

A Laravel 13 starter with a PostgreSQL-backed, role-based sidebar menu.

## Features

- PostgreSQL schema: `mstmenu`, `user_group`, `menuaccess`, `users`.
- `MenuService` caches permitted menu codes per role and builds the sidebar tree.
- `Permission::getAccess($groupId, $menucode)` returns CRUD flags.
- `BaseController` enforces `fview` authorization and shares `$userAccess` to views.
- Responsive, collapsible sidebar (Alpine.js + Tailwind CSS 4).
- Example dashboard + CRUD pages for menus, users, and menu access.

## Demo Accounts

| Email                 | Password | Role        |
|-----------------------|----------|-------------|
| admin@example.com     | password | Administrator |
| manager@example.com   | password | Manager     |
| operator@example.com  | password | Operator    |

## Setup

1. Install PHP dependencies:
   ```bash
   composer install
   ```

2. Install Node dependencies and build assets:
   ```bash
   npm install
   npm run build
   ```

3. Copy `.env.example` to `.env` and configure PostgreSQL:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=localhost
   DB_PORT=5432
   DB_DATABASE=templateapp
   DB_USERNAME=postgres
   DB_PASSWORD=1234
   ```

4. Create the database:
   ```bash
   createdb -U postgres templateapp
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. Serve the application:
   ```bash
   php artisan serve
   ```

## Notes

- The `sessions` table migration is included because `SESSION_DRIVER=database` is configured.
- Menu changes automatically clear the role menu cache via `MenuService::clearAllMenuCache()`.
- Menu access changes clear the affected role's cache via `MenuService::clearMenuCacheByRole($roleId)`.
