<?php
session_start();
require 'config_users.php';

// Funkcja sprawdzająca, czy hasło jest w bazie wycieków (HIBP)
function isPasswordBreached($password) {
    // Oblicz hash SHA-1 hasła
    $sha1 = strtoupper(sha1($password));
    // Pobierz pierwsze 5 znaków skrótu
    $prefix = substr($sha1, 0, 5);
    $suffix = substr($sha1, 5);

    // Zapytanie do API HIBP z prefiksem skrótu
    $url = 'https://api.pwnedpasswords.com/range/' . $prefix;
    $response = file_get_contents($url);

    if ($response !== false) {
        $hashes = explode("\n", $response);
        foreach ($hashes as $hash) {
            list($hashSuffix, $count) = explode(':', $hash);
            if ($suffix === trim($hashSuffix)) {
                return true; // Hasło jest na liście wycieków
            }
        }
    }
        
    return false; // Hasło nie jest na liście wycieków
}

if (isset($_POST['username']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_confirm'])) {
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['new_password_confirm'];

    if ($new_password !== $confirm_new_password) {
        header('Location: index.php?error=password_mismatch');
        exit();
    }

    if (!preg_match('/^.{12,128}$/us', $new_password)) {
        header('Location: index.php?error=weak_password');
        exit();
    }

    if (isPasswordBreached($new_password)) {
        header('Location: index.php?error=password_not_safe');
        exit();
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $storedHashedPassword = $user['password'];

            if (!password_verify($old_password, $storedHashedPassword)) {
                header('Location: index.php?error=incorrect_old_password');
                exit();
            }

            // hash
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE username = :username');
            $stmt->execute(['password' => $hashedPassword, 'username' => $username]);

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
