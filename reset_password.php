<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Update the user's password and invalidate the token
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $new_password, $user_id);
        if ($stmt->execute()) {
            $success_message = "Your password has been reset successfully.";
            // Redirect to login or another page
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error updating password: " . $conn->error;
        }
    } else {
        $error_message = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Reset Password</h2>
    <form method="POST">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
        <p class="text-success"><?php echo isset($success_message) ? $success_message : ''; ?></p>
        <p class="text-danger"><?php echo isset($error_message) ? $error_message : ''; ?></p>
    </form>
</div>
</body>
</html>
