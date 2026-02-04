<?php
require_once 'dataconnect.php';
if($_SESSION['role'] == 'admin' && $_POST['action'] == 'delete') {
    $id = strip_non_alphanumeric($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM auth_user WHERE auth_user_id = :id");
    if($stmt->execute([':id' => $id])) echo "ok";
}