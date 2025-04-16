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
    <title>Campus Placement - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <style>
        .placement-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .placement-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .placement-header h1 {
            color: #1B99D4;
            font-family: 'Caveat', cursive;
            font-size: 2.5rem;
        }
        .placement-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .placement-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .placement-card h2 {
            color: #1B99D4;
            margin-bottom: 15px;
        }
        .placement-card p {
            color: #666;
            line-height: 1.6;
        }
        .placement-card ul {
            list-style-type: none;
            padding: 0;
        }
        .placement-card li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        .placement-card li:before {
            content: "•";
            color: #1B99D4;
            position: absolute;
            left: 0;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat-card {
            background-color: #1B99D4;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-card h3 {
            font-size: 2rem;
            margin: 0;
        }
        .stat-card p {
            margin: 5px 0 0;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Campus Placement</h1>
        </header>
    </div>
    <main>
        <div class="placement-container">
            <div class="placement-header">
                <h1>Campus Placement Program</h1>
                <p>Empowering students for successful careers</p>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <h3>95%</h3>
                    <p>Placement Rate</p>
                </div>
                <div class="stat-card">
                    <h3>200+</h3>
                    <p>Recruiting Companies</p>
                </div>
                <div class="stat-card">
                    <h3>₹12LPA</h3>
                    <p>Highest Package</p>
                </div>
            </div>

            <div class="placement-content">
                <div class="placement-card">
                    <h2>Placement Process</h2>
                    <ul>
                        <li>Pre-placement talks by companies</li>
                        <li>Resume building workshops</li>
                        <li>Mock interviews and GD sessions</li>
                        <li>Technical and aptitude tests</li>
                        <li>Final interviews and selection</li>
                    </ul>
                </div>

                <div class="placement-card">
                    <h2>Training Programs</h2>
                    <ul>
                        <li>Technical skill enhancement</li>
                        <li>Soft skills development</li>
                        <li>Communication workshops</li>
                        <li>Industry-specific training</li>
                        <li>Personality development</li>
                    </ul>
                </div>

                <div class="placement-card">
                    <h2>Our Recruiters</h2>
                    <p>We have strong relationships with leading companies across various sectors:</p>
                    <ul>
                        <li>Technology Giants</li>
                        <li>Financial Institutions</li>
                        <li>Consulting Firms</li>
                        <li>Manufacturing Companies</li>
                        <li>Startups and SMEs</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 