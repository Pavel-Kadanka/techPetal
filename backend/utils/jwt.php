<?php
require_once __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function generateJWT($user) {
    $secret_key = "heslo"; // Store this in a secure configuration file
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60 * 24); // 24 hours

    $payload = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "data" => array(
            "id" => $user['id'],
            "role" => $user['role']
        )
    );

    return JWT::encode($payload, $secret_key, 'HS256');
}

function validateJWT($token) {
    $secret_key = "your_secret_key";
    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        return $decoded->data;
    } catch(Exception $e) {
        return false;
    }
}
?> 