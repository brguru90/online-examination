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
		$que=htmlentities($_POST["que"][$i]);
		$option=htmlentities($_POST["option1"][$i]."_SePaRaTe_".$_POST["option2"][$i]."_SePaRaTe_".$_POST["option3"][$i]."_SePaRaTe_".$_POST["option4"][$i]);
		$correct=$_POST["correct"][$i];
		$subject_code=$_POST["subject_code"][$i];
		echo "$que<br />$option<br />$correct<br />";
		$sql="
			insert into quiz (que,ans_list,corr_ans,subject_code)
			values('$que','$option',$correct,'$subject_code');
		";
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