<?php require_once 'dbconn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join | AppCore</title>
    <!-- Professional Assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; --text-main: #2b3674; }
        body { background-color: var(--bg); font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        
        .signup-card { background: #ffffff; border-radius: 20px; box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.05); width: 100%; max-width: 500px; padding: 40px; }
        .form-control, .form-select { border-radius: 12px; padding: 12px 15px; border: 1px solid #e0e5f2; background-color: #f8fafc; transition: 0.3s; }
        .form-control:focus, .form-select:focus { box-shadow: 0px 4px 12px rgba(67, 24, 255, 0.1); border-color: var(--primary); background-color: #fff; outline: none; }
        
        .btn-signup { background: var(--primary); color: #fff; border-radius: 12px; padding: 12px; font-weight: 700; border: none; transition: 0.3s; margin-top: 10px; }
        .btn-signup:hover { background: #3311cc; transform: translateY(-1px); box-shadow: 0px 5px 15px rgba(67, 24, 255, 0.2); }
        
        .label-text { font-weight: 600; font-size: 0.85rem; color: #707eae; margin-bottom: 5px; display: block; margin-left: 5px; }
        .title-text { color: var(--text-main); font-weight: 800; letter-spacing: -0.5px; }
    </style>
</head>
<body>

    <div class="signup-card">
        <div class="text-center mb-4">
            <h2 class="title-text">Create Account</h2>
            <p class="text-muted small">Register your profile to access the system.</p>
        </div>

        <div id="msg"></div>

        <!-- autocomplete="off" tells the browser not to fill saved data -->
        <form id="regForm" autocomplete="off">
            <div class="mb-3">
                <label class="label-text">Username</label>
                <input type="text" id="u" class="form-control" required autocomplete="off" value="">
            </div>

            <div class="mb-3">
                <label class="label-text">Email Address</label>
                <input type="email" id="e" class="form-control" required autocomplete="off" value="">
            </div>

            <div class="mb-3">
                <label class="label-text">Account Role</label>
                <select id="role" class="form-select" required>
                    <option value="" disabled selected>Select Access Level</option>
                    <option value="user">Normal User</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="label-text">Password</label>
                    <input type="password" id="p" class="form-control" required autocomplete="new-password" value="">
                </div>
                <div class="col-md-6">
                    <label class="label-text">Confirm Password</label>
                    <input type="password" id="cp" class="form-control" required autocomplete="new-password" value="">
                </div>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-signup w-100">Register Profile</button>
        </form>
        
        <p class="mt-4 text-center text-muted small">
            Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a>
        </p>
    </div>

    <script>
    // HARD RESET: Forces all fields to be empty when the page is loaded/refreshed
    window.onload = function() {
        const form = document.getElementById('regForm');
        form.reset(); // Clears standard fields
        document.getElementById('u').value = "";
        document.getElementById('e').value = "";
        document.getElementById('role').selectedIndex = 0; // Resets dropdown to "Select Access Level"
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

        // Basic validation
        if(p !== cp) { 
            document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 small shadow-sm">Passwords do not match!</div>`; 
            return; 
        }

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i>Processing...';
        btn.disabled = true;

        // XMLHTTPRequest Implementation
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "actions/save_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                btn.innerHTML = 'Register Profile'; 
                btn.disabled = false;
                
                try {
                    let res = JSON.parse(this.responseText);
                    document.getElementById('msg').innerHTML = `<div class="alert alert-${res.status=='ok'?'success':'danger'} border-0 small shadow-sm">${res.message}</div>`;
                    
                    if(res.status == 'ok') {
                        document.getElementById('regForm').reset();
                        setTimeout(() => { window.location.href = "login.php"; }, 2000);
                    }
                } catch (err) {
                    document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 small shadow-sm">Server Error. Please check your database.</div>`;
                }
            }
        };

        // Send parameters including 'role'
        let params = "user=" + encodeURIComponent(u) + 
                     "&email=" + encodeURIComponent(e_val) + 
                     "&role=" + encodeURIComponent(role) + 
                     "&pass=" + encodeURIComponent(p);
        
        xhr.send(params);
    };
    </script>
</body>
</html>