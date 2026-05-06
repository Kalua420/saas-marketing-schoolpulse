<?php
/**
 * Database Character Set Fix Script
 * 
 * This script will:
 * 1. Convert database to utf8mb4
 * 2. Convert all tables to utf8mb4
 * 3. Convert all columns to utf8mb4
 * 
 * INSTRUCTIONS:
 * 1. Update the database credentials below
 * 2. Upload this file to your server
 * 3. Access it via browser: https://yourdomain.com/fix-database-charset.php
 * 4. DELETE THIS FILE after running!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// UPDATE THESE WITH YOUR ACTUAL CREDENTIALS
// ============================================
$host = 'localhost';
$dbname = 'schoolpulse_schoolpulse_db';  // ← Your database name
$username = 'schoolpulse_schoolpulse_user';  // ← Your username
$password = 'your_password_here';  // ← Your password
// ============================================

echo "<h2>Database Character Set Conversion</h2>";
echo "<hr>";

try {
    // Connect to MySQL server
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<p>✓ Connected to MySQL server</p>";
    
    // Step 1: Convert database
    echo "<h3>Step 1: Converting Database</h3>";
    $pdo->exec("ALTER DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✓ Database converted to utf8mb4</p>";
    
    // Select the database
    $pdo->exec("USE `$dbname`");
    
    // Step 2: Get all tables
    echo "<h3>Step 2: Converting Tables</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p>Found " . count($tables) . " tables</p>";
    echo "<ul>";
    
    foreach ($tables as $table) {
        try {
            // Convert table
            $pdo->exec("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "<li>✓ Converted table: <strong>$table</strong></li>";
        } catch (PDOException $e) {
            echo "<li>✗ Failed to convert table: <strong>$table</strong> - " . $e->getMessage() . "</li>";
        }
    }
    
    echo "</ul>";
    
    // Step 3: Verify conversion
    echo "<h3>Step 3: Verification</h3>";
    
    // Check database charset
    $stmt = $pdo->query("SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
                         FROM information_schema.SCHEMATA 
                         WHERE SCHEMA_NAME = '$dbname'");
    $dbInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Database Character Set:</strong> " . $dbInfo['DEFAULT_CHARACTER_SET_NAME'] . "</p>";
    echo "<p><strong>Database Collation:</strong> " . $dbInfo['DEFAULT_COLLATION_NAME'] . "</p>";
    
    if ($dbInfo['DEFAULT_CHARACTER_SET_NAME'] === 'utf8mb4') {
        echo "<p style='color: green; font-weight: bold;'>✓ Database is now using utf8mb4!</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>✗ Database is still using " . $dbInfo['DEFAULT_CHARACTER_SET_NAME'] . "</p>";
    }
    
    // Check tables
    echo "<h4>Table Character Sets:</h4>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Table</th><th>Charset</th><th>Collation</th></tr>";
    
    $stmt = $pdo->query("SELECT TABLE_NAME, TABLE_COLLATION 
                         FROM information_schema.TABLES 
                         WHERE TABLE_SCHEMA = '$dbname'");
    $tableInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $allUtf8mb4 = true;
    foreach ($tableInfo as $info) {
        $charset = explode('_', $info['TABLE_COLLATION'])[0];
        $color = ($charset === 'utf8mb4') ? 'green' : 'red';
        echo "<tr>";
        echo "<td>{$info['TABLE_NAME']}</td>";
        echo "<td style='color: $color;'>$charset</td>";
        echo "<td style='color: $color;'>{$info['TABLE_COLLATION']}</td>";
        echo "</tr>";
        
        if ($charset !== 'utf8mb4') {
            $allUtf8mb4 = false;
        }
    }
    
    echo "</table>";
    
    echo "<hr>";
    
    if ($allUtf8mb4) {
        echo "<h3 style='color: green;'>✓ SUCCESS!</h3>";
        echo "<p>All tables have been converted to utf8mb4.</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ol>";
        echo "<li>Update includes/db.php to use utf8mb4 (should already be set)</li>";
        echo "<li>Test your website</li>";
        echo "<li><strong style='color: red;'>DELETE THIS FILE (fix-database-charset.php)</strong></li>";
        echo "</ol>";
    } else {
        echo "<h3 style='color: orange;'>⚠ PARTIAL SUCCESS</h3>";
        echo "<p>Some tables may still need manual conversion.</p>";
        echo "<p>Contact your hosting provider if issues persist.</p>";
    }
    
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>✗ ERROR</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
    echo "Error: " . $e->getMessage();
    echo "</pre>";
    
    echo "<h4>Common Solutions:</h4>";
    echo "<ul>";
    echo "<li>Check database credentials are correct</li>";
    echo "<li>Make sure database user has ALTER privileges</li>";
    echo "<li>Contact hosting provider for assistance</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><em>Script executed at: " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p style='color: red; font-weight: bold;'>⚠ REMEMBER TO DELETE THIS FILE AFTER USE!</p>";
?>
