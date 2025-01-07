<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $created;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    name = :name,
                    email = :email,
                    password = :password,
                    role = :role";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        if ($this->role == null) {
            $this->role = "user";
        }
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getUserByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt;
    }

    // Method to get all users
    public function getUsers() {
        try {
            $query = "SELECT id, name, email, role, created FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    // Method to get a single user
    public function getSingleUser() {
        try {
            $query = "SELECT id, name, email, role, created FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function updateUser($data) {
        $query = "UPDATE " . $this->table_name . " SET ";
        $params = [];
        
        if (!empty($data->name)) {
            $params[] = "name = :name";
        }
        if (!empty($data->email)) {
            $params[] = "email = :email";
        }
        if (!empty($data->password)) {
            $params[] = "password = :password";
        }
        if (!empty($data->role)) {
            $params[] = "role = :role";
        }
        
        $query .= implode(", ", $params);
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        if (!empty($data->name)) {
            $stmt->bindParam(":name", $data->name);
        }
        if (!empty($data->email)) {
            $stmt->bindParam(":email", $data->email);
        }
        if (!empty($data->password)) {
            $password_hash = password_hash($data->password, PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $password_hash);
        }
        if (!empty($data->role)) {
            $stmt->bindParam(":role", $data->role);
        }
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function deleteUser() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?> 