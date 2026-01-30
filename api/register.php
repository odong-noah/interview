<?php
require '../dbconn.php';
header('Content-Type: application/json');

$user = $_POST['username'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if user exists
$check = $conn->query("SELECT id FROM users WHERE username='$user' OR email='$email'");
if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Username or Email already taken."]);
} else {
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "User registered!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving data."]);
    }
}
?>