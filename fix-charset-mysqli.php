<?php
/**
 * Database Character Set Fix Script (MySQLi Version)
 * 
 * This script uses mysqli instead of PDO
 * 
 * INSTRUCTIONS:
 * 1. Update the database credentials below
 * 2. Upload this file to your server
 * 3. Access it via browser: https://yourdomain.com/fix-charset-mysqli.php
 * 4. DELETE THIS FILE after running!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// UPDATE THESE WITH YOUR ACTUAL CREDENTIALS
// ============================================
$host = 'localhost';
$dbname = 'schoolpulse_schoolpulse_db';  // ← Get this from DirectAdmin MySQL Management
$username = 'schoolpulse_schoolpulse_user';  // ← Get this from DirectAdmin MySQL Management
$password = 'your_password_here';  // ← Get this from DirectAdmin MySQL Management
// ============================================

echo "<h2>Database Character Set Conversion (MySQLi)</h2>";
echo "<hr>";

// Check if mysqli is available
if (!extension_loaded('mysqli')) {
    die("<p style='color: red;'>✗ MySQLi extension is not loaded. Please contact your hosting provider.</p>");
}

echo "<p>✓ MySQLi extension is loaded</p>";

// Connect to MySQL
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("<h3 style='color: red;'>✗ Connection failed</h3><p>" . $conn->connect_error . "</p>");
}

echo "<p>✓ Connected to MySQL server</p>";

try {
    // Step 1: Convert database
    echo "<h3>Step 1: Converting Database</h3>";
    
    $sql = "ALTER DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ Database converted to utf8mb4</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Database conversion: " . $conn->error . "</p>";
    }
    
    // Select the database
    $conn->select_db($dbname);
    
    // Step 2: Get all tables
    echo "<h3>Step 2: Converting Tables</h3>";
    
    $result = $conn->query("SHOW TABLES");
    if (!$result) {
        die("<p style='color: red;'>✗ Could not get tables: " . $conn->error . "</p>");
    }
    
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    
    echo "<p>Found " . count($tables) . " tables</p>";
    echo "<ul>";
    
    foreach ($tables as $table) {
        $sql = "ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if ($conn->query($sql) === TRUE) {
            echo "<li>✓ Converted table: <strong>$table</strong></li>";
        } else {
            echo "<li style='color: orange;'>⚠ Failed to convert table: <strong>$table</strong> - " . $conn->error . "</li>";
        }
    }
    
    echo "</ul>";
    
    // Step 3: Verify conversion
    echo "<h3>Step 3: Verification</h3>";
    
    // Check database charset
    $sql = "SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
            FROM information_schema.SCHEMATA 
            WHERE SCHEMA_NAME = '$dbname'";
    $result = $conn->query($sql);
    $dbInfo = $result->fetch_assoc();
    
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
    
    $sql = "SELECT TABLE_NAME, TABLE_COLLATION 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = '$dbname'";
    $result = $conn->query($sql);
    
    $allUtf8mb4 = true;
    while ($info = $result->fetch_assoc()) {
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
        echo "<li>Your includes/db.php already uses utf8mb4 (no changes needed)</li>";
        echo "<li>Test your website</li>";
        echo "<li><strong style='color: red;'>DELETE THIS FILE (fix-charset-mysqli.php)</strong></li>";
        echo "</ol>";
    } else {
        echo "<h3 style='color: orange;'>⚠ PARTIAL SUCCESS</h3>";
        echo "<p>Some tables may still need manual conversion.</p>";
        echo "<p>Try running this script again or contact your hosting provider.</p>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>✗ ERROR</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
    echo "Error: " . $e->getMessage();
    echo "</pre>";
}

$conn->close();

echo "<hr>";
echo "<p><em>Script executed at: " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p style='color: red; font-weight: bold;'>⚠ REMEMBER TO DELETE THIS FILE AFTER USE!</p>";
?>
