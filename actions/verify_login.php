<?php
session_start();
// Use require_once for professional consistency
require_once '../dbconn.php';
header('Content-Type: application/json');

// 1. Capture and sanitize inputs
$u = $_POST['user'] ?? '';
$p = $_POST['pass'] ?? '';

// 2. Use Prepared Statements to prevent SQL Injection
$stmt = $conn->prepare("SELECT id, username, password, role, is_active FROM users WHERE username = ?");
$stmt->bind_param("s", $u);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 3. Verification Logic
if($user && password_verify($p, $user['password'])) {
    
    // Check if the account is active (if you have an is_active column)
    // If you don't have this column yet, you can remove this inner IF
    if($user['is_active'] == 1) {
        
        // SET SESSIONS: This is what the dashboard uses to decide what to show
        $_SESSION['uid'] = $user['id'];
        $_SESSION['uname'] = $user['username'];
        $_SESSION['role'] = strtolower($user['role']); // Store role in lowercase for easier comparison
        
        // Send success response
        echo json_encode([
            "status" => "ok", 
            "link" => "dashboard.php"
        ]);
        
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Your account is currently disabled. Please contact the Administrator."
        ]);
    }
} else {
    // Generic error message for security (don't tell them if it was the user or pass that was wrong)
    echo json_encode([
        "status" => "error", 
        "message" => "Invalid username or password credentials."
    ]);
}

$stmt->close();
$conn->close();
?>