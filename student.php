<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    setFlashMessage('Please log in first!', 'danger');
    header('Location: login.php');
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $sid = $_SESSION['sid'];

    $errors = [];
    
    if (!empty($phone_number) && !preg_match('/^\d{10}$/', $phone_number)) {
        $errors[] = 'Invalid phone number. Must be 10 digits.';
    }
    if (!empty($semester) && !is_numeric($semester)) {
        $errors[] = 'Semester must be a number.';
    }

    if (empty($errors)) {
        $conn = getDbConnection();
        if ($conn) {
            $updates = [];
            $params = [];
            $types = '';

            if (!empty($password)) {
                $updates[] = "password = ?";
                $params[] = $password;
                $types .= 's';
            }
            if (!empty($phone_number)) {
                $updates[] = "phone_number = ?";
                $params[] = $phone_number;
                $types .= 's';
            }
            if (!empty($address)) {
                $updates[] = "address = ?";
                $params[] = $address;
                $types .= 's';
            }
            if (!empty($semester)) {
                $updates[] = "semester = ?";
                $params[] = $semester;
                $types .= 's';
            }

            if (!empty($updates)) {
                $query = "UPDATE students SET " . implode(", ", $updates) . " WHERE sid = ?";
                $types .= 's';
                $params[] = $sid;

                $stmt = $conn->prepare($query);
                $stmt->bind_param($types, ...$params);
                
                if ($stmt->execute()) {
                    // Update session data
                    if (!empty($phone_number)) $_SESSION['phone_number'] = $phone_number;
                    if (!empty($address)) $_SESSION['address'] = $address;
                    if (!empty($semester)) $_SESSION['semester'] = $semester;
                    
                    setFlashMessage('Profile updated successfully!', 'success');
                } else {
                    setFlashMessage('Failed to update profile.', 'danger');
                }
                $stmt->close();
            }
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

// Get current user data from session
$sid = $_SESSION['sid'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$dob = $_SESSION['dob'];
$phone_number = $_SESSION['phone_number'];
$gender = $_SESSION['gender'];
$enrollment_date = $_SESSION['enrollment_date'];
$address = $_SESSION['address'];
$branch = $_SESSION['branch'];
$section = $_SESSION['section'];
$semester = $_SESSION['semester'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 60px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Student Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="student.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.php">Courses</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-light">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container profile-container">
        <?php
        $flashMessage = getFlashMessage();
        if ($flashMessage) {
            echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
        }
        ?>
        
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($name, 0, 1)); ?>
            </div>
            <h2><?php echo htmlspecialchars($name); ?></h2>
            <p class="text-muted">Student ID: <?php echo htmlspecialchars($sid); ?></p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4>Personal Information</h4>
                <table class="table">
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td><?php echo htmlspecialchars($dob); ?></td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td><?php echo htmlspecialchars($gender); ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number:</th>
                        <td><?php echo htmlspecialchars($phone_number); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($address); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h4>Academic Information</h4>
                <table class="table">
                    <tr>
                        <th>Branch:</th>
                        <td><?php echo htmlspecialchars($branch); ?></td>
                    </tr>
                    <tr>
                        <th>Section:</th>
                        <td><?php echo htmlspecialchars($section); ?></td>
                    </tr>
                    <tr>
                        <th>Semester:</th>
                        <td><?php echo htmlspecialchars($semester); ?></td>
                    </tr>
                    <tr>
                        <th>Enrollment Date:</th>
                        <td><?php echo htmlspecialchars($enrollment_date); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="mt-4">
            <h4>Update Profile</h4>
            <form id="updateForm" method="POST" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($address); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Current Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester" value="<?php echo htmlspecialchars($semester); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            const phone = document.getElementById('phone_number').value.trim();
            const semester = document.getElementById('semester').value.trim();
            
            if (phone && !/^\d{10}$/.test(phone)) {
                alert('Phone number must be exactly 10 digits');
                return false;
            }
            
            if (semester && !/^\d+$/.test(semester)) {
                alert('Semester must be a valid number');
                return false;
            }
            
            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 