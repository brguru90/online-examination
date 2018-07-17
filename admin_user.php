<?php
session_start();
if (!isset($_SESSION['admin']))
{
	header('Location:index.html');
}
include('db.php');
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}
$sql="select * from login";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) 
	{
		$start_date=$row["start_date"];
		$end_date=$row["end_date"];
		break;
	}
}
else{
	$start_date=date("dmY");
	$end_date=(date("d")+6)."".date("mY");
}
?>
<html>
<head>
	<title>Admin</title>
	<script>
		window.onload=function(){
			add_fields(1);
		}
		function add_fields(n)
		{
			var i=0,text="";
			for(i=1;i<=n;i++)
			{
				text+="<table><tr><td colspan='2'><h2>User: "+i+"</h2></td></tr><tr><th>Name:</th><td><input type='text' value='' name='name["+i+"]' /></td></tr>"+
					 "<tr><th>User name</th><td><input type='text' value='' name='user["+i+"]' /></td></tr>"+
					 "<tr><th>Passwod</th><td><input type='password' value='' name='pwd["+i+"]' /></td></tr>"+
					 "<tr><th>User ID</th><td><input type='text' value='' name='user_id["+i+"]' /></td></tr>"+
					 "<tr><th>Branch code</th><td><input type='text' maxlength='10' value='' name='branch_code["+i+"]' /></td></tr>"+
					 "<tr><th>Start date</th><td><input type='text' value='<?php echo $start_date; ?>' maxlength='8' name='start_date["+i+"]' /></td></tr>"+
					 "<tr><th>End date</th><td><input type='text' value='<?php echo $end_date; ?>' maxlength='8' name='end_date["+i+"]' /></td></tr></table><br />";
					 
			}
			document.getElementById('frm').innerHTML=text;
		}
	</script>
	<style>
		table *{text-align:left;}
		table{border:solid silver 1px;padding:5px 10px 10px 10px;}
	</style>
<?php include('header.php'); ?>
	<form action="admin_user_add.php" method="post">
		<h4>Enter number of user to be added:</h4>
		<input type="number" value="1" name="n" id="n" />
		<input type="button" value="Add" onclick="add_fields(document.getElementById('n').value);" />
		<p id="frm">
		
		</p>
		<input type="submit" value="submit" />
	</form>
<?php include('footer.php'); ?>
</html>