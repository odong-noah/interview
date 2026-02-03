<?php require_once 'dbconn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Join</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-fontawesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7fe; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .signup-card { background: #ffffff; border-radius: 20px; box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.05); border: none; width: 100%; max-width: 500px; padding: 40px; }
        
        .input-group-text { background-color: #f8fafc; border: 1px solid #e0e5f2; border-right: none; border-radius: 12px 0 0 12px; color: #707eae; }
        .form-control, .form-select { border-radius: 0 12px 12px 0; padding: 12px 15px; border: 1px solid #e0e5f2; background-color: #f8fafc; }
        .form-control:focus, .form-select:focus { box-shadow: 0px 4px 12px rgba(67, 24, 255, 0.1); border-color: #4318FF; }
        
        .btn-signup { background: #4318FF; color: #fff; border-radius: 12px; padding: 12px; font-weight: 700; border: none; transition: 0.3s; margin-top: 10px; }
        .btn-signup:hover { background: #3311cc; transform: translateY(-1px); }
        
        .title-text { color: #2b3674; font-weight: 800; letter-spacing: -0.5px; }
        .label-text { font-weight: 600; font-size: 0.85rem; color: #707eae; margin-bottom: 5px; display: block; }
        .input-wrapper { margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="signup-card">
        <div class="text-center mb-4">
            <h2 class="title-text">Create Account</h2>
            <p class="text-muted small">Enter your details below to register.</p>
        </div>
        
        <div id="msg"></div>
        
        <!-- autocomplete="off" prevents browser autofill -->
        <form id="regForm" autocomplete="off">
            <!-- Username -->
            <div class="input-wrapper">
                <label class="label-text">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" id="u" class="form-control" required value="">
                </div>
            </div>

            <!-- Email -->
            <div class="input-wrapper">
                <label class="label-text">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" id="e" class="form-control" required value="">
                </div>
            </div>

            <!-- Role Selection -->
            <div class="input-wrapper">
                <label class="label-text">Account Role</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user-shield"></i></span>
                    <select id="role" class="form-select" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option value="user">Normal User</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>

            <!-- Password Fields -->
            <div class="row">
                <div class="col-md-6">
                    <div class="input-wrapper">
                        <label class="label-text">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="p" class="form-control" required autocomplete="new-password" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-wrapper">
                        <label class="label-text">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-check-double"></i></span>
                            <input type="password" id="cp" class="form-control" required autocomplete="new-password" value="">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-signup w-100">Sign Up</button>
        </form>

        <p class="mt-4 text-center text-muted small">Already a member? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
    </div>

    <script>
    // Layer 3: Force inputs to be empty on page load/refresh
    window.onload = function() {
        document.getElementById('regForm').reset();
        document.getElementById('u').value = "";
        document.getElementById('e').value = "";
        document.getElementById('p').value = "";
        document.getElementById('cp').value = "";
    };

    document.getElementById('regForm').onsubmit = function(e) {
        e.preventDefault();
        
        let u = document.getElementById('u').value;
        let e_val = document.getElementById('e').value;
        let role = document.getElementById('role').value;
        let p = document.getElementById('p').value;
        let cp = document.getElementById('cp').value;
        let btn = document.getElementById('submitBtn');

        if(p !== cp) { 
            document.getElementById('msg').innerHTML = '<div class="alert alert-danger border-0 small shadow-sm">Passwords do not match!</div>'; 
            return; 
        }

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;

        // XMLHttpRequest (XHR) Implementation
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "actions/save_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                btn.innerHTML = 'Sign Up'; 
                btn.disabled = false;
                
                try {
                    let res = JSON.parse(this.responseText);
                    document.getElementById('msg').innerHTML = `<div class="alert alert-${res.status=='ok'?'success':'danger'} border-0 small shadow-sm">${res.message}</div>`;
                    
                    if(res.status == 'ok') {
                        document.getElementById('regForm').reset();
                        setTimeout(() => { window.location.href = "login.php"; }, 2000);
                    }
                } catch (err) {
                    document.getElementById('msg').innerHTML = '<div class="alert alert-danger border-0 small">Error: Invalid Server Response.</div>';
                }
            }
        };

        let params = "user=" + encodeURIComponent(u) + 
                     "&email=" + encodeURIComponent(e_val) + 
                     "&role=" + encodeURIComponent(role) + 
                     "&pass=" + encodeURIComponent(p);
        
        xhr.send(params);
    };
    </script>
</body>
</html>