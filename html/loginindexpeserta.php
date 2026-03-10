<ul> 
    <li  class="active"><a href="../html/loginmasuk.php">Home</a></li> 
    <li><a href=../html/kedudukan.php>Result</a></li> 
    <li><a href=../php/logout.php>Logout</a></li> 
   </ul>
<?php 
    
    session_start();
    include '../Safety.php';
    include '../connect.php';
    $usernamePeserta = $_SESSION['usernamePeserta'];

    $sel= "SELECT * FROM peserta WHERE usernamePeserta = '".$usernamePeserta."'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sel))
 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <link rel="stylesheet" href="../css/loginindex.css"> 
        <script type="text/javascript "src="../js/loginindex.js" defer></script> 
        <title>LoginIndex</title> 
    </head> 
    <body onload="accuracyBarSetting(<?php echo $row['markah'] ?>)"> 
        <div class="main_container"> 
            <div class="profile"> 
                <h1>Profile</h1> 
                <p>Username :<span id="data"><?php echo $usernamePeserta; ?><p>
                <p>Name: <span id="data"><?php echo $row['namaPeserta']; ?></p> 
                <p>Password: <span id="data"><?php echo $row['kataLaluanPeserta'] ?></span></p> 
                <p>Point: <span id="data"><?php echo $row['markah'] ?></span></p> 
                <p id="label">Average accuracy: <?php echo $row['markah'] ?>%</span></p> 
                <div class="accuracy"></div> 
                <div class="accuracy accuracy_bar" id="accuracy_bar"></div> 
            </div> 
    </body> 
</html>
