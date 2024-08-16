<?php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];

    // Ensure the uploads directory exists and is writable
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $design_path = $upload_dir . basename($_FILES['design']['name']);
    if (move_uploaded_file($_FILES['design']['tmp_name'], $design_path)) {
        $stmt = $conn->prepare("INSERT INTO designs (user_id, design_path, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $design_path, $description);

        if ($stmt->execute()) {
            $success_message = 'Design uploaded successfully!';
        } else {
            $error_message = 'Failed to upload design.';
        }
    } else {
        $error_message = 'Failed to move uploaded file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Design</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #4caf50; /* Green background */
            color: #ffeb3b; /* Yellow text */
        }
        .container {
            max-width: 400px;
            margin-top: 50px;
            background-color: #000; /* Black background for container */
            padding: 20px;
            border-radius: 5px;
            color: #ffeb3b; /* Yellow text */
        }
        .btn-primary {
            background-color: #000; /* Black button background */
            border-color: #000; /* Black button border */
            color: #4caf50; /* Green button text */
        }
        .btn-primary:hover {
            background-color: #333; /* Darker black button background on hover */
            border-color: #333; /* Darker black button border on hover */
        }
        .btn-secondary {
            background-color: #6c757d; /* Gray button background */
            border-color: #6c757d; /* Gray button border */
            color: #fff; /* White button text */
        }
        .btn-secondary:hover {
            background-color: #5a6268; /* Darker gray button background on hover */
            border-color: #545b62; /* Darker gray button border on hover */
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
        }
        .success-message {
            color: #28a745; /* Green text for success messages */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 style="text-align: center; margin-bottom: 20px;">Upload Your Design</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="design" class="form-label">Choose Design:</label>
            <input type="file" class="form-control" id="design" name="design" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Upload Design</button>
        <a href="index.php" class="btn btn-secondary">Return to Home</a>
        <p class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></p>
        <p class="success-message"><?php echo isset($success_message) ? $success_message : ''; ?></p>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
