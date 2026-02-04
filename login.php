<?php require_once 'dataconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Sparrow Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; }
        body { background: var(--bg); height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .auth-card { background: white; padding: 40px; border-radius: 20px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .label-std { font-weight: 600; font-size: 0.85rem; color: #707eae; display: block; margin-bottom: 8px; }
        .label-std i { margin-right: 5px; color: var(--primary); }
        .form-control { border-radius: 12px; padding: 12px; background: #f8fafc; border: 1px solid #d1d9e6; }
        .btn-std { background: var(--primary); color: white; border: none; padding: 13px; border-radius: 12px; font-weight: 700; width: 100%; margin-top: 15px; }
    </style>
</head>
<body>

<div class="auth-card">
    <h3 class="fw-bold text-center mb-4">Sign In</h3>
    <div id="msg"></div>
    <form id="logForm" autocomplete="off">
        <div class="mb-3">
            <label class="label-std"><i class="fa-solid fa-user-tag"></i> Username</label>
            <input type="text" id="u" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="label-std"><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" id="p" class="form-control" required>
        </div>
        <button type="submit" id="subBtn" class="btn btn-std">Enter System</button>
    </form>
    <p class="mt-4 text-center small text-muted">
        New user? <a href="signup.php" class="text-primary fw-bold text-decoration-none">Create Account</a>
    </p>
</div>

<script>
window.onload = function() {
    document.getElementById('u').value = "";
    document.getElementById('p').value = "";
};

document.getElementById('logForm').onsubmit = function(e) {
    e.preventDefault();
    const btn = document.getElementById('subBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Verifying...';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "verify_login.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        try {
            const res = JSON.parse(this.responseText);
            if(res.status == 'ok') { window.location.href = "dashboard.php"; }
            else {
                document.getElementById('msg').innerHTML = `<div class="alert alert-danger p-2 small">${res.message}</div>`;
                btn.disabled = false; btn.innerHTML = 'Enter System';
            }
        } catch(e) { btn.disabled = false; btn.innerHTML = 'Enter System'; }
    };
    xhr.send("u=" + encodeURIComponent(document.getElementById('u').value) + "&p=" + encodeURIComponent(document.getElementById('p').value));
};
</script>
</body>
</html>