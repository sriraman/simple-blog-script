<?php

require('../db_connect.php');
require('admin_only_area.php');


if(!isset($_GET['id']))
{
	header("Location: index.php");
}

$categories = $db->prepare("SELECT * FROM category");

$categories->execute();

$articleId = $_GET['id'];

$articleCategories = $db->prepare("SELECT * from `articlecategory` where `articleId` = $articleId");

$articleCategories->execute();

$articleCategory = $articleCategories->fetchAll();

$article = $db->prepare("SELECT * FROM article WHERE articleId = :id");

$article->execute(array('id'=>$_GET['id']));

$article = $article->fetch();

if($article==NULL)
{
	$_SESSION['flash_warning'] = "Illegal Access detected..";
	header("Location: admin.php");
}


$settings = $db->prepare("SELECT * from admin");

$settings->execute();

$setting = $settings->fetchAll();

?>


<!DOCTYPE html>
<html>	
	<head>
			<meta charset="utf-8">
			<title>Edit | <?php echo $setting['0']['value']; ?></title>
			<link rel="stylesheet" type="text/css" href="css/admin.css">
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
		</header>
		<div id="article-container">
			<div class="post-content">
				<form action="updatePost.php" method="post" >

				<input type="text" name="articleId" value="<?php echo $_GET['id']; ?>" hidden="true">
				<textarea name="title" class="post-title"><?php echo $article['title']; ?></textarea>
				<br>
				<textarea name="content" class="content"> <?php echo $article['content']; ?> </textarea>	
		
				
				

		
				<label for="categories"> Categories : </label><br>

<?php

$categories = $categories->fetchAll();

				foreach($categories as $category)
				{					
					echo "<div class='categories'>";
					echo "<input type='checkbox' name='category[]' value='".$category['category']."' ";
					foreach($articleCategory as $articlecat)
						{
							if(in_array($category['category'] , $articlecat))
							  echo "checked";
						}

					echo ">".$category['category'];
					echo "</div>";
				}

?>


				<center>
					<a href="admin.php" class="button button-primary"> Back to Admin panel </a>
					<input type="submit" value="Submit" class="button button-subscribe">
					<a href="deletePost.php?id=<?php echo $article['articleId']; ?>" class="button button-danger"> Delete this Article </a>
				</center>
				</form>
				</div>
			</div>
		</div>

	</body>
</html>