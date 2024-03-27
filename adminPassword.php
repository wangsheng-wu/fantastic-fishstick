<html>
	<head>
		<title>ParkingMaster</title>
	</head>

	<a href="administrator.php">Back to Administrator Login</a>
	<br>
    <center><font size=4>
		<?php
			$pass = $_POST["pass"];
			if($pass == '123456') {
				echo "Logged in!<br><br>";
			} else {
				echo "Incorrect password.<br>";
				exit;
			}
		?>
		
		<form method="post" action="AdminView.php">
			<label for="datelist">Select a date to see data:</lable>
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
		


	</font>
	</center>


</html>