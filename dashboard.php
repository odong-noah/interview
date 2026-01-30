<?php
session_start();
require 'dbconn.php';
if(!isset($_SESSION['uid'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="p-5">
    <h2>Welcome, <?php echo $_SESSION['uname']; ?>!</h2>
    <a href="logout.php" class="btn btn-dark">Logout</a>

    <h4 class="mt-4">My Account</h4>
    <table class="table border">
        <?php
        $id = $_SESSION['uid'];
        $me = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
        ?>
        <tr><th>Username</th><td><?php echo $me['username']; ?></td></tr>
        <tr><th>Email</th><td><?php echo $me['email']; ?></td></tr>
        <tr><th>Joined</th><td><?php echo $me['created_at']; ?></td></tr>
    </table>

    <?php if($_SESSION['role'] == 'admin'): ?>
        <div class="mt-5">
            <h3>Admin Panel</h3>
            <table class="table table-striped border">
                <tr><th>User</th><th>Email</th><th>Role</th><th>Date</th></tr>
                <?php
                $all = $conn->query("SELECT * FROM users");
                while($row = $all->fetch_assoc()) {
                    echo "<tr><td>{$row['username']}</td><td>{$row['email']}</td><td>{$row['role']}</td><td>{$row['created_at']}</td></tr>";
                }
                ?>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>