<html>
<head>
	<title>Results</title>
<?php include('header.php'); ?>
<?php
if(isset($_GET["user_id"]))
{
	include('db.php');
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$uid=$_GET["user_id"];
	$sql="select * from login where user_id='$uid'";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
		{
			$branch_code=$row['branch_code'];
		}
	}
	$count_sub=0;
	$sql="select * from subjects where branch_code='$branch_code'";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
		{
			$count_sub++;
		}
	}
	$sql="select * from user_subject where user_id='$uid'";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		$flag=0;
		$sum_total=0;
		$sum_marks=0;
		$count=0;
		while($row = $result->fetch_assoc()) 
		{
			$user_id=$row['user_id'];
				$sql1="select * from login where user_id='$uid'";
				$result1=$conn->query($sql1);
				if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc()) 
					{
						$name=$row1['name'];
					}
				}
			$total=$row['total'];
			$attended=$row['attended'];
			$marks=$row['right_ans'];
			$sub_code=$row['sub_code'];
				$sql2="select * from subjects where sub_code='$sub_code'";
				$result2=$conn->query($sql2);
				if ($result2->num_rows > 0) {
					while($row2 = $result2->fetch_assoc()) 
					{
						$subject_name=$row2['sub_name'];
					}
				}
				if($flag==0)
					echo "<h2>Hi Mr/Ms $name</h2><table>";		
				echo "<tr><th>Subject:</th><td>$subject_name</td><th>Attended quetions:</th><td>$attended</td><th>Marks:</th><td>$marks/$total</td></tr>";
				$flag=1;
				$count++;
				$sum_total+=$total;
				$sum_marks+=$marks;
		}
		if($flag>0)
			echo "</table>";
		$percentage=($sum_marks*100)/($number_of_quetions*$count_sub);
		switch(true)
		{
			case ($percentage>=35 && $percentage<=40):$result="PASS";break;
			case ($percentage>40 && $percentage<=50):$result="SECOND CLASS";break;
			case ($percentage>50 && $percentage<=60):$result="FIRST CLASS";break;
			case ($percentage>60 && $percentage<=75):$result="DISTINCTION";break;
			case ($percentage>75 && $percentage<=100):$result="OUSTANDING";break;
			default:$result="fail";
		}
		$percentage=round($percentage,2);
		echo "<br /><table style='border:outset RoyalBlue 4px'>&nbsp&nbsp<tr><th>Nor of subject attended: </th><td>$count/$count_sub</td><th>Total: </th><td>".($number_of_quetions*$count_sub)."</td><th>Marks: </th><td>$sum_marks</td><th>Result: </th><td>$percentage</td><th colsoan='2' style='text-transform:uppercase;
'>&nbsp$result</th></tr></table>";
	}
	else
	{
		echo "<script>alert('Not found');history.go(-1);</script>";
	}
	$conn->close();
}
else
{
	echo "<script>alert('Wrong entry');window.location.assign('index.html');</script>";
}
?>
<?php include('footer.php'); ?>
</html>