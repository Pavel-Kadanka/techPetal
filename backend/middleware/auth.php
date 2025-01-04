<?php
function requireAuth() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(array("message" => "No authorization token provided"));
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $user = validateJWT($token);
    
    if (!$user) {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid token"));
        exit();
    }

    return $user;
}
?> 