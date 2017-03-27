<?php 
session_start(); 
include("header.php");
?> 

<h1>Summary&nbsp;
  </p>
</h1>


<table class="colored" width="212" height="54">
	<thead>
	<tr>
		
	
		<th width="204" align=left>Number of contacts of highest three persons in decreasing order </th>
		
	</tr>
	</thead>
	<tbody>
	<?php

$query = "SELECT numberofcontact FROM users order by numberofcontact desc LIMIT 3";
//$query = "SELECT users.username, users.numberofcontact FROM contacts, users  where users.username = contacts.email and users.username = users.username order by users.numberofcontact desc";

		if(!mysqli_num_rows(mysqli_query($conn,$query))>0){
		   echo "<tr><td colspan=6><i>There are no records now</i></td></tr>";
		}
		else {
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_array($result)) 
				{
				?>
					<tr onmouseover="this.style.backgroundColor='#d4e3e5';" onmouseout="this.style.backgroundColor='#F8F8F8';">
				<?php
						 echo "<td>".$row[0]."</td>
						       
						     
						       </td>
				       </tr>";
				}			
		     }
		?>
    </tbody>
</table>
<table class="colored" width="213" height="28">
	<thead>
	<tr>
		
		<th width="205" align=left>Number of Signed up User</th>
		
		
	</tr>
	</thead>
	<tbody>
	<?php
$query = "SELECT count(*) FROM users";

		if(!mysqli_num_rows(mysqli_query($conn,$query))>0){
		   echo "<tr><td colspan=6><i>There are no records now</i></td></tr>";
		}
		else {
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_array($result)) 
				{
				?>
					<tr onmouseover="this.style.backgroundColor='#d4e3e5';" onmouseout="this.style.backgroundColor='#F8F8F8';">
				<?php
						 echo "<td>".$row[0]."</td>
						       
						     
						       </td>
				       </tr>";
				}			
		     }
		?>
    </tbody>
</table>
<p>
<?php include("footer.php"); ?>

