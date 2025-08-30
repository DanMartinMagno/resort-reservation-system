<?php 

session_start();
session_unset();
session_destroy();
header("location: http://localhost/Hi-Way_411/admin-panel/admins/login-admins.php");


?>