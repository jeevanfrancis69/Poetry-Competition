<?php
    require "../connect.php";

    $Student = $_POST['List'];
    $count = 0;

    foreach ($Student as $a){
        $del = "DELETE FROM peserta WHERE usernamePeserta = '".$a."'";
        mysqli_query($con, $del);
    }
?>