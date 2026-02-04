<?php 
require_once 'dataconnect.php';
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Sparrow Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7fe; padding-top: 50px; font-family: sans-serif; }
        .card-custom { background: white; border-radius: 20px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.03); padding: 30px; }
        .welcome-hero { background: #4318FF; color: white; border-radius: 24px; padding: 60px 40px; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold">Hello, <?php echo clean_string($_SESSION['username']); ?></h2>
        <a href="logout.php" class="btn btn-dark rounded-pill px-4">Logout</a>
    </div>

    <?php if($role == 'admin'): ?>
        <div class="card-custom">
            <h5 class="fw-bold mb-4">All Registered Users</h5>
            <table class="table">
                <thead><tr class="text-muted small"><th>USERNAME</th><th>EMAIL</th><th>ROLE</th></tr></thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM spr_user WHERE spr_user_role = 'user'");
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td class="fw-bold"><?php echo $row['spr_user_username']; ?></td>
                        <td><?php echo $row['spr_user_email']; ?></td>
                        <td><span class="badge bg-light text-primary rounded-pill px-3">USER</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="welcome-hero text-center shadow-lg">
            <h1 class="display-4 fw-bold">Welcome back!</h1>
            <p class="lead opacity-75">Your normal user account is active. Enjoy your dashboard.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>