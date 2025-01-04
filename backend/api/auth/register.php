<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
        // Set user properties
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = password_hash($data->password, PASSWORD_DEFAULT);
        $user->role = !empty($data->role) ? $data->role : 'user';

        // Check if email already exists
        if ($user->emailExists()) {
            http_response_code(400);
            echo json_encode(array("message" => "Email already exists."));
            return;
        }

        // Create the user
        if ($user->create()) {
            http_response_code(201);
            echo json_encode(array(
                "user" => array(
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role" => $user->role
                ),
                "message" => "User was created."
            ));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create user."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
?> 