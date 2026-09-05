<?php
require_once '../includes/db.php';

try {
    // Add Low_Stock_Threshold to products table
    $pdo->exec("ALTER TABLE products ADD COLUMN Low_Stock_Threshold INT DEFAULT 5");
    echo "Successfully updated products table.\n";
} catch (PDOException $e) {
    echo "Note: " . $e->getMessage() . " (The column might already exist)\n";
}
