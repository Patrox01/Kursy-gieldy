<?php
session_start();
require 'config_users.php';

if (isset($_POST['username'], $_POST['password'], $_POST['password_confirm'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    if (empty($username) || empty($password)) {
        header('Location: index.php?register_error=empty');
        exit();
    }

    // Polityka hasła: minimum 8 znaków, w tym co najmniej jedna cyfra i jeden znak specjalny
    if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/', $password)) {
        header('Location: index.php?register_error=weak_password');
        exit();
    }

    if ($password !== $passwordConfirm) {
        header('Location: index.php?register_error=password_mismatch');
        exit();
    }


    // Sprawdzenie czy istnieje
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            header('Location: index.php?register_error=user_exists');
            exit();
        }

        // Hashowanie
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);

        echo "Rejestracja zakończona sukcesem!";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');

        exit();
    } catch (PDOException $e) {
        header('Location: index.php?register_error=server');
        exit();
    }
} else {
    header('Location: index.php?register_error=invalid_request');
    exit();
}
?>
