<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />

<link rel="stylesheet" type="text/css" href="css/style.css" />

<title>CONTACT MANAGMENT SYSTEM</title>
<script type="text/javascript">
function checkCookie(){
var cookieEnabled=(navigator.cookieEnabled)? true : false   
if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){ 
	document.cookie="testcookie";
	cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false;
}
return (cookieEnabled)?true:showCookieFail();
}

function showCookieFail(){
document.write("<style type='text/css'> .container {display:none;}</style><div class='noscriptmsg'><center><p><h3>You don't have cookies enabled. Access to the site blocked, it may not work properly!</h3></p></center></div>");;
}
checkCookie();
</script>
<!-- check if java script is disabled and block the site content if so -->
<noscript>
<style type="text/css">
	.container {display:none;}
</style>
<div class="noscriptmsg">
 <center><p><h3>You don't have javascript enabled. Access to the site blocked, it may not work properly!</h3></p></center>
</div>
</noscript>

<script type="text/javascript">
function hideHint(box)
{
 document.getElementById(box).style.visibility='hidden';
}
function showHint(box)
{
 document.getElementById(box).style.visibility='visible';
}
</script>

</head>

<body>

<div class="container">
<div class="page">
	<div id="header">
		<div id="logo">
			CONTACT MANAGMENT SYSTEM</div>
		<!-- logo -->

	</div><!-- header -->
</div><!-- page -->

<div id="headerbreak"></div>

<?php
	//connection to the database	
	$conn = mysqli_connect('localhost', 'root','root','s202500');
	if (!$conn) {
	die('Connect error ('. mysqli_connect_errno() . ') '. mysqli_connect_error());
	}
	$conn2 = mysql_connect("localhost", "root", "root");
	mysql_select_db("s202500", $conn2);
	
?>
<?php
	/*
	//connection to the database
		$conn = mysqli_connect('localhost', 's202500','entrowea','s202500');
		if (!$conn) 
		{
		die('Connect error ('. mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		
		$conn2 = mysql_connect("localhost", "s202500", "entrowea");
		mysql_select_db("s202500", $conn2);	
		*/		
?>

<div class="page">
	<div class="leftnav">
		<div class="portlet" style="width:100%">
			<div class="header">Navigation</div>
			<div class="content">
				<p>
				<?php //show navigation links based on admin or logged in user or guest role
					if (isset($_SESSION['username'])) {
						 ?><br/>
						  <a href="newcontact.php" >Add Contact </a><br/>
						  <a href="viewcontacts.php" > My Contacts List</a><br/>
						
						  <a href="signout.php" >Sign Out</a><br/> 
					<?php
					}  
					else { ?>
					   <a href="index.php" >Sign In</a><br/>
					   <a href="signup.php" >Sign Up</a><br/>
					<?php
					} ?>
				<br />
				
				<a href="contactpublic.php" >Show  summary </a><br/>
		  </div>
		</div>
		
		<?php	if (isset($_SESSION['username'])) {
					
					echo "Signed in as: <i>".$_SESSION['username']."</i>";
					}
		?>

	</div>
	<div id="content">


