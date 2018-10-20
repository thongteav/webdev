<!-- Teav Thong 14883251 -->
<?php
	require_once('../../conf/sqlinfo.inc.php');

	//try to establish a connection to the database
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);

	$sql_table = 'booking';
	//check if connection to that database is successful
	if(!$conn) 
	{
		//display an error message
		echo"<p>Database connection failure</p>";
	}
	else {
		$query = "SHOW TABLES LIKE '$sql_table'";
		$result = mysqli_query($conn, $query);
		//check if table exists
		if($result){
			$tableExists = mysqli_num_rows($result) > 0;
			if($tableExists){
				//table exists
				//check if there is any booking between now and the next 2 hours
				$query = "SELECT * FROM $sql_table WHERE pickup_date_time > NOW() AND pickup_date_time < DATE_ADD( NOW( ) , INTERVAL 2 HOUR ) ";
				$result = mysqli_query($conn, $query);
				if(!result){
					echo "<p>Sorry, something is wrong with $query</p>";
				}
				else {					
					echo "<table id='booking'> <tr> <th>Booking Ref Number</th> <th>Customer Name</th> <th>Contact Phone</th> <th>Pickup Suburb</th> <th>Destination Suburb</th> <th>Pickup Date/Time</th> </tr>";
					//print out the result by looping through the results of the query
					while($row = mysqli_fetch_assoc($result)){	
						echo "<tr> <td>",$row["ref_num"],"</td> <td>",$row["name"],"</td> <td>",$row["contact"],"</td> <td>",$row["pickup_suburb"],"</td> <td>",$row["dest_suburb"],"</td> <td>",$row["pickup_date_time"],"</td> </tr>";
					}
				}
			} 
			else {
				echo "<p>Sorry, table $sql_table doesn't exist</p>";
			}
		}
		else {
			echo "<p> Sorry, something is wrong with $query";
		}
		
		mysqli_close($conn);//closes the connection
	}
?>