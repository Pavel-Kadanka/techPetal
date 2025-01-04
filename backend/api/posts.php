<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Get single post
        $post->id = $_GET['id'];
        $stmt = $post->getSinglePost();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            http_response_code(200);
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Post not found."));
        }
    } else {
        // Get all posts
        $stmt = $post->getPosts();
        $posts_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($posts_arr, $row);
        }
        
        http_response_code(200);
        echo json_encode($posts_arr);
    }
}
?> 