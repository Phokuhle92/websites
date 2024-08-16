<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query to get user details
    $stmt = $conn->prepare("SELECT id, full_name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $full_name, $hashed_password, $is_admin);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['is_admin'] = $is_admin;
            
            // Redirect to appropriate page
            if ($is_admin) {
                header('Location: admin_view.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $error_message = 'Invalid email or password.';
        }
    } else {
        $error_message = 'Invalid email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2 style="text-align: center; margin-bottom: 20px;">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-custom">Login</button>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
