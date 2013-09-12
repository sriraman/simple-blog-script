<?php

session_start();

require_once('../db_connect.php');

$settings = $db->prepare("SELECT * from admin");

$settings->execute();

$setting = $settings->fetchAll();


if(isset($_SESSION['authorName']))
{
	header("Location: admin.php");
}

if(!isset($_POST['email']))
{

?>

<!DOCTYPE html>
	<head>
			<meta charset="utf-8">
			<title><?php echo $setting['0']['value']; ?> Admin</title>
			
			<link rel="stylesheet" href="css/admin.css">
	</head>

<body>

	<header>
			<a href="index.php">
				<center>
				<?php

					if($setting['9']['value']==NULL)
							{

								echo "<h1 id='title'> ".$setting['0']['value']."</h1>";
							}
						else
							{
								echo "<img id='title' src='../images/".$setting['9']['value']."'></img>";
							}

				?>
			</center>
			</a>


			</a>

		</header>
<form name="login" method="post" action="admin_login.php" class="box">

	<label>Email :</label>
	<input type="text" name="email" placeholder="email"><br>
	<label>Password :</label>
	<input type="password" name="password" placeholder="password"><br>
	<center><input class="btn" value="submit" type="submit"></center>

</form>

</body>


<?php

}
else
{
	include_once('../db_connect.php');


	if($setting[6]['value']==$_POST['email']&&$setting[7]['value']==$_POST['password'])
	{
		$_SESSION['authorName']=$setting[1]['value'];

		$_SESSION['flash_notice']="Logged in successfully";
		
		header('Location: admin.php');
	}
	else
	{	
		

		echo "password or username is wrong";
	}


}





?>

</html>