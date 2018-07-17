<?php
include('db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

?>
<html>
<head>
	<title>quetions</title>
	<style>
		table{width:650px;}
		table *{text-align:left;}
	</style>
	<script src="jquery-3.2.1.min.js"></script>
<?php include('header.php'); ?>
	<?php
	ob_start();
		include('log_details.php');
		if(isset($_SESSION["user"]))
		{
			echo "
		<div class='log'>
			<form action='logout.php' method='post' class='login'>
				<input  style='padding:5px 5px 5px 5px' type='submit' value='Logout' name='logout'/><b>";
				echo $_SESSION["user"]."</b>";
		echo "
			</form>
		</div>";
		}
		/***********************End of quetion initialization*************************/
		if(isset($_POST["sub_code"])){
			$sub_code=$_POST["sub_code"];
			$_SESSION["sub_code"]=$sub_code;
			$uid=$_POST["user_id"];
			$sql="select * from user_subject where sub_code='$sub_code' and user_id='$uid' and user='".$_SESSION["user"]."'";
			$result=$conn->query($sql);
			if ($result->num_rows == 0) {
				$sql="insert into user_subject(user,user_id,sub_code) values('".$_SESSION["user"]."','$uid','$sub_code')";
				$conn->query($sql);
			}
		}

		/*************GENERATING QUITIONS**********************/
		if(isset($_POST["sub_code"])){
			echo "<h4>Subject code: $sub_code</h4>";
			$sql="select * from quiz where subject_code='$sub_code' order by id";
			$result=$conn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) 
				{
					$quiz_arr[$row["id"]][0]=$row["que"];
					$quiz_arr[$row["id"]][1]=$row["ans_list"];
				}
				$keys = array_keys($quiz_arr);
				shuffle($keys);//randoming quetions(id)
			}
		}
/******************************************************/

		/***********check whether alredy quiz is attended or time expired***********************/
		if(isset($_POST["user_id"]))
		{
			$uid=$_POST["user_id"];
			$sql="select * from user_subject where user='".$_SESSION["user"]."' and user_id='$uid' and sub_code='$sub_code'";
			$result=$conn->query($sql);
			if ($result->num_rows ==1) 
			{
				$_SESSION["user_id"]=$uid;
				if(isset($quiz_arr))
					generate_quetion();
				else
					echo "<script>alert('No quetions allotted');history.go(-1);</script>";
				while($row = $result->fetch_assoc()) 
				{
					if($row["tim"]!=null)
					{
						//now-before>maximum time limit;
						if(time()-$row["tim"]>($timeout))
						{
							header('Location: time_expire.php');
							exit;
						}
						else
						{
							$timeout-=time()-$row["tim"];
						}
					}
					else 
					{
						$conn->query("update user_subject set tim=".time()." where user='".$_SESSION["user"]."' and user_id='$uid' and sub_code='$sub_code';");
					}
					
					if($row["date"]!=null)
					{
						//now-before>maximum time limit;
						if($row["date"]!=date("dmY"))
						{
							header('Location: time_expire.php');
							exit;
						}
					}
					else 
					{
						$conn->query("update user_subject set date=".date("dmY")." where user='".$_SESSION["user"]."' and user_id='$uid' and sub_code='$sub_code';");
					}
				}
				
				
			}
			else
				echo "<script>alert('you have alredy attended quiz');history.go(-1);</script>";
		}
		/*********************************************************************************/
		$sql="select * from user_subject where user='".$_SESSION["user"]."' and user_id='$uid' and sub_code='$sub_code'";
				$result=$conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) 
					{
						$ans_data=$row['ans_data'];
					}
					echo "<script>var ans_data='$ans_data';</script>";
				}
		?>
	
	<script>
	//save data periodically on atteneding each quetions
	$(document).ready(function(){
		var timeout=<?php echo $timeout ?>;//seconds
		var count=0;
		//setTimeout(function(){document.getElementById('quiz').submit();}, timeout*1000);
		var trigger=setInterval(function(){
			var duration=(timeout-count);
			var k=0;
			while(duration>=60)
			{
				duration=duration-60;
				k++;
			}
			if(k>0)
				var text=k+"Min : "+duration+"Sec";
			else 
				var text=duration+"Sec";
			document.getElementById("timeout").innerHTML=text;
			count++;
			if(duration==0)
					clearInterval(trigger);
		}, 1000);
		
		$("input[type='radio']").change(function(){
			$.ajax({
				type: 'POST',
				url: $('#quiz').attr('action'),
				data: $('form').serializeArray()
			})
		});
		//previously selected answers
		setTimeout(function(){ select_it(); }, 1000);
		function select_it()
		{
			res=ans_data.split(" ");
			for(var i=0;i<res.length-1;i++)
			{
				//alert(res[i]);
				var sel=res[i].split(":");
				$("input[name='quiz_arr["+sel[0]+"]'][value="+sel[1]+"]").prop("checked", true);
				
				//$("input[type='radio'] [name='quiz_arr["+sel[0]+"]'] [value="+sel[1]+"]").attr('checked', 'checked');
			}
		}
	});
	</script>
	<script>
	/*************display remaining time & after timout submit automatically**********************/
		
		
	</script>
		<?php
		
		/*******************************displaying quetions************************************************/
			function generate_quetion()
			{
				global $keys,$quiz_arr,$number_of_quetions;
				
				echo "<h1>Timout:&nbsp&nbsp<b id='timeout'></b></h1><form action='check_ans.php' id='quiz' method='post'>";
				$c=1;
				$count=$_SESSION["nor_of_quetions"]=$number_of_quetions; //number of quetion to be displayed
				echo "<table>";
				foreach($keys as $key)
				{
					$options=explode("_SePaRaTe_",$quiz_arr[$key][1]);
					
					echo "
						<tr>
							<th>$c)".$quiz_arr[$key][0]."</th>
							<td><input type='radio' name='quiz_arr[$key]' value='1'>$options[0]</td>
							<td><input type='radio' name='quiz_arr[$key]' value='2'>$options[1]</td>
							<td><input type='radio' name='quiz_arr[$key]' value='3'>$options[2]</td>
							<td><input type='radio' name='quiz_arr[$key]' value='4'>$options[3]</td>
						</tr>
						";
						$c++;
						if($c==$count+1)
							break;
				}
				echo "
					</table>
					<input type='submit' value='submit' name='submit' />
					</form>
					";
			}
			
		/***********************************************************************************************************/
		ob_end_flush();
	?>
	
<?php include('footer.php'); ?>
</html>
<?php
$conn->close();
?>