<?php require 'dbconn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Join</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f7fe; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .signup-card { background: #ffffff; border-radius: 20px; box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.05); border: none; width: 100%; max-width: 500px; padding: 40px; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e0e5f2; margin-bottom: 15px; background-color: #f8fafc; }
        .form-control:focus { box-shadow: 0px 4px 12px rgba(67, 24, 255, 0.1); border-color: #4318FF; }
        .btn-signup { background: #4318FF; color: #fff; border-radius: 12px; padding: 12px; font-weight: 700; border: none; transition: 0.3s; }
        .btn-signup:hover { background: #3311cc; transform: translateY(-1px); }
        .title-text { color: #2b3674; font-weight: 800; letter-spacing: -0.5px; }
        .label-text { font-weight: 600; font-size: 0.85rem; color: #707eae; margin-left: 5px; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="signup-card">
        <div class="text-center mb-4">
            <h2 class="title-text">Create Account</h2>
            <p class="text-muted small">Please fill in your details to get started.</p>
        </div>
        <div id="msg"></div>
        
        <!-- autocomplete="off" tells browsers not to autofill -->
        <form id="regForm" autocomplete="off">
            <label class="label-text">Username</label>
            <input type="text" id="u" class="form-control" placeholder="Choose username" required value="">

            <label class="label-text">Email</label>
            <input type="email" id="e" class="form-control" placeholder="name@company.com" required value="">

            <div class="row">
                <div class="col-md-6">
                    <label class="label-text">Password</label>
                    <input type="password" id="p" class="form-control" placeholder="Enter password" required autocomplete="new-password" value="">
                </div>
                <div class="col-md-6">
                    <label class="label-text">Confirm</label>
                    <input type="password" id="cp" class="form-control" placeholder="Confirm password" required autocomplete="new-password" value="">
                </div>
            </div>
            <button type="submit" id="submitBtn" class="btn btn-signup w-100 mt-2">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-muted small">Already a member? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
    </div>

    <script>
    // Force inputs to be empty on load
    window.onload = () => {
        document.getElementById('u').value = "";
        document.getElementById('e').value = "";
        document.getElementById('p').value = "";
        document.getElementById('cp').value = "";
    };

    document.getElementById('regForm').onsubmit = function(e) {
        e.preventDefault();
        let u = document.getElementById('u').value;
        let e_val = document.getElementById('e').value;
        let p = document.getElementById('p').value;
        let cp = document.getElementById('cp').value;
        let btn = document.getElementById('submitBtn');

        // Validation: Passwords match
        if(p !== cp) { 
            document.getElementById('msg').innerHTML = '<div class="alert alert-danger border-0 small shadow-sm">Passwords do not match!</div>'; 
            return; 
        }

        btn.innerHTML = 'Creating Account...'; btn.disabled = true;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "actions/save_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            btn.innerHTML = 'Sign Up'; btn.disabled = false;
            try {
                let res = JSON.parse(this.responseText);
                document.getElementById('msg').innerHTML = `<div class="alert alert-${res.status=='ok'?'success':'danger'} border-0 small shadow-sm">${res.message}</div>`;
                if(res.status == 'ok') {
                    document.getElementById('regForm').reset();
                    // Optional: Redirect to login after 2 seconds
                    setTimeout(() => { window.location.href = "login.php"; }, 2000);
                }
            } catch (err) {
                document.getElementById('msg').innerHTML = '<div class="alert alert-danger border-0 small">Server Error. Please check your database.</div>';
            }
        };
        // Safely send data
        xhr.send("user="+encodeURIComponent(u)+"&email="+encodeURIComponent(e_val)+"&pass="+encodeURIComponent(p));
    };
    </script>
</body>
</html>