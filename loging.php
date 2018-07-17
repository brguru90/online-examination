<?php
session_start();
	if (isset($_COOKIE['user']))
	{
		$_SESSION['user']=$_COOKIE['user'];
	}
	if (isset($_SESSION['user']))
	{
		header('Location:quiz.php');
	}
include('db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$user=$_POST["user"];
$pwd=$_POST["pwd"];
$sql="select * from login where user='".$user."';";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
        $passwd=$row["pwd"];
		if($pwd==$passwd)
		{
			if(isset($_POST["loginkeeping"]))
			{
				setcookie("user",$user, time() + (86400), "/");
			}	
			$_SESSION["user"]=$user;
			header('Location: quiz.php');
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