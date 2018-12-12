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


<!DOCTYPE html>
<html>
<head>
	<title>Result page</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>
	<?php
	    include("conf.php");  
		$item=$_GET["item"];
		if ($item == 'all') 
		{
			echo '<table cellpadding="10" width="100%" >
				<tr>
					<th align="center"><b><span class="acctable">Date</span></b></th>
					<th align="center"><b><span class="acctable">To/From</span></b></th>
					<th align="center"><b><span class="acctable">Description</span></b></th>
					<th align="center"><b><span class="acctable">Debit</span></b></th>
					<th align="center"><b><span class="acctable">Credit</span></b></th>
				</tr>';

				
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

			$query = "SELECT * FROM send_transaction WHERE ssn = '$ssn' OR identifier='$phone' OR identifier='$mail' ;";
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
			echo "</table>";
			
		}

		elseif ($item == 'request') 
		{
			$sel=$_GET["sel"];

			if ($sel == 'month') 
			{
				echo '<table cellpadding="10" width="100%" >
				<tr>
					<th align="center"><b><span class="acctable">Date</span></b></th>
					<th align="center"><b><span class="acctable">To/From</span></b></th>
					<th align="center"><b><span class="acctable">Description</span></b></th>
					<th align="center"><b><span class="acctable">Debit</span></b></th>
					<th align="center"><b><span class="acctable">Credit</span></b></th>
				</tr>';

				
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
				$cdate='';
				$nomonth=$_POST["month"];
				$var=date("m-d-Y H:i:s");

				if ($nomonth == '1') 
				{
					$cdate=date( "m-d-Y H:i:s", strtotime( "date(Y-m-d) -1 month" ) );	
				} 
				else if ($nomonth == '3')
				{
					$cdate=date( "m-d-Y H:i:s", strtotime( "date(Y-m-d) -1 month" ) );
				}

				else
				{
					$cdate=date( "m-d-Y H:i:s", strtotime( "date(Y-m-d) -6 month" ) );
				}
				
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
				echo "</table>";
			}

			//***********************CUSTOM SELECTION*******************************

			else 
			{
				echo '<table cellpadding="10" width="100%" >
				<tr>
					<th align="center"><b><span class="acctable">Date</span></b></th>
					<th align="center"><b><span class="acctable">To/From</span></b></th>
					<th align="center"><b><span class="acctable">Description</span></b></th>
					<th align="center"><b><span class="acctable">Debit</span></b></th>
					<th align="center"><b><span class="acctable">Credit</span></b></th>
				</tr>';

				
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
				$sdate=$_POST["sdate"].' '.'00:00:00';
				$edate=$_POST["edate"].' '.'23:59:59';
				

				
				$query = "SELECT * FROM send_transaction WHERE (ssn = '$ssn' OR identifier='$phone' OR identifier='$mail') AND (datestamp BETWEEN '$sdate' AND '$edate' );";
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
				echo "</table>";
				
			}
			
			
		}
		else
		{
			echo "<h1> Retry...... </h1>";
		    sleep(1);
		    header("Location: error.html?var=search");

		}

		
	?>
			
</body>
</html>