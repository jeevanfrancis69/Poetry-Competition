<?php 
    
    include '../connect.php';
    $usernamePeserta = $_POST['usernamePeserta'];

    $sel= "SELECT * FROM peserta WHERE usernamePeserta = '".$usernamePeserta."'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sel));

    $num = mysqli_num_rows(mysqli_query($con, $sel));
    if ($num == 0){
        echo '<script>alert("Tiada Rekod")</script>';
        echo "<script> window.location.href = '../html/laporan.html'; </script>";
    }else{
        echo '<script>alert("Rekod Dicari")</script>';?>
    <html lang="en"> 
        <head> 
            <link rel="stylesheet" href="../css/loginIndex.css"> 
            <script type="text/javascript "src="../js/LoginIndex.js" defer></script> 
            <title>Laporan</title> 
        </head> 
        <body onload="accuracyBarSetting(<?php echo $row['Markah'] ?>)"> 
            <div class="main_container"> 
                <div class="profile"> 
                    <h1>Profile</h1> 
                    <p>Username: <span id="data"><?php echo $usernamePeserta; ?><p>
                    <p>Name: <span id="data"><?php echo $row['namaPeserta']; ?></p> 
                    <p>Point: <span id="data"><?php echo $row['markah'] ?></span></p> 
                    <p id="label">Average accuracy: <?php echo $row['markah'] ?>%</span></p> 
                    <div class="accuracy"></div> 
                    <div class="accuracy accuracy_bar" id="accuracy_bar"></div> 
                </div> 
        </body> 
    </html>
   <?php }
 
?> 
 