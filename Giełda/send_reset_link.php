<?php
session_start();
require 'config_users.php';

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?error=invalid_email');
        exit();
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // token
            $token = bin2hex(random_bytes(50));
            $stmt = $pdo->prepare('UPDATE users SET reset_token = :token, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email');
            $stmt->execute(['token' => $token, 'email' => $email]);

            // Link
            $resetLink = "http://localhost/Gie%c5%82da/reset_password.phptoken=" . $token;

            $subject = "Resetowanie hasła";
            $message = "Kliknij w poniższy link, aby zresetować swoje hasło:\n\n" . $resetLink;
            $headers = 'From: no-reply@yourdomain.com' . "\r\n" .
                       'Reply-To: no-reply@yourdomain.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            mail($email, $subject, $message, $headers);

            header('Location: index.php?success=reset_link_sent');
            exit();
        } else {
            header('Location: index.php?error=email_not_found');
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
