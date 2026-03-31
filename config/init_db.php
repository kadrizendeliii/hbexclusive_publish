<?php
include_once('../config/config.php');

// Create users table if it doesn't exist
$create_users_table = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($create_users_table) === TRUE) {
    echo "Users table created/verified successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Add user_id column to orders table if it doesn't exist
$check_column = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='orders' AND COLUMN_NAME='user_id'");

if ($check_column->num_rows == 0) {
    $alter_orders = "ALTER TABLE `orders` ADD COLUMN `user_id` int(11)";
    if ($conn->query($alter_orders) === TRUE) {
        echo "<br>user_id column added to orders table";
    } else {
        echo "<br>Error adding column: " . $conn->error;
    }
} else {
    echo "<br>user_id column already exists in orders table";
}
?>
