<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['sid'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_SESSION['sid'];
    $flexi_core_2 = $_POST['flexi_core_2'] ?? '';
    $program_elective_1 = $_POST['program_elective_1'] ?? '';
    
    // Check if student has already selected courses
    $check_query = "SELECT * FROM elective_courses WHERE sid = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $sid);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "You have already selected your elective courses!";
    } else {
        // Insert selected courses
        $insert_query = "INSERT INTO elective_courses (sid, flexi_core_2, program_elective_1) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sss", $sid, $flexi_core_2, $program_elective_1);
        
        if ($insert_stmt->execute()) {
            $success = "Elective courses selected successfully!";
        } else {
            $error = "Failed to select courses. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick Elective Courses - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/styles.css">
    <link rel="stylesheet" href="static/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Pick Elective Courses</h1>
        </header>
    </div>
    <main>
        <div class="body-centered-div">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <p>
                You can only pick elective courses once!
            </p>
            <form action="pick_elective_courses.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="flexi_core_2">Flexi Core-2:</label>
                    <select class="form-select" id="flexi_core_2" name="flexi_core_2" aria-label="Select Flexi Core-2" required>
                        <option value="" selected disabled>Select Flexi Core-2</option>
                        <option value="INT2220,Data Communication,Flexi Core-2">Data Communication</option>
                        <option value="INT2221,Modern Web Technologies,Flexi Core-2">Modern Web Technologies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="program_elective_1">Program Elective-1:</label>
                    <select class="form-select" id="program_elective_1" name="program_elective_1" aria-label="Select Program Elective-1" required>
                        <option value="" selected disabled>Select Program Elective-1</option>
                        <option value="INT2240,Computer Organization & Microprocessor,Program Elective-1">Computer Organization & Microprocessor</option>
                        <option value="INT2241,IoT Fundamentals,Program Elective-1">IoT Fundamentals</option>
                        <option value="INT2242,Python Programming,Program Elective-1">Python Programming</option>
                    </select>
                </div>
                <button type="submit" class="btn-pages">Confirm Selection</button>
            </form>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 