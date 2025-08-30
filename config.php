<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_results";

$con = new mysqli($host, $user, $pass, $db);
if ($con->connect_error) die("DB Connection Failed: " . $con->connect_error);
?>
