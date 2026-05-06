<?php
header('Content-Type: application/json');
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

// Check authentication
if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    $user_id = $_SESSION['admin_id'];
    
    // Get current profile picture
    $stmt = $pdo->prepare("SELECT profile_picture FROM admin_users WHERE id = ?");
    $stmt->execute([$user_id]);
    $profile_picture = $stmt->fetchColumn();
    
    if (!$profile_picture) {
        throw new Exception('No profile picture to delete');
    }
    
    // Delete file from filesystem
    $file_path = '../../' . $profile_picture;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Update database
    $stmt = $pdo->prepare("UPDATE admin_users SET profile_picture = NULL WHERE id = ?");
    $stmt->execute([$user_id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Profile picture deleted successfully'
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
