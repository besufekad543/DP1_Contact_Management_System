<?php 
	session_start();
   include("header.php");
	
	if($_SERVER["HTTPS"] != "on")
	{
	 header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); 
	 exit(); 
	 }
 
	if ((time() - $_SESSION['time']) > 120) { // new or with inactivity period too long 
		session_unset(); 	// empty session
		session_destroy();  // destroy session
		// redirect client to login page
		header('Location:index.php?msg=SessionTimeOut'); 
		exit; 
	} 
	else {
	   $_SESSION['time']=time();
	}
?> 


<?php
//This function is to prevent sql injection attacks 
function safe($string){  
if (get_magic_quotes_gpc()) 
$string = stripcslashes($string);
$string = strip_tags($string);	
return mysql_real_escape_string($string);
} 
?>

<h1>View my contact list </h1>
<p>
  <?php
		if ($_GET['msg']=="1recordinserted") 
	 	{
			echo "<i><font color=green>New Contact Sucessfully Added</font></i>";
		}
		else if ($_GET['msg']=="1recorddeleted")
		{
		echo "<i><font color=green>Your contact deleted sucessfully</font></i>";
		}
?>
  
<?php

try{
		mysqli_autocommit($conn, false);
	
		// registration
		if (isset($_POST['register']))
		{
			$email=safe($_POST['email']);
			$uname=$_SESSION['username'];
			$result = mysql_query("SELECT * FROM users WHERE username='$email' LIMIT 1", $conn2);
			$num_rows = mysql_num_rows($result);
			if($_POST['email'] !=null){
				// username exists
				if ($num_rows > 0) {
						
						$result_ar1 = mysql_query("SELECT * FROM contacts WHERE username ='$uname' and email='$email' LIMIT 1", $conn2);
						$num_rows = mysql_num_rows($result_ar1);
						if ($num_rows > 0) {
							//this contact is already your contact
							header('Location:newcontact.php?msg=alreadyinserted');
						}
						else
						{
						
							if($uname==$email)
							{
								$query6 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$uname','$email')";
								if(!$result = $conn->query($query6)) {
									die("can't register new contact!");
								}
								$query_s6 = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$uname'";				
								if(!$result6 = $conn->query($query_s6)) 
								{
									die("aint update numberofcontact!");
								}
							}
							else
							{
								$query1 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$uname','$email')";	
								if(!$result = $conn->query($query1)) {
									die("can't register new contact!");
								}	
								$query2 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$email','$uname')";
								if(!$result = $conn->query($query2)) {
									die("can't register new contact!");
								}
								header('Location:viewcontacts.php?msg=1recordinserted');
								
								$query_r = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$email'";				
								if(!$result1 = $conn->query($query_r)) 
								{
									die("aint update numberofcontact!");
								}
								$query_s = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$uname'";				
								if(!$result1 = $conn->query($query_s)) 
								{
									die("aint update numberofcontact!");
								}
							}
						}
				}
				else {
						// create user
						$query0 = "INSERT INTO users (`username`,`password`,`numberofcontact`) 
						VALUES ('$email','pass',0)";
						if(!$result = $conn->query($query0)) {
							die("can't register new contact0!");
						}
						
						$result_ar = mysql_query("SELECT * FROM contacts WHERE username ='$uname' and email='$email' LIMIT 1", $conn2);
						$num_rows = mysql_num_rows($result_ar);
						if ($num_rows > 0) {
							//this contact is already your contact
							header('Location:newcontact.php?msg=alreadyinserted');
						}
						else
						{
							if($uname==$email)
							{
								$query6 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$uname','$email')";
								if(!$result = $conn->query($query6)) {
									die("can't register new contact!");
								}
								$query_s6 = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$uname'";				
								if(!$result6 = $conn->query($query_s6)) 
								{
									die("aint update numberofcontact!");
								}
							}
							else
							{
							
								$query1 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$uname','$email')";
								if(!$result = $conn->query($query1)) {
								die("can't register new contact!");
								}
								$query2 = "INSERT INTO contacts (`username`, `email`) 
								VALUES ('$email','$uname')";
								
								if(!$result = $conn->query($query2)) {
								die("can't register new contact!");
								}
								header('Location:viewcontacts.php?msg=1recordinserted');
								
								$query_s26 = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$email'";				
								if(!$result26 = $conn->query($query_s26)) 
								{
									die("aint update numberofcontact!");
								}
								
								$query_s27 = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$uname'";				
								if(!$result27 = $conn->query($query_s27)) 
								{
									die("aint update numberofcontact!");
								}
							}
						}
						}
					
			}
			else
			{
				$contactlist=safe($_POST['contactlist']);
				print_r($email);
				$uname=$_SESSION['username'];
					
				$result_ar1 = mysql_query("SELECT * FROM contacts WHERE username ='$uname' and email='$contactlist' LIMIT 1", $conn2);
				$num_rows = mysql_num_rows($result_ar1);
					if ($num_rows > 0) {
							//this contact is already your contact
							header('Location:newcontact.php?msg=alreadyinserted');
					}
					else
					{
						$query1 = "INSERT INTO contacts (`username`, `email`) 
						VALUES ('$uname','$contactlist')";	
						if(!$result = $conn->query($query1)) {
							die("can't register new contact!");
						}	
						$query2 = "INSERT INTO contacts (`username`, `email`) 
						VALUES ('$contactlist','$uname')";
						if(!$result = $conn->query($query2)) {
							die("can't register new contact!");
						}
						header('Location:viewcontacts.php?msg=1recordinserted');
						
						$query_r = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$contactlist'";				
						if(!$result1 = $conn->query($query_r)) 
						{
							die("aint update numberofcontact!");
						}
						$query_s = "UPDATE users SET numberofcontact=numberofcontact+1 WHERE username = '$uname'";				
						if(!$result1 = $conn->query($query_s)) 
						{
							die("aint update numberofcontact!");
						}
						
					}
				
			}
		}
		mysqli_commit($conn);		
}
catch (Exception $e) {
	mysqli_rollback($conn);
	echo "Rollback ".$e->getMessage();
}
	
?>







<?php
try{
//canceling a item record --
if (isset($_GET['email']) && $_GET['action']=='delete') {
	
	if($_GET['email']==$_SESSION['username'])
	{
	$query6 = "delete from contacts where username ='".$_SESSION['username']."' and email ='".$_GET['email']."'";
			if(!$result = $conn->query($query6)) {
			  die("cannot delete a record!");
		}
		$query_s16 = "UPDATE users SET numberofcontact=numberofcontact-1 WHERE username = '".$_SESSION['username']."'";				
		if(!$result16 = $conn->query($query_s16)) 
		{
			die("aint update numberofcontact!");
		}
	}
	else
	{
		$query2 = "delete from contacts where username ='".$_SESSION['username']."' and email ='".$_GET['email']."'";
			if(!$result = $conn->query($query2)) {
			  die("cannot delete a record2!");
		}
		
		$query3 = "delete from contacts where email='".$_SESSION['username']."' and username='".$_GET['email']."'";
		if(!$result = $conn->query($query3)) {
			 die("cannot delete a record!");
		}
		
		
		$query_s12 = "UPDATE users SET numberofcontact = numberofcontact - 1 WHERE username = '".$_SESSION['username']."' and numberofcontact>0 ";				
		if(!$result12 = $conn->query($query_s12)) {
			print_r($query_s12);
			die("aint update numberofcontact!");
		}
		$query_s13 = "UPDATE users SET numberofcontact = numberofcontact - 1 WHERE username = '".$_GET['email']."' and numberofcontact>0 ";				
		if(!$result13 = $conn->query($query_s13)) 
		{
			print_r($query_s13);
			die("aint update numberofcontact!");
		}
		
	}
	//header('Location:mgecontacts.php?msg=1recorddeleted'); 
	header('Location:viewcontacts.php?msg=1recorddeleted'); 
}
mysqli_commit($conn);		
}
catch (Exception $e) {
	mysqli_rollback($conn);
	echo "Rollback ".$e->getMessage();
}
?>
 
  
  <!-- List of all items -->
</p>
<table class="colored">
  <thead>
	<tr>
	 <th align=left>Contacts</th>
	 <th align=left>Number of contacts</th>
	 <th align=left></th> 
	</tr>
	
  </thead>
  
  <tbody>
<?php
$query = "SELECT distinct contacts.email, users.numberofcontact FROM contacts, users  where contacts.email = users.username and contacts.username = '".$_SESSION['username']."'";
		if(!mysqli_num_rows(mysqli_query($conn,$query))>0){
		   echo "<tr><td colspan=6><i>There are no contacts now</i></td></tr>";
		}
		else {
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_array($result)) 
				{
				?>
					<tr onmouseover="this.style.backgroundColor='#d4e3e5';" onmouseout="this.style.backgroundColor='#F8F8F8';">
				<?php
						 echo "<td>".$row[0]."</td>
							  
							   <td>".$row[1]."</td>
							 
								<td><a href='viewcontacts.php?email=".$row[0]."&action=delete'>Remove contact</a>
								 
							   </td>
					   </tr>";
				}			
			 }
		?>
	</tr>
  </tbody>
</table>

 <?php include("footer.php"); ?>