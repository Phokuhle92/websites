<?php
session_start();
require_once "config/database.php";

// Check if the user is logged in as an admin
if (!isset($_SESSION["admin_logged_in"]) || !$_SESSION["admin_logged_in"]) {
    header("Location: admin_login.php");
    exit();
}

// Query to retrieve designs from the database
$sql = "SELECT designs.*, users.full_name FROM designs JOIN users ON designs.user_id = users.id";
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Designs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #4caf50; /* Green background */
            color: #ffeb3b; /* Yellow text */
        }
        .container {
            max-width: 1200px;
            background-color: #000; /* Black background for container */
            color: #ffeb3b; /* Yellow text */
            padding: 20px;
            border-radius: 5px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table img {
            max-width: 300px;
            height: auto;
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
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Uploaded Designs</h2>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Design</th>
                <th>Description</th>
                <th>Uploaded At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                    <td>
                        <?php
                        $filePath = htmlspecialchars($row["design_path"]);
                        if (file_exists($filePath)): ?>
                            <img src="<?php echo $filePath; ?>" alt="Design">
                        <?php else: ?>
                            <p class="text-danger">File not found</p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row["description"]); ?></td>
                    <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
</body>
</html>
