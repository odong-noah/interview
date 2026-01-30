<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "interview_test");
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection failed. Please try again later.");
}
?>