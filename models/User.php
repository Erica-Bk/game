<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $password;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $query = "SELECT id, username, password, email
                  FROM {$this->table}
                  WHERE username = :username
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function usernameExists($username) {
        $query = "SELECT id FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (username, password, email)
                  VALUES (:username, :password, :email)";

        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $this->email);

        return $stmt->execute();
    }
}
