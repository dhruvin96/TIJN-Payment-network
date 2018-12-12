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
	<title>Changing Segment</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>
	<?php
		if(isset($_POST['submit']))
	 	{
	 
			include("conf.php");
	
			$item=$_GET['cgtype'];

			if ($item == 'name') 
			{
				$cgvar=$_POST['data'];
				$query = "UPDATE user_account SET name='$cgvar' WHERE ssn = '$ssn' ;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Name changed Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Name change error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'email') 
			{
				$cgvar=$_POST['data'];
				$query = "UPDATE electronic_address SET identifier='$cgvar' WHERE ssn = '$ssn' AND type = 'email'; ";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Email changed Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Email change error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'phone') 
			{
				$cgvar=$_POST['data'];
				$query = "UPDATE electronic_address SET identifier='$cgvar' WHERE ssn = '$ssn' AND type = 'phone'; ";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Phone number changed Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Phone no. change error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'addsec') 
			{
				$bankid=$_POST['data1'];
				$accno=$_POST['data2'];
				$query = "INSERT INTO has_additional VALUES ($ssn, $bankid, $accno, '1'); ";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Phone number changed Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Phone no. change error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'delsec') 
			{
				$bankid=$_GET['bank'];
				$accno=$_GET['acc'];
				$query = "DELETE FROM has_additional WHERE ssn=$ssn AND bankid=$bankid AND 	banumber=$accno;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Bank details deleted Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Delete ERROR..... </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'updsec') 
			{
				$bankid=$_POST['nbankid'];
				$accno=$_POST['nacc'];
				$old1=$_GET['bank'];
				$old2=$_GET['acc'];
				$query = "DELETE FROM has_additional WHERE ssn=$ssn AND bankid=$old1 AND banumber=$old2";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());

				$query = "INSERT INTO has_additional VALUES ($ssn, $bankid, $accno, '1'); ";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Phone number changed Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Phone no. change error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'updpri') 
			{
				$bankid=$_POST['nbankid'];
				$accno=$_POST['nacc'];
				$old1=$_GET['bank'];
				$old2=$_GET['acc'];
				$query = "UPDATE user_account SET bankid=$bankid, banumber=$accno WHERE ssn=$ssn AND bankid=$old1 AND banumber=$old2";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Primary account details updated Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Primary account update error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}
			}

			elseif ($item == 'chgpri') 
			{
				$bankid=$_POST['nbankid'];
				$accno=$_POST['nacc'];
				$pbankid=$_GET['bank'];
				$paccno=$_GET['acc'];

				$query = "DELETE FROM bank_account WHERE bankid=$pbankid AND banumber=$paccno;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					//echo "<script type= 'text/javascript'>alert('Primary account details updated Successfull'); </script>";
					//mysqli_close($con);
					//header("Location: account.php");
				}

				else
				{
					echo "<h1>Primary entry error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}

				$query = "DELETE FROM bank_account WHERE bankid=$bankid AND banumber=$accno;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					//echo "<script type= 'text/javascript'>alert('Primary account details updated Successfull'); </script>";
					//mysqli_close($con);
					//header("Location: account.php");
				}

				else
				{
					echo "<h1>Secondary entry error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}

				$query = "UPDATE user_account SET bankid=$bankid, banumber=$accno WHERE ssn=$ssn AND bankid=$pbankid AND banumber=$paccno;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					//echo "<script type= 'text/javascript'>alert('Primary account details updated Successfull'); </script>";
					//mysqli_close($con);
					//header("Location: account.php");
				}

				else
				{
					echo "<h1>User account update error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}

				$query = "UPDATE has_additional SET bankid=$pbankid, banumber=$paccno WHERE ssn=$ssn AND bankid=$bankid AND banumber=$accno;";
				$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
				
				if ($run) 
				{
				
					echo "<script type= 'text/javascript'>alert('Primary account details updated Successfull'); </script>";
					mysqli_close($con);
					header("Location: account.php");
				}

				else
				{
					echo "<h1>Secondary account update error </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=cda");
				}

				
			}

			else
			{
				echo "No change item found!!!!!!!!!!!!";
			}

			
		}

		else
		{
			echo "<h1> Retry...... </h1>";
			sleep(1);
			header("Location: error.html?var=cd");
		}
	?>
</body>
</html>