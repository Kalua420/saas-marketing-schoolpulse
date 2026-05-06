<?php
/**
 * Database Options Checker
 * 
 * This will help you decide which approach to take
 * DELETE THIS FILE after checking!
 */

echo "<h2>Database Connection Options</h2>";
echo "<hr>";

// Check PHP Version
echo "<h3>1. PHP Version</h3>";
$phpVersion = phpversion();
echo "<p><strong>Version:</strong> $phpVersion</p>";

if (version_compare($phpVersion, '7.4.0', '>=')) {
    echo "<p style='color: green;'>✓ PHP version is compatible</p>";
} else {
    echo "<p style='color: red;'>✗ PHP version is too old (need 7.4+)</p>";
}

echo "<hr>";

// Check Database Extensions
echo "<h3>2. Available Database Extensions</h3>";

$hasPDO = extension_loaded('pdo');
$hasPDOMySQL = extension_loaded('pdo_mysql');
$hasMySQLi = extension_loaded('mysqli');

echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Extension</th><th>Status</th><th>Notes</th></tr>";

// PDO
$pdoStatus = $hasPDO ? '✓ Available' : '✗ Not Available';
$pdoColor = $hasPDO ? 'green' : 'red';
$pdoNotes = $hasPDO ? 'Core PDO is available' : 'PDO not installed';
echo "<tr>";
echo "<td><strong>PDO</strong></td>";
echo "<td style='color: $pdoColor; font-weight: bold;'>$pdoStatus</td>";
echo "<td>$pdoNotes</td>";
echo "</tr>";

// PDO MySQL
$pdoMySQLStatus = $hasPDOMySQL ? '✓ Available' : '✗ Not Available';
$pdoMySQLColor = $hasPDOMySQL ? 'green' : 'red';
$pdoMySQLNotes = $hasPDOMySQL ? 'Can use PDO for MySQL' : 'Cannot use PDO for MySQL';
echo "<tr>";
echo "<td><strong>PDO MySQL Driver</strong></td>";
echo "<td style='color: $pdoMySQLColor; font-weight: bold;'>$pdoMySQLStatus</td>";
echo "<td>$pdoMySQLNotes</td>";
echo "</tr>";

// MySQLi
$mysqliStatus = $hasMySQLi ? '✓ Available' : '✗ Not Available';
$mysqliColor = $hasMySQLi ? 'green' : 'red';
$mysqliNotes = $hasMySQLi ? 'Can use MySQLi as alternative' : 'MySQLi not available';
echo "<tr>";
echo "<td><strong>MySQLi</strong></td>";
echo "<td style='color: $mysqliColor; font-weight: bold;'>$mysqliStatus</td>";
echo "<td>$mysqliNotes</td>";
echo "</tr>";

echo "</table>";

echo "<hr>";

// Recommendation
echo "<h3>3. Recommended Action</h3>";

if ($hasPDO && $hasPDOMySQL) {
    echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 15px; border-radius: 5px;'>";
    echo "<h4 style='color: #155724; margin-top: 0;'>✓ PERFECT! Use PDO (Current Setup)</h4>";
    echo "<p><strong>What to do:</strong></p>";
    echo "<ol>";
    echo "<li>Your server supports PDO MySQL</li>";
    echo "<li>Update <code>includes/db.php</code> with production credentials</li>";
    echo "<li>Run <code>fix-charset-mysqli.php</code> to fix database charset</li>";
    echo "<li>Your website should work perfectly</li>";
    echo "</ol>";
    echo "<p><strong>No code changes needed!</strong></p>";
    echo "</div>";
    
} elseif ($hasMySQLi) {
    echo "<div style='background: #fff3cd; border: 2px solid #ffc107; padding: 15px; border-radius: 5px;'>";
    echo "<h4 style='color: #856404; margin-top: 0;'>⚠ USE MYSQLI (Temporary Solution)</h4>";
    echo "<p><strong>What to do:</strong></p>";
    echo "<ol>";
    echo "<li><strong>Short-term:</strong> Use MySQLi connection</li>";
    echo "<li>Replace <code>includes/db.php</code> with <code>includes/db-mysqli.php</code></li>";
    echo "<li>Update all PHP files to use MySQLi syntax</li>";
    echo "<li>Run <code>fix-charset-mysqli.php</code> to fix database charset</li>";
    echo "</ol>";
    echo "<p><strong>Long-term:</strong></p>";
    echo "<ol>";
    echo "<li>Contact hosting provider to enable PDO MySQL extension</li>";
    echo "<li>Once enabled, switch back to PDO (no code changes needed)</li>";
    echo "</ol>";
    echo "<p style='color: #856404;'><strong>⚠ This requires updating all database code!</strong></p>";
    echo "</div>";
    
} else {
    echo "<div style='background: #f8d7da; border: 2px solid #dc3545; padding: 15px; border-radius: 5px;'>";
    echo "<h4 style='color: #721c24; margin-top: 0;'>✗ CRITICAL: No Database Extensions Available</h4>";
    echo "<p><strong>What to do:</strong></p>";
    echo "<ol>";
    echo "<li><strong>Contact your hosting provider IMMEDIATELY</strong></li>";
    echo "<li>Ask them to enable either:</li>";
    echo "<ul>";
    echo "<li>PDO with PDO MySQL driver (recommended)</li>";
    echo "<li>MySQLi extension (alternative)</li>";
    echo "</ul>";
    echo "<li>Your website cannot connect to database without these</li>";
    echo "</ol>";
    echo "<p style='color: #721c24;'><strong>✗ Website will not work until this is fixed!</strong></p>";
    echo "</div>";
}

echo "<hr>";

// Test Connection (if possible)
echo "<h3>4. Test Database Connection</h3>";

if ($hasPDO && $hasPDOMySQL) {
    echo "<p>Testing PDO connection...</p>";
    
    // Try to connect
    $testHost = 'localhost';
    $testDB = 'schoolpulse_schoolpulse_db';  // Update this
    $testUser = 'schoolpulse_schoolpulse_user';  // Update this
    $testPass = 'your_password_here';  // Update this
    
    try {
        $testPDO = new PDO("mysql:host=$testHost;dbname=$testDB", $testUser, $testPass);
        echo "<p style='color: green;'>✓ PDO connection successful!</p>";
        echo "<p>Database: <strong>$testDB</strong></p>";
        
        // Check charset
        $stmt = $testPDO->query("SELECT @@character_set_database, @@collation_database");
        $charset = $stmt->fetch(PDO::FETCH_NUM);
        echo "<p>Current Charset: <strong>{$charset[0]}</strong></p>";
        echo "<p>Current Collation: <strong>{$charset[1]}</strong></p>";
        
        if ($charset[0] === 'utf8mb4') {
            echo "<p style='color: green;'>✓ Database is using utf8mb4 (correct)</p>";
        } else {
            echo "<p style='color: red;'>✗ Database is using {$charset[0]} (needs conversion to utf8mb4)</p>";
            echo "<p><strong>Action:</strong> Run <code>fix-charset-mysqli.php</code></p>";
        }
        
    } catch (PDOException $e) {
        echo "<p style='color: orange;'>⚠ Could not connect: " . $e->getMessage() . "</p>";
        echo "<p><strong>Note:</strong> Update the credentials in this file to test connection</p>";
    }
    
} elseif ($hasMySQLi) {
    echo "<p>Testing MySQLi connection...</p>";
    
    $testHost = 'localhost';
    $testDB = 'schoolpulse_schoolpulse_db';  // Update this
    $testUser = 'schoolpulse_schoolpulse_user';  // Update this
    $testPass = 'your_password_here';  // Update this
    
    $testConn = new mysqli($testHost, $testUser, $testPass, $testDB);
    
    if ($testConn->connect_error) {
        echo "<p style='color: orange;'>⚠ Could not connect: " . $testConn->connect_error . "</p>";
        echo "<p><strong>Note:</strong> Update the credentials in this file to test connection</p>";
    } else {
        echo "<p style='color: green;'>✓ MySQLi connection successful!</p>";
        echo "<p>Database: <strong>$testDB</strong></p>";
        
        // Check charset
        $result = $testConn->query("SELECT @@character_set_database, @@collation_database");
        $charset = $result->fetch_row();
        echo "<p>Current Charset: <strong>{$charset[0]}</strong></p>";
        echo "<p>Current Collation: <strong>{$charset[1]}</strong></p>";
        
        if ($charset[0] === 'utf8mb4') {
            echo "<p style='color: green;'>✓ Database is using utf8mb4 (correct)</p>";
        } else {
            echo "<p style='color: red;'>✗ Database is using {$charset[0]} (needs conversion to utf8mb4)</p>";
            echo "<p><strong>Action:</strong> Run <code>fix-charset-mysqli.php</code></p>";
        }
        
        $testConn->close();
    }
    
} else {
    echo "<p style='color: red;'>✗ Cannot test connection - no database extensions available</p>";
}

echo "<hr>";

// Summary
echo "<h3>5. Quick Summary</h3>";

echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Item</th><th>Status</th><th>Action Required</th></tr>";

// PHP Version
$phpOK = version_compare($phpVersion, '7.4.0', '>=');
echo "<tr>";
echo "<td>PHP Version</td>";
echo "<td style='color: " . ($phpOK ? 'green' : 'red') . ";'>$phpVersion</td>";
echo "<td>" . ($phpOK ? 'None' : 'Upgrade PHP to 7.4+') . "</td>";
echo "</tr>";

// PDO MySQL
echo "<tr>";
echo "<td>PDO MySQL</td>";
echo "<td style='color: " . ($hasPDO && $hasPDOMySQL ? 'green' : 'red') . ";'>" . ($hasPDO && $hasPDOMySQL ? 'Available' : 'Not Available') . "</td>";
echo "<td>" . ($hasPDO && $hasPDOMySQL ? 'None - Use PDO' : 'Contact hosting to enable') . "</td>";
echo "</tr>";

// MySQLi
echo "<tr>";
echo "<td>MySQLi</td>";
echo "<td style='color: " . ($hasMySQLi ? 'green' : 'red') . ";'>" . ($hasMySQLi ? 'Available' : 'Not Available') . "</td>";
echo "<td>" . ($hasMySQLi ? 'Can use as fallback' : 'Contact hosting to enable') . "</td>";
echo "</tr>";

echo "</table>";

echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>⚠ DELETE THIS FILE AFTER CHECKING!</p>";
echo "<p><em>Generated at: " . date('Y-m-d H:i:s') . "</em></p>";
?>
