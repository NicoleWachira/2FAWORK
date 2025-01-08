<?php
session_start();
session_destroy(); // Destroy the session

// Redirect to login page
header("Location: Login.html");
exit();
?>
