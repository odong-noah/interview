<?php require_once 'dataconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Sparrow Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; --text-dark: #2b3674; }
        body { background: var(--bg); height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .auth-card { background: white; padding: 40px; border-radius: 20px; width: 100%; max-width: 450px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .label-std { font-weight: 600; font-size: 0.85rem; color: #707eae; display: block; margin-bottom: 8px; }
        .label-std i { margin-right: 5px; color: var(--primary); }
        .form-control, .form-select { border-radius: 12px; padding: 12px; background: #f8fafc; border: 1px solid #d1d9e6; }
        .btn-std { background: var(--primary); color: white; border: none; padding: 13px; border-radius: 12px; font-weight: 700; width: 100%; margin-top: 15px; }
        .btn-std:disabled { background-color: var(--primary) !important; opacity: 0.8; color: white !important; }
    </style>
</head>
<body>

<div class="auth-card">
    <h3 class="fw-bold text-center mb-4" style="color: var(--text-dark);">Create Account</h3>
    <div id="msg"></div>
    <form id="regForm" autocomplete="off">
        <div class="mb-3">
            <label class="label-std"><i class="fa-solid fa-user"></i> Username</label>
            <input type="text" id="u" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="label-std"><i class="fa-solid fa-envelope"></i> Email Address</label>
            <input type="email" id="e" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="label-std"><i class="fa-solid fa-users-gear"></i> Account Role</label>
            <select id="r" class="form-select" required>
                <option value="" disabled selected>Select Access Level</option>
                <option value="user">Normal User</option>
                <option value="admin">Administrator</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="label-std"><i class="fa-solid fa-key"></i> Password</label>
            <input type="password" id="p" class="form-control" required autocomplete="new-password">
        </div>
        <button type="submit" id="subBtn" class="btn btn-std">Register Profile</button>
    </form>
    <p class="mt-4 text-center small text-muted">
        Already registered? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a>
    </p>
</div>

<script>
// Standard: Ensure fields are empty on load
window.onload = function() {
    document.getElementById('regForm').reset();
    document.getElementById('u').value = "";
    document.getElementById('e').value = "";
    document.getElementById('p').value = "";
};

document.getElementById('regForm').onsubmit = function(event) {
    event.preventDefault();
    const btn = document.getElementById('subBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Processing...';

    const xhr = new XMLHttpRequest();
    // THE FIX: Ensure this filename is exactly save_user.php in the same folder
    xhr.open("POST", "save_user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    if(res.status == 'ok') {
                        document.getElementById('msg').innerHTML = '<div class="alert alert-success small">Success! Redirecting...</div>';
                        setTimeout(() => { window.location.href = "login.php"; }, 500);
                    } else {
                        document.getElementById('msg').innerHTML = `<div class="alert alert-danger small">${res.message}</div>`;
                        btn.disabled = false; btn.innerHTML = 'Register Profile';
                    }
                } catch (e) {
                    document.getElementById('msg').innerHTML = `<div class="alert alert-danger small">System Error: Check save_user.php code.</div>`;
                    btn.disabled = false; btn.innerHTML = 'Register Profile';
                }
            } else {
                document.getElementById('msg').innerHTML = `<div class="alert alert-danger small">Connection Failed (Status: ${this.status}). Check if save_user.php exists in this folder.</div>`;
                btn.disabled = false; btn.innerHTML = 'Register Profile';
            }
        }
    };

    const params = `u=${encodeURIComponent(document.getElementById('u').value)}&e=${encodeURIComponent(document.getElementById('e').value)}&r=${document.getElementById('r').value}&p=${encodeURIComponent(document.getElementById('p').value)}`;
    xhr.send(params);
};
</script>
</body>
</html>