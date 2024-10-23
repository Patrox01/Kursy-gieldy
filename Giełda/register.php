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

    if (!preg_match('/^.{12,128}$/us', $password)) {
        header('Location: index.php?register_error=weak_password');
        exit();
    }

    if ($password !== $passwordConfirm) {
        header('Location: index.php?register_error=password_mismatch');
        exit();
    }

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
    if (isPasswordBreached($password)) {
        header('Location: index.php?register_error=password_not_safe');
        exit();
    } else {
        header('Location: index.php?register_error=password_safe');
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
