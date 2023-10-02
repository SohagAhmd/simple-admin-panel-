<?php
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page or any other page as needed
header('location: index.php'); // Change 'login.php' to your login page
exit();
