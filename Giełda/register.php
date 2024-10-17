<?php
session_start();
require 'config_users.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = ($_POST['password']);
    $passwordConfirm =($_POST['password_confirm']);

    if (empty($username) || empty($email) || empty($password)) {
        header('Location: index.php?register_error=empty');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?register_error=invalid_email');
        exit();
    }

    if (!preg_match('/^[A-Za-z0-9!@#$%^&* \s]{12,128}$/u', $password)) {
        header('Location: index.php?register_error=weak_password');
        exit();
    }

    if ($password !== $passwordConfirm) {
        header('Location: index.php?register_error=password_mismatch');
        exit();
    }


    // Sprawdzenie czy istnieje
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            header('Location: index.php?register_error=user_or_email_exists');
            exit();
        }

        // Hashowanie
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $stmt->execute([
            'username' => $username,
            'email' => $email,
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
