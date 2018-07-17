<html>
<head></head>
<body>
<h1> Page displayed after login</h1>
<?php include('log_details.php');
		if(isset($_SESSION["user"]))
		{
			echo "
		<div class='log'>
			<form action='logout.php' method='post' class='login'>
				<input  style='padding:5px 5px 5px 5px' type='submit' value='Logout' name='logout'/><b>";
				echo $_SESSION["user"]."</b>";
		echo "
			</form>
		</div>";
		}
?>
<h2><a href="quiz.php">Write test</a></h2>
</body>
<html>