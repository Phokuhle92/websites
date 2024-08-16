<?php
require_once 'config/database.php'; // Ensure this path is correct
require 'vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Check if passwords match
    if ($password !== $repeat_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = 'Email already registered.';
        } else {
            $otp = rand(100000, 999999); // Generate a 6-digit OTP
            $otp_expiration = date("Y-m-d H:i:s", strtotime("+15 minutes")); // OTP valid for 15 minutes

            $password_hashed = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, otp, otp_expiration) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $password_hashed, $otp, $otp_expiration);

            if ($stmt->execute()) {
                // Send OTP email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                    $mail->SMTPAuth = true; // Enable SMTP authentication
                    $mail->Username = 'mfanefikile@gmail.com'; // Your Gmail address
                    $mail->Password = 'blcc hvvi rrll ycqz'; // Your Gmail app password
                    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
                    $mail->Port = 587; // TCP port to connect to

                    // Set email format to HTML
                    $mail->isHTML(true);
                    $mail->setFrom('mfanefikile@gmail.com', 'phokuhle');
                    $mail->addAddress($email, $name); // Add a recipient

                    $mail->Subject = 'Email Verification OTP';
                    $mail->Body = "Your OTP for email verification is: <b>$otp</b>";

                    $mail->send();
                    $success_message = 'Registration successful! Please check your email for OTP verification.';
                    header("Location: verify_otp.php?email=" . urlencode($email));
                    exit();
                } catch (Exception $e) {
                    $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Beauty Store</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #4caf50; /* Green background */
            color: #fff; /* White text color */
        }
        .container {
            background-color: #000; /* Black background for container */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            padding: 20px;
            color: #ffeb3b; /* Yellow text color */
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .btn-primary, .btn-custom {
            background-color: #000; /* Black button background */
            color: #4caf50; /* Green button text */
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-primary:hover, .btn-custom:hover {
            background-color: #333; /* Darker black button background on hover */
        }
        .form-control {
            background-color: #000; /* Black input background */
            color: #ffeb3b; /* Yellow input text */
            border: 1px solid #4caf50; /* Green input border */
            border-radius: 5px;
        }
        .form-control::placeholder {
            color: #ffeb3b; /* Yellow placeholder text */
        }
        .error-message, .success-message {
            text-align: center;
            margin-top: 10px;
        }
        .error-message {
            color: #dc3545; /* Red text for error messages */
        }
        .success-message {
            color: #28a745; /* Green text for success messages */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 style="text-align: center; margin-bottom: 20px;">Sign Up</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="repeat_password">Repeat Password:</label>
            <input type="password" class="form-control" id="repeat_password" name="repeat_password" required>
        </div>
        <button type="submit" class="btn btn-custom">Sign Up</button>
        <p class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></p>
        <p class="success-message"><?php echo isset($success_message) ? $success_message : ''; ?></p>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
