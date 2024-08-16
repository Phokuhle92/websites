<?php
require_once 'config/database.php';
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Store the token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $user_id);
        $stmt->execute();

        // Send the reset link to the user's email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'mfanefikile@gmail.com'; // Your Gmail address
            $mail->Password = 'blcc hvvi rrll ycqz'; // Your Gmail password (or App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            //Recipients
        
             $mail->setFrom('mfanefikile@gmail.com', 'phokuhle');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $reset_link = "localhost/full/reset_password.php?token=$token";
            $mail->Body = "Click this link to reset your password: <a href=\"$reset_link\">$reset_link</a>";

            $mail->send();
            $success_message = "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Forgot Password</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
        <p class="text-success"><?php echo isset($success_message) ? $success_message : ''; ?></p>
        <p class="text-danger"><?php echo isset($error_message) ? $error_message : ''; ?></p>
    </form>
</div>
</body>
</html>
