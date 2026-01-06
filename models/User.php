<?php

class User {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::connect();
    }
    
    public function create($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword]);
    }
    
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}