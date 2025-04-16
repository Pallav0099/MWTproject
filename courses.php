<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['sid'])) {
    header('Location: login.php');
    exit();
}

$sid = $_SESSION['sid'];

// Fetch student's branch and semester
$student_query = "SELECT branch, semester FROM students WHERE sid = ?";
$student_stmt = $conn->prepare($student_query);
$student_stmt->bind_param("s", $sid);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student = $student_result->fetch_assoc();

// Fetch regular courses based on branch and semester
$courses_query = "SELECT * FROM courses WHERE branch = ? AND semester = ?";
$courses_stmt = $conn->prepare($courses_query);
$courses_stmt->bind_param("si", $student['branch'], $student['semester']);
$courses_stmt->execute();
$courses_result = $courses_stmt->get_result();
$courses = $courses_result->fetch_all(MYSQLI_ASSOC);

// Fetch elective courses
$elective_query = "SELECT * FROM elective_courses WHERE sid = ?";
$elective_stmt = $conn->prepare($elective_query);
$elective_stmt->bind_param("s", $sid);
$elective_stmt->execute();
$elective_result = $elective_stmt->get_result();
$student_elective_courses = $elective_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/styles.css">
    <link rel="stylesheet" href="static/bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Courses</title>
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Courses</h1>
        </header>
        <nav>
            <a href="dashboard.php" class="btn">Dashboard</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </div>

    <div class="body-centered-div">
        <?php if (!empty($courses)): ?>
        <h2>Courses for Semester <?php echo htmlspecialchars($student['semester']); ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Credits</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $index => $course): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($course['cid']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['credits']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No courses found for your branch and semester.</p>
        <?php endif; ?>

        <?php if (!empty($student_elective_courses)): ?>
        <h2>Your Selected Elective Courses</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Credits</th>
                    <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student_elective_courses as $index => $course): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['credits']); ?></td>
                    <td><?php echo htmlspecialchars($course['category']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Update your elective courses first!</p>
        <?php endif; ?>

        <div style="padding-left: 8vw;">
            <a href="pick_elective_courses.php"><button type="button" class="btn-pages">Pick Elective Courses</button></a>
        </div>
    </div>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 