<?php
require_once 'dataconnect.php';
header('Content-Type: application/json');

$u = clean_string($_POST['u'] ?? '');
$p = $_POST['p'] ?? '';

try {
    $stmt = $conn->prepare("SELECT * FROM spr_user WHERE spr_user_username = :u");
    $stmt->execute([':u' => $u]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($p, $user['spr_user_password'])) {
        $_SESSION['user_id'] = $user['spr_user_id'];
        $_SESSION['username'] = $user['spr_user_username'];
        $_SESSION['role'] = $user['spr_user_role'];
        echo json_encode(["status" => "ok"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    }
} catch (PDOException $ex) {
    echo json_encode(["status" => "error", "message" => "ERROR J3DJS7SGHSJS"]);
}