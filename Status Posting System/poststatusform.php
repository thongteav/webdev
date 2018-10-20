<!DOCTYPE html>
<html>
<head>
	<title>Post Status Page</title>
</head>
<body>
	<form action="poststatusprocess.php" method="POST"><!-- using post method for form submission to protect -->
		<h1>Status Posting System</h1>
		<!-- using a table to format the form into better structure -->
		<p><table border="0">
			<tr><td>Status Code (required): </td>
				<td><input type="text" name="code" style="width:100%" maxlength="5" required/></td>
			</tr>
			<tr><td>Status (required): </td>
				<td><input type="text" name="status" style="width:200%" required/></td>
			</tr>
		</table></p>
		<p><table border="0">
			<tr><td>Share:</td> 
				<td><input type="radio" name="share" value="Public">Public</td>
				<td><input type="radio" name="share" value="Friends">Friends</td>
				<td><input type="radio" name="share" value="Only Me">Only Me</td>
			<tr><td>Date:</td>
				<td><input type="text" name="date" value=<?php echo(strftime("%d/%m/%y")); ?> required/></td>
			<tr><td>Permission Type:</td>
				<td><input type="checkbox" name="permission[]" value="like"> Allow like</td>
				<td><input type="checkbox" name="permission[]" value="comment"> Allow Comment</td>
				<td><input type="checkbox" name="permission[]" value="share"> Allow Share</td>
		</table></p>
		<p>
			<input type="submit" value="Post">
			<input type="reset" value="Reset">
		</p>
		<p>
			<a href="index.php">Return to Home Page</a><br>
		</p>
	</form>
</body>
</html>