<?php
session_start();
require 'dbconn.php';

if(!isset($_SESSION['uid'])) { 
    header("Location: login.php"); 
    exit(); 
}

$id = $_SESSION['uid'];
$me = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: #4e73df; --success: #1cc88a; --bg: #f8f9fc; }
        body { background-color: var(--bg); font-family: 'Inter', sans-serif; color: #5a5c69; }
        .navbar { background: #fff; border-bottom: 1px solid #e3e6f0; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); margin-bottom: 1.5rem; overflow: hidden; }
        .profile-bg { background: linear-gradient(135deg, var(--primary) 0%, #224abe 100%); height: 90px; }
        .profile-avatar { width: 85px; height: 85px; border: 5px solid #fff; background: #f8f9fc; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; color: var(--primary); margin: -45px auto 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .card-header { background-color: #fff; border-bottom: 1px solid #e3e6f0; font-weight: 700; color: var(--primary); padding: 1.2rem; }
        .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.05rem; color: #858796; padding: 1rem; border: none; }
        .table tbody td { padding: 1rem; vertical-align: middle; font-size: 0.9rem; border-bottom: 1px solid #f1f1f1; }
        .badge-log { background: #e3fcef; color: #008a52; border: 1px solid #008a52; font-size: 0.75rem; font-weight: 700; padding: 5px 12px; border-radius: 50px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand navbar-light sticky-top mb-4 py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-shield-halved me-2"></i>ADMIN DASHBOARD</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            
            <!-- User Profile Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="profile-bg"></div>
                    <div class="card-body text-center">
                        <div class="profile-avatar"><i class="fas fa-user-circle"></i></div>
                        <h5 class="fw-bold mb-1 text-dark"><?php echo $me['username']; ?></h5>
                        <p class="text-muted small mb-3"><?php echo $me['email']; ?></p>
                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-3"><?php echo strtoupper($me['role']); ?></span>
                        <div class="mt-2 pt-3 border-top text-start">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted">Registered:</span>
                                <span class="fw-bold"><?php echo date('M d, Y', strtotime($me['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Panels -->
            <div class="col-lg-8">
                <h4 class="fw-bold text-dark mb-4">System Management</h4>

                <?php if($_SESSION['role'] == 'admin'): ?>
                    
                    <!-- TABLE 1: REGISTERED USERS -->
                    <div class="card">
                        <div class="card-header"><i class="fas fa-users me-2"></i>User Directory</div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $all = $conn->query("SELECT * FROM users ORDER BY id DESC");
                                    while($row = $all->fetch_assoc()) {
                                        echo "<tr>
                                            <td class='fw-bold text-dark'>{$row['username']}</td>
                                            <td class='text-muted'>{$row['email']}</td>
                                            <td><span class='badge bg-light text-dark border'>".strtoupper($row['role'])."</span></td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TABLE 2: LOGIN HISTORY (Tracks every time a user logs in) -->
                    <div class="card mt-4">
                        <div class="card-header text-success"><i class="fas fa-clock-rotate-left me-2"></i>Login Activity History</div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $logs = $conn->query("SELECT * FROM login_history ORDER BY login_time DESC LIMIT 10");
                                    if($logs->num_rows > 0) {
                                        while($log = $logs->fetch_assoc()) {
                                            echo "<tr>
                                                <td class='fw-bold text-dark'>{$log['uname']}</td>
                                                <td><span class='badge-log'>SUCCESSFUL LOGIN</span></td>
                                                <td class='text-muted small'><i class='far fa-calendar-alt me-1'></i> ".date('M d, Y | h:i A', strtotime($log['login_time']))."</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No login history available yet.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card p-5 text-center">
                        <i class="fas fa-shield-check fa-4x text-success opacity-25 mb-4"></i>
                        <h2 class="fw-bold">Your Portal is Secure</h2>
                        <p class="text-muted">Standard access granted. All activities are monitored for your security.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>