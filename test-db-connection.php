<?php
/**
 * Database Connection Test Script
 * Upload this to your server and access it via browser
 * Delete after testing!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";
echo "<hr>";

// Test 1: Check PHP PDO Extension
echo "<h3>1. Checking PHP PDO Extension</h3>";
if (extension_loaded('pdo')) {
    echo "✓ PDO extension is loaded<br>";
} else {
    echo "✗ PDO extension is NOT loaded<br>";
    die("Please enable PDO extension in PHP");
}

if (extension_loaded('pdo_mysql')) {
    echo "✓ PDO MySQL driver is loaded<br>";
} else {
    echo "✗ PDO MySQL driver is NOT loaded<br>";
    die("Please enable PDO MySQL driver in PHP");
}

echo "<hr>";

// Test 2: Try to connect with current credentials
echo "<h3>2. Testing Database Connection</h3>";
echo "<p><strong>Current Configuration:</strong></p>";

// Read from includes/db.php
$config = [
    'host' => 'localhost',
    'dbname' => 'schoolpulse_marketing',
    'username' => 'root',
    'password' => 'Root@123'
];

echo "Host: " . $config['host'] . "<br>";
echo "Database: " . $config['dbname'] . "<br>";
echo "Username: " . $config['username'] . "<br>";
echo "Password: " . str_repeat('*', strlen($config['password'])) . "<br>";
echo "<hr>";

// Test 3: Attempt connection
echo "<h3>3. Connection Attempt</h3>";

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ Successfully connected to MySQL server<br>";
    
    // Test 4: Check if database exists
    echo "<hr>";
    echo "<h3>4. Checking Database</h3>";
    
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$config['dbname']}'");
    $dbExists = $stmt->fetch();
    
    if ($dbExists) {
        echo "✓ Database '{$config['dbname']}' exists<br>";
        
        // Try to select the database
        $pdo->exec("USE {$config['dbname']}");
        echo "✓ Successfully selected database<br>";
        
        // Test 5: Check tables
        echo "<hr>";
        echo "<h3>5. Checking Tables</h3>";
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "✓ Found " . count($tables) . " tables:<br>";
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
            
            // Check for required tables
            $requiredTables = ['admin_users', 'demo_requests', 'contact_submissions', 'clients'];
            $missingTables = array_diff($requiredTables, $tables);
            
            if (empty($missingTables)) {
                echo "<br>✓ All required tables exist<br>";
            } else {
                echo "<br>⚠ Missing tables: " . implode(', ', $missingTables) . "<br>";
                echo "Please import database.sql file<br>";
            }
        } else {
            echo "⚠ No tables found in database<br>";
            echo "Please import database.sql file<br>";
        }
        
    } else {
        echo "✗ Database '{$config['dbname']}' does NOT exist<br>";
        echo "<br><strong>Action Required:</strong><br>";
        echo "1. Create database in your hosting control panel<br>";
        echo "2. Import database.sql file<br>";
    }
    
    echo "<hr>";
    echo "<h3>✓ Connection Test Successful!</h3>";
    echo "<p style='color: green;'><strong>Your database connection is working!</strong></p>";
    echo "<p>If you see this message, update includes/db.php with these credentials.</p>";
    
} catch (PDOException $e) {
    echo "✗ Connection failed<br>";
    echo "<hr>";
    echo "<h3>Error Details:</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error Message: " . $e->getMessage() . "\n";
    echo "</pre>";
    
    echo "<hr>";
    echo "<h3>Common Solutions:</h3>";
    echo "<ol>";
    echo "<li><strong>Wrong credentials:</strong> Check your database username and password in hosting control panel</li>";
    echo "<li><strong>Database doesn't exist:</strong> Create the database first</li>";
    echo "<li><strong>Wrong host:</strong> Try 'localhost' or ask your hosting provider for the correct host</li>";
    echo "<li><strong>User permissions:</strong> Make sure database user has ALL PRIVILEGES on the database</li>";
    echo "<li><strong>MySQL not running:</strong> Contact your hosting provider</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>If connection successful: Update includes/db.php with correct credentials</li>";
echo "<li>If database doesn't exist: Create it in your hosting control panel</li>";
echo "<li>If tables missing: Import database.sql file via phpMyAdmin</li>";
echo "<li><strong style='color: red;'>DELETE THIS FILE after testing!</strong></li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Test completed at: " . date('Y-m-d H:i:s') . "</em></p>";
?>
