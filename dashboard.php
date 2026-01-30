<?php
session_start();
require 'dbconn.php';
if(!isset($_SESSION['uid'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e3e6f0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
            color: #4e73df;
        }
        .admin-section {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
        }
        .table thead th {
            background-color: #4e73df;
            color: white;
            border: none;
        }
        .welcome-text {
            color: #5a5c69;
        }
    </style>
</head>
<body>

    <!-- Professional Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="fas fa-chart-line me-2"></i>APP-PORTAL</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 d-none d-md-inline text-muted">Signed in as: <strong><?php echo $_SESSION['uname']; ?></strong></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Left Side: User Info -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-circle me-2"></i> My Account Profile
                    </div>
                    <div class="card-body">
                        <?php
                        $id = $_SESSION['uid'];
                        $me = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
                        ?>
                        <div class="text-center mb-4">
                            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                            <h5><?php echo $me['username']; ?></h5>
                            <span class="badge bg-primary rounded-pill"><?php echo ucfirst($_SESSION['role']); ?></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Email Address</label>
                            <span class="fw-bold"><?php echo $me['email']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted d-block">Account Created</label>
                            <span class="fw-bold"><?php echo date('M d, Y', strtotime($me['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Dashboard Content / Admin Panel -->
            <div class="col-lg-8">
                <div class="welcome-text mb-4">
                    <h2 class="fw-bold">Welcome back, <?php echo $_SESSION['uname']; ?>!</h2>
                    <p class="text-muted">Here is what's happening with your account today.</p>
                </div>

                <?php if($_SESSION['role'] == 'admin'): ?>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-shield me-2"></i> Admin Management Panel</span>
                            <span class="badge bg-success small">System Active</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Join Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $all = $conn->query("SELECT * FROM users");
                                        while($row = $all->fetch_assoc()) {
                                            $roleBadge = ($row['role'] == 'admin') ? 'bg-danger' : 'bg-secondary';
                                            echo "<tr>
                                                <td class='ps-4 fw-bold text-dark'>{$row['username']}</td>
                                                <td>{$row['email']}</td>
                                                <td><span class='badge {$roleBadge}'>{$row['role']}</span></td>
                                                <td class='text-muted small'>".date('Y-m-d', strtotime($row['created_at']))."</td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center py-3">
                            <small class="text-muted font-italic">End of user database</small>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Standard User View (Optional) -->
                    <div class="card p-5 text-center">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4>Your account is in good standing.</h4>
                        <p class="text-muted">You have access to all standard user features.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
=======
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
>>>>>>> 7073fbde480adff11f63309c4fe9062875202171
</body>
</html>