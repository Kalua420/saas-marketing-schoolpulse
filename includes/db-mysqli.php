<?php
/**
 * Database Connection using MySQLi
 * Use this if PDO is not available on your server
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'schoolpulse_marketing');
define('DB_USER', 'root');
define('DB_PASS', 'Root@123');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}

// Set charset
$conn->set_charset("utf8mb4");

// Helper function to emulate PDO prepare/execute
function db_query($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        return false;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $stmt->execute();
    return $stmt;
}

// Helper function to fetch all results
function db_fetch_all($stmt) {
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to fetch single result
function db_fetch($stmt) {
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
