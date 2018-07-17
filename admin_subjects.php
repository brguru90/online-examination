<?php
session_start();
if (!isset($_SESSION['admin']))
{
	header('Location:index.html');
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
				text+="<table>"+
							"<tr><th>Subject Code</th><th>Subject Name</th><th>Branch code</th></tr>"+
							"<tr><td><input type='text' value='' name='sub_code["+i+"]' /></td><td><input type='text' value='' name='sub_name["+i+"]' /></td><td><input type='text' value='' name='branch_code["+i+"]' /></td></tr>"+
						"</table><br />";	 
			}
			document.getElementById('frm').innerHTML=text;
		}
	</script>
	<style>
		table *{text-align:left;}
		table{border:solid silver 1px;padding:5px 10px 10px 10px;}
	</style>
<?php include('header.php'); ?>
	<form action="admin_sub_add.php" method="post">
		<h4>Enter number of Subjects to be added:</h4>
		<input type="number" value="1" name="n" id="n" />
		<input type="button" value="Add" onclick="add_fields(document.getElementById('n').value);" />
		<p id="frm">
		
		</p>
		<input type="submit" value="submit" />
	</form>
<?php include('footer.php'); ?>

</html>