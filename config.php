<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'pallav');
define('DB_PASS', 'damnboi');
define('DB_NAME', 'students_db');

// start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection function
function getDbConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        error_log("Database Connection Error: " . $e->getMessage());
        return null;
    }
}

// Flash message helper functions
function setFlashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}
?> 