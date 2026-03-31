<?php
// Prevent multiple inclusions from causing issues
if (!defined('DB_CONNECTED')) {
    $servername = getenv('DB_HOST') ?: 'localhost';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: '';
    $dbname = getenv('DB_NAME') ?: 'hbexclusive';
    $dbport = (int) (getenv('DB_PORT') ?: 3306);

    // 1. Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $dbport);

    // 2. Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 3. Set Charset (Crucial for names/emails with special characters)
    $conn->set_charset("utf8mb4");

    // 4. Set MySQLi to throw exceptions (Helps catch errors instead of looping/hanging)
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    define('DB_CONNECTED', true);
}
?>
