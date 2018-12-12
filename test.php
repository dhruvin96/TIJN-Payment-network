<!DOCTYPE html>
<html>
<head>
	<title>test scrap work</title>
</head>
<body>
	<?php
	$var=date("m-d-Y h:i:s");
	$var2=date("m").'-01-'.date("Y").' '.'00:00:00' ;
					$cdate=date( "m-Y", strtotime( "-1 month" ) );

					$edate = explode("-", $cdate);
					$emon= $edate[0]; 
					$eyear= $edate[1]; 

					$cdate=$emon.'-01-'.$eyear.' '.'00:00:00' ;
	echo "Timestamp=".$var;
	echo "<br>";
	echo "Timestamp2=".$var2;
	echo "<br>";
	echo "Timestamp3=".$cdate;
	
	?>
</body>
</html>