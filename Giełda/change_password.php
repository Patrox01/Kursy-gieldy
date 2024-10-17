<?php
session_start();
require 'config_users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password']) && isset($_POST['old_password']) && isset($_POST['confirm_new_password'])) {
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password !== $confirm_new_password) {
        echo "Nowe hasła nie są zgodne.";
        exit;
    }

    if (strlen($new_password) < 12 || strlen($new_password) > 128) {
        echo "Hasło musi mieć od 12 do 128 znaków.";
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($old_password, $user['password'])) {
            // Hashowanie nowego hasła
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE username = :username');
            $stmt->execute(['password' => $hashed_new_password, 'username' => $username]);

            echo "Hasło zostało zmienione pomyślnie.";
        } else {
            echo "Błędne stare hasło.";
        }
    } catch (PDOException $e) {
        echo "Wystąpił błąd serwera. Prosimy spróbować ponownie później.";
    }
}
?>
