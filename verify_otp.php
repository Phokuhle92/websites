<?php
session_start();
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    // Check if the OTP is correct
    $stmt = $conn->prepare("SELECT * FROM users WHERE otp = ?");
    $stmt->bind_param("s", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is correct, update the user's status to verified
        $stmt->close(); // Close the previous statement

        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, otp = NULL WHERE otp = ?");
        $stmt->bind_param("s", $otp);
        if ($stmt->execute()) {
            echo "OTP verified successfully!";
            // Redirect to login or another page
            header("Location: login.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid OTP.";
    }
    $stmt->close(); // Close the statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #4caf50; /* Green background */
            color: #fff; /* White text */
        }
        .container {
            background-color: #000; /* Black background for container */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            padding: 20px;
            color: #ffeb3b; /* Yellow text */
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
        .error-message {
            color: #dc3545; /* Red text for error messages */
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Verify OTP</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="otp" class="form-label">OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
</body>
</html>
