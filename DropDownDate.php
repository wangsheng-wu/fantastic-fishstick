<html>
    <head>
		<title>ParkingMaster</title>
	</head>

    <body>
		
			<font size=5>
			<pre>
            <?php
				printf("We have following garages available.<br><br>");
				$edate=$_POST["edate"];
				SESSION_start();
				$_SESSION['date']=$edate;
                //create connection
			    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
			    if(!$conn) {
				    die('Could not connect'.mysqli_connect_error());
			    }
			    $sql="select GName, EDate, SpotPrice, AvailableSpots from GARAGE where EDate='$edate'";
			    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
			    
				printf("     %-30s %-14s %-12s %-10s<br><br>","Garage Name", "Date","Quantity", "Price");
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$garagename=$row['GName'];
					$date=$row['EDate'];
					$available=$row['AvailableSpots'];
					$price=$row['SpotPrice'];
					$distances="<tr><td><a href=\"hyperlinkprocess.php?ID=$garagename\">Distances to Venues</a></td></tr>";

					$_SESSION['name']=$garagename;
					printf("     %-30s %-10s     %-10d   $%5.2f      %s<br>", $garagename, $date, $available, $price, $distances);
					
				}
			    
		        //close connection
			    mysqli_close($conn);
            ?>
			</pre>
			</font>
			
			<center>
			<form method="post" action="DropDownGarage.php">
				<label for="garagelist">Select garage:</lable>
				<select name="garage" id="garagelist">
				<?php
				    //create connection
				    $conn = new mysqli('127.0.0.1','phpuser', 'phpwd','pmaster');
				    if(!$conn) {
					    die('Could not connect'.mysqli_connect_error());
				    }
				    $sql="select GName from GARAGE where EDate='$edate'";
				    $result=mysqli_query($conn, $sql) or die(mysqli_connect_error());
				    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					    $garage=$row['GName'];
					    print<<<_HTML_
							<option value='$garage'>$garage</option>
						_HTML_;
				    }
				    //close connection
				    mysqli_close($conn);
				?>
				</select>
				<input type="submit" value="SUMBIT">

			</form>
			</center>

			<br>
		
			</pre>
		
    </body>

</html>