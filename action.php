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
  <title>Action page</title>
  <link rel="icon" type="image/png" href="icon1.png">
</head>
<body>
  <center>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <h1>No search criteria selected</h1>
  </center>

</body>
</html>