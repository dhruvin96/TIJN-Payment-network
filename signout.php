<?php 
session_start();
session_destroy();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Out</title>
	<link rel="icon" type="image/png" href="icon1.png">
</head>
<body>

	<script type="text/javascript">
		function Redirect() 
	    {  
	        window.location="Homepage.html"; 
	    } 
	    document.write("<h1>Signing Out. Please Wait.....<h1>"); 
	    setTimeout('Redirect()', 2000);
	</script>

</body>
</html>