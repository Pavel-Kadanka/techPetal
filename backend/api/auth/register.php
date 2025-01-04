<?php
require_once '../../config/cors.php';
require_once '../../config/database.php';
require_once '../../models/User.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        // Set user values
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = password_hash($data->password, PASSWORD_DEFAULT);
        $user->role = isset($data->role) ? $data->role : 'user';
        
        if ($user->create()) {
            // Get the newly created user's data
            $stmt = $user->getUserByEmail();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            http_response_code(201);
            echo json_encode(array(
                "user" => array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "role" => $row['role']
                ),
                "token" => $row['id'] // Using user ID as token, same as login
            ));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create user."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
    }
}
?> 