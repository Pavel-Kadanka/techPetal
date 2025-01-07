<?php
include_once '../config/cors.php';
handleCors();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Get single user
        $user->id = $_GET['id'];
        $stmt = $user->getSingleUser();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            http_response_code(200);
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "User not found."));
        }
    } else {
        // Get all users
        $stmt = $user->getUsers();
        $users_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($users_arr, $row);
        }
        
        http_response_code(200);
        echo json_encode($users_arr);
    }
}

// Handle DELETE requests
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$id) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing user ID"));
        exit;
    }

    $user->id = $id;
    if ($user->deleteUser()) {
        http_response_code(200);
        echo json_encode(array("message" => "User deleted successfully"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete user"));
    }
}

// Handle PUT requests
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    
    // Validate required data
    if (!isset($data->id)) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing user ID"));
        exit;
    }

    $user->id = $data->id;
    
    // Create update data array with only provided fields
    $updateData = new stdClass();
    if (isset($data->name)) $updateData->name = $data->name;
    if (isset($data->email)) $updateData->email = $data->email;
    if (isset($data->role)) $updateData->role = $data->role;
    if (isset($data->password)) $updateData->password = $data->password;

    if ($user->updateUser($updateData)) {
        http_response_code(200);
        echo json_encode(array(
            "message" => "User updated successfully",
            "user" => array(
                "id" => $data->id,
                "name" => $data->name,
                "email" => $data->email,
                "role" => $data->role,
                "password" => $data->password
            )
        ));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update user"));
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    // Validate required data
    if (!isset($data->name) || !isset($data->email) || !isset($data->password) || !isset($data->role)) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing required data"));
        exit;
    }

    // Set user properties
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = password_hash($data->password, PASSWORD_DEFAULT);
    $user->role = $data->role;

    // Check if email already exists
    if ($user->emailExists()) {
        http_response_code(400);
        echo json_encode(array("message" => "Email already exists"));
        exit;
    }

    // Create the user
    if ($user->create()) {
        http_response_code(201);
        echo json_encode(array(
            "message" => "User created successfully",
            "user" => array(
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->role
            )
        ));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user"));
    }
}
?>
