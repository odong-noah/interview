<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto shadow-sm" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="text-center">Login</h4>
            <div id="msg"></div>
            <form id="logForm">
                <input type="text" id="u" class="form-control mb-2" placeholder="Username" required>
                <input type="password" id="p" class="form-control mb-2" placeholder="Password" required>
                <button type="submit" class="btn btn-success w-100">Enter</button>
            </form>
            <p class="mt-2 text-center"><a href="signup.php">Register here</a></p>
        </div>
    </div>
</div>

<script>
document.getElementById('logForm').onsubmit = function(e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "actions/verify_login.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        let res = JSON.parse(this.responseText);
        if(res.status == 'ok') { window.location.href = res.link; }
        else { document.getElementById('msg').innerHTML = `<div class="alert alert-danger">${res.message}</div>`; }
    };
    xhr.send("user="+document.getElementById('u').value+"&pass="+document.getElementById('p').value);
};
</script>
</body>
</html>