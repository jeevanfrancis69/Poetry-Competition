<?PHP  
//Destroy and eliminate session
session_start(); 
session_unset(); 
session_destroy(); 
echo
" <script> 
alert('Thank you for staying with us! '); 
window.location.href='../html/loginmasuk.php'; 
</script> 
"; 
?>