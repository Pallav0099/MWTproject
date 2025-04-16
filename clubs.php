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
    <title>Student Clubs - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <style>
        .clubs-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .clubs-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .clubs-header h1 {
            color: #1B99D4;
            font-family: 'Caveat', cursive;
            font-size: 2.5rem;
        }
        .clubs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .club-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .club-card:hover {
            transform: translateY(-5px);
        }
        .club-card h2 {
            color: #1B99D4;
            margin-bottom: 15px;
        }
        .club-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .club-card ul {
            list-style-type: none;
            padding: 0;
        }
        .club-card li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        .club-card li:before {
            content: "•";
            color: #1B99D4;
            position: absolute;
            left: 0;
        }
        .join-button {
            display: inline-block;
            background-color: #1B99D4;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 15px;
            transition: background-color 0.3s;
        }
        .join-button:hover {
            background-color: #1680b3;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Student Clubs</h1>
        </header>
    </div>
    <main>
        <div class="clubs-container">
            <div class="clubs-header">
                <h1>Student Clubs & Organizations</h1>
                <p>Join our vibrant community of student-led organizations</p>
            </div>

            <div class="clubs-grid">
                <div class="club-card">
                    <h2>Technical Clubs</h2>
                    <ul>
                        <li>Code Club</li>
                        <li>Robotics Club</li>
                        <li>AI & ML Club</li>
                        <li>Cyber Security Club</li>
                    </ul>
                    <a href="#" class="join-button">Join Now</a>
                </div>

                <div class="club-card">
                    <h2>Cultural Clubs</h2>
                    <ul>
                        <li>Music Club</li>
                        <li>Dance Club</li>
                        <li>Drama Club</li>
                        <li>Photography Club</li>
                    </ul>
                    <a href="#" class="join-button">Join Now</a>
                </div>

                <div class="club-card">
                    <h2>Sports Clubs</h2>
                    <ul>
                        <li>Cricket Club</li>
                        <li>Football Club</li>
                        <li>Basketball Club</li>
                        <li>Athletics Club</li>
                    </ul>
                    <a href="#" class="join-button">Join Now</a>
                </div>

                <div class="club-card">
                    <h2>Social Clubs</h2>
                    <ul>
                        <li>Rotaract Club</li>
                        <li>Eco Club</li>
                        <li>Literary Club</li>
                        <li>Debate Club</li>
                    </ul>
                    <a href="#" class="join-button">Join Now</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html>