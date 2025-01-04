<?php
function generateJWT($user) {
    $secret_key = "your_secret_key"; // Store this in a secure configuration file
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60 * 24); // 24 hours

    $payload = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "user" => array(
            "id" => $user['id'],
            "role" => $user['role']
        )
    );

    return jwt_encode($payload, $secret_key);
}

function validateJWT($token) {
    $secret_key = "your_secret_key";
    try {
        $decoded = jwt_decode($token, $secret_key);
        return $decoded->user;
    } catch(Exception $e) {
        return false;
    }
}
?> 