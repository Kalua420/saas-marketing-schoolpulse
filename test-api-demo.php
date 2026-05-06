<?php
/**
 * Test Demo API
 * This will show the actual error
 * DELETE AFTER TESTING!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Demo API</h2>";
echo "<hr>";

// Test 1: Check if db.php loads
echo "<h3>Test 1: Loading Database Connection</h3>";
try {
    require_once 'includes/db.php';
    echo "<p style='color: green;'>✓ Database connection loaded</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to load database: " . $e->getMessage() . "</p>";
    exit;
}

// Test 2: Check if functions.php loads
echo "<h3>Test 2: Loading Functions</h3>";
try {
    require_once 'includes/functions.php';
    echo "<p style='color: green;'>✓ Functions loaded</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to load functions: " . $e->getMessage() . "</p>";
    exit;
}

// Test 3: Check database connection
echo "<h3>Test 3: Testing Database Query</h3>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM demo_requests");
    $result = $stmt->fetch();
    echo "<p style='color: green;'>✓ Database query successful</p>";
    echo "<p>Found {$result['count']} demo requests</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database query failed: " . $e->getMessage() . "</p>";
    exit;
}

// Test 4: Test INSERT query
echo "<h3>Test 4: Testing INSERT Query</h3>";
try {
    $test_data = [
        'school_name' => 'Test School',
        'contact_person' => 'Test Person',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'city' => 'Test City',
        'student_count' => '100',
        'message' => 'Test message'
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO demo_requests 
        (school_name, contact_person, email, phone, city, student_count, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $result = $stmt->execute([
        $test_data['school_name'],
        $test_data['contact_person'],
        $test_data['email'],
        $test_data['phone'],
        $test_data['city'],
        $test_data['student_count'],
        $test_data['message']
    ]);
    
    if ($result) {
        $lastId = $pdo->lastInsertId();
        echo "<p style='color: green;'>✓ INSERT successful</p>";
        echo "<p>New record ID: $lastId</p>";
        
        // Clean up test record
        $stmt = $pdo->prepare("DELETE FROM demo_requests WHERE id = ?");
        $stmt->execute([$lastId]);
        echo "<p style='color: orange;'>Test record deleted</p>";
    } else {
        echo "<p style='color: red;'>✗ INSERT failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ INSERT failed: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

// Test 5: Test sanitize function
echo "<h3>Test 5: Testing sanitize() Function</h3>";
try {
    if (function_exists('sanitize')) {
        $test = sanitize('<script>alert("test")</script>');
        echo "<p style='color: green;'>✓ sanitize() function exists</p>";
        echo "<p>Test output: " . htmlspecialchars($test) . "</p>";
    } else {
        echo "<p style='color: red;'>✗ sanitize() function not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ sanitize() error: " . $e->getMessage() . "</p>";
}

// Test 6: Simulate actual API call
echo "<h3>Test 6: Simulating API Call</h3>";
try {
    $_POST = [
        'school_name' => 'Test School API',
        'contact_person' => 'Test Person API',
        'email' => 'testapi@example.com',
        'phone' => '9876543210',
        'city' => 'Test City API',
        'designation' => 'Principal',
        'student_count' => '500',
        'message' => 'Test API message',
        'interested_features' => 'Attendance, Fees'
    ];
    
    $school_name    = sanitize($_POST['school_name'] ?? '');
    $contact_person = sanitize($_POST['contact_person'] ?? '');
    $email          = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone          = sanitize($_POST['phone'] ?? '');
    $city           = sanitize($_POST['city'] ?? '');
    $student_count  = sanitize($_POST['student_count'] ?? '');
    $message        = sanitize($_POST['message'] ?? '');
    
    echo "<p>Sanitized data:</p>";
    echo "<ul>";
    echo "<li>School: $school_name</li>";
    echo "<li>Contact: $contact_person</li>";
    echo "<li>Email: $email</li>";
    echo "<li>Phone: $phone</li>";
    echo "</ul>";
    
    $stmt = $pdo->prepare("
        INSERT INTO demo_requests 
        (school_name, contact_person, email, phone, city, student_count, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $result = $stmt->execute([$school_name, $contact_person, $email, $phone, $city, $student_count, $message]);
    
    if ($result) {
        $lastId = $pdo->lastInsertId();
        echo "<p style='color: green;'>✓ API simulation successful</p>";
        echo "<p>New record ID: $lastId</p>";
        
        // Clean up
        $stmt = $pdo->prepare("DELETE FROM demo_requests WHERE id = ?");
        $stmt->execute([$lastId]);
        echo "<p style='color: orange;'>Test record deleted</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ API simulation failed: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p>If all tests passed, the API should work. If not, check the errors above.</p>";
echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>⚠ DELETE THIS FILE AFTER TESTING!</p>";
?>
