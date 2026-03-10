<?php
if (isset($_SESSION['success'])) {
    echo '<p style="color: #c9a84c; text-align:center;">✓ ' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    echo '<p style="color: #e74c3c; text-align:center;">✗ ' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>


<ul> 
    <li class="active"><a href="../html/loginmasuk.php">Home</a></li> 
    <li><a href=../html/intro.php>Introduction </a></li>  
</ul>

<link rel= "stylesheet" href = ../css/about_us.css>
<div class="container"> 
 <div class="row title"> 
   <h1>Contact us</h1> 
 </div> 
 <div class="row"> 
   <h4 style="text-align:center">For any enquiry, we will reply you within 3 working days.</h4> 
 </div> 
 <div class="row input-container"> 
   <div class="col-xs-12"> 
    <div class="styled-input wide"> 
     <input type="text" name="Name" required /> 
     <label>Name</label>  
    </div> 
   </div> 
   <div class="col-md-6 col-sm-12"> 
    <div class="styled-input"> 
     <input type="email" name="Email" required /> 
     <label>Email</label>  
    </div> 
   </div> 
   <div class="col-md-6 col-sm-12"> 
    <div class="styled-input" style="float:right;"> 
     <input type="text" name="PhoneNum" required /> 
     <label>Phone Number</label>  
    </div> 
   </div> 
   <div class="col-xs-12"> 
    <div class="styled-input wide"> 
     <textarea name="Message" required></textarea> 
     <label>Message</label> 
    </div> 
   </div> 
   <div class="col-xs-12"> 
    <div class="btn-lrg submit-btn"> 
                    <input type = 'submit'> 
                </div> 
   </div> 
        </form> 
 </div> 
</div>