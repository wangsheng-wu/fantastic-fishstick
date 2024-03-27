<html>
    <head>
		<title>ParkingMaster</title>
	</head>

    <body>
    <center>
    <?php
        $number=$_POST['number'];

        //create connection
		$conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
		if(!$conn) {
			die('Could not connect'.mysqli_connect_error());
		}
		$sql="select EDate from reservation where ReservationNo='$number'";
		$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
        //verify if meet requirement (compare parking date with current date)
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $parkingDate=$row['EDate'];
        $allowedDate=date("Y-m-d",strtotime("-3 days", strtotime($parkingDate)));
        $currentDate=date("Y-m-d");
        
        if($currentDate<=$allowedDate) {
            //Retrieve GName
            $sql="select GName, Price from reservation where ReservationNo='$number'";
            $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $garageToUpdate=$row['GName'];
            $price=$row['Price'];

            //Delete reservation entry from reservation table
            $sql="delete from reservation where ReservationNo='$number'";
            if (mysqli_query($conn, $sql)) {
				echo "<br>Reservation Cancelled Successfully!<br>";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

            //Update transaction table - set active to 0
            $sql="update transaction set active='0' where TransNo='$number'";
            if (mysqli_query($conn, $sql)) {
				echo "Fee Returned Successfully!<br>";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

            //Update spots availability
            $sql="select AvailableSpots from garage where GName='$garageToUpdate' and EDate='$parkingDate'";
            $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($row == NUll) {
                $sql="insert into garage (GName, EDate, SpotPrice, AvailableSpots) VALUES ('$garageToUpdate', '$parkingDate', '$price', '1')";
                mysqli_query($conn, $sql);
            } else {
                $currentSpots=$row['AvailableSpots'];
                $sql="SET FOREIGN_KEY_CHECKS=0";
			    mysqli_query($conn, $sql);
                $newSpots=$currentSpots+1;
			    $sql="update garage set AvailableSpots='$newSpots' where GName='$garageToUpdate' and EDate='$parkingDate'";
			    mysqli_query($conn, $sql);
			    $sql="SET FOREIGN_KEY_CHECKS=1";
			    mysqli_query($conn, $sql);
            }
        } else {
            printf("<br>%s<br>", "You are not allowed to cancel this reservation.");
            printf("%s<br>", "You are only allowed to cancel your reservation at least three days before reserved date.");
            printf("Today is: %s and your reserved parking date is: %s.<br>You are allowed to cancel this reservation on or before %s", $currentDate, $parkingDate, $allowedDate);
        }

        //close connection
		mysqli_close($conn);
    ?>

    <br><br>
    <a href="index.php">Go to Homepage</a>

    </center>
    </body>

</html>