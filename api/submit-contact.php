<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Validate required fields
    $required_fields = ['firstName', 'lastName', 'email', 'schoolName', 'message'];
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . ' is required';
        }
    }
    
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }
    
    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
        exit;
    }
    
    // Sanitize input data
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $schoolName = sanitizeInput($_POST['schoolName']);
    $studentCount = sanitizeInput($_POST['studentCount'] ?? '');
    $inquiryType = sanitizeInput($_POST['inquiryType'] ?? 'general');
    $message = sanitizeInput($_POST['message']);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO contact_submissions (
            first_name, last_name, email, phone, school_name, 
            student_count, inquiry_type, message, newsletter_signup, 
            submitted_at, ip_address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
    ");
    
    $result = $stmt->execute([
        $firstName,
        $lastName, 
        $email,
        $phone,
        $schoolName,
        $studentCount,
        $inquiryType,
        $message,
        $newsletter,
        $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
    
    if ($result) {
        // Send notification email (optional - implement based on requirements)
        $subject = "New Contact Form Submission - SchoolPulse";
        $emailBody = "
            New contact form submission received:
            
            Name: {$firstName} {$lastName}
            Email: {$email}
            Phone: {$phone}
            School: {$schoolName}
            Students: {$studentCount}
            Inquiry Type: {$inquiryType}
            Newsletter: " . ($newsletter ? 'Yes' : 'No') . "
            
            Message:
            {$message}
            
            Submitted: " . date('Y-m-d H:i:s') . "
            IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "
        ";
        
        // Uncomment to send email notifications
        // mail('admin@schoolpulse.in', $subject, $emailBody);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Thank you for your message! We will get back to you soon.'
        ]);
    } else {
        throw new Exception('Failed to save contact submission');
    }
    
} catch (Exception $e) {
    error_log("Contact form error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Sorry, there was an error processing your request. Please try again.'
    ]);
}
?>