<!DOCTYPE html>
<html>
<head>
	<title>Search Status Process</title>
</head>
<body>
<h1>Status Information</h1>
<?php
	require_once('../../conf/sqlinfo.inc.php');
	
	//using the login information to establish a connection
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);

	//check if connection to that database is successful
	if(!$conn) {
		echo"<p>Database connection failure</p>";
	}
	else {
		$string = $_GET["string"];//get the search string from the form

		$query = "select * from $sql_tble where status like '%$string%'";
		$result = mysqli_query($conn, $query);//execute the query

		//check if the query execution has been successful
		if(!$result){
			//print out the error message
			echo "<p>Something is wrong with ", $query, "</p>";
		} else {
			//print out the result by looping through the results of the query
			while($row = mysqli_fetch_assoc($result)){
				echo "<p>Status: ",$row["status"],"<br>";
				echo "Status Code: ",$row["code"],"</p>";
				echo "<p>Share: ",$row["share"],"<br>";
				echo "Date Posted: ",$row["date"],"<br>";
				echo "Permission: ";
				if($row["allow_like"]){
					echo "Allow Like ";
				}
				if($row["allow_comment"]){
					echo "Allow Comment ";
				}
				if($row["allow_share"]){
					echo "Allow Share ";
				}
				echo "</p>";
				echo "<hr width=80%>";//seperate each status with a horizontal line
			}

			//close the opened connection
			mysqli_close($conn);
		}
	}
?>

<!-- provide links to go back to search for another status and home page in the beginning and end on the same line -->
<p style="text-align:left;">
	<a href="searchstatusform.php">Search for another status</a>
	<span style="float:right;"><a href="index.php">Return to Home Page</a></span>
</p>
</body>
</html>