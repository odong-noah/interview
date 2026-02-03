<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | AppCore</title>
    <!-- Professional Assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; --text-main: #2b3674; }
        body { background-color: var(--bg); font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        
        .login-card { background: #ffffff; border-radius: 20px; box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.05); width: 100%; max-width: 420px; padding: 40px; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e0e5f2; background-color: #f8fafc; transition: 0.3s; }
        .form-control:focus { box-shadow: 0px 4px 12px rgba(67, 24, 255, 0.1); border-color: var(--primary); background-color: #fff; outline: none; }
        
        .btn-enter { background: var(--primary); color: #fff; border-radius: 12px; padding: 12px; font-weight: 700; border: none; transition: 0.3s; }
        .btn-enter:hover { background: #3311cc; transform: translateY(-1px); box-shadow: 0px 5px 15px rgba(67, 24, 255, 0.2); }
        
        .label-text { font-weight: 600; font-size: 0.85rem; color: #707eae; margin-bottom: 5px; display: block; margin-left: 5px; }
        .login-title { color: var(--text-main); font-weight: 800; letter-spacing: -0.5px; }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <h2 class="login-title mb-2">Sign In</h2>
        <p class="text-muted small mb-4">Enter your credentials to access your dashboard.</p>

        <div id="msg"></div>

        <!-- autocomplete="off" stops browser from suggesting previous usernames -->
        <form id="logForm" class="text-start" autocomplete="off">
            <div class="mb-3">
                <label class="label-text">Username</label>
                <input type="text" id="u" class="form-control" required autocomplete="off" value="">
            </div>
            
            <div class="mb-4">
                <label class="label-text">Password</label>
                <!-- Using autocomplete="new-password" is a trick to stop most browsers from autofilling saved passwords -->
                <input type="password" id="p" class="form-control" required autocomplete="new-password" value="">
            </div>

            <button type="submit" id="submitBtn" class="btn btn-enter w-100">Sign In</button>
        </form>

        <p class="mt-4 text-muted small">New here? 
            <a href="signup.php" class="text-primary fw-bold text-decoration-none">Create Account</a>
        </p>
    </div>

    <script>
    /**
     * TRIPLE-LAYER RESET: 
     * Ensures fields are empty on load, refresh, and even back-navigation.
     */
    window.onload = function() {
        // Method 1: Form Reset
        document.getElementById('logForm').reset();
        // Method 2: Manual field clearing
        document.getElementById('u').value = '';
        document.getElementById('p').value = '';
    };

    document.getElementById('logForm').onsubmit = function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        
        // UI Feedback
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Verifying...';
        btn.disabled = true;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "actions/verify_login.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onload = function() {
            btn.innerHTML = 'Sign In'; 
            btn.disabled = false;
            
            try {
                let res = JSON.parse(this.responseText);
                if(res.status == 'ok') { 
                    document.getElementById('msg').innerHTML = `<div class="alert alert-success border-0 small shadow-sm">Success! Redirecting...</div>`;
                    window.location.href = res.link; 
                } else { 
                    document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 small shadow-sm">${res.message}</div>`; 
                }
            } catch (e) {
                document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 small shadow-sm">Server Error. Please try again.</div>`;
            }
        };

        // Standardized variable names
        let user = encodeURIComponent(document.getElementById('u').value);
        let pass = encodeURIComponent(document.getElementById('p').value);
        xhr.send("user=" + user + "&pass=" + pass);
    };
    </script>
</body>
</html>