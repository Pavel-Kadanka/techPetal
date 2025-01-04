<?php
function verifyToken($token) {
    if (!$token) {
        return false;
    }

    try {
        // Decode JWT token and verify
        // Replace this with your actual JWT verification logic
        $decoded = jwt_decode($token, JWT_SECRET_KEY);
        return [
            'id' => $decoded->id,
            'role' => $decoded->role
        ];
    } catch (Exception $e) {
        return false;
    }
}
?> 