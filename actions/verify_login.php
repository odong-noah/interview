<?php
session_start();
require '../dbconn.php';
header('Content-Type: application/json');

$u = $_POST['user'];
$p = $_POST['pass'];

$res = $conn->query("SELECT * FROM users WHERE username='$u'");
$user = $res->fetch_assoc();

if($user && password_verify($p, $user['password'])) {
    if($user['is_active'] == 1) {
        $_SESSION['uid'] = $user['id'];
        $_SESSION['uname'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        echo json_encode(["status" => "ok", "link" => "dashboard.php"]);
    } else {
        echo json_encode(["status" => "err", "message" => "Account Inactive"]);
    }
} else {
    echo json_encode(["status" => "err", "message" => "Wrong details"]);
}
?>