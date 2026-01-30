<?php
session_start();
require '../dbconn.php';
header('Content-Type: application/json');

$user = $_POST['username'];
$pass = $_POST['password'];

$res = $conn->query("SELECT * FROM users WHERE username='$user'");
$row = $res->fetch_assoc();

if ($row && password_verify($pass, $row['password'])) {
    if ($row['is_active'] == 1) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['created_at'] = $row['created_at'];
        echo json_encode(["success" => true, "redirect" => "dashboard.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Account is inactive."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid credentials."]);
}
?>