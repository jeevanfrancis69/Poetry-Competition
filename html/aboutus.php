<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? 'guest';
$nama = $_SESSION['nama'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us — Pertandingan Mendeklamasikan Sajak</title>
    <link rel="stylesheet" href="../css/about_us.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav>
    <ul>
        <li><a href="../html/intro.php">Home</a></li>
        <li class="active"><a href="../html/aboutus.php">About Us</a></li>

        <?php if ($role === 'student'): ?>
            <li><a href="../html/loginindexpeserta.php">My Results</a></li>
            <li><a href="../php/logout.php">Log Out</a></li>

        <?php elseif ($role === 'judge'): ?>
            <li><a href="../html/judgeDashboard.php">Dashboard</a></li>
            <li><a href="../php/logout.php">Log Out</a></li>

        <?php elseif ($role === 'admin'): ?>
            <li><a href="../html/adminDashboard.php">Admin Panel</a></li>
            <li><a href="../php/logout.php">Log Out</a></li>

        <?php else: ?>
            <li><a href="../html/login.php">Log In</a></li>
            <li><a href="../html/registeruser.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container">
    <div class="row title">
        <h1>Contact Us</h1>
    </div>
    <div class="row">
        <h4>For any enquiry, we will reply you within 3 working days.</h4>
    </div>

    <!-- No action/method — fetch handles submission -->
    <form id="contactForm">
        <div class="row input-container">

            <div class="col-xs-12">
                <div class="styled-input wide">
                    <input type="text" name="Name" required>
                    <label>Name</label>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="styled-input">
                    <input type="email" name="Email" required>
                    <label>Email</label>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="styled-input" style="float:right;">
                    <input type="text" name="PhoneNum">
                    <label>Phone Number</label>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="styled-input wide">
                    <textarea name="Message" required></textarea>
                    <label>Message</label>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="btn-lrg submit-btn">
                    <input type="submit" value="Send Message">
                </div>
            </div>

        </div>
    </form>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('../php/Contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: data.message,
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#fff',
            }).then(() => {
                document.getElementById('contactForm').reset();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message,
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#fff',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Could not connect to the server.',
            background: '#111',
            color: '#fff',
        });
    });
});
</script>

</body>
</html>
