# Examen Dag 1

Laravel 13 project.

## Requirements

- PHP 8.4 or newer
- Composer
- Node.js and npm

## Setup

Run these commands after cloning the repository:

```bash
composer run setup
```

This installs PHP dependencies, creates `.env`, generates `APP_KEY`, creates the local SQLite database file, runs migrations, installs npm dependencies, and builds Vite assets.

If you prefer to run the steps manually:

```bash
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
npm install
npm run build
```

Start the app:

```bash
php artisan serve
```

The default database is SQLite, so `php artisan migrate` works without creating a MySQL database first. To use MySQL, copy the commented MySQL settings from `.env.example` into `.env` and create the database locally.
