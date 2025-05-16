<?php
session_start();
session_unset();
session_destroy();

// Redirect to home page using a relative path
header("Location: home.php");
exit();
?>