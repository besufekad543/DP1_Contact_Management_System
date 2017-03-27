
<?php include("header.php"); 
?>

<script type="text/javascript">
//Input validation using javascript
function validateForm()
{

var email=document.forms["registration"]["email"].value;

if (email==null || email=="")
 {
  alert("UserName must be filled!");
  return false;
 }


var x=document.forms["registration"]["email"].value;
var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length  || !filter.test(x) )
  {
	alert("e-mail address in your username field is not valid ");
	return false;
  }


var password=document.forms["registration"]["password"].value;
if (password==null || password=="")
 {
  alert("Password must be filled");
  return false;
 }
 

}   

</script>
<?php
//Input validation using php

?>

<h1>Registration</h1>

<?php
//This function is to prevent sql injection attacks 
function safe($string){  
if (get_magic_quotes_gpc()) 
$string = stripcslashes($string);
$string = strip_tags($string);	
return mysql_real_escape_string($string);
} 
?>

<!-- user registation -->
<?php
try{
// registration
if (isset($_POST['register'])) {
	
	$username =safe($_POST['email']);
	$passw =safe($_POST['password']);
	$confpass = safe($_POST['confpassword']);
	
	$result = mysql_query("SELECT * FROM users WHERE email='$username' LIMIT 1", $conn2);
	$num_rows = mysql_num_rows($result);
	
	// username exists
	if ($num_rows > 0) {
		echo "<i><font color=red>User name already exists, please choose another username</font></i>";
	}
	if ($passw != $confpass) {	
 
		echo "<i><font color=red>The password you entered doesn't much, please enter your password again</font></i>";
	}
	else {
	  // create user
		$query = "INSERT INTO users (`username`,`password`,`numberofcontact`) 
		VALUES ('$username','$passw',0)";
				mysqli_autocommit($conn, false);
				if(!$result = $conn->query($query)) {
				die("cannot do registration!");
				}
				
				// user will be taken to login form after registration
				header('Location:index.php?msg=NewlyRegistered'); 
	}
}
mysqli_commit($conn);
} catch (Exception $e) {
mysqli_rollback($conn);
echo "Rollback ".$e->getMessage();
}
?>
<form  method="post" name="registration" onsubmit="return validateForm();"> 
<div class="form">
	<table width="399">
		
		<tr>
		  <td height="19" align="right"><p>Username </p>		      </td>
		   <td><input name="email" type="text" value="<?php echo $_SESSION['email']; ?>"onfocus="showHint('email');" onblur="hideHint('email');" /></td>
		   <td><div style="visibility:hidden" id="email"><i>Provide a valid email address</i></div></td>
		</tr>
		</tr>
		
		   <tr><td align="right">Password</td>
		   <td><input type="password" name="password" onfocus="showHint('password');" onblur="hideHint('password');"/></td>
		   <td><div style="visibility:hidden" id="password"><i>Provide your password here</i></div></td>
		</tr>
		<tr><td align="right">Confirm Password</td>
		   <td><input type="password" name="confpassword" onfocus="showHint('confpassword');" onblur="hideHint('confpassword');"/></td>
		   <td><div style="visibility:hidden" id="confpassword"><i>Confirm your password here</i></div></td>
		</tr>
		   <tr><td colspan=2><center><input type="submit" name="register" value="Register"/></center></td></tr>
	</table>

</div>
</form> <!-- form -->
<?php include("footer.php"); ?>

