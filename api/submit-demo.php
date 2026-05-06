<?php
// Suppress any PHP errors/warnings from being output
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Validate required fields
$school_name    = sanitize($_POST['school_name'] ?? '');
$contact_person = sanitize($_POST['contact_person'] ?? '');
$email          = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone          = sanitize($_POST['phone'] ?? '');
$city           = sanitize($_POST['city'] ?? '');
$designation    = sanitize($_POST['designation'] ?? '');
$student_count  = sanitize($_POST['student_count'] ?? '');
$message        = sanitize($_POST['message'] ?? '');
$interested_features = sanitize($_POST['interested_features'] ?? '');

if (!$school_name || !$contact_person || !$email || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
    exit;
}

try {
    // Insert demo request
    $stmt = $pdo->prepare("
        INSERT INTO demo_requests 
        (school_name, contact_person, email, phone, city, student_count, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$school_name, $contact_person, $email, $phone, $city, $student_count, $message]);
    
    // Send notification email to admin (optional - don't fail if this errors)
    try {
        $admin_email = get_setting($pdo, 'contact_email', 'admin@schoolpulse.in');
        $subject = "New Demo Request: $school_name";
        $body = "
            <h2>New Demo Request</h2>
            <p><strong>School:</strong> $school_name</p>
            <p><strong>Contact:</strong> $contact_person</p>
            <p><strong>Designation:</strong> $designation</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Students:</strong> $student_count</p>
            <p><strong>Interested Features:</strong> $interested_features</p>
            <p><strong>Message:</strong> $message</p>
            <p><strong>Submitted:</strong> " . date('Y-m-d H:i:s') . "</p>
        ";
        
        send_notification_email($admin_email, $subject, $body);
    } catch (Exception $e) {
        // Email failed but don't stop the process
        error_log("Email notification error: " . $e->getMessage());
    }
    
    echo json_encode(['success' => true, 'message' => 'Demo request submitted successfully']);
    
} catch (Exception $e) {
    error_log("Demo submission error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
}