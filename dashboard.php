<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['uid'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Fetch current user details safely
$id = $_SESSION['uid'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$me = $stmt->get_result()->fetch_assoc();

if (!$me) { session_destroy(); header("Location: login.php"); exit(); }
$userRole = strtolower($me['role']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo ucfirst($userRole); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; }
        body { background-color: var(--bg); font-family: 'Inter', sans-serif; color: #2b3674; }
        .navbar { background: #fff; border-bottom: 1px solid #e0e5f2; }
        .card-custom { background: #fff; border: none; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.03); }
        .welcome-hero { background: linear-gradient(135deg, #4318FF 0%, #b4a3ff 100%); border-radius: 20px; color: white; padding: 60px 40px; }
        .table thead th { background-color: #f8fafc; color: #707eae; font-size: 0.75rem; text-transform: uppercase; border: none; padding: 15px; }
        .table tbody td { padding: 15px; border-bottom: 1px solid #f1f4f9; vertical-align: middle; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="fa-solid fa-cube me-2"></i>APP.CORE</a>
            <div class="ms-auto">
                <a href="logout.php" class="btn btn-dark btn-sm rounded-pill px-4">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        
        <?php if ($userRole === 'admin'): ?>
            <!-- ADMINISTRATOR VIEW: TABLE -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">System User Directory</h3>
                <button onclick="refreshUserList()" id="refBtn" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-sync me-1"></i> Refresh Data
                </button>
            </div>

            <div class="card-custom overflow-hidden">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php
                            $users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
                            while($row = $users->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['username']; ?></td>
                                <td class="text-muted"><?php echo $row['email']; ?></td>
                                <td><span class="badge bg-light text-primary border rounded-pill px-3"><?php echo strtoupper($row['role']); ?></span></td>
                                <td class="small text-muted"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- NORMAL USER VIEW: WELCOME MESSAGE -->
            <div class="welcome-hero shadow-lg text-center">
                <i class="fa-solid fa-circle-check fa-4x mb-4 opacity-50"></i>
                <h1 class="display-4 fw-bold">Welcome back, <?php echo $me['username']; ?>!</h1>
                <p class="lead">You are logged in as a <strong>Standard User</strong>. You have access to your personal portal.</p>
                <div class="mt-4">
                    <button class="btn btn-light rounded-pill px-5 fw-bold shadow-sm">Enter Portal</button>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script>
    function refreshUserList() {
        let btn = document.getElementById('refBtn');
        btn.disabled = true;
        btn.innerHTML = 'Updating...';

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'actions/fetch_users.php', true);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('userTableBody').innerHTML = this.responseText;
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-sync me-1"></i> Refresh Data';
            }
        };
        xhr.send();
    }
    </script>
</body>
</html>