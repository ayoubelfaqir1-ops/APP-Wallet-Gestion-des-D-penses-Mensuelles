<?php

class User
{
    private $db;
    private $id;
    private $nom;
    private $email;
    private $password;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function __construct($id = null, $nom, $email, $password)
    {
        $this->db = Database::getInstance();
    }

    public function create($nom, $email, $password)
    {
        // Validation
        if (empty($nom) || empty($email) || empty($password)) {
            return false;
        }

        if (!Security::validateEmail($email)) {
            return false;
        }

        if (!Security::validatePassword($password)) {
            return false;
        }

        // Vérifier si l'email existe déjà
        if ($this->emailExists($email)) {
            return false;
        }

        // Hash du mot de passe
        $passwordHash = Security::hashPassword($password);

        // Insertion
        $sql = "INSERT INTO users (nom, email, password_hash, role) VALUES (?, ?, ?, ?)";
        try {
            $this->db->query($sql, [$nom, $email, $passwordHash]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function emailExists($email)
    {
        $sql = "SELECT id FROM users WHERE email = ? AND deleted_at IS NULL";
        $result = $this->db->query($sql, [$email]);
        return $result->rowCount() > 0;
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND deleted_at IS NULL";
        $result = $this->db->query($sql, [$email]);
        $user = $result->fetch();

        if ($user && Security::verifyPassword($password, $user['password_hash'])) {
            // Remplir les propriétés de l'objet
            $this->hydrate($user);

            // Initialiser la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            // Régénérer l'ID de session
            session_regenerate_id(true);

            return $user;
        }

        return false;
    }

    private function hydrate($data) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password_hash'] ?? '';


    }

    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
    }

    public function getById($id) {
        $sql = "SELECT id, nom, email, role, created_at FROM users WHERE id = ? AND deleted_at IS NULL";
        $result = $this->db->query($sql, [$id]);
        $data = $result->fetch();
        
        if ($data) {
            // Remplir les propriétés
            $this->hydrate($data);
        }
        return $data;
    }

    public function update($id, $nom, $email) {
        $sql = "UPDATE users SET nom = ?, email = ? WHERE id = ?";
        try {
            $this->db->query($sql, [$nom, $email, $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function softDelete($id) {
        $sql = "UPDATE users SET deleted_at = NOW() WHERE id = ?";
        try {
            $this->db->query($sql, [$id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    
}
