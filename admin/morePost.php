<?php

require_once('../db_connect.php');
require_once('admin_only_area.php');

$limit = (($_POST['page_num']-1)*5).",5";


	$posts = $db->prepare("SELECT COUNT('articleId') from article");
	$posts->execute();
	$post = $posts->fetch();
	
	$articles = $db->prepare("SELECT * from article order BY article.createdAt DESC LIMIT $limit");
	

$articles->execute();

?>

<table class="editTable">
			
<?php 
		while($article=$articles->fetch())
		{
			echo "<tr><td><a class='article' href='edit.php?id=".$article['articleId']."' title='".$article['title']."''>".$article['title']."</a></td><td class='views'>".$article['views']." </td></tr>";
		}

?>


</table>



