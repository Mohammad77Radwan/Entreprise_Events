<?php
namespace App\Controllers;



use App\Models\User;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = $this->userModel->getByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];

                header("Location: " . BASE_URL . "/home");
                exit();
            } else {
                $error = "Identifiants incorrects";
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/auth/login");
        exit();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => ROLE_EMPLOYEE
            ];

            if ($data['password'] !== $data['confirm_password']) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif ($this->userModel->getByUsername($data['username'])) {
                $error = "Ce nom d'utilisateur est déjà pris";
            } elseif ($this->userModel->getByEmail($data['email'])) {
                $error = "Cet email est déjà utilisé";
            } else {
                $userId = $this->userModel->create(
                    $data['username'],
                    $data['email'],
                    $data['password'],
                    $data['role']
                );

                if ($userId) {
                    $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                    header("Location: " . BASE_URL . "/auth/login");
                    exit();
                } else {
                    $error = "Une erreur est survenue lors de l'inscription";
                }
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }
}
