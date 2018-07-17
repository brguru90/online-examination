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
<?php include('header.php'); ?>
	<style>
		ul *{text-decoration:none;}
	</style>
	<ul>
		<li><a href="init.php">Initialize</a></li>
		<li><a href="admin_user.php">Add users</a></li>
		<li><a href="admin_quiz.php">Add Quiz</a></li>
		<li><a href="admin_subjects.php">Add Subjects</a></li>
	</ul>
<?php include('footer.php'); ?>
</html>