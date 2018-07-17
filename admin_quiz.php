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
							"<tr><th colspan=2>Quetion:"+i+")<input type='text' value='' name='que["+i+"]' /></th></tr>"+
							"<tr><td>1.<input type='text' value='' name='option1["+i+"]' /></td><td>2.<input type='text' value='' name='option2["+i+"]' /></td></tr>"+
							"<tr><td>3.<input type='text' value='' name='option3["+i+"]' /></td><td>4.<input type='text' value='' name='option4["+i+"]' /></td></tr>"+
							"<tr><th>Correct Answer:</th><td>&nbsp&nbsp&nbsp<select name='correct["+i+"]' ><option>1</option><option>2</option><option>3</option><option>4</option></select></td></tr>"+
							"<tr><th>Subject code:</th><td>&nbsp&nbsp&nbsp<input type='text' value='cs' name= 'subject_code["+i+"]' /></td></tr>"+
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
	<form action="admin_quiz_add.php" method="post">
		<h4>Enter number of Quiz to be added:</h4>
		<input type="number" value="1" name="n" id="n" />
		<input type="button" value="Add" onclick="add_fields(document.getElementById('n').value);" />
		<p id="frm">
		
		</p>
		<input type="submit" value="submit" />
	</form>
<?php include('footer.php'); ?>
</html>