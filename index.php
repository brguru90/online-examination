<html>
<head>
	<title>Home</title>
<?php include('header.php');?>
	<center><h1>HOME PAGE</h1></center>
	<div class='block_group'>
		<div class='block_1'>
			<br />
			<center><a style='text-decoration:none;color:black' onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" href="login.php"><h2 >Attend Quiz</h2></a></center>
		</div>
		<div class='block_2'><br />
			<center>
				<h2>Check Results</h2>
				<form action="results.php" method="get">
					<input type="text" value="1da16cs404" name="user_id" onclick="this.value='';" />
					<input type="submit" value="check" />
				</form>
			</center>
		</div>
		<div class='block_3'>
			<center>	
				<h2>Admin login</h2>
				<form action="admin_login.php" method="post">
					<input type="text" value="guru" name="user" onclick="this.value='';" /><br /><br />
					<input type="password" value="9611" name="pwd" onclick="this.value='';" /><br /><br />
					<input type="submit" value="Login" />
				</form>
			</center>
		</div>
	</div>
<?php include('footer.php');?>
</html>