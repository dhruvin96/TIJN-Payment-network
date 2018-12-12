<!DOCTYPE html>
<html>
<head>
	<title>Verifying.......</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>

	<?php
		if(isset($_POST['submit']))
	 	{
	 
			include("conf.php");
		
			$username=$_POST['uname'];
			$pass=$_POST['pass'];
			$ssn='';
		
			$query = "SELECT * FROM login WHERE username = '$username' AND password = '$pass' ";
			$run = mysqli_query($con,$query) or die("ERROR: Resource not available......" . mysql_error());
			$check = mysqli_num_rows($run);
			if ($check == '1') 
			{
				while ($data = mysqli_fetch_assoc($run))
				{
					$ssn=$data['ssn'];
				}

				session_start();
				$_SESSION['login_user'] = $username;
				$_SESSION['utin'] = $ssn;
				echo "<script type= 'text/javascript'>alert('Login Successfull'); </script>";
				mysqli_close($con);
				header("Location: main.html");
			}

			else
			{
				echo "<h1>Invalid login credential. Re-login </h1>";
				sleep(1);
				mysqli_close($con);
				header("Location: error.html?var=login");
			}
		}

		else
			{
				echo "<h1> Retry...... </h1>";
				sleep(1);
				header("Location: error.html?var=login");
			}
		
	?>
</body>
</html>
