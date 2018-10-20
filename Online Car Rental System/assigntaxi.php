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
		//check if the table exists or not
		$query = "SHOW TABLES LIKE '$sql_table'";
		$result = mysqli_query($conn, $query);

		if($result){
			$tableExists = mysqli_num_rows($result) > 0;
			if($tableExists){
				//table exists
				$ref_num = $_POST['ref_num'];//get the reference number

				$query = "SELECT * FROM $sql_table WHERE ref_num='$ref_num'";//get the result set
				$result = mysqli_query($conn, $query);
				if(!result){
					echo "<p>Sorry, something is wrong with $query</p>";
				}
				else {
					if($row = mysqli_fetch_assoc($result) > 0) { 
						$query = "UPDATE $sql_table SET status='assigned' WHERE ref_num='$ref_num'";//change the status string to 'assigned'
						$result = mysqli_query($conn, $query);
						if(!result){
							echo "<p>Sorry, something is wrong with $query</p>";
						}
						else {							
							echo "<p>The booking request <$ref_num> has been properly assigned.</p>";//tell user the booking request status is updated
						}
					}
					else {
						echo "<p>Sorry, reference number<$ref_num> is invalid.</p>";
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
		
		mysqli_close($conn);
	}
?>