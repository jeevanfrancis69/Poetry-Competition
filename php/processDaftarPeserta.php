<?php
    session_start();

    require_once "../connect.php";
    $usernamePeserta = mysqli_escape_string($con, $_POST['usernamePeserta']);
    $namaPeserta = mysqli_escape_string($con, $_POST['namaPeserta']);
    $kataLaluanPeserta = mysqli_escape_string($con, $_POST['kataLaluanPeserta']);
    $ComKataLaluanPeserta = mysqli_escape_string($con, $_POST['ComKataLaluanPeserta']);
    $umurPeserta = mysqli_escape_string($con, $_POST['umurPeserta']);
    $emelPeserta = mysqli_escape_string($con, $_POST['emelPeserta']);

    $hashedPassword = password_hash($kataLaluanPeserta, PASSWORD_DEFAULT);

    $sel = "SELECT * FROM user WHERE usernamePeserta = '$usernamePeserta'";
    $result = mysqli_query($con, $sel);
    $num = mysqli_num_rows($result);

    if ($kataLaluanPeserta !== $ComKataLaluanPeserta){
        echo "<script> alert('Passwords do not match!');
        window.history.back();
        </script>";
        exit();
    }

    else if ($num >= 1){
        $_SESSION['user_exists'] = "User already exists";
        header("Location: ../html/daftarpeserta.php");
        exit();
    }
        
    else{

        $reg = "INSERT into user(usernamePeserta, namaPeserta, kataLaluanPeserta , umurPeserta , emelPeserta)
        values('".$usernamePeserta."', '".$namaPeserta."','".$hashedPassword."', '".$umurPeserta."' , '".$emelPeserta."')";
          
          
          if (mysqli_query($con, $reg)){
            $_SESSION['success'] = "Registration successful!";
            header("Location: ../html/intro.php");
            exit();
            
        } else{
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: ../html/register.php");
            exit();
        }
    }
?>
  