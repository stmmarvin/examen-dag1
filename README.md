# Examen Dag 1

Laravel 13 project.

## Requirements

- PHP 8.4 or newer
- Composer
- Node.js and npm
- MySQL or MariaDB

## Setup

Run these commands after cloning the repository:

```bash
composer run setup
```

This installs PHP dependencies, creates `.env`, generates `APP_KEY`, creates the MySQL database from the `.env` settings when it does not exist yet, runs migrations, installs npm dependencies, and builds Vite assets.

The default database settings are:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=examen_dag1
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL username or password is different, update `.env` before running migrations.

Manual setup:

```bash
composer install
cp .env.example .env
php artisan key:generate
php scripts/create_mysql_database.php
php artisan migrate
npm install
npm run build
```

Start the app:

```bash
php artisan serve
```
