<?php

class authController
{
    public function showLoginForm()
    {
        require 'Views/login.php';
    }

    public function showRegisterForm()
    {
        require 'Views/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill all fields';
            header('Location: /login');
            exit();
        }

        try {
            $user = new User();
            $userData = $user->findByEmail($email);
            
            if (!$userData) {
                $_SESSION['error'] = 'User not found. Please register first.';
                header('Location: /login');
                exit();
            }
            
            if ($user->verifyPassword($password, $userData['password_hash'])) {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_name'] = $userData['nom'];
                header('Location: /dashboard');
            } else {
                $_SESSION['error'] = 'Invalid password';
                header('Location: /login');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Database error: ' . $e->getMessage();
            header('Location: /login');
        }
        exit();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit();
        }

        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Please fill all fields';
            header('Location: /register');
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: /register');
            exit();
        }

        $user = new User();
        if ($user->create($nom, $email, $password)) {
            $_SESSION['register_success'] = 'Account created successfully! You can now login.';
            header('Location: /login');
        } else {
            $_SESSION['error'] = 'Registration failed. Email may already exist.';
            header('Location: /register');
        }
        exit();
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit();
    }
}