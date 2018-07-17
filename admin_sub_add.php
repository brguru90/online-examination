<?php
session_start();
if (!isset($_SESSION['admin']))
{
	header('Location:index.html');
}
if(isset($_POST["n"]))
{
	include('db.php');
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	$n=$_POST["n"];
	$success=$fail=0;
	for($i=1;$i<=$n;$i++)
	{
		$sub_code=$_POST["sub_code"][$i];
		$sub_name=$_POST["sub_name"][$i];
		$branch_code=$_POST["branch_code"][$i];
		$sql="insert into subjects values('$sub_code','$sub_name','$branch_code');";
		if ($conn->query($sql) === TRUE) {
			$success++;
		} else {
			$fail++;
		}
	}	
	echo "<script>alert('success:$success & fail:$fail');history.go(-1);</script>";
	$conn->close();
}
?>