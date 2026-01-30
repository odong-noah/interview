<?php
require '../dbconn.php';
header('Content-Type: application/json');

$u = $_POST['user'];
$e = $_POST['email'];
$p = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$check = $conn->query("SELECT id FROM users WHERE username='$u' OR email='$e'");
if($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Username/Email taken"]);
} else {
    $conn->query("INSERT INTO users (username, email, password) VALUES ('$u', '$e', '$p')");
    echo json_encode(["status" => "ok", "message" => "User Registered!"]);
}
?>