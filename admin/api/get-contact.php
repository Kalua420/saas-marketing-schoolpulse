<?php
header('Content-Type: application/json');
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$contact_id = (int)($_GET['id'] ?? 0);

if (!$contact_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM contact_submissions WHERE id = ?");
    $stmt->execute([$contact_id]);
    $contact = $stmt->fetch();
    
    if ($contact) {
        echo json_encode(['success' => true, 'contact' => $contact]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Contact not found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>