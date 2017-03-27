
<?php
session_start();
if($_SERVER["HTTPS"] != "on")
{ 
header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); exit(); 
}
include("header.php");
?>

<?php
		//session, authentication and authorization error messages
		
		if ($_GET['msg']=="SessionTimeOut") {
			echo "<i><font color=red>Your session has expired, you have to login</font></i>";
		}
		else if ($_GET['msg']=="HavetoLogin") {
			echo "<i><font color=red>You have to login to access this page</font></i>";
		}
		else if ($_GET['msg']=="NotAuthorized") {
			echo "<i><font color=red>You are not authorized to access this page, login as ligitimate user</font></i>";
		}
		else if ($_GET['msg']=="NewlyRegistered") {
			echo "<i><font color=green>Thank you for registration, you can now login</font></i>";
		}
		
?>

<script type="text/javascript">
function validateForm()
{
   var username=document.forms["login"]["username"].value;
   if (username==null || username=="")
     {
	  alert("Please insert a valid Username must be filled");
	  return false;
     }
	
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var atpos=username.indexOf("@");
	var dotpos=username.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=username.length  || !filter.test(username) )
	  {
		alert("Invalid username");
		return false;
	  }
   var password=document.forms["login"]["password"].value;
   if (password==null || password=="")
     {
	  alert("Password must be filled");
	  return false;
     }
	 
}    
</script>

<h1>Login</h1>
<?php
//This function is to prevent sql injection attacks 
function safe($string){  
	if (get_magic_quotes_gpc()) 
	$string = stripcslashes($string);
	$string = strip_tags($string);	
	return mysql_real_escape_string($string);
} 
?>
		<?php
		if (isset($_POST['login'])) {
				$usname=safe($_POST['username']);
				$pswdme=safe($_POST['password']);
				$query = "SELECT user_id, username, password FROM users";
				if ($stmt = mysqli_prepare($conn, $query)) {
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $user_id, $email, $password);
					while (mysqli_stmt_fetch($stmt)) {
						if ($usname==$email && $pswdme==$password) {
						$_SESSION['user_id']=$user_id;
						$_SESSION['time']=time();
						$_SESSION['username']=$email;
					  	header('Location:contactpublic.php'); 					
						}
					}
					echo "<i><font color=red><br/>Invalid credentials!</font></i>";
					mysqli_stmt_close($stmt);
				}
				else {die('Error in prepared statement');}
				mysqli_close($conn);
		}
		?>
		
		<!-- user login form -->
		<form method="post" name="login" onSubmit="return validateForm();">
		  <div class="form">
				<table width="637">
				  <tr>
				  <td width="85" align="right">User Name</td>
					   <td width="148"><input type="text" name="username" onfocus="showHint('username');" onblur="hideHint('username');"/></td><td width="388"><div style="visibility:hidden" id="username"><i>Provide your email </i></div></td></tr>
				       <tr><td align="right">Password</td>
					   <td><input type="password" name="password" onfocus="showHint('password');" onblur="hideHint('password');"/></td><td width="388"><div style="visibility:hidden" id="password"><i>Provide your password</i> </div></td></tr>
					    <tr>
					      <td colspan="2" align="right">New User? <a href="signup.php" target="_self">Sign Up</a></td>
					   </tr>
				       <tr><td colspan=2><center><input type="submit" name="login" value="Sign In"/></center></td></tr>
			  </table>

			   
		  </div>
		</form><!-- form -->
<?php include("footer.php"); ?>
