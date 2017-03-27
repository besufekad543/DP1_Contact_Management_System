<?php 
session_start(); 
session_unset(); 	// empty session
session_destroy();  // destroy session
// redirect client to login page
header('Location:index.php'); 
exit; 
?> 

