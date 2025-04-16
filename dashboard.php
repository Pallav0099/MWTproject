<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['sid'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Lifestyle Management</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Student Lifestyle Management</h1>
        </header>
        <nav>
            <a href="student.php"><button type="button" class="btn">Your Profile</button></a>
            <a href="#"><button type="button" class="btn">Courses</button></a>
            <a href="#"><button type="button" class="btn">Attendance Summary</button></a>
            <a href="clubs.php"><button type="button" class="btn">Clubs & Societies</button></a>
            <a href="logout.php"><button type="button" class="btn">Logout</button></a>
        </nav>
    </div>
    <main>
        <h3 style="text-align: center;">Checkout What's going on at our college.</h3>
        <div class="card-deck">
            <div class="card">
                <img class="card-img-top" src="static/images/campus_resized.jpg" alt="Campus Placement">
                <div class="card-body">
                    <h5 class="card-title">Campus placement drive 2024</h5>
                    <a class="card-text" href="campusplacement.php">Learn more about the 2024 Placement Stats</a>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="static/images/clubs (1).jpg" alt="Clubs & Chapters">
                <div class="card-body">
                    <h5 class="card-title">Clubs & Chapters</h5>
                    <a class="card-text" href="clubs.php">Learn more about the clubs & chapters at MUJ</a>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="static/images/oniros.jpg" alt="Oniros'25">
                <div class="card-body">
                    <h5 class="card-title">Oniros'25</h5>
                    <a class="card-text" href="oniros.php">Read more about our upcoming College festival</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 