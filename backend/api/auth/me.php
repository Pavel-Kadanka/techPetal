<?php
require_once '../../config/cors.php';
handleCors();

require_once '../../config/database.php';

header("Content-Type: application/json; charset=UTF-8");

// Get the token from the Authorization header
$headers = getallheaders();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = str_replace('Bearer ', '', $auth_header);

if (!$token) {
    http_response_code(401);
    echo json_encode(['error' => 'No token provided']);
    exit;
}

try {
    // Get user from database using the token as user ID
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT id, email, name, role FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$token]);
    
    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($user);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'User not found']);
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => $e->getMessage()]);
} 