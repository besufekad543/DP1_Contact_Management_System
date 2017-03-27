<?php 
session_start(); 
if($_SERVER["HTTPS"] != "on")
{ 
header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); exit(); 
}
include("header.php");

if ((time() - $_SESSION['time']) > 120) { // with inactivity period too long 
	session_unset(); 	// empty session
	session_destroy();  // destroy session
	// redirect client to login page
	header('Location:index.php?msg=SessionTimeOut'); 
	exit; 
} 
else 
{
   $_SESSION['time']=time();
}
?> 

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
		else if ($_GET['msg']=="alreadyinserted")
		{
		echo "<i><font color=green>This Contact is already added</font></i>";
		}
?>
<script type="text/javascript">
function validateForm()
{
	
	
   var email=document.forms["registration"]["email"].value;
   var contactlist=document.forms["registration"]["contactlist"].value;
	  if(!email)
	  {
		if(!contactlist)
		{
			alert("Please provide username or select contact from the list");
			return false;
		}
	  }
  	if(email && contactlist)
	{
		alert("Please provide username OR select contact from the list not both");
			return false;
	}
	if(email)
	{
	var x=document.forms["registration"]["email"].value;
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length  || !filter.test(x) )
	  {
		alert("e-mail address in your username field is not valid ");
		return false;
	  }
	}
	
} 
</script>   
<script type="text/javascript">
$(function()
{
	$('*[name=openingtime]').appendDtpicker(
	{
	//"minute_interval": 5
	});

	$('*[name=closingtime]').appendDtpicker(
	{
	//"minute_interval": 5
	});

}
  );


</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<h1>Add New Contact</h1>

<!-- user registation -->
<form  method="post" name="registration" action ="viewcontacts.php" onsubmit="return validateForm();"> 
<div class="form">
		<table width="568">
			
			<tr><td colspan="4">You can provide new username OR select contact from list</td></tr>
		 	<tr>
			  <td class "colored" width="78">UserName</td>
		      <td width="151"><input name="email" type="text" onfocus="showHint('email');" onblur="hideHint('email');"/></td>
		      <td width="90"><div style="visibility:hidden"  id="email">Provide your email</div></td>
			   <td width="229"><p><strong>Sugggested contact list </strong></p>		      </td>
			</tr>
			
			<tr>
			 <td width="78">List of Contacts</td>
			 <td width="151"><select name="contactlist" onfocus="showHint('contactlist');" onblur="hideHint('contactlist');">
               <option value="">--select--</option>
               <?php
				//list the possible/available stations
				$query = "SELECT distinct contacts.email,  users.numberofcontact FROM contacts, users  where contacts.email = users.username and contacts.email != '".$_SESSION['username']."' and contacts.email not in (SELECT distinct contacts.email FROM contacts, users  where contacts.email = users.username and contacts.username= '".$_SESSION['username']."')";
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_array($result)) {
					?>
               <option  value="<?php echo $row[0]; ?>" 
						<?php echo ($_POST['contactlist']==$row[0]) ? 'selected' : '' ?> > <?php echo $row[0]; ?> </option>
               <?php
					}
				?>
             </select></td>
			 <td width="90"><div style="visibility:hidden"  id="contactlist">Select contact from the list</div></td>
		     <td width="229"><table width="229" class="colored">
               <thead>
                 <tr>
                   <th align="left">Contacts</th>
                   <th align="left">Number of contacts</th>
                 </tr>
               </thead>
               <tbody>
                 <?php

$query = "SELECT distinct contacts.email,  users.numberofcontact FROM contacts, users  where contacts.email = users.username and contacts.email != '".$_SESSION['username']."' and contacts.email not in (SELECT distinct contacts.email FROM contacts, users  where contacts.email = users.username and contacts.username= '".$_SESSION['username']."')";
 
		if(!mysqli_num_rows(mysqli_query($conn,$query))>0){
		   echo "<tr><td colspan=6><i>There are no suggested contacts now</i></td></tr>";
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
							  	 
						       </td>
				       </tr>";
				}			
		     }
		?>
                 </tr>
               </tbody>
             </table></td>
			</tr>
	  </table>
        <p>
          <left>
            <input type="submit" name="register" value="Add as contact"/></p>
  </div>
</form> 
<!-- form -->
<?php include("footer.php"); ?>

