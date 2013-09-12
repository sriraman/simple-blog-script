<?php


require('../db_connect.php');
require('admin_only_area.php');

$articleId = $_POST['articleId'];

$title = $_POST['title'];

$content = $_POST['content'];

$stmt = $db->prepare("UPDATE article SET `title`='".$title."',`content`='".$content."' where `articleId` = '".$articleId."'");

$stmt->execute();



$articleCategories = $db->prepare("DELETE from `articlecategory` where `articleId` = $articleId");

$articleCategories->execute();

$category = $_POST['category'];

$stmt = $db->prepare("INSERT INTO articlecategory(`articleId`,`category`) values( $articleId ,:category)");

$stmt->bindParam(':category',$cat);

foreach($category as $cat)
{
	$stmt->execute();
}


$_SESSION['flash_notice'] = "Article is updated successfully";

header('Location: admin.php');

?>