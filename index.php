<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #4caf50; /* Green background */
            color: #fff; /* White text color */
        }
        .container {
            background-color:  #4caf50; /* Black background for container */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            color: #ffeb3b; /* Yellow text color */
        }
        .btn-primary, .btn-custom {
            background-color: #000; /* Black button background */
            color: #4caf50; /* Green button text */
            border: none;
            margin: 0 5px; /* Horizontal margin between buttons */
        }
        .btn-primary:hover, .btn-custom:hover {
            background-color: #333; /* Darker black button background on hover */
        }
        .custom-img {
            width: 200px; /* Smaller image size */
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto 20px; /* Center the image and add bottom margin */
        }
        .btn-success, .btn-danger, .btn-info {
            border: none;
            color: #fff; /* White button text color */
        }
        .btn-success {
            background-color: #4caf50; /* Green button background */
        }
        .btn-danger {
            background-color: #f44336; /* Red button background */
        }
        .btn-info {
            background-color: #2196f3; /* Blue button background */
        }
        .btn-success:hover {
            background-color: #388e3c; /* Darker green on hover */
        }
        .btn-danger:hover {
            background-color: #c62828; /* Darker red on hover */
        }
        .btn-info:hover {
            background-color: #1976d2; /* Darker blue on hover */
        }
        .btn-group-horizontal {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
            margin-bottom: 20px; /* Space below the button group */
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .carousel-item img {
            object-fit: cover;
            height: 500px;
            width: 100%;
        }
        .social-links {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .social-links a {
            color: #4caf50;
            font-size: 24px;
            text-decoration: none;
        }
        .social-links a:hover {
            color: #ffeb3b;
        }
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #000;
            color:blue ;
            border: none;
        }
        .btn-social:hover {
            background-color: #333;
            color: #ffeb3b;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <header>
        <div class="btn-group btn-group-horizontal">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="upload_design.php" class="btn btn-custom">Design</a>
                
                <a href="logout.php" class="btn btn-custom">Logout</a>
            <?php else: ?>
                <a href="signup.php" class="btn btn-custom">Sign Up</a>
                <a href="login.php" class="btn btn-custom">Login</a>
                <a href="admin_login.php" class="btn btn-custom">Admin Login</a>
            <?php endif; ?>
        </div>
        <h2>Welcome to Phokuhle Dlamini Website</h2>
        <div class="social-links">
            <a href="https://www.facebook.com/PhokuhleDlamini" target="_blank" class="btn-social"><i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/PhokuhleDlamini" target="_blank" class="btn-social"><i class="fab fa-x"></i></a>
            <a href="https://www.instagram.com/PhokuhleDlamini" target="_blank" class="btn-social"><i class="fab fa-instagram"></i></a>
        </div>
    </header>

    <!-- Carousel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slide1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Phokuhle Design</h5>
                    <p>It's your choice to select</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/slide2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Phokuhle Design</h5>
                    <p>It's your choice to select</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/slide4.jpg" class="d-block w-100" alt="Slide 4">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Phokuhle Design</h5>
                    <p>It's your choice to select</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="mt-5">
        <h3>About This Website</h3>
        <p>This website is designed to facilitate easy interaction between users and the admin. Users can sign up, log in, and upload designs. The admin can view and manage these designs. Our goal is to provide a seamless experience for both users and administrators.</p>
    </section>

    <p><a href="owner_profile.php" class="btn btn-custom">View Admin Profile</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
