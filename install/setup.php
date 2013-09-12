<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Setup</title>
	<link rel="stylesheet" type="text/css" href="../admin/css/admin.css">
</head>
<body>
<?php
	/* Flash Notice */
	

	if(isset($_SESSION['flash_notice']))
	{
		echo "<div class='box flash_notice' id='notification'>".$_SESSION['flash_notice']." </div>";
		unset($_SESSION['flash_notice']);
	}
	if(isset($_SESSION['flash_warning'])){
		echo "<div class='box flash_warning' id='notification'>". $_SESSION['flash_warning']."</div>";
		unset($_SESSION['flash_warning']);
	}

?>
<div class="box">
<form action="settingUp.php" method="post">
<center> <h2> Admin </h2> </center>
<hr>
	<label> Site Title </label>
	<input type="text" name="siteTitle" >
	<br>
	<label> Your Name </label>
	<input type="text" name="name">
	<br>
	<label> Email </label>
	<input type="text" name="email">
	<br>
	<label> Password </label>
	<input type="password" name="password">
	<br>
	<label> Retype Password </label>
	<input type="password" name="rpassword">
	<br>
	<center><input class="btn" type="submit"></center>
</form>
</div>

</body>
</html>