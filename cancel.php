<html>
    <head>
		<title>ParkingMaster</title>
	</head>

    <body>

    <center>
    <pre>
    <font size=4>
    <?php
        SESSION_start();
        $cellNo=$_SESSION['cellNo'];

        //create connection
		$conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
		if(!$conn) {
			die('Could not connect'.mysqli_connect_error());
		}
		$sql="select ReservationNo, GName, EDate from RESERVATION where cellNo='$cellNo'";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
        printf("%s<br>", "Your reservation(s):");
        printf("%-20s %-20s %-10s<br>", "Reservation Number", "Garage Name", "Parking Date");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			printf("%-20s %-20s %-10s<br>", $row['ReservationNo'], $row['GName'], $row['EDate']);
		}

        //close connection
		mysqli_close($conn);
    ?>
    </font>
    </pre>

    <form method="post" action="DropDownCancel.php">
		<label for="numberlist">To cancel a reservation, select the reservation number:</lable>
		<select name="number" id="numberlist">
		<?php
            $cell=$_SESSION['cellNo'];
			//create connection
		    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
			if(!$conn) {
				die('Could not connect'.mysqli_connect_error());
			}
			$sql="select ReservationNo from Reservation where CellNo='$cell'";
			$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$reservationno=$row['ReservationNo'];
				print<<<_HTML_
					<option value='$reservationno'>$reservationno</option>
				_HTML_;
			}
			
            //close connection
			mysqli_close($conn);
		?>
		</select>
		<input type="submit" value="SUMBIT">
	</form>

    <br>
    <a href="index.php">Go to Homepage</a>

    </center>
    </body>

</html>