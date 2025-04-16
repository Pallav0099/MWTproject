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
    <title>Events - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <style>
        .events-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .events-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .events-header h1 {
            color: #1B99D4;
            font-family: 'Caveat', cursive;
            font-size: 2.5rem;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .event-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .event-card h2 {
            color: #1B99D4;
            margin-bottom: 15px;
        }
        .event-card .date {
            color: #666;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .event-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .event-card .location {
            color: #1B99D4;
            font-weight: bold;
        }
        .register-button {
            display: inline-block;
            background-color: #1B99D4;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 15px;
            transition: background-color 0.3s;
        }
        .register-button:hover {
            background-color: #1680b3;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Events</h1>
        </header>
    </div>
    <main>
        <div class="events-container">
            <div class="events-header">
                <h1>Upcoming Events</h1>
                <p>Stay updated with our latest events and activities</p>
            </div>

            <div class="events-grid">
                <div class="event-card">
                    <h2>Tech Symposium 2024</h2>
                    <div class="date">March 15-16, 2024</div>
                    <p>A two-day technical symposium featuring workshops, hackathons, and expert talks on emerging technologies.</p>
                    <div class="location">Venue: Main Auditorium</div>
                    <a href="#" class="register-button">Register Now</a>
                </div>

                <div class="event-card">
                    <h2>Cultural Fest</h2>
                    <div class="date">April 5-7, 2024</div>
                    <p>Annual cultural festival showcasing music, dance, drama, and various cultural performances.</p>
                    <div class="location">Venue: Open Air Theater</div>
                    <a href="#" class="register-button">Register Now</a>
                </div>

                <div class="event-card">
                    <h2>Sports Meet</h2>
                    <div class="date">April 20-22, 2024</div>
                    <p>Inter-department sports competition featuring various athletic events and team sports.</p>
                    <div class="location">Venue: Sports Complex</div>
                    <a href="#" class="register-button">Register Now</a>
                </div>

                <div class="event-card">
                    <h2>Career Fair</h2>
                    <div class="date">May 10, 2024</div>
                    <p>Opportunity to meet with top recruiters and explore internship and job opportunities.</p>
                    <div class="location">Venue: Convention Center</div>
                    <a href="#" class="register-button">Register Now</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 