<?php
    require '../connect.php';
    $usernamePeserta = mysqli_escape_string($con, $_POST['usernamePeserta']);
    $namaPeserta = mysqli_escape_string($con, $_POST['namaPeserta']);
    $kataLaluanPeserta = mysqli_escape_string($con, $_POST['kataLaluanPeserta']);
    $OriNoUser = $_POST['OriNoUser'];
    $markah = $_POST['MarkahPeserta'];
    $update= "UPDATE peserta SET namaPeserta = '". $namaPeserta ."', usernamePeserta = '". $usernamePeserta ."', kataLaluanPeserta = '". $kataLaluanPeserta."' , Markah = '".$Markah."' WHERE usernamePeserta='".$OriNoIC."'";
    if (mysqli_query($con, $update)){
        echo '<script>alert("Update Successful!")</script>';
    }
    $update= "UPDATE rank SET usernamePeserta = '".$usernamePeserta."'  WHERE ICPeserta='".$OriNoUser."'";
    if (mysqli_query($con, $update)){
        echo '<script>alert("Update Successful!")</script>';
    }

    echo "<script> window.location.href = '../html/senaraipeserta.php'; </script>";
?>