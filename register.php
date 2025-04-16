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
    <title>Register - Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .register-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="text-center mb-4">Student Registration</h2>
            <?php
            $flashMessage = getFlashMessage();
            if ($flashMessage) {
                echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
            }
            ?>
            <form id="registerForm" method="POST" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sid" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="sid" name="sid" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="enrollment_date" class="form-label">Enrollment Date</label>
                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="branch" class="form-label">Branch</label>
                        <input type="text" class="form-control" id="branch" name="branch" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="section" class="form-label">Section</label>
                        <input type="text" class="form-control" id="section" name="section" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" class="form-control" id="semester" name="semester" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php">Already registered? Login here</a>
            </div>
        </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 