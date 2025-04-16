<?php
require_once 'config.php';

// Clear all session data
session_unset();
session_destroy();

// Redirect to login page with success message
setFlashMessage('Logged out successfully!', 'success');
header('Location: login.php');
exit();
?> 