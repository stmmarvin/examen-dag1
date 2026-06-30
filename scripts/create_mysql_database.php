<?php

$envPath = dirname(__DIR__).'/.env';

if (! file_exists($envPath)) {
    fwrite(STDERR, "No .env file found. Copy .env.example to .env first.\n");
    exit(1);
}

$env = [];

foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
        continue;
    }

    [$key, $value] = explode('=', $line, 2);
    $env[trim($key)] = trim(trim($value), "\"'");
}

$connection = $env['DB_CONNECTION'] ?? 'mysql';

if (! in_array($connection, ['mysql', 'mariadb'], true)) {
    exit(0);
}

$database = $env['DB_DATABASE'] ?? '';

if ($database === '') {
    fwrite(STDERR, "DB_DATABASE is empty in .env.\n");
    exit(1);
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';
$charset = $env['DB_CHARSET'] ?? 'utf8mb4';
$collation = $env['DB_COLLATION'] ?? 'utf8mb4_unicode_ci';
$quotedDatabase = '`'.str_replace('`', '``', $database).'`';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset={$charset}", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$quotedDatabase} CHARACTER SET {$charset} COLLATE {$collation}");
    echo "Database {$database} is ready.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, "Could not create MySQL database '{$database}': {$exception->getMessage()}\n");
    fwrite(STDERR, "Check DB_HOST, DB_PORT, DB_USERNAME and DB_PASSWORD in .env, then run php artisan migrate again.\n");
    exit(1);
}
