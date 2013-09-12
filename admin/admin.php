<?php

require('../db_connect.php');

require('admin_only_area.php');


$settings = $db->prepare("SELECT * from admin");

$settings->execute();

$setting = $settings->fetchAll();



$posts = $db->prepare("SELECT COUNT('articleId') from article");
	
$posts->execute();
$post = $posts->fetch();
	
$articles = $db->prepare("SELECT * from article order BY article.createdAt DESC LIMIT 5");

$articles->execute();

?>
<!DOCTYPE html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title><?php echo $setting['0']['value']; ?> Admin</title>
			<link rel="stylesheet" type="text/css" href="css/component.css" />
			<link rel="stylesheet" type="text/css" href="css/normalize.css" />
			<script src="../js/jquery-2.0.3.min.js"></script>
			<link rel="stylesheet" href="css/admin.css">
			<script src="js/modernizr.custom.js"></script>
			<link rel="stylesheet" type="text/css" href="icomoon.css">
	</head>
	<body>
		
	<div id="top-nav">
		<ul id="gn-menu" class="gn-menu-main">
			<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li><a class="gn-icon gn-icon-article" onclick="newPost()">New post</a></li>
								<li><a class="gn-icon gn-icon-edit" onclick="editPost()">Edit post</a></li>
								<li><a class="gn-icon gn-icon-plus" onclick="addCat()">Categories</a></li>
								<li><a class="gn-icon gn-icon-user" onclick="profile()">Edit profile</a></li>
								<li><a class="gn-icon gn-icon-cog" onclick="site_settings()">Settings</a></li>

							</ul>
						</div><!-- /gn-scroller -->
					</nav>
			</li>
			<li><h1 id="nav-title"><?php echo $setting['0']['value']; ?> Admin</h1></li>
			<li style="float:right;"><a id="logout-btn" class="btn" href="logout.php" title="Logout">Logout</a></li>
			<li style="float: right;"><img src="../images/dp/thumb<?php echo ($setting[2]['value']==NULL)?'.png':$setting[2]['value']; ?>" alt="" style="margin-top: 14px;height: 36px;"> </li>
			<li style="float:right;"><p class="greeting">Welcome <?php echo ucfirst($_SESSION['authorName']); ?></p></li>
			
			
		</ul>

	</div>




	<div class="container">

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

		<div id="new_post" class="box">
			<form method="post" action="post.php" enctype="multipart/form-data">
				<label> Title </label>
				<input name="title" type="text">
				<br><br>
				<label> Content </label>
				<textarea id="content" name="content"> </textarea>
				<label> Featured Image Size </label>
				<select name="featureSize"> 
					<OPTION value="small"> Small </OPTION>
					<option value="medium"> Medium </option>
					<option vlaue="large"> Large </option>
				</select>
				<br>
				<label> Featured Image Float </label>
				<select name="featureImageFloat"> 
					<OPTION value="left"> Left </OPTION>
					<option value="right"> Right </option>
				</select>
				<br>
				<label for="featuredImage"> Featured Image </label>
				<input type="file" name="featuredImage"><br>

				<label for="category"> Category : </label><br>
				<?php


				$stmt = $db->prepare('SELECT `category` from category');

				$stmt->execute();

				$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach($categories as $category)
				{
					echo "<div class='categories'>";
					echo "<input type='checkbox' name='category[]' value='".$category['category']."'>".$category['category'];
					echo "</div>";
				}

				?>
				<div class="clearfix"></div>
				<center><input type="submit" class="btn" value="submit"></center>
			</form>
		</div>

		<div class="box" id="editPost">
			<div id='result'>
				<table class="editTable">
			
	<?php
		$flag = 0; //Check wheather the control entering into the where condition for first time 
		while($article=$articles->fetch())
		{
			if($flag==0)
			{
				echo "<tr><th>Article Name</th><th>Views</th></tr>";
				$flag = 1;
			}

			echo "<tr><td><a class='article' href='edit.php?id=".$article['articleId']."' title='".$article['title']."''>".$article['title']."</a></td><td class='views'>".$article['views']." </td></tr>";
		}

		echo "</table></div> <center><a id='morePost' href='#' onclick='ajaxPost()'> [ More post ... ] </a></center>";

		if($flag==0)
		{
			echo "<center><h2> You didn't post anything till now :( </h2></center>";
		}

?>
			
				</table>

			</div>
		</div>


		<div class="box" id="category">	
			<h3 id="subtitle">Categories</h3>

			<?php

			$stmt = $db->prepare("SELECT * from category where 1");

			$stmt->execute();

			echo "<div style='width:300px; margin: 0 auto;'>";
		
			echo "<form name='deleteCategories' method='post' action='deleteCategories.php'>";

			while($category = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<input type='checkbox' name='categories[]' value='".$category['category']."'>".$category['category']."</input><br>";
			}

			echo "<center><input class='btn' type='submit' value='delete categories'>";
			echo "</form></center></div>";

			?>

			<hr>

			<h3 id="subtitle">Add category</h3>

			<form name="addCategory" method = "post" action="addCategory.php">

			<label for="category"> New Category </label>
			<input type="text" name="category"><br>
			<label for="description"> Description </label>
			<textarea name="description"></textarea><br>
			<center><input class="btn" type="submit"></center>

			</form>
		</div>


		<div class="box" id="editProfile">

			<h3 id="subtitle">Edit profile</h3>

			<h2> Profile Editor </h2>
			<center>
			<?php 

			if($setting[2]['value']==NULL)
			{
				echo "<img src='../images/profile_dummy.jpg'></img>";
			}
			else
			{
				echo "<img src='../images/dp/".$setting[2]['value']."' width='185px'></img>";
			}

			echo "</center>";

			echo "<form name='dp' method='post' action='dp_update.php' enctype='multipart/form-data'><center><input type='file' name='dp'><br><input class='btn' type='submit' value='upload'></center></form>";


			?>

<hr>
			<form name='editProfile' method='post' action='editProfile.php'>

			<label for='name'> Name : </label>
			<input type="text" name="name" value="<?php echo $setting[1]['value']; ?>"><br>

			<label for='fbUrl'> Facebook URL </label>
			<input type="text" name="fbUrl" value="<?php echo $setting[3]['value']; ?>"><br>

			<label for="gpUrl"> Google+ URL </label>
			<input type="text" name="gpUrl" value="<?php echo $setting[4]['value']; ?>"><br>

			<label for='twitterUrl'> Twitter URL </label>
			<input type="text" name="twitterUrl" value="<?php echo $setting[5]['value']; ?>"><br>

			<label for="email"> Email :</label> 
			<input type="text" name="email" value="<?php echo $setting[6]['value']; ?>"><br>

			<center><input class="btn" type="submit"></center>

			</form>

	</div>


	<div class="box" id="setting">

		<h3 id="subtitle"> Settings </h3>

		
		<center><img class="logo" src="../images/<?php echo $setting['9']['value']; ?>"></center>

			<form name='logo' method='post' action='logo_update.php' enctype='multipart/form-data'>
				
				<label> Your Logo : </label>
					<input type='file' name='logo'>
					<br>
				<center>
					<input class='btn' type='submit' value='Upload the logo'>
				</center>
			
			</form>
<hr>
		<form name="settings" method="post" action="settings.php">

			<label> Site Name : </label>
			<input type="text" name="siteTitle" value="<?php echo $setting['0']['value']; ?>">
			
			<label> Footer : </label>
			<textarea name="footer"><?php echo $setting['8']['value']; ?></textarea>

			<center>
				<input class="btn" type="submit"/>
			</center>

		</form>
	</div>

	</div>


</body>
<script src="js/classie.js"></script>
		<script src="js/gnmenu.js"></script>
		<script type="text/javascript">

			var page = 1;
			var total_article = <?php echo ($post['0']==0)?'0':$post['0']; ?>;


			function ajaxPost()
					{

						page++;

						var data = {
							page_num: page
						};

						

						$.ajax({
						type: "POST",
						url: 'morePost.php',
						data: data,
						success: function(res) {
							$('#result').append(res);
						}
						});

						if((page)* 5 >= total_article)
						{
							$('#morePost').hide();
						}

					}


			new gnMenu( document.getElementById( 'gn-menu' ) );

			$(document).ready(function() {

					$('#new_post').hide();
					$('#category').hide();
					$('#editProfile').hide();
					$('#setting').hide();
					$('#notification').delay(5000).fadeOut('slow');
					$('.gn-submenu').hide();

					if(total_article<=5)
					{
						$('#morePost').hide();
					}
			});


			function clear()
			{
					$('#new_post').hide();
					$('#editPost').hide();
					$('#category').hide();
					$('#editProfile').hide();
					$('#setting').hide();
			}

			function newPost()
			{
				clear();
				$('#new_post').slideDown();
			}

			function site_settings()
			{
				clear();
				$('#setting').slideDown();
			}

			function editPost()
			{
				clear();
				$('#editPost').slideDown();
			}
			function profile()
			{
				clear();
				$('#editProfile').slideDown();
			}

			function addCat()
			{
				clear();
				$('#category').slideDown();
			}




		</script>
</html>
