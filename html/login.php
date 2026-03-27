<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pertandingan Mendeklamasikan Sajak</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav>
    <ul>
        <li class="active"><a href="../html/login.php">Log In</a></li>
        <li><a href="../html/intro.php">Home</a></li>
        <li><a href="../html/aboutus.php">About Us</a></li>
        <li><a href="../html/registeruser.php">Register</a></li>
    </ul>
</nav>

<div class="login-box">
    <form id="loginForm">
        <h1 class="animate__animated animate__fadeInDown">Login</h1>

        <div class="textbox">
            <i class="fa fa-user" aria-hidden="true"></i>
            <input type="text" placeholder="Enter Username" name="usernamePeserta"
                   class="animate__animated animate__fadeInDown"
                   minlength="4" maxlength="50" required>
        </div>

        <div class="textbox">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <input type="password" placeholder="Password" name="kataLaluanPeserta"
                   class="animate__animated animate__fadeInDown" required>
        </div>

        <input class="btn animate__animated animate__fadeInDown" type="submit" value="Login">

        <!-- Register prompt -->
        <p style="text-align:center; margin-top: 18px; font-size: 0.85rem; color: rgba(255,255,255,0.65);">
            Don't have an account?
            <a href="../html/registeruser.php"
               style="color:#fff; text-decoration: underline;">Register here</a>
        </p>
    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('../php/processLogin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                showConfirmButton: false,
                timer: 1200
            }).then(() => {
                // PHP tells us exactly where to go based on role
                window.location.href = data.url;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Could not connect to the server.', 'error');
    });
});
</script>

</body>
</html>
