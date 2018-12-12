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
	?>

	<div id="body">
		<div id="div1">
			<center>
				<br>
				<a href="#pending_request" class="div1a">Pending Request</a>
				<br>
				<a href="#statement" class="div1a">Statement</a>
			</center>
			
		</div>

		<div id="div2">
			<h1><a id="pending_request"><span style="color: gray;">Pending Request</span></a></h1>
			<br>
			<table cellpadding="10" width="100%">
				<th>
					<td align="center"><b><span class="acctable">Person</span></b></td>
					<td align="center"><b><span class="acctable">Description</span></b></td>
					<td align="center"><b><span class="acctable">Amount</span></b></td>
					<td></td>
				</th>
			</table>
	
			<h1><a id="statement"><span style="color: gray;">Statement</span></a></h1>
			<br>
			<table cellpadding="10" width="100%" >
				<tr>
					<th align="center"><b><span class="acctable">Date</span></b></th>
					<th align="center"><b><span class="acctable">To/From</span></b></th>
					<th align="center"><b><span class="acctable">Description</span></b></th>
					<th align="center"><b><span class="acctable">Debit</span></b></th>
					<th align="center"><b><span class="acctable">Credit</span></b></th>
				</tr>

				<?php
					$phone='';
					$mail='';
					$debit=0;
					$credit=0;
					$rmail='';
					$balance=0;

					$query = "SELECT * FROM user_account WHERE ssn = '$ssn';";
					$run = mysqli_query($con,$query) or die("ERROR:s4 Resource not available......" . mysql_error());

					if (mysqli_num_rows($run) > 0)
						{
				    		while($data = mysqli_fetch_assoc($run)) 
				    		{
				       		 	$balance=$data["balance"];
				    		}
						} 	

					$query = "SELECT * FROM electronic_address WHERE ssn = '$ssn';";
					$run = mysqli_query($con,$query) or die("ERROR:s1 Resource not available......" . mysql_error());

					if (mysqli_num_rows($run) > 0)
						{
				    		while($data = mysqli_fetch_assoc($run)) 
				    		{
				       		 	if ($data['type'] == 'phone') 
				       		 	{
				       		 		$phone=$data['identifier'];
				       		 	}

				       		 	else
				       		 	{
				       		 		$mail=$data['identifier'];
				       		 	}
				    		}
						} 	

					$var=date("m").'-01-'.date("Y").' '.'00:00:00' ;
					$cdate=date( "m-Y", strtotime( "-1 month" ) );

					$edate = explode("-", $cdate);
					$emon= $edate[0]; 
					$eyear= $edate[1]; 

					$cdate=$emon.'-01-'.$eyear.' '.'00:00:00' ;

					$query = "SELECT * FROM send_transaction WHERE (ssn = '$ssn' OR identifier='$phone' OR identifier='$mail') AND (datestamp BETWEEN '$cdate' AND '$var' );";
					$run = mysqli_query($con,$query) or die("ERROR:s2 Resource not available......" . mysql_error());

					if (mysqli_num_rows($run) > 0)
					{
				    	while($data = mysqli_fetch_assoc($run)) 
				    	{
				    		$flag='not';
				    		echo "<tr>";
				    		echo '<td align="center"><span class="acctable">'.$data["datestamp"].'</span></td>';
				    		echo '<td align="center"><span class="acctable">';

				    		if (($data["identifier"] == $phone) OR ($data["identifier"] == $mail)) 
				    		{
				    			$temp=$data["ssn"];
				    			
				    			$query2 = "SELECT * FROM electronic_address WHERE ssn = '$temp' AND type='email' ;";
								$run2 = mysqli_query($con,$query2) or die("ERROR:s3 Resource not available......" . mysql_error());

								if (mysqli_num_rows($run2) > 0)
								{
						    		while($data2 = mysqli_fetch_assoc($run2)) 
						    		{
						       		 	$rmail=$data2["identifier"];
						    		}
								} 
								$flag='cr';
								echo $rmail;
				    			
				    		}

				    		else
				    		{

				    			$flag='deb';
				    			echo $data['identifier'];
				    		}
				    		echo '</span></td>';
				    		echo '<td align="center"><span class="acctable">'.$data["memo"].'</span></td>';

				    		if ($flag == 'cr') 
				    		{
				    			echo "<td> </td>";
				    			echo '<td align="center"><span class="acctable">'.$data["amount"].'</span></td>';
				    			$credit=$credit+$data["amount"];
				    		} 
				    		else if ($flag == 'deb')
				    		{
				    			
				    			echo '<td align="center"><span class="acctable">'.$data["amount"].'</span></td>';
				    			echo "<td> </td>";
				    			$debit=$debit+$data["amount"];
				    		}

				    		else
				    		{

				    		}
				    		

				    		echo "</tr>";
				    	}

				    	echo '<tr align="center"><td colspan="5"><b><span class="acctable">Total Debit='.$debit.'</span></b></td></tr>';
				    	echo '<tr align="center"><td colspan="5"><b><span class="acctable">Total Credit='.$credit.'</span></b></td></tr>';
				    	echo '<tr align="center"><td colspan="5"><b><span class="acctable">TIJN Wallet Balance='.$balance.'</span></b></td></tr>';
					} 	

				?>
			</table>
			
			
			
		</div>
	</div>
	<?php mysqli_close($con);?>
</body>
</html>