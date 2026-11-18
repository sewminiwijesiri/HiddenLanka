<?php
/**
 * Hidden Lanka - Database Connection Helper
 * Require this file to establish database connection across pages.
 */

require_once __DIR__ . '/../config.php';

// Establish connection to MySQL
$db_conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($db_conn->connect_error) {
    error_log("Database connection failed: " . $db_conn->connect_error);
    die("A database connection error occurred. Please try again later.");
}

// Set charset to utf8mb4 for unicode security support
$db_conn->set_charset("utf8mb4");
?>
