<?php
include('db.php');
include('log_details.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST["quiz_arr"]) && isset($_SESSION["user_id"]) && isset($_SESSION['sub_code']))
{
	$sql="select * from user_subject where user='".$_SESSION["user"]."' and user_id='".$_SESSION["user_id"]."' and sub_code='".$_SESSION['sub_code']."'";
	$result=$conn->query($sql);
	if ($result->num_rows ==1) 
	{
		while($row = $result->fetch_assoc()) 
		{
			$time_rem=$row["tim"];
		}
	}
	$ans_list=$_POST["quiz_arr"];
	$uid=$_SESSION["user_id"];
	//print_r($_POST["quiz_arr"]);
	$sql="select * from quiz order by id";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		$count=0;
		$ans_data="";
		while($row = $result->fetch_assoc()) 
		{
			if(isset($ans_list[$row['id']]))
			$ans_data.=$row['id'].":".$ans_list[$row['id']]." ";
		
			if(isset($ans_list[$row['id']]) &&$ans_list[$row['id']]==$row['corr_ans'])
				$count++;
		}
		$total_quetions=$_SESSION["nor_of_quetions"];
		$attended=count($ans_list);
		if(time()-$time_rem<=($timeout))
		{
			$conn->query("update user_subject set total='$total_quetions',attended='$attended',right_ans='$count',ans_data='$ans_data' where user_id='$uid'  and sub_code='".$_SESSION['sub_code']."';");
			echo "<script>alert('Session is not completed,wait....');window.location.assign('quiz.php');</script>";
			if(isset($_POST["submit"]))
				unset($_SESSION['sub_code']);
			exit;
		}
		$sql="select * from user_subject where user='".$_SESSION["user"]."' and user_id='".$_SESSION["user_id"]."' and sub_code='".$_SESSION['sub_code']."'";
		$result=$conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$total_quetions=$row['total'];
				$attended=$row['attended'];
				$right_ans=$row['right_ans'];
			}
		}
		if(isset($_POST["submit"]))
			unset($_SESSION['sub_code']);
		echo "<script>alert('Attended:$attended/$total_quetions Right:$right_ans Wrong:".($attended-$right_ans)."');window.location.assign('quiz.php');</script>";
	}
}
else
{
	echo "<script>alert('nothing selected');window.location.assign('quiz.php');</script>";
}
$conn->close();
?>