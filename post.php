<?php

	if(!isset($_GET['id']))
	{
		header("Location: index.php");
	}

	require('db_connect.php');

	session_start();

	$article = $db->prepare("SELECT * FROM article WHERE articleId = :id");

	$id = $_GET['id'];

	$article->execute(array('id'=>$id));

	$article = $article->fetch();

	if($article==NULL)
	{
		header('Location: index.php');
		exit;
	}

	if(!isset($_COOKIE["article".$id]))
	{
		setcookie("article".$id,"1");

		//increase the view

		$view = $db->prepare("UPDATE article SET views = views + 1 WHERE articleId = $id");

		$view->execute();
	}

	$rarticles = $db->prepare("SELECT * from article WHERE articleId != $id order BY RAND() LIMIT 1");

	$rarticles->execute();

	$settings = $db->prepare("SELECT * from admin");

	$settings->execute();

	$setting = $settings->fetchAll();

	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $setting['0']['value']; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/style1.css">	
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
								echo "<img id='title' src='images/".$setting['9']['value']."'></img>";
							}

				?>
			</center>
			</a>
		</header>
		<div class="container">
					<h1> <?php echo $article['title']; ?> </h1>
					<hr>
					<p class="content"> <?php echo nl2br($article['content']); ?> </p>
					
		</div>
				
				
				<div class="clearfix"></div>
				
		<br><br>
		<center> <h2 class='thank-you'><?php echo $setting['8']['value']; ?></h2> </center>
		</div>
		

</body>
</html>