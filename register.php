<!DOCTYPE html>
<html>
<head>
	<title>Registering......</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>

	<?php

		if (isset($_POST['submit'])) 
		{
			$uname=$_POST['username'];
			$pass=$_POST['password'];
			$ssn=$_POST['ssn'];
			$name=$_POST['name'];
			$email=$_POST['email'];
			$phone=$_POST['phone'];
			$bankid=$_POST['bankid'];
			$accno=$_POST['account'];
			$regtime=date("m-d-Y h:i:s");

			include("conf.php");

			//user-account......
			$query = "INSERT INTO user_account (ssn, name, bankid, banumber, pbaverified) VALUES ('$ssn', '$name', '$bankid', '$accno', '1');";
			$run = mysqli_query($con,$query) or die("ERROR: Unable to register......" . mysql_error());
			
			if ($run) 
			{
				echo "<h1>User details registered Successfull...............33.33%</h1>";
				
			}

			else
			{
				$query = "SELECT ssn FROM user_account WHERE ssn='$ssn';";
				$run = mysqli_query($con,$query) or die("ERROR: ......" . mysql_error());
				$check = mysqli_num_rows($run);
				if ($check == '1') 
				{
					echo "<script type= 'text/javascript'>alert('Account already exists. Try signing up!!!!!!!!!!!'); </script>";
					mysqli_close($con);
					header("Location: login.html");
				}

				else
				{
					echo "<h1>Error. Re-try after sometime </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=registera");
				}
				
			}
			//login...
			
			$query = "INSERT INTO login VALUES ('$uname', '$pass', '$regtime', '$ssn');";
			$run = mysqli_query($con,$query) or die("ERROR: Unable to register......" . mysql_error());
			
			if ($run) 
			{
				echo "<h1>User details registered Successfull...............66.66%</h1>";
			}

			else
			{
				$query = "SELECT username FROM login WHERE username='$uname' OR ssn='$ssn';";
				$run = mysqli_query($con,$query) or die("ERROR: ......" . mysql_error());
				$check = mysqli_num_rows($run);
				if ($check == '1') 
				{
					echo "<script type= 'text/javascript'>alert('Username already exists!!!!!!!!!!!'); </script>";
					mysqli_close($con);
					header("Location: register.html");
				}

				else
				{
					echo "<h1>Error. Re-try after sometime </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=registera");
				}
				
			}
	
			//electronic_address
			$query = "INSERT INTO electronic_address VALUES ('$email', '$ssn', 'email', '1');";
			$run = mysqli_query($con,$query) or die("ERROR: Unable to register......" . mysql_error());

			if (isset($_POST['phone']) and !empty($phone)) 
			{
				$query = "INSERT INTO electronic_address VALUES ('$phone', '$ssn', 'phone', '1');";
				$run2 = mysqli_query($con,$query) or die("ERROR: Unable to register......" . mysql_error());

				if ($run2) 
				{
					echo "<h1>Almost there</h1>";
				}

				else
				{
					$query = "SELECT identifier FROM electronic_address WHERE identifier='$phone';";
					$run = mysqli_query($con,$query) or die("ERROR: ......" . mysql_error());
					$check = mysqli_num_rows($run);
					if ($check == '1') 
					{
						echo "<script type= 'text/javascript'>alert('Phone number already used!!!!!!!!!!!'); </script>";
						mysqli_close($con);
						header("Location: register.html");
					}

					else
					{
						echo "<h1>Error. Re-try after sometime </h1>";
						sleep(1);
						mysqli_close($con);
						header("Location: error.html?var=registera");
					}
				
				}
			}
			
			
			if ($run) 
			{
					echo "<h1>User details registered Successfull...............100.00%</h1>";
					sleep(2);
			}

			else
			{
				$query = "SELECT identifier FROM electronic_address WHERE identifier='$email';";
				$run = mysqli_query($con,$query) or die("ERROR: ......" . mysql_error());
				$check = mysqli_num_rows($run);
				if ($check == '1') 
				{
					echo "<script type= 'text/javascript'>alert('Email id already used!!!!!!!!!!!'); </script>";
					mysqli_close($con);
					header("Location: register.html");
				}

				else
				{
					echo "<h1>Error. Re-try after sometime </h1>";
					sleep(1);
					mysqli_close($con);
					header("Location: error.html?var=registera");
				}
				
			}

			header("Location: login.html");

		}

		else
		{
			echo "<h1>Form Error. Re-try... </h1>";
			sleep(1);
			header("Location: error.html?var=register");
		}

	?>

</body>
</html>