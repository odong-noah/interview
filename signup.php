<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto shadow-sm" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="text-center">Create Account</h4>
            <div id="msg"></div>
            <form id="regForm">
                <input type="text" id="u" class="form-control mb-2" placeholder="Username" required>
                <input type="email" id="e" class="form-control mb-2" placeholder="Email" required>
                <input type="password" id="p" class="form-control mb-2" placeholder="Password" required>
                <input type="password" id="cp" class="form-control mb-2" placeholder="Confirm Password" required>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
            <p class="mt-2 text-center">Already a member? <a href="login.php">Login</a></p>
        </div>
    </div>
</div>

<script>
document.getElementById('regForm').onsubmit = function(e) {
    e.preventDefault();
    let u = document.getElementById('u').value;
    let e_val = document.getElementById('e').value;
    let p = document.getElementById('p').value;
    let cp = document.getElementById('cp').value;
    let msg = document.getElementById('msg');

    // Simple JS Validation
    let regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
    if(p !== cp) { msg.innerHTML = '<div class="alert alert-danger">Passwords match error!</div>'; return; }
    if(!regex.test(p)) { msg.innerHTML = '<div class="alert alert-danger">Need 8+ chars, 1 Number, 1 Uppercase</div>'; return; }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "actions/save_user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        let res = JSON.parse(this.responseText);
        msg.innerHTML = `<div class="alert alert-${res.status=='ok'?'success':'danger'}">${res.message}</div>`;
        if(res.status == 'ok') document.getElementById('regForm').reset();
    };
    xhr.send("user="+u+"&email="+e_val+"&pass="+p);
};
</script>
</body>
</html>