<?php
// Garissa County Admin Logout

session_start();

// remove all session data
session_unset();
session_destroy();

// redirect to Garissa County login page
header("Location: login.php");
exit;
?>