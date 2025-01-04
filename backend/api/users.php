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
?> 