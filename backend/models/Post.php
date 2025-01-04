<?php
class Post {
    private $conn;
    private $table_name = "post";

    public $id;
    public $title;
    public $date;
    public $theme;
    public $rating;
    public $text;
    public $image;
    public $link;
    public $parameters;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all posts
    public function getPosts() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single post
    public function getSinglePost() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }
}
?> 