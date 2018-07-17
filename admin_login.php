<?php
session_start();
include('db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
//---------first time Admin login table creation----------
$sql = "create table admin_login
(
user VARCHAR(20) primary key,
pwd VARCHAR(20) NOT NULL
);";
$conn->query($sql);
$sql="insert into admin_login values('admin','12345');";
$conn->query($sql);
$sql="insert into admin_login values('guru','9611');";
$conn->query($sql);

$user=$_POST["user"];
$pwd=$_POST["pwd"];
$sql="select * from admin_login where user='".$user."';";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
        $passwd=$row["pwd"];
		if($pwd==$passwd)
		{	
			$_SESSION["admin"]=$user;
			header('Location: admin.php');
		}
		else
		{
			echo "<script>alert('entered password is incorrect');history.go(-1);</script>";
			
		}
    }
	} else {
   echo "<script>alert('you have entered invalid user name');history.go(-1);</script>";
}
 

$conn->close();
?> 