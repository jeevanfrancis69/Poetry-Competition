<?php
    session_start();

    require_once "../connect.php";
    $usernamePeserta = mysqli_escape_string($con, $_POST['usernamePeserta']);
    $kataLaluanPeserta = mysqli_escape_string($con, $_POST['kataLaluanPeserta']);

    $sel = "SELECT * FROM peserta where usernamePeserta = '$usernamePeserta' AND kataLaluanPeserta = '$kataLaluanPeserta'";
    $result = mysqli_query($con, $sel);
    $num = mysqli_num_rows($result);
    //Login denied. No match record is found
    if ($num == 0){
        //Try to search the same data in Judge table
        $sel = "SELECT * FROM judge where icAdmin = '$usernamePeserta' AND kataLaluanAdmin = '$kataLaluanPeserta'";
        $result = mysqli_query($con, $sel);
        $num = mysqli_num_rows($result);
        //Not found in both table. Login denied
        if ($num == 0){
            echo "Wrong username or password";
        }
        //Match record found in Admin table. Login as Admin. Status acts as an unique key for admin page indication.
        else{
            echo "Login Successful";
            $_SESSION['usernamePeserta']=$usernamePeserta;
            echo "<script> window.location.href = '../html/senaraipeserta.php'; </script>";
            $_SESSION['Status'] = 'Admin';
        }        
        
    }
    //Login as user
    else{
        echo "Login Successful";
        $_SESSION['usernamePeserta']=$usernamePeserta;
        echo "<script> window.location.href = '../html/loginindexpeserta.php'; </script>";
    }
    ?>