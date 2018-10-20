<!DOCTYPE html>
<html>
<head>
	<title>Post status process</title>
</head>
<body>
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
	else 
	{		
		//get data from the post status form	
		$code = $_POST["code"];			
		$status = $_POST["status"];
		$share = $_POST["share"];
		$date = $_POST["date"];		
		$allow_like = false;
		$allow_comment = false;
		$allow_share = false;

		//regular expressions to check for input validation
		$codeRE = "/^S\d{4}$/";//a code should start with capital 'S' followed by 4 digits 
		$statusRE = "/^[a-zA-Z0-9 ,\.!\?]*$/";//a status should only include alphanumberic characters, comma, fullstop, exclaimation mark, and question mark
		$dateRE = "/^\d{1,2}\/\d{1,2}\/\d{1,2}$/";//date should be in dd/mm/yy format

		if(!preg_match($codeRE, $code)) {
			//if the input doesnt match the expression, display an error message
			echo "<p>Sorry, code must start with an uppercase letter \"S\" followed by 4 numbers.</p>";
		} 
		else {
			$query = "select * from $sql_tble where code = '$code'";//check if the code has already existed in the database by executing the query with the code
			$result = mysqli_query($conn, $query);
			
			if(!$result) {
				//if the execution isn't successful, display an error message
				echo "<p>Sorry, something is wrong with $query</p>";
			} 
			else {
				//if the execution is successful, check the number of rows returned
				$num_row = mysqli_num_rows($result);

				if($num_row > 0){//if result has some rows, that means the code already existed, inform user that they can't use that code
					echo "<p>Sorry, $code already existed. Please try another number.</p>";
				} 
				else {//if result has no row, that means the user can use the code
					//check if the status matches the status expression
					if(!preg_match($statusRE, $status)) {
						echo "<p>Sorry, status can only contain alphanumeric characters including spaces, comma, period, exclamation point and question mark.</p>";
					} 
					else {
						//if the status is fine, check if date matches the date regular expression
						if(!preg_match($dateRE, $date)) {
							echo "<p>Sorry, please make sure date is in dd/mm/yy format.</p>";
						} 
						else {
							//if date is fine, check data for the permission
							foreach($_POST['permission'] as $permission){
								if($permission == 'like'){
									$allow_like = true;
								}
								if($permission == 'comment'){
									$allow_comment = true;
								}
								if($permission == 'share'){
									$allow_share = true;
								}
							}

							//create the sql command to insert data into the table
							$query = "insert into $sql_tble" . 
									 " (code, status, share, date, allow_like, allow_comment, allow_share)" .
									 "values" .
									 "('$code', '$status', '$share', STR_TO_DATE('$date', '%d/%m/%y'), '$allow_like', '$allow_comment', '$allow_share')";
							
							//execute the query
							$result = mysqli_query($conn, $query);
							//check if the execution is succesful
							if(!$result){
								//display an error message
								echo "<p>Something is wrong with ", $query, "</p>";
							} 
							else {
								//inform user the status has been posted
								echo "<p>Sucessfully posted the status.</p>";
							}			
						}				
					}
				}	
			}					
		}		
		
		//close the database connection
		mysqli_close($conn);		
	}
?>
<p>
	<a href="poststatusform.php">Return to Post Status Page</a><br>
	<a href="index.php">Return to Home Page</a>
</p>
</body>
</html>