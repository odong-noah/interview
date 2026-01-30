<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Access | Sign In</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f4f7fe; 
            font-family: 'Inter', sans-serif; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            padding: 20px;
        }
        .login-card { 
            background: #ffffff; 
            border-radius: 20px; 
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.05); 
            border: none; 
            width: 100%; 
            max-width: 420px; 
            padding: 40px; 
        }
        .form-control { 
            border-radius: 12px; 
            padding: 12px 15px; 
            border: 1px solid #e0e5f2; 
            background-color: #f8fafc;
        }
        .form-control:focus { 
            box-shadow: 0px 4px 12px rgba(67, 24, 255, 0.1); 
            border-color: #4318FF; 
            background-color: #fff; 
        }
        .btn-enter { 
            background: #4318FF; 
            color: #fff; 
            border-radius: 12px; 
            padding: 12px; 
            font-weight: 700; 
            border: none; 
            transition: 0.3s; 
        }
        .btn-enter:hover { 
            background: #3311cc; 
            transform: translateY(-1px);
        }
        .login-title { color: #2b3674; font-weight: 800; letter-spacing: -0.5px; }
        .label-text { font-weight: 600; font-size: 0.85rem; color: #707eae; margin-left: 5px; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <h2 class="login-title">Sign In</h2>
            <p class="text-muted">Enter your credentials to access the portal.</p>
        </div>

        <div id="msg"></div>

        <form id="logForm" autocomplete="off">
            <div class="mb-3">
                <label class="label-text">Username</label>
                <!-- value="" and autocomplete="off" ensure it stays empty -->
                <input type="text" id="u" class="form-control" placeholder="Username" required autocomplete="off" value="">
            </div>
            
            <div class="mb-4">
                <label class="label-text">Password</label>
                <!-- autocomplete="new-password" forces the browser to not autofill -->
                <input type="password" id="p" class="form-control" placeholder="Enter password" required autocomplete="new-password" value="">
            </div>

            <button type="submit" id="submitBtn" class="btn btn-enter w-100">
                Sign In
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-muted small mb-0">Don't have an account? 
                <a href="signup.php" class="text-primary fw-bold text-decoration-none">Create account</a>
            </p>
        </div>
    </div>

    <script>
    // HARD RESET: Ensures fields are empty even if user hits "Back" button
    window.onload = function() {
        document.getElementById('u').value = '';
        document.getElementById('p').value = '';
    };

    document.getElementById('logForm').onsubmit = function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Authenticating...'; 
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
                    document.getElementById('msg').innerHTML = `<div class="alert alert-success border-0 shadow-sm small">Success! Redirecting...</div>`;
                    window.location.href = res.link; 
                } else { 
                    document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 shadow-sm small">${res.message}</div>`; 
                }
            } catch (e) {
                document.getElementById('msg').innerHTML = `<div class="alert alert-danger border-0 shadow-sm small">Server Error. Please try again.</div>`;
            }
        };

        // Standardized variable names: user and pass
        let user = encodeURIComponent(document.getElementById('u').value);
        let pass = encodeURIComponent(document.getElementById('p').value);
        xhr.send("user=" + user + "&pass=" + pass);
    };
    </script>
</body>
</html>