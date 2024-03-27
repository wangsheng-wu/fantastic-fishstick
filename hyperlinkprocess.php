<html>
    <head>
		<title>ParkingMaster</title>
	</head>
	<center>
	<font  size=4>
    <?php
        if(isset($_GET['ID'])) {
            $garage=$_GET['ID'];
            printf("%s is <br>", $garage);

            //create connection
			$conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
		    if(!$conn) {
			    die('Could not connect'.mysqli_connect_error());
			}

			$sql="select VName, Distance from NEAR where GName='$garage'";
			$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				printf("%4.2f miles from %s<br>", $row['Distance'], $row['VName']);
			}
			//close connection
			mysqli_close($conn);
        }
    ?>

	</font>
	</center>

</html>