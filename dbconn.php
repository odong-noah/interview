<?php
$conn = new mysqli("localhost", "root", "", "interview_test");
if ($conn->connect_error) { 
    die("Database connection failed."); 
}
?>