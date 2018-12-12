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
  <title>Transaction Page</title>
  <link rel="icon" type="image/png" href="icon1.png">
</head>
<body>
  <?php
    if (isset($_POST['submit'])) 
    {
      include("conf.php");

      $proc=$_GET['item'];

      if ($proc == 'send') 
      {
        $rid=$_POST['identifier'];
        $amount=$_POST['amount'];
        $acc=explode(",", $_POST['selacc']);
        $bankid=$acc[0];
        $banumber=$acc[1];
        $memo=$_POST['memo'];
        $timevar=date("m-d-Y H:i:s");
        $checkbal='';

        $query = "SELECT * FROM electronic_address WHERE identifier='$rid' ; ";
        $run = mysqli_query($con,$query) or die("ERROR:1 Resource not available......" . mysql_error());
        
        if ($run AND (mysqli_num_rows($run) > 0)) 
        {
        
          if ( $_POST['selacc'] == 'tijnwal') 
          {

            $query = "SELECT balance FROM user_account WHERE ssn='$ssn' ; ";
            $run = mysqli_query($con,$query) or die("ERROR:2 Resource not available......" . mysql_error());

            if ($run AND (mysqli_num_rows($run) > 0)) 
            {
              while ($data = mysqli_fetch_assoc($run)) 
              {
                $checkbal=$data['balance'];
              }
              
            }

            if ($checkbal < $amount) 
            {
              echo "<h1>ERROR: Transaction Unsuccessfull </h1>";
              sleep(1);
              mysqli_close($con);
              header("Location: error.html?var=transactionless");
              
            }

            $query = "INSERT INTO send_transaction (amount, datestamp, memo, cancelled, ssn, identifier) VALUES ('$amount', '$timevar', '$memo', '0' ,'$ssn', '$rid'); ";
            $run = mysqli_query($con,$query) or die("ERROR:2 Resource not available......" . mysql_error());
          
            if ($run) 
            {
            
              echo "<script type= 'text/javascript'>alert('Transaction Successfull'); </script>";
              mysqli_close($con);
              header("Location: sendmoney.php");
            }

            else
            {
              echo "<h1>ERROR: Transaction Unsuccessfull </h1>";
              sleep(1);
              mysqli_close($con);
              header("Location: error.html?var=transactiona");
            }
          } 

          else 
          {
            $query = "INSERT INTO send_transaction (amount, datestamp, memo, cancelled, ssn, identifier) VALUES ('$amount', '$timevar', '$memo', '0' ,'$ssn', '$rid'); ";
            $run = mysqli_query($con,$query) or die("ERROR:3 Resource not available......" . mysql_error());

            $query = "UPDATE user_account SET balance=balance+'$amount' WHERE ssn='$ssn' ; ";
            $run = mysqli_query($con,$query) or die("ERROR:4 Resource not available......" . mysql_error());
          
            if ($run) 
            {
            
              echo '<script type= "text/javascript">alert("Transaction Successfull"); </script>';
              sleep(2);
              mysqli_close($con);
              header("Location: sendmoney.php");
            }

            else
            {
              echo "<h1>ERROR: Transaction Unsuccessfull </h1>";
              sleep(1);
              mysqli_close($con);
              header("Location: error.html?var=transactiona");
            }
          }  
        }

        else
        {
          echo "<h1>Runtime ERROR </h1>";
          sleep(1);
          mysqli_close($con);
          header("Location: error.html?var=transactionb");
        }
      } 

      elseif ($proc == 'request') 
      {
        $id=$_POST['identifier'];
        $amount=$_POST['amount'];
        $memo=$_POST['memo'];
        $timevar=date("m-d-Y H:i:s");

        $query = "SELECT * FROM electronic_address WHERE identifier = '$id' ;";
        $run = mysqli_query($con,$query) or die("ERROR:r1 Resource not available......" . mysql_error());
        
        if ($run AND (mysqli_num_rows($run) > 0)) 
        {
        
          $query = "INSERT INTO request_transaction (amount, datestamp, memo, ssn) VALUES ('$amount', '$timevar', '$memo', '$ssn');";
          $run = mysqli_query($con,$query) or die("ERROR:r2 Resource not available......" . mysql_error());
          
          if ($run) 
          {
            $rtid='';
            $query = "SELECT rtid FROM request_transaction WHERE ssn='$ssn' AND datestamp='$timevar' ;";
            $run = mysqli_query($con,$query) or die("ERROR:r3 Resource not available......" . mysql_error());

            if (mysqli_num_rows($run) > 0) 
            {
    
              while($row = mysqli_fetch_assoc($run)) 
              {
                $rtid=$row["rtid"];
              }
            } 

            else 
            {
              echo "no data found results";
              sleep(1);
              mysqli_close($con);
              header("Location: error.html?var=transactionreqa");
            }

            $query = "INSERT INTO rfrom (rtid, identifier, percentage) VALUES ('$rtid', '$id', '100');";
            $run = mysqli_query($con,$query) or die("ERROR:r4 Resource not available......" . mysql_error());
            
            if ($run) 
            {
            
              echo "<script type= 'text/javascript'>alert('Request Successfull'); </script>";
              mysqli_close($con);
              header("Location: requestmoney.php");
            }

            else
            {
              echo "<h1>Not able to complete request...... </h1>";
              sleep(1);
              mysqli_close($con);
              header("Location: error.html?var=transactionreqa");
            }

            echo "<script type= 'text/javascript'>alert('Request ticket Successfull'); </script>";
            //mysqli_close($con);
            header("Location: requestmoney.php");
          }

          else
          {
            echo "<h1>Not able to generate ticket...... </h1>";
            sleep(1);
            mysqli_close($con);
            header("Location: error.html?var=transactionreqa");
          }

          echo "<script type= 'text/javascript'>alert('Request Successfull'); </script>";
          //mysqli_close($con);
          header("Location: requestmoney.php");
        }

        else
        {
          echo "<h1>Request error </h1>";
          sleep(1);
          mysqli_close($con);
          header("Location: error.html?var=transactionreq");
        }
      }

      else 
      {
        echo "Bad transaction request!!!!!!!!!!!!";
        sleep(1);
        header("Location: error.html?var=transactionelse");
      }
      
    }

    else
    {
      echo "<h1> Retry...... </h1>";
      sleep(1);
      header("Location: error.html?var=transaction");
    }

  ?>
</body>
</html>