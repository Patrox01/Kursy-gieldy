<?php
session_start();
require 'config_users.php';

if (isset($_GET['token']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
    $token = $_GET['token'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password !== $confirm_new_password) {
        header('Location: reset_password.php?token=' . $token . '&error=password_mismatch');
        exit();
    }

    if (!preg_match('/^[\p{Print}]{12,128}$/u', $new_password)) {
        header('Location: reset_password.php?token=' . $token . '&error=weak_password');
        exit();
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE reset_token = :token AND token_expiry > NOW()');
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Aktualizacja hasła
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE reset_token = :token');
            $stmt->execute(['password' => $hashedPassword, 'token' => $token]);

            header('Location: index.php?success=password_reset');
            exit();
        } else {
            header('Location: index.php?error=invalid_token');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: index.php?error=server');
        exit();
    }
} else {
    header('Location: index.php?error=invalid_request');
    exit();
}
?>
