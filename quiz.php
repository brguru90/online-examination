<html>
<head>
	<title>Quiz</title>
<?php 	include('header.php');
		include('log_details.php');
		if(isset($_SESSION["user"]))
		{
			echo "
		<div class='log'>
			<form action='logout.php' method='post' class='login'>
				<input  style='padding:5px 5px 5px 5px;height:35px;' type='submit' value='Logout' name='logout'/><b>";
				echo $_SESSION["user"]."</b>";
		echo "
			</form>
		</div>";
		}
include('db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
$sql="select * from login where user='".$_SESSION["user"]."'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
		$name=$row['name'];
		$user_id=$row['user_id'];
		$branch_code=$row['branch_code'];
	}
}
echo "<h1>Hi Mr/Ms $name</h1>";
echo "
	<form action='quetions.php' method='post'>";
$sql="select * from subjects where branch_code='$branch_code'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	$flag=0;
    while($row = $result->fetch_assoc()) 
	{
		$sub_code=$row['sub_code'];
		$sub_name=$row['sub_name'];
		if($flag==0)
			echo 
			"<label><input type='radio' name='sub_code' checked='checked' value='$sub_code'/>$sub_name</label><br />";
		else
			echo 
			"<label><input type='radio' name='sub_code' value='$sub_code'/>$sub_name</label><br />";
		$flag=1;
	}
}		
	echo "<br /><br />&nbsp&nbsp<input type='text' value='$user_id' name='user_id' onfocus='this.blur();'/>
		<input type='submit' value='proceed' />
	</form>
	";
	$conn->close();
	include('footer.php');
?>
</html>