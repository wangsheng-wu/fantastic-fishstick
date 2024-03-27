<html>
    <head>
		<title>ParkingMaster</title>
	</head>
	<center>
	<font  size=4>
    <?php
		SESSION_start();
		$garage=$_POST["garage"];
		$date=$_SESSION['date'];
		$cell=$_SESSION['cellNo'];

		
        //create connection
		$conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
		if(!$conn) {
		    die('Could not connect'.mysqli_connect_error());
		}
		//generate transaction number
		$newTransNo=0;
		$sql="select MAX(TransNo) from TRANSACTION";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if($row != NULL) {
			$newTransNo=$row['MAX(TransNo)']+1;
		} else {
			$newTransNo=1;
		}

		$sql="select SpotPrice from GARAGE where GName='$garage' and EDate='$date'";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$fee=$row['SpotPrice'];

		$today=date("Y-m-d");


		

		//MYSQL: Load these data into TRANSACTION
		$sql="insert into TRANSACTION (TransNo, GName, EDate, TDate, Active, Fee) VALUES ('$newTransNo', '$garage', '$date', '$today', '1', '$fee')";
		if (mysqli_query($conn, $sql)) {
			echo "<br>Transaction Approved!<br>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		//MYSQL: Load these data into RESERVATION
		$sql="insert into RESERVATION (ReservationNo, TransNo, GName, Edate, Rdate, CellNo, Price) VALUES ('$newTransNo', '$newTransNo', '$garage', '$date', '$today', '$cell', '$fee')";
		if (mysqli_query($conn, $sql)) {
			echo "Reservation Confirmed!<br>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		//MYSQL: Update available spots in GARAGE
		$sql="select AvailableSpots from garage where GName='$garage' and EDate='$date'";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$available=$row['AvailableSpots'];
		if($available>1) {
			$newAvailable=$available-1;
			$sql="update garage set AvailableSpots = '$newAvailable' where GName='$garage' and EDate='$date'";
			mysqli_query($conn, $sql);
		} else {
			$sql="SET FOREIGN_KEY_CHECKS=0";
			mysqli_query($conn, $sql);
			$sql="delete from garage where GName='$garage' and EDate='$date'";
			mysqli_query($conn, $sql);
			$sql="SET FOREIGN_KEY_CHECKS=1";
			mysqli_query($conn, $sql);
		}

		$sql="select AvailableSpots from garage where GName='$garage' and EDate='$date'";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if($row != NULL) {
			$available=$row['AvailableSpots'];
		} else {
			$available=0;
		}

		printf("<br>Transaction/Reservation Number: %s<br>Fee Charged: $%4.2f<br>", $newTransNo, $fee);
		printf("Garage Name: %s<br>Parking Date: %s<br>Cellphone Number: %s<br>", $garage, $date, $cell);

		//close connection
		mysqli_close($conn);
    ?>
	</font>
	<br>
    <a href="index.php">Go to Homepage</a>
	</center>
</html>