<?php
// Prevent multiple inclusions from causing issues
if (!defined('DB_CONNECTED')) {
    $servername = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: '0.0.0.0/0';
    $username = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: 'ur5dwwodezbp4aa7';
    $password = getenv('DB_PASS') ?: getenv('MYSQLPASSWORD') ?: 'bnl3mzyspllclrolwbgn';
    $dbname = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'hbexclusive';
    $dbport = (int) (getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: 3306);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn = new mysqli($servername, $username, $password, $dbname, $dbport);
    } catch (mysqli_sql_exception $e) {
        die(
            'Database connection failed. Check your Render environment variables ' .
            '(DB_HOST/DB_USER/DB_PASS/DB_NAME/DB_PORT or MYSQLHOST/MYSQLUSER/MYSQLPASSWORD/MYSQLDATABASE/MYSQLPORT). ' .
            'Original error: ' . $e->getMessage()
        );
    }

    $conn->set_charset("utf8mb4");

    define('DB_CONNECTED', true);
}
?>
