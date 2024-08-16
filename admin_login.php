<?php
session_start();

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $adminUsername = 'admin'; // Admin username
    $adminPassword = 'adminpassword'; // Admin password (hashed in real scenarios)

    if ($username === $adminUsername && $password === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_view.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Invalid username or password.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 20px;">Admin Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-custom" name="login">Login</button>
        </form>
    </div>
</body>
</html>
