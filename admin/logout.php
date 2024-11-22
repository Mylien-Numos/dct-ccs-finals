<?php
    // Logout Code Here
    session_start();
session_destroy();
// Redirect back to the login page
header("Location: index.php");
exit();
?>
