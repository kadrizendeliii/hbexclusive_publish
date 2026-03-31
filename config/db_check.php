<?php
include '../config/config.php';

echo "<h2>Database Diagnostic</h2>";

// Check 1: Does the table exist?
$table_check = $conn->query("SHOW TABLES LIKE 'categories'");
if ($table_check->num_rows > 0) {
    echo "<p style='color:green;'>✅ Table 'categories' exists.</p>";
} else {
    echo "<p style='color:red;'>❌ Table 'categories' DOES NOT exist. You need to run the CREATE TABLE SQL.</p>";
}

// Check 2: How many rows are in it?
$count_check = $conn->query("SELECT COUNT(*) as total FROM categories");
if ($count_check) {
    $row = $count_check->fetch_assoc();
    echo "<p style='color:green;'>✅ Found " . $row['total'] . " categories in the database.</p>";
} else {
    echo "<p style='color:red;'>❌ Could not count rows. Error: " . $conn->error . "</p>";
}

// Check 3: What are the column names?
$columns = $conn->query("DESCRIBE categories");
echo "<h4>Table Columns:</h4><ul>";
while($col = $columns->fetch_assoc()) {
    echo "<li>" . $col['Field'] . "</li>";
}
echo "</ul>";
?>