<!-- Teav Thong 14883251 -->
<?php
	require_once('../../conf/sqlinfo.inc.php');

	//try to establish a connection to the database
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);

	//check if connection to that database is successful
	if(!$conn) 
	{
		//display an error message
		echo"<p>Database connection failure</p>";
	}
	else {
		//get the inputs
		$name = $_POST['namefield'];
		$contact = $_POST['contact'];
		$unit_number = $_POST['unit_number'];
		$street_number = $_POST['street_number'];
		$street_address = $_POST['street_address'];
		$suburb = $_POST['suburb'];
		$dest_suburb = $_POST['dest_suburb'];
		$pickup_date = $_POST['pickup_date'];
		$pickup_time = $_POST['pickup_time'];

		$query = "CREATE TABLE IF NOT EXISTS booking (
					ref_num INT(10) NOT NULL AUTO_INCREMENT, 
					name varchar(50) NOT NULL, 
					contact varchar(15) NOT NULL, 
					pickup_unit varchar(5),
					pickup_st_num varchar(5) NOT NULL,
					pickup_st_name varchar(40) NOT NULL,
					pickup_suburb varchar(20) NOT NULL,
					pickup_date_time DATETIME NOT NULL, 
					dest_suburb varchar(20) NOT NULL,
					status VARCHAR(200) DEFAULT ' unassigned', 
					PRIMARY KEY (ref_num))";
		$result = mysqli_query($conn, $query); //checks if table exists and creates a new one if it doesn't
		if(!$result) {
			//if the execution isn't successful, display an error message
			echo "<p>Sorry, something is wrong with $query</p>";
		} 
		else {
			//table created or existed
			//insert the date into the database
			$query = "INSERT INTO booking (name, contact, pickup_unit, pickup_st_num, pickup_st_name, pickup_suburb, pickup_date_time, dest_suburb) VALUES ('$name', '$contact', '$unit_number', '$street_number', '$street_address', '$suburb', '$pickup_date $pickup_time', '$dest_suburb')";

			//execute the query
			$result = mysqli_query($conn, $query);
			//check if the execution is succesful
			if(!$result){
				//display an error message
				echo "<p>Something is wrong with ", $query, "</p>";
			} 
			else {
				//inform user the status has been posted			
				echo "<p>Thank you! Your booking reference number is <",mysqli_insert_id($conn),">. You will be picked up in front of your provided adress at <$pickup_time> on <$pickup_date>.</p>";
			}			
		}
		//close the database connection
		mysqli_close($conn);
	}
?>