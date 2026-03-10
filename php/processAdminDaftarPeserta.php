<?php
    session_start();
    require_once "../connect.php";
    $usernamePeserta = mysqli_escape_string($con, $_POST['usernameeserta']);
    $namaPeserta = mysqli_escape_string($con, $_POST['namaPeserta']);
    $kataLaluanPeserta = mysqli_escape_string($con, $_POST['kataLaluanPeserta']);

    $sel = "SELECT * FROM peserta where usernamePeserta = '$usernamePeserta'";
    $result = mysqli_query($con, $sel);
    $num = mysqli_num_rows($result);

    if ($num >= 1){
        echo "User already exists";
    }
    else{
        $reg = "INSERT into peserta (usernamePeserta, namaPeserta, kataLaluanPeserta)
        values('".$usernamePeserta."', '".$namaPeserta."','".$kataLaluanPeserta."')";
    }
    if (mysqli_query($con, $reg)){
        echo "Registration successful";
    } else{
        echo "Registration unsuccessful";
    }

    echo "<script> window.location.href = '../html/senaraipeserta.php'; </script>";
    ?>