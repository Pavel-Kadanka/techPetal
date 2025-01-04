<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!empty($data->email) && !empty($data->password)) {
        $user->email = $data->email;
        $stmt = $user->getUserByEmail();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($data->password, $row['password'])) {
                // Generate JWT token
                $token = generateJWT($row);
                
                http_response_code(200);
                echo json_encode(array(
                    "user" => array(
                        "id" => $row['id'],
                        "name" => $row['name'],
                        "email" => $row['email'],
                        "role" => $row['role']
                    ),
                    "token" => $token
                ));
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "Invalid credentials"));
            }
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Missing required fields"));
    }
}
?> 