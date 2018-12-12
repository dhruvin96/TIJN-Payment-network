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
	<title>Payment Network</title>

	<link rel="stylesheet" type="text/css" href="mainstyle.css">
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>

	<div id="header">
		<div id="header1">
			<div style="float: left;position: relative;left: 3%; right: 3%;">
				<img class="profilepic" src="icon1.png" height="50px"; width="50px"; />
			</div>
			<div style="float: right;position: relative;right: 3%;">
				<h2><?php  if (!empty($_SESSION['login_user'])) {
					echo "$user";
				} 
				else
					{
						echo "Guest User";
					} ?></h2>
			</div>

			<div style="float: right;position: relative;top: 15%;left: 9%;">
				<img src="profile.png" height="70%" width="25%" />
			</div>
		</div>

		<div id="header2">
			<div class="drop">
				<button class="menus">Main Menu</button>
				<div class="menu-content">
					<a href="account.php">Account</a>
					<a href="sendmoney.php">Send Money</a>	
					<a href="requestmoney.php">Request Money</a>
					<a href="statement.php">Statements</a>
					<a href="searchtrans.php">Search Transactions</a>
					<a href="signout.php">Sign Out</a>
				</div>
			</div>	

			<div class="drop">
				<button class="menus">Account Functions</button>
				<div class="menu-content">
					<a href="account.php">Modify personal details</a>
					<a href="account.php">Modify E-Mail address</a>
					<a href="account.php">Modify phone number</a>	
					<a href="account.php">Modify bank account</a>
				</div>
			</div>	

			<?php 

				if (!empty($_SESSION['login_user'])) 
				{
					echo '<div style="float: right;">
							<a href="signout.php"><button class="signout">Sign Out</button></a>
						</div>';

				}

				else
				{
					echo '<div style="float: right;">
							<a href="register.html"><button class="signout">Register</button></a>
						</div>

						<div style="float: right;">
							<a href="login.html.html"><button class="signout">Sign In</button></a>
						</div>';
				}
				
			?>
		</div>
	</div>

	<?php
		include("conf.php");

		$query = "SELECT * FROM user_account WHERE ssn = '$ssn';";
		$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
		$name='';
		$verify='';
		$pbankid='';
		$pbano='';
		if (mysqli_num_rows($run) > 0)
		{
    		while($data = mysqli_fetch_assoc($run)) 
    		{
       		 	$name=$data["name"];
       		 	$verify=$data['pbaverified'];
       		 	$pbankid=$data['bankid'];
       		 	$pbano=$data['banumber'];
    		}
		} 	

		else 
		{
		    echo "0 results";
		}

		$query = "SELECT identifier,type FROM electronic_address WHERE ssn = '$ssn';";
		$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
		$email='';
		$phone='';
		if (mysqli_num_rows($run) > 0)
		{
    		while($data = mysqli_fetch_assoc($run)) 
    		{
    			
    			if ($data["type"] == 'email') 
    			{
    				$email=$data["identifier"];
    			}

    			else
    			{
    				$phone=$data['identifier'];
    			}
       		 	
    		}
		} 	

		else 
		{
		    echo "0 results";
		}
	?>

	<div id="body">
		<div id="div1">
			<center>
				<br>
				<img class="profilepic" src="profile.png" height="190px" width="190px" alt="profile.png">
				<br>
				<h2><?php echo "$name";?></h2>
				<br><br><br>
				<a href="#personal_details" class="div1a">Personal Details</a>
				<br>
				<a href="#bank_details" class="div1a">Bank Details</a>
			</center>
			
		</div>

		<div id="div2">
			<h1><a id="personal_details"><span style="color: gray;">Personal Details</span></a></h1>
			<br>
			<table cellpadding="10" width="50%">
				<tr>
					<td align="center"><b><span class="acctable">Name</span></b></td>
					<td><b><span class="acctable">:</span></b></td>
					<td><span class="acctable"><?php echo "$name"; ?></span></td>
					<td align="right"><a href="accountmod.php?item=name&value=<?php echo($name) ?>">edit</a></td>
				</tr>

				<tr>
					<td align="center"><b><span class="acctable">E-Mail</span></b></td>
					<td><b><span class="acctable">:</span></b></td>
					<td><span class="acctable"><?php echo "$email"; ?></span></td>
					<td align="right"><a href="accountmod.php?item=email&value=<?php echo($email) ?>">edit</a></td>
				</tr>

				<tr>
					<td align="center"><b><span class="acctable">Phone</span></b></td>
					<td><b><span class="acctable">:</span></b></td>
					<td><span class="acctable"><?php echo "$phone"; ?></span></td>
					<td align="right"><a href="accountmod.php?item=phone&value=<?php echo($phone) ?>">edit</a></td>
				</tr>
			</table>
	
			<h1><a id="bank_details"><span style="color: gray;">Bank Details</span></a></h1>
			<br>
			<table cellpadding="10" width="100%">
				<tr>
					<td colspan="4" align="center"><b><span class="acctable" style="font-size: 25;">Primary Account</span></b></td>
				</tr>

				<tr>
					<th><span class="acctable">Bank Id</span></th>
					<th><span class="acctable">Account Number</span></th>
					<th><span class="acctable">Status</span></th>
				</tr>

				<tr>
					<td align="center"><span class="acctable"><?php echo "$pbankid"; ?></span></td>
					<td align="center"><span class="acctable"><?php echo "$pbano"; ?></span></td>
					<td align="center"><?php 
							if ($verify == '1') 
								{
									echo '<span class="acctable" style="color:green;">Verified</span>';
								}

							else
							{
								echo '<span style="color: red;font-size:20;">Pending</span>';
							}
						?>		
					</td>
					<td align="center"><a href="accountmod.php?item=primaryacc&bank=<?php echo($pbankid) ?>&acc=<?php echo($pbano) ?>">edit</a></td>
				</tr>
			</table>
			<br><br>

			<?php
				$query = "SELECT * FROM has_additional WHERE ssn = '$ssn';";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
			?>
			<table cellpadding="10" width="100%">
				<tr>
					<td colspan="3" align="center"><b><span class="acctable" style="font-size: 25;">Secondary Accounts</span></b></td>
				</tr>

				<tr>
					<th><span class="acctable">Bank Id</span></th>
					<th><span class="acctable">Account Number</span></th>
					<th><span class="acctable">Status</span></th>
					<th></th>
				</tr>

				<?php 
				$count=0;
			
					if (mysqli_num_rows($run) > 0)
					{
			    		while($data = mysqli_fetch_assoc($run)) 
			    		{
			    			$data1=$data['bankid'];
			    			$data2=$data['banumber'];
			    			$status=$data['verified'];
			    			if ($count == '0')
			    			{
			    				echo "<tr>";
				    			echo '<td align="center"><span class="acctable">'.$data1.'</span></td>';
				    			echo '<td align="center"><span class="acctable">'.$data2.'</span></td>';
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
								echo '<td align="center"><a href="accountmod.php?item=secondaryacc&bank='.$data1.'&acc='.$data2.'">edit</a></td>';
				       		 	echo "</tr>";
				       		 	$count=1;
			    			}

			    			else
			    			{
			    				echo '<tr style="background-color: rgba(0, 0, 0, 0.1)">';
				    			echo '<td align="center"><span class="acctable">'.$data1.'</span></td>';
				    			echo '<td align="center"><span class="acctable">'.$data2.'</span></td>';
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
								echo '<td align="center"><a href="accountmod.php?item=secondaryacc&bank='.$data1.'&acc='.$data2.'">edit</a></td>';
				       		 	echo "</tr>";
				       		 	$count=0;
			    			}
			    			
			    		}
					} 
				?>	

				<tr>
					<td colspan="4"><center><a href="accountmod.php?item=addsec"><button id="addbut"><b>Add</b></button></a></center></td>
				</tr>
				
			</table>
			
		</div>
	</div>
	<?php mysqli_close($con);?>
</body>
</html>