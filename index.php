<html>
	<head>
		<title>ParkingMaster</title>
	</head>
	<body>
		<a href="administrator.php">Administrator Login</a>

		<section class="sub-section" id="preface">
			<center>
				<br>
				<font size=7><b>Welcome to ParkingMaster!</b></font><br>
				<font size=4>
					<br>
					<i>Instruction:</i><br>
					Enter your phone number to start a new reservation or see your previous reservation(s).<br>
				</font>
			</center>
			<br><br>
		</section>
		
		<center><font size=5>
		<form action="EnterPhoneNum.php" method="post">
			Please Enter Your Phone Number: <input name="cellNo" type="text">
			<input type="submit" value="Enter">
		</form>

		</font>
		</center>
	</body>
</html>