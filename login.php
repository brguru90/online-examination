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
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  
  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <body>
  <form method="post" action="loging.php" id="form1">
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Login</h1>
			</div>

			<div class="login-form">
				<div class="control-group">
				<input type="text" name="user" value="" placeholder="username"z>
				<label class="login-field-icon fui-user" for="login-name"></label>
				</div>

				<div class="control-group">
				<input type="password" name="pwd" value="" onclick="this.value='';" placeholder="password" >
				<label class="login-field-icon fui-lock" for="login-pass"></label>
				</div>

				<input type="Submit" value="Login">
			</div>
		</div>
	</div>
	</form>
</body>
  
  
</body>
</html>
