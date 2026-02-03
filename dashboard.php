<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['uid'])) { header("Location: login.php"); exit(); }

$id = $_SESSION['uid'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$me = $stmt->get_result()->fetch_assoc();

$userRole = strtolower($me['role']); // Ensure we use role from DB for real-time security
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | AppCore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; }
        body { background-color: var(--bg); font-family: 'Inter', sans-serif; color: #2b3674; }
        .navbar { background: #fff; border-bottom: 1px solid #e0e5f2; }
        .card-custom { background: #fff; border: none; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.02); }
        .welcome-hero { background: linear-gradient(135deg, #4318FF 0%, #b4a3ff 100%); border-radius: 24px; color: white; padding: 60px 40px; }
        .table thead th { background: #f8fafc; color: #707eae; font-size: 0.7rem; text-transform: uppercase; border: none; padding: 15px; }
        .table tbody td { padding: 15px; border-bottom: 1px solid #f1f4f9; vertical-align: middle; font-size: 0.9rem; }
        .btn-action { width: 32px; height: 32px; padding: 0; line-height: 32px; border-radius: 8px; border: none; transition: 0.2s; }
        .btn-edit { background: #eef2ff; color: #4318FF; }
        .btn-delete { background: #fff5f5; color: #ff3b3b; }
    </style>
</head>
<body>

    <nav class="navbar py-3 sticky-top">
        <div class="container">
            <span class="navbar-brand fw-bold text-primary"><i class="fa-solid fa-cube me-2"></i>APP.CORE</span>
            <div class="ms-auto d-flex align-items-center">
                <span class="small text-muted me-3">Hello, <b><?php echo $me['username']; ?></b></span>
                <a href="logout.php" class="btn btn-dark btn-sm rounded-pill px-4">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        
        <?php if ($userRole === 'admin'): ?>
            <!-- ADMIN SECTION -->
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold mb-1">User Management</h3>
                    <p class="text-muted small mb-0">Overview of all registered accounts.</p>
                </div>
                <div>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa-solid fa-plus me-2"></i>Add New User
                    </button>
                </div>
            </div>

            <div class="card-custom overflow-hidden">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                            <?php
                            $res = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
                            while($row = $res->fetch_assoc()):
                            ?>
                            <tr id="row_<?php echo $row['id']; ?>">
                                <td class="fw-bold"><?php echo $row['username']; ?></td>
                                <td class="text-muted"><?php echo $row['email']; ?></td>
                                <td><span class="badge rounded-pill bg-light text-primary px-3"><?php echo strtoupper($row['role']); ?></span></td>
                                <td class="small"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <button class="btn-action btn-edit me-1" onclick="editUser(<?php echo $row['id']; ?>)"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn-action btn-delete" onclick="deleteUser(<?php echo $row['id']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- NORMAL USER SECTION -->
            <div class="welcome-hero shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-4 fw-bold">Welcome back, <?php echo $me['username']; ?>!</h1>
                        <p class="lead opacity-75">Your standard account is active. Enjoy your personalized dashboard experience.</p>
                        <button class="btn btn-light rounded-pill px-5 fw-bold mt-3 text-primary">Explore Features</button>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <i class="fa-solid fa-user-astronaut fa-8x opacity-25"></i>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- MODAL FOR ADDING USER (ADMIN ONLY) -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-4">Register New System User</h5>
                    <form id="adminAddForm">
                        <input type="text" id="au" class="form-control mb-3" placeholder="Username" required>
                        <input type="email" id="ae" class="form-control mb-3" placeholder="Email" required>
                        <select id="ar" class="form-select mb-3" required>
                            <option value="user">Normal User</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <input type="password" id="ap" class="form-control mb-4" placeholder="Password" required>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // DELETE USER XHR
    function deleteUser(id) {
        if(confirm('Are you sure you want to delete this user?')) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "actions/manage_user.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if(this.responseText == 'success') {
                    document.getElementById('row_'+id).remove();
                } else { alert("Failed to delete."); }
            };
            xhr.send("action=delete&id=" + id);
        }
    }

    // ADD USER XHR
    document.getElementById('adminAddForm').onsubmit = function(e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "actions/save_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            location.reload(); // Refresh table
        };
        xhr.send(`user=${encodeURIComponent(document.getElementById('au').value)}&email=${encodeURIComponent(document.getElementById('ae').value)}&role=${document.getElementById('ar').value}&pass=${encodeURIComponent(document.getElementById('ap').value)}`);
    }
    </script>
</body>
</html>