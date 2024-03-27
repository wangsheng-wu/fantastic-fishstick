<html>
    <head>
		<title>ParkingMaster</title>
	</head>

    <body>
		<center>
		<br>
		<font size=5>
		<?php
			$cellNo = $_POST["cellNo"];
			SESSION_start();
			$_SESSION['cellNo']=$cellNo;
			echo "Welcome, customer ", $cellNo, "!<br>";
		?>
		</font>
		<pre><font size=4>
        <?php
			
            //create connection
			$conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
			if(!$conn) {
				die('Could not connect'.mysqli_connect_error());
			}
			$sql="select ReservationNo, GName, EDate from RESERVATION where cellNo='$cellNo'";
			$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
			$rowcheck = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if($rowcheck != NULL) {
				printf("%s<br><br>", "You have made following reservation(s):");
				printf("%-20s %-20s %-10s<br>", "Reservation Number", "Garage Name", "Parking Date");
				$sql="select ReservationNo, GName, EDate from RESERVATION where cellNo='$cellNo'";
				$result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					printf("%-20s %-20s %-10s<br>", $row['ReservationNo'], $row['GName'], $row['EDate']);
				}
				//Cancellation Option
				print "<br>If you want to make cancellation, ";
				echo "<a href=\"cancel.php\">Click here</a>";
			} else {
				printf("You do not have any reservation yet.");
			}
			
			
		    //close connection
			mysqli_close($conn);
        ?>
		</font>
		</pre>
		</center>
		<br><br>

		<center>
        <form method="post" action="DropDownDate.php">
			<label for="datelist">To make a new reservation, select your parking date:</lable>
			<select name="edate" id="datelist">
				<?php
				    //create connection
				    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
				    if(!$conn) {
					    die('Could not connect'.mysqli_connect_error());
				    }
				    $sql="select distinct edate from GARAGE order by edate";
				    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					    $edate=$row['edate'];
					    print<<<_HTML_
							<option value='$edate'>$edate</option>
						_HTML_;
				    }
				    //close connection
				    mysqli_close($conn);
				?>
			</select>
			<input type="submit" value="SUMBIT">
		</form>

        </center>
    </body>
</html>