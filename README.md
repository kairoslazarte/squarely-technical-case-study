# Task & Request Management Module

Built with Laravel 11 (API) + Vue 3 (frontend).

---

## Stack

- **Backend** — Laravel 11, Sanctum (token auth), SQLite
- **Frontend** — Vue 3, Vite, Pinia, Vue Router, Tailwind CSS

---

## Requirements

- PHP 8.2+
- Composer
- Node 18+

---

## Setup

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan serve
```

API runs at `http://localhost:8000`.

### Frontend

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

App runs at `http://localhost:5173`.

---

## Demo accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Employee | employee@example.com | password |

---

## API endpoints

| Method | Endpoint | Auth | Notes |
|--------|----------|------|-------|
| POST | `/api/auth/login` | — | returns bearer token |
| POST | `/api/auth/register` | — | |
| GET | `/api/auth/me` | ✓ | |
| POST | `/api/auth/logout` | ✓ | |
| GET | `/api/requests` | ✓ | employees see own, admins see all |
| POST | `/api/requests` | ✓ | create request |
| PATCH | `/api/requests/{id}` | admin | update status |

---

## Assumptions & Decisions

**Authentication** — used Sanctum token auth. Simple to set up, works well for a separate frontend hitting an API. Login returns a bearer token, frontend stores it in localStorage.

**`created_by` field** — named as per the spec. The relationship on the model points to `users.id` via this column.

**Admin vs employee access** — rather than a roles table, went with a simple `is_admin` boolean on users. The requirements only have two roles so a full roles/permissions system would be overkill here.

**Integration design** — used Laravel events so the core service stays clean. When a request is created or its status changes, an event fires and any registered integration reacts to it. To add a new integration you implement `IntegrationInterface` and register it in `AppServiceProvider`. The Google and Shopify classes are stubs showing how this would work in practice.

**SQLite** — no database server needed to run this locally. Swap `DB_CONNECTION` in `.env` for MySQL/Postgres in a real environment.

**No pagination** — left it out for now, the requirements didn't call for it and adding it prematurely felt like over-engineering for this scope.
