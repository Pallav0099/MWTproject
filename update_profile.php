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
    $semester = $_POST['semester'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    
    $updates = [];
    $params = [];
    $types = '';
    
    // Validate and prepare updates
    if (!empty($semester)) {
        if (!is_numeric($semester) || $semester < 1 || $semester > 8) {
            $error = "Invalid semester value. Must be between 1 and 8.";
        } else {
            $updates[] = "semester = ?";
            $params[] = $semester;
            $types .= 'i';
        }
    }
    
    if (!empty($password)) {
        if (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            $updates[] = "password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
            $types .= 's';
        }
    }
    
    if (!empty($phone_number)) {
        if (!preg_match('/^\d{10}$/', $phone_number)) {
            $error = "Invalid phone number. Must be 10 digits.";
        } else {
            $updates[] = "phone_number = ?";
            $params[] = $phone_number;
            $types .= 's';
        }
    }
    
    if (!empty($address)) {
        $updates[] = "address = ?";
        $params[] = $address;
        $types .= 's';
    }
    
    // If no errors and there are updates to make
    if (!isset($error) && !empty($updates)) {
        $query = "UPDATE students SET " . implode(", ", $updates) . " WHERE sid = ?";
        $types .= 's';
        $params[] = $sid;
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Manipal University Jaipur</title>
    <link rel="stylesheet" href="static/styles.css">
    <link rel="stylesheet" href="static/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-container">
        <header>
            <h1>Update Profile</h1>
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
                Leave the ones you do NOT wish to update empty!
            </p>
            <form action="update_profile.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="semester" class="form-label">Semester:</label>
                    <select class="form-select" id="semester" name="semester" aria-label="Select your semester">
                        <option value="" selected disabled>Select your Semester</option>
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
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="setup a new password">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Enter your full address">
                </div>
                <button type="submit" class="btn-pages">Update</button>
            </form>
        </div>
    </main>
    <footer>
        <p style="text-align: center; color: #666;">Manipal University Jaipur - All rights reserved</p>
    </footer>
</body>
</html> 