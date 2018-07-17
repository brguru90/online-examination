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
	$sql = "create table login
	(
	name varchar(20) not null,
	user VARCHAR(20) UNIQUE,
	pwd VARCHAR(20) NOT NULL,
	user_id varchar(10) primary key,
	branch_code varchar(10) not null,
	start_date INT(10) not null,
	end_date INT(10) not null
	);";
	$conn->query($sql);
	$n=$_POST["n"];
	$success=$fail=0;
	for($i=1;$i<=$n;$i++)
	{
		$name=$_POST["name"][$i];
		$user=$_POST["user"][$i];
		$pwd=$_POST["pwd"][$i];
		$user_id=$_POST["user_id"][$i];
		$branch_code=$_POST["branch_code"][$i];
		$start_date=$_POST["start_date"][$i];
		$end_date=$_POST["end_date"][$i];
		//echo "$name<br />$user<br />$pwd<br />$user_id<br /><br />";
		$sql="insert into login values('$name','$user','$pwd','$user_id','$branch_code',$start_date,$end_date)";
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