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
  <style>

    .input
    {
      width: 140%;
      padding: 5;
    }

    .inp
    {
      cursor: pointer;
      padding: 10px;
      font-size: 18px;
      text-align: center;
      background-color: lightblue;

    }

    .inp:hover 
    {
      background-color: lightgreen;
    }
  </style>
</head>
<body>
  <br><br>
    <center>
      <table cellpadding="15" >
        <form action="result.php?item=request&sel=month" method="POST">
          <tr align="center">
            <td colspan="3"><b><span class="acctable"><h2>Month Wise</h2></span></b></td>
          </tr>

          <tr>
            <td><b><span class="acctable"><input class="input" type="radio" name="month" title="Select option" value="1">1 Month</span></b></td>
            <td><b><span class="acctable"><input class="input" type="radio" name="month" title="Select option" value="3">3 Month</span></b></td>
            <td><b><span class="acctable"><input class="input" type="radio" name="month" title="Select option" value="6">6 Month</span></b></td>
          </tr>

          <tr>
            <td colspan="3"><center><b><span class="acctable"><input type="submit" name="submit" value="Search" class="inp">  <input type="reset" name="reset" value="Reset" class="inp"></span></b></center></td>
          </tr>
          </form>
          <tr>
            <td colspan="3"> </td>
          </tr>

          <tr>
            <td colspan="3" align="center"><h3>OR</h3></td>
          </tr>

          <form action="result.php?item=request&sel=custom" method="POST">
          <tr align="center">
            <td colspan="3"><b><span class="acctable"><h2>Custom Selection</h2></span></b></td>
          </tr>

          <tr>
            <td><h2>Start Date<b style="color: red;">*</b></h2></td>
            <td><b>:</b></td>
            <td><input class="input" type="text" name="sdate" title="*********Give date in specified format**********" placeholder="MM-DD-YYYY" required></td>
          </tr>

          <tr>
            <td><h2>End Date<b style="color: red;">*</b></h2></td>
            <td><b>:</b></td>
            <td><input class="input" type="text" name="edate" title="*********Give date in specified format**********" placeholder="MM-DD-YYYY" required></td>
          </tr>

          <tr>
            <td colspan="3"><center><b><span class="acctable"><input type="submit" name="submit" value="Search" class="inp">  <input type="reset" name="reset" value="Reset" class="inp"></span></b></center></td>
          </tr>
          </form>
          
      
    </table>
    </center>

</body>
</html>