<?php
    session_start();

    require_once "../connect.php";
    $usernamePeserta = mysqli_escape_string($con, $_POST['usernamePeserta']);
    $kataLaluanPeserta = mysqli_escape_string($con, $_POST['kataLaluanPeserta']);

    $hashedPassword = password_hash($kataLaluanPeserta, PASSWORD_DEFAULT);


    $sel = "SELECT * FROM user where usernamePeserta = '$usernamePeserta'";
    $result = mysqli_query($con, $sel);
    $num = mysqli_num_rows($result);

    if ($num == 0) {
        // username doesn't exist
        $_SESSION['error'] = "Wrong username or password";
        header("Location: ../html/loginmasuk.php");
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    if (!password_verify($kataLaluanPeserta, $row['kataLaluanPeserta'])) {
    
    
    $_SESSION['error'] = "Wrong username or password";
    header("Location: ../html/loginmasuk.php");
    exit();
    }

    // success
    $_SESSION['usernamePeserta'] = $usernamePeserta;
    $_SESSION['success'] = "Login successful! Welcome, " . $usernamePeserta;
    header("Location: ../html/loginindexpeserta.php");
    exit();

?>

