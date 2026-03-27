<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pertandingan Mendeklamasikan Sajak</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- All styles live in login.css -->
</head>
<body>

<nav>
    <ul>
        <li class="active"><a href="../html/loginmasuk.php">Log In</a></li>
        <li><a href="../html/intro.html">Home</a></li>
        <li><a href="../html/aboutus.html">About Us</a></li>
        <li><a href="../html/daftarpeserta.php">Register</a></li>
    </ul>
</nav>

<div class="login-box">
    <form id="registerForm">
        <h1 class="animate__animated animate__fadeInDown">Register</h1>

        <!-- Role selection: card-style toggle buttons -->
        <div class="role-selection animate__animated animate__fadeInDown">
            <label class="role-card" id="card-peserta">
                <input type="radio" name="role" value="peserta" checked
                       onchange="toggleFields('peserta')">
                <i class="fa fa-user-graduate"></i>
                <span>Student</span>
            </label>
            <label class="role-card" id="card-judge">
                <input type="radio" name="role" value="judge"
                       onchange="toggleFields('judge')">
                <i class="fa fa-gavel"></i>
                <span>Judge</span>
            </label>
        </div>

        <!-- Notice shown when Judge is selected -->
        <div class="judge-notice" id="judgeNotice">
            <i class="fa fa-clock"></i>
            Judge accounts require admin approval before you can log in.
        </div>

        <!-- Common fields -->
        <div class="textbox">
            <i class="fa fa-user" aria-hidden="true"></i>
            <input type="text" placeholder="Enter Name" name="namaPeserta"
                   class="animate__animated animate__fadeInDown"
                   minlength="2" maxlength="50" required>
        </div>

        <div class="textbox">
            <i class="fa fa-at" aria-hidden="true"></i>
            <input type="text" placeholder="Enter Username" name="usernamePeserta"
                   class="animate__animated animate__fadeInDown"
                   minlength="4" maxlength="50" required>
        </div>

        <div class="textbox">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <input type="password" placeholder="Password" name="kataLaluanPeserta"
                   class="animate__animated animate__fadeInDown"
                   id="passwordField" required>
        </div>

        <div class="textbox">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <input type="password" placeholder="Confirm Password" name="ComKataLaluanPeserta"
                   class="animate__animated animate__fadeInDown"
                   id="confirmPasswordField" required>
        </div>

        <!-- Student-only fields (also collected for judges so admin has context) -->
        <div id="extraFields">
            <div class="textbox">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <input type="email" placeholder="Enter Email" name="emelPeserta"
                       class="animate__animated animate__fadeInDown"
                       id="emailInput" required>
            </div>

            <div class="textbox">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input type="number" placeholder="Enter Age" name="umurPeserta"
                       class="animate__animated animate__fadeInDown"
                       id="ageInput" min="5" max="120" required>
            </div>
        </div>

        <input class="btn animate__animated animate__fadeInDown" type="submit" value="Register">
    </form>
</div>
<script src = "../js/Register.js"></script>
</body>
</html>
