<?php
require_once 'dataconnect.php';
header('Content-Type: application/json');

$u = clean_string($_POST['u'] ?? '');
$e = clean_string($_POST['e'] ?? '');
$r = clean_string($_POST['r'] ?? '');
$p = $_POST['p'] ?? '';

if(empty($u) || empty($e) || empty($p)) {
    echo json_encode(["status" => "error", "message" => "All fields required"]);
    exit;
}

try {
    // Standard: Check existence using PDO
    $check = $conn->prepare("SELECT spr_user_id FROM spr_user WHERE spr_user_username = :u OR spr_user_email = :e LIMIT 1");
    $check->execute([':u' => $u, ':e' => $e]);
    
    if($check->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Username or Email already exists"]);
    } else {
        // Standard: Unique ID prefix + uniqid
        $uid = "SPR" . strtoupper(substr(uniqid(), 8));
        $pass_hashed = password_hash($p, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO spr_user (spr_user_id, spr_user_username, spr_user_email, spr_user_password, spr_user_role, spr_user_created_date) VALUES (:id, :u, :e, :p, :r, NOW())");
        $stmt->execute([':id'=>$uid, ':u'=>$u, ':e'=>$e, ':p'=>$pass_hashed, ':r'=>$r]);
        
        echo json_encode(["status" => "ok"]);
    }
} catch (PDOException $ex) {
    echo json_encode(["status" => "error", "message" => "ERROR H3J7622HNS"]);
}