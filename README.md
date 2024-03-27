Introduction:
	This is a web application that users can use it to make reservations of parking spaces in different garages. 
	Users do not need to register. 
	Users can make reservations using their phone number. 
	At the same time, they can find their past reservations using their phone number. 
	Users are allowed to cancel their reservation at least THREE days before their reserved date.

How to play with this web application on your device?
	Our program was developed on mac. 
	If your machine is window system, instructions may be slightly different.

	create database pmaster;
	use pmaster;
	Then use the file pmaster_create.sql to create tables.
	And you may need to load table contents into the table garageinfo, garage, venue, and near (in this order).
	(note: These data only contains 1 available spots for each garage on a few days 
	as given in CSE3241_Project_SP23_testdata.xlsx download from Carmen.
	we give some more spots on other days in May as well.)
	Now, you have necessary data to play with.
	Next, you need to create a user with name: 'phpuser' and password: 'phpwd'.
	You may follow the following instructions to achieve that.
	create user 'phpuser'@'127.0.0.1' identified by 'phpwd';
	GRANT ALL PRIVILEGES ON pmaster TO 'phpuser'@'127.0.0.1';
	(Reference: https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql)
	Don't forget to put all the other php files in your directory.
	Start localhost and go to browser. The homepage is index.php.
	After that, you can play with the web application ParkingMaster.

Some instructions:
	You can enter a phone number in the homepage and submit it.
	You will then be directed to a page where your previous reservations will be shown if there's any.
	On the same page, you can select the available date to go to another page where all available garages will be shown with price, available spots number, and your preselected date. 
	Also, there is a hyperlink for each of these garages where you can see distances to each venue if you clicked.

	On the upper left corner of the homepage, there's a hyperlink to administrator page.
	Administrator may enter a password to access a statistics page.
	The default password is 123456 which is shown by a DEBUG note (can be removed for a commercial version).
	Once logged in, Administrator can see total spaces assigned, reserved in different garages on a given date.
	Also, Administrator can see revenue of each garage on a given date along with total revenue of that date.
	Total revenue of the month is also displayed below revenue of the date.
