<?php
require_once '../../config/cors.php';
handleCors();

header("Content-Type: application/json; charset=UTF-8");

require_once '../../config/database.php';
require_once '../../models/User.php';

// Debug log
error_log("Login attempt started");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    // Debug log received data
    error_log('Received login data: ' . print_r($data, true));
    
    if (!empty($data->email) && !empty($data->password)) {
        $user->email = $data->email;
        $stmt = $user->getUserByEmail();
        
        // Debug log database query
        error_log('Querying database for email: ' . $data->email);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            error_log('User found in database');
            error_log('Stored password hash: ' . $row['password']);
            error_log('Provided password: ' . $data->password);
            
            if (password_verify($data->password, $row['password'])) {
                error_log('Password verified successfully');
                
                $response = array(
                    "user" => array(
                        "id" => $row['id'],
                        "name" => $row['name'],
                        "email" => $row['email'],
                        "role" => $row['role']
                    ),
                    "token" => $row['id']
                );
                
                error_log('Sending success response: ' . print_r($response, true));
                
                http_response_code(200);
                echo json_encode($response);
            } else {
                error_log('Password verification failed');
                http_response_code(401);
                echo json_encode(array("message" => "Invalid credentials"));
            }
        } else {
            error_log('No user found with email: ' . $data->email);
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials"));
        }
    } else {
        error_log('Missing required fields');
        http_response_code(400);
        echo json_encode(array("message" => "Missing required fields"));
    }
} else {
    error_log('Invalid request method: ' . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
}
?> 