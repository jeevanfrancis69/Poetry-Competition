<?php
session_start();

if(isset($_SESSION['error'])){
    echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>


<!DOCTYPE html> 
<html> 
 <head> 
 <meta cherset = "utf-8"> 
 <title>Pertandingan Mendeklamasikan Sajak</title> 
 <link rel= "stylesheet" href = "../css/login.css"> 
 <head> 
    <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" 
    />
    <link rel = "stylesheet" href = "../css/register.css">
</head> 
<ul> 
<ul> 
    <li  class="active"><a href="../html/loginmasuk.php">Home</a></li> 
    <li><a href=../html/intro.html>Introduction </a></li> 
    <li><a href="../html/aboutus.html">About Us</a></li> 
    <li><a href="../html/daftarpeserta.php">Register</a></li> 
   </ul>
   </ul> 
 <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" 
/> 
</head> 
<div class = "login-box"> 
 <form action="../php/processDaftarPeserta.php" method="POST"> 
  <h1 class = "animate__animated animate__fadeInDown"> Register </h1> 
  <div class = "textbox"> 
   <i class="fa fa-user" aria-hidden="true"></i> 
   <input type = "text", placeholder = "Enter Username", name = "usernamePeserta", class = "animate__animated animate__fadeInDown" minlength = 5 maxlength = 20 required> 
  </div> 
  <div class = "textbox"> 
   <i class="fa fa-user" aria-hidden="true"></i> 
   <input type = "text", placeholder = "Enter Name", name = "namaPeserta", class = "animate__animated animate__fadeInDown" minlength = 7 maxlength = 50 required> 
  </div> 
  <div class = "textbox"> 
   <i class="fa fa-lock" aria-hidden="true"></i> 
   <input type = "password", placeholder = "Password", name = "kataLaluanPeserta", value = "" class = "animate__animated animate__fadeInDown" required> 
  </div> 
  <div class = "textbox"> 
   <i class="fa fa-lock" aria-hidden="true"></i> 
   <input type = "password", placeholder = "Confirm Password", name = "ComKataLaluanPeserta", value = "" class = "animate__animated animate__fadeInDown" required> 
  </div> 
  <div class = "textbox" >
    <i class = "fa fa-lock" aria-hidden="true"></i>
    <input type = "text" , placeholder = "Enter Email" , name = "emelPeserta" , value = "" class = "animate__animated animate__fadeInDown" required>
    </div>
    <div class = "textbox"> 
   <i class="fa fa-user" aria-hidden="true"></i> 
   <input type = "text", placeholder = "Enter Age", name = "umurPeserta", class = "animate__animated animate__fadeInDown" required> 
  </div> 


  <input class = "btn" type = "submit" name = "" value = "Register" class = "animate__animated animate__fadeInDown"> 
  </div> 
  </form> 
  </body> 
 
 
</html>