<html>
    <head>
		<title>ParkingMaster</title>
	</head>

	<a href="index.php">Homepage</a>
	
	    <body>
			<font size=4>
			<pre>
            <?php
				$edate=$_POST["edate"];
				$month=date("m",strtotime($edate));
				printf("The following information is available for %s<br><br>", $edate);
				SESSION_start();
				$_SESSION['date']=$edate;
                //create connection
			    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
			    if(!$conn) {
				    die('Could not connect'.mysqli_connect_error());
			    }
				$sql="select distinct GName from RESERVATION where EDate='$edate' UNION select distinct GName from GARAGE where EDate='$edate'";
			    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				printf("%-30s %-20s %-25s %-20s %-20s<br>", "Garage Name", "Spaces Assigned", "Total Spaces Reserved", "Spaces Available", "Revenue");
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$garagename=$row['GName'];
					$sql="select count(*) from RESERVATION where EDate='$edate' and GName='$garagename'";
					$result1=mysqli_query($conn, $sql) or die(mysqli_connect_error());
					$row1=mysqli_fetch_array($result1, MYSQLI_ASSOC);
					if($row1 == NULL) {
						$assigned=0;
					} else {
						$assigned=$row1['count(*)'];
					}

					$sql="select AvailableSpots from Garage where EDate='$edate' and GName='$garagename'";
					$result2=mysqli_query($conn, $sql) or die(mysqli_connect_error());
					$row2=mysqli_fetch_array($result2, MYSQLI_ASSOC);
					if($row2 == NULL) {
						$available=0;
					} else {
						$available=$row2['AvailableSpots'];
					}

					$sql="select sum(price) from RESERVATION where EDate='$edate' and GName='$garagename'";
					$result3=mysqli_query($conn, $sql) or die(mysqli_connect_error());
					$row3=mysqli_fetch_array($result3, MYSQLI_ASSOC);
					if($row3 == NULL) {
						$revenue=0;
					} else {
						$revenue=$row3['sum(price)'];
					}
					
					$reserved=$available + $assigned;
					printf("%-36s %-20s %-25s %-14s $ %-.2f<br>", $garagename, $assigned, $reserved, $available, $revenue);
					
				}

				//Total Revenue of the date
				$sql="select sum(price) from RESERVATION where EDate='$edate'";
			    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
				$totalRevenue=$row['sum(price)'];
				printf("<br>%100s %.2f", "Total Revenue of the Day: $", $totalRevenue);

				//Total Revenue of the month
				$sql="select EDate, price from RESERVATION";
			    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				$monthRevenue=0;
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$adate=$row['EDate'];
					$amonth=date("m", strtotime($adate));
					if($amonth == $month) {
						$monthRevenue = $monthRevenue + $row['price'];
					}
				}
				printf("<br>%100s %.2f", "Total Revenue of the Month: $", $monthRevenue);

		        //close connection
			    mysqli_close($conn);
            ?>
			</pre>
			</font>

        	<form method="post" action="AdminView.php">
			<label for="datelist">To check a different date, select your event date:</lable>
			<select name="edate" id="datelist">
				<?php
				    //create connection
				    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
				    if(!$conn) {
					    die('Could not connect'.mysqli_connect_error());
				    }
				    $sql="select distinct edate from RESERVATION UNION (select distinct edate from GARAGE) order by edate";
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
    </body>
</html>