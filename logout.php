<?php
// logout script
session_start();
session_destroy();

// redirect back to the login page
header('Location: login.php');
?>