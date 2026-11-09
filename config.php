<?php
// Configuration File: Database connection & application settings

// Choose database driver: 'sqlite' or 'pgsql'
// 'sqlite' works instantly out of the box with zero external setup.
// To use local PostgreSQL, set DB_DRIVER to 'pgsql' and adjust connection credentials below.
define('DB_DRIVER', 'sqlite');

// PostgreSQL Settings (used when DB_DRIVER === 'pgsql')
define('PG_HOST', 'localhost');
define('PG_PORT', '5432');
define('PG_DBNAME', 'links_base');
define('PG_USER', 'postgres');
define('PG_PASS', 'postgres');

// SQLite Settings
define('SQLITE_FILE', __DIR__ . '/data/links.db');

/**
 * Returns the PDO database connection singleton.
 */
function getDB() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        if (DB_DRIVER === 'sqlite') {
            $dbDir = dirname(SQLITE_FILE);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            $pdo = new PDO('sqlite:' . SQLITE_FILE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            initSchema($pdo, 'sqlite');
        } elseif (DB_DRIVER === 'pgsql') {
            $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', PG_HOST, PG_PORT, PG_DBNAME);
            $pdo = new PDO($dsn, PG_USER, PG_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            initSchema($pdo, 'pgsql');
        } else {
            throw new Exception("Unsupported DB driver: " . DB_DRIVER);
        }
    } catch (PDOException $e) {
        die("<div style='font-family:sans-serif;padding:2rem;background:#fee;color:#c00;border:1px solid #faa;border-radius:8px;max-width:600px;margin:2rem auto;'>"
            . "<h3>Database Connection Error</h3>"
            . "<p>" . htmlspecialchars($e->getMessage()) . "</p>"
            . "<p><small>Driver: " . htmlspecialchars(DB_DRIVER) . "</small></p>"
            . "</div>");
    }

    return $pdo;
}

/**
 * Ensures required database tables exist.
 */
function initSchema(PDO $pdo, string $driver) {
    if ($driver === 'sqlite') {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS links (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                url TEXT NOT NULL,
                major_tag TEXT NOT NULL,
                minor_tag TEXT NOT NULL,
                description TEXT DEFAULT '',
                icon_url TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS tag_meta (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                major_tag TEXT NOT NULL,
                minor_tag TEXT DEFAULT '',
                icon TEXT DEFAULT '',
                color TEXT DEFAULT '',
                description TEXT DEFAULT '',
                UNIQUE(major_tag, minor_tag)
            );
        ");
    } else {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS links (
                id SERIAL PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                url TEXT NOT NULL,
                major_tag VARCHAR(100) NOT NULL,
                minor_tag VARCHAR(100) NOT NULL,
                description TEXT DEFAULT '',
                icon_url TEXT DEFAULT '',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS tag_meta (
                id SERIAL PRIMARY KEY,
                major_tag VARCHAR(100) NOT NULL,
                minor_tag VARCHAR(100) DEFAULT '',
                icon VARCHAR(100) DEFAULT '',
                color VARCHAR(50) DEFAULT '',
                description TEXT DEFAULT '',
                UNIQUE(major_tag, minor_tag)
            );
        ");
    }
}
