<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_POST['sid'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $enrollment_date = $_POST['enrollment_date'] ?? '';
    $address = $_POST['address'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $section = $_POST['section'] ?? '';
    $semester = $_POST['semester'] ?? '';

    $errors = [];
    
    // Server-side validation
    if (!preg_match('/^[a-zA-Z0-9]+$/', $sid)) {
        $errors[] = 'Student ID must be alphanumeric.';
    }
    if (!preg_match('/^\d{10}$/', $phone_number)) {
        $errors[] = 'Invalid phone number. Must be 10 digits.';
    }
    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = 'Invalid gender selection.';
    }
    if (!is_numeric($semester)) {
        $errors[] = 'Semester value must be an integer.';
    }

    if (empty($errors)) {
        $conn = getDbConnection();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO students (sid, password, email, name, dob, phone_number, gender, enrollment_date, address, branch, section, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss", $sid, $password, $email, $name, $dob, $phone_number, $gender, $enrollment_date, $address, $branch, $section, $semester);
            
            if ($stmt->execute()) {
                setFlashMessage('Registration successful! Please log in.', 'success');
                header('Location: login.php');
                exit();
            } else {
                setFlashMessage('Registration failed due to a database error.', 'danger');
            }
            $stmt->close();
            $conn->close();
        } else {
            setFlashMessage('Database connection failed!', 'danger');
        }
    } else {
        foreach ($errors as $error) {
            setFlashMessage($error, 'danger');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Register for Student Portal</h1>
        </header>
    </div>
    <main>
        <div class="login-container">
            <?php
            $flashMessage = getFlashMessage();
            if ($flashMessage) {
                echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
            }
            ?>
            <form action="register.php" method="post" class="login-form" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="sid">Student ID:</label>
                    <input type="text" id="sid" name="sid" placeholder="Enter your student ID" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="branch" class="form-label">Branch:</label>
                    <select id="branch" name="branch" class="form-select" required aria-label="Select your branch">
                        <option selected disabled>Select your Branch</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester" class="form-label">Semester:</label>
                    <select id="semester" name="semester" class="form-select" required aria-label="Select your semester">
                        <option selected disabled>Select your Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="section" class="form-label">Section:</label>
                    <select id="section" name="section" class="form-select" required aria-label="Select your section">
                        <option selected disabled>Select your Section</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="gender" class="form-label">Gender:</label>
                    <select class="form-select" id="gender" name="gender" required aria-label="Select your gender">
                        <option selected disabled>Select your gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="enrollment_date">Enrollment Date:</label>
                    <input type="date" id="enrollment_date" name="enrollment_date" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Enter your full address" required>
                </div>
                <button type="submit" class="btn-login">Register</button>
                <p style="text-align: center; margin-top: 10px;">
                    Already have an account? <a href="login.php" style="color: #1B99D4;">Login Here</a>
                </p>
            </form>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>

    <script>
        function validateForm() {
            const sid = document.getElementById('sid').value.trim();
            const phone = document.getElementById('phone_number').value.trim();
            const semester = document.getElementById('semester').value.trim();
            
            if (!/^[a-zA-Z0-9]+$/.test(sid)) {
                alert('Student ID must be alphanumeric');
                return false;
            }
            
            if (!/^\d{10}$/.test(phone)) {
                alert('Phone number must be exactly 10 digits');
                return false;
            }
            
            if (!/^\d+$/.test(semester)) {
                alert('Semester must be a valid number');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html> 