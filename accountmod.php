<?php

  session_start();
  if(!empty($_SESSION['login_user']))
  {
    $user=$_SESSION['login_user'];
    $ssn=$_SESSION['utin'];
  }

  else
  {
    header('Location: login.html');
  }

?>

<html>
<head>
	<title>Account Modification</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>
	<?php

		$moditem=$_GET['item'];
		switch ($moditem) 
		{
			case 'name':
				$name=$_GET['value'];
				echo '<center><form action="cd.php?cgtype=name" method="POST"> <table cellpadding="5">';
				echo '<tr><td><b>New Name</b></td><td><b>:</b></td><td><input type="text" name="data" title="Enter new name" required></td></tr>';
				echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Modify">   <input type="reset" value="Reset"></center></td></tr>';
				echo "</form></table></center>";
				break;

			case 'email':
				$mail=$_GET['value'];
				echo '<center><form action="cd.php?cgtype=email" method="POST"> <table cellpadding="5">';
				echo '<tr><td><b>New Email</b></td><td><b>:</b></td><td><input type="text" name="data" title="Enter new email" required></td></tr>';
				echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Modify">   <input type="reset" value="Reset"></center></td></tr>';
				echo "</form></table></center>";
				break;

			case 'phone':
				$phone=$_GET['value'];
				echo '<center><form action="cd.php?cgtype=phone" method="POST"> <table cellpadding="5">';
				echo '<tr><td><b>New Phone no</b></td><td><b>:</b></td><td><input type="text" name="data" title="Enter new Phone number" required></td></tr>';
				echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Modify">   <input type="reset" value="Reset"></center></td></tr>';
				echo "</form></table></center>";
				break;

			case 'primaryacc':
					echo '<center> <form action="cd.php?cgtype=updpri&bank='.$_GET['bank'].'&acc='.$_GET['acc'].'" method="POST"><table cellpadding="5">';
					echo '<tr><td><b>Current  primary Bank Id</b></td><td><b>:</b></td><td>'.$_GET['bank'].'</td></tr>';
					echo '<tr><td><b>Current primary Account number</b></td><td><b>:</b></td><td>'.$_GET['acc'].'</td></tr>';
					echo '<tr><td><b>New primary Bank Id</b></td><td><b>:</b></td><td><input type="text" name="nbankid" title="Give new primary bank Id" required></td></tr>';
					echo '<tr><td><b>New primary Account number</b></td><td><b>:</b></td><td><input type="text" name="nacc" title="Give new primary account number" required></td></tr>';
					echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Modify Primary"></center></td></tr>';
					echo "</table></form></center>";

					echo "<center><h1>OR</h1></center>";

					echo '<center> <table cellpadding="5">';
					echo '<tr><td><b>Current primary Bank Id</b></td><td><b>:</b></td><td>'.$_GET['bank'].'</td></tr>';
					echo '<tr><td><b>Current primary Account number</b></td><td><b>:</b></td><td>'.$_GET['acc'].'</td></tr>';
					echo "<tr> <td> </td></tr>";

					include("conf.php");

					$query = "SELECT * FROM has_additional WHERE ssn = '$ssn';";
					$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());

					if (mysqli_num_rows($run) > 0)
					{
			    		while($data = mysqli_fetch_assoc($run)) 
			    		{
			    			$data1=$data['bankid'];
			    			$data2=$data['banumber'];
			    			$status=$data['verified'];
			    			
			    			echo '<tr><form action="cd.php?cgtype=chgpri&bank='.$_GET['bank'].'&acc='.$_GET['acc'].'" method="POST">';
				    		echo '<td align="center"><input type="text" name="nbankid" value="'.$data1.'" readonly></td>';
				    		echo '<td align="center"><input type="text" name="nacc" value="'.$data2.'" readonly></td>';
				    		echo '<td align="center">';
				    		if ($status == '1') 
							{
								echo '<span class="acctable" style="color:green;">Verified</span>';
							}

							else
							{
								echo '<span style="color: red;font-size:20;">Pending</span>';
							}
							echo "</td>";
							echo '<td align="center"><input type="submit" name="submit" value="select" ></td>';
				       		echo "</form></tr>";
				       		
			    			
			    		}
					}

					mysqli_close($con);
					echo "</table></center>";
				break;

			case 'secondaryacc':
					echo '<center> <table cellpadding="5">';
					echo '<tr><td><b>Current Bank Id</b></td><td><b>:</b></td><td>'.$_GET['bank'].'</td></tr>';
					echo '<tr><td><b>Current Account number</b></td><td><b>:</b></td><td>'.$_GET['acc'].'</td></tr>';
					echo '<tr><td colspan="3"><center><form action="cd.php?cgtype=delsec&bank='.$_GET['bank'].'&acc='.$_GET['acc'].'" method="POST"><input type="submit" name="submit" value="Delete"></form></center></td></tr>';
					echo "</table></center>";

					echo "<center><h1>OR</h1></center>";

					echo '<center> <form action="cd.php?cgtype=updsec&bank='.$_GET['bank'].'&acc='.$_GET['acc'].'" method="POST"><table cellpadding="5">';
					echo '<tr><td><b>Current Bank Id</b></td><td><b>:</b></td><td>'.$_GET['bank'].'</td></tr>';
					echo '<tr><td><b>Current Account number</b></td><td><b>:</b></td><td>'.$_GET['acc'].'</td></tr>';
					echo '<tr><td><b>New Bank Id</b></td><td><b>:</b></td><td><input type="text" name="nbankid" title="Give new bank Id " required></td></tr>';
					echo '<tr><td><b>New Account number</b></td><td><b>:</b></td><td><input type="text" name="nacc" title="Give new account number" required></td></tr>';
					echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Change"></center></td></tr>';
					echo "</table></form></center>";
				break;

			case 'addsec':
					echo '<center><form action="cd.php?cgtype=addsec" method="POST"> <table cellpadding="5">';
					echo '<tr><td><b>New Bank Id</b></td><td><b>:</b></td><td><input type="text" name="data1" title="Enter new bank id" required></td></tr>';
					echo '<tr><td><b>New Account number</b></td><td><b>:</b></td><td><input type="text" name="data2" title="Enter new account number" required></td></tr>';
					echo '<tr><td colspan="3"><center><input type="submit" name="submit" value="Add">   <input type="reset" value="Reset"></center></td></tr>';
					echo "</form></table></center>";
				break;
			
			default:
				
				break;
		}
	?>
</body>
</html>