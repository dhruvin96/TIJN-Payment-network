<?php

  session_start();
  if(!empty($_SESSION['login_user']))
  {
    $user=$_SESSION['login_user'];
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

	<div id="body">
		<center><h1>Welcome back <?php echo "$user";?>. Your payment system is ready to go. Have a safe trasaction</h1></center>

	</div>

</body>
</html>