<?php
/**
 * Khushi Enterprises - Database Configuration & PDO Helper
 * Configured for GoDaddy cPanel Shared Hosting (MySQL + JSON Fallback)
 */

// Set your GoDaddy MySQL Database credentials here after creating in cPanel
define('DB_HOST', 'localhost');
define('DB_NAME', 'khushi_wholesale_db');
define('DB_USER', 'khushi_db_user');
define('DB_PASS', 'YourStrongPassword123!');
define('DB_CHARSET', 'utf8mb4');

// Email Notification Settings
define('ADMIN_EMAIL', 'khushienterprisespune@gmail.com');
define('SITE_NAME', 'Khushi Enterprises Pune');

function getDBConnection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    // Try connecting to MySQL; if not configured or failed, return null gracefully (fallback to JSON)
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 3,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Return null to trigger automatic JSON flat-file storage
        return null;
    }
}
