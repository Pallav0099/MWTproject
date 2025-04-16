<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_POST['sid'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $conn = getDbConnection();
    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM students WHERE sid = ? AND password = ?");
        $stmt->bind_param("ss", $sid, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($student = $result->fetch_assoc()) {
            $_SESSION['user'] = $sid;
            $_SESSION['sid'] = $student['sid'];
            $_SESSION['name'] = $student['name'];
            $_SESSION['email'] = $student['email'];
            $_SESSION['dob'] = $student['dob'];
            $_SESSION['gender'] = $student['gender'];
            $_SESSION['enrollment_date'] = $student['enrollment_date'];
            $_SESSION['phone_number'] = $student['phone_number'];
            $_SESSION['address'] = $student['address'];
            $_SESSION['branch'] = $student['branch'];
            $_SESSION['section'] = $student['section'];
            $_SESSION['semester'] = $student['semester'];
            
            setFlashMessage('Login successful!');
            header('Location: dashboard.php');
            exit();
        } else {
            setFlashMessage('Login failed. Incorrect registration number or password.', 'danger');
        }
        $stmt->close();
        $conn->close();
    } else {
        setFlashMessage('Database connection failed!', 'danger');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Student Login</h2>
            <?php
            $flashMessage = getFlashMessage();
            if ($flashMessage) {
                echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
            }
            ?>
            <form id="loginForm" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="sid" class="form-label">Student ID</label>
                    <input type="text" class="form-control" id="sid" name="sid" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="register.php">New student? Register here</a>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const sid = document.getElementById('sid').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (sid === '' || password === '') {
                alert('Please fill in all fields');
                return false;
            }
            
            if (!/^[a-zA-Z0-9]+$/.test(sid)) {
                alert('Student ID must be alphanumeric');
                return false;
            }
            
            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 