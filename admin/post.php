<?php

require('../db_connect.php');

require('admin_only_area.php');



$featuredImageURL = NULL;

/*** Featured image ***/

if($_FILES['featuredImage'])
{
	$name = $_FILES['featuredImage']['name'];
	$filename = 'images/'.time().$name;
	copy($_FILES['featuredImage']['tmp_name'],"../".$filename);

	include("resize-class.php");

	$resizeObj = new resize("../".$filename);

	$resizeObj -> resizeImage(256, 256,'crop');

	$resizeObj -> saveImage("../".$filename, 100);

	if (preg_match('/^image\/p?jpeg$/i', $_FILES['featuredImage']['type']) || preg_match('/^image\/gif$/i', $_FILES['featuredImage']['type']) || preg_match('/^image\/(x-)?png$/i',$_FILES['featuredImage']['type']))
	{
		$featuredImageURL = $filename;
	}
	else
	{
		$_SESSION['flash_warning'] = "FeaturedImage you provided is not an image file";

		@header('Location: admin.php'); // It is not an image file
		exit;
	}
}


$title = $_POST['title'];

$content = $_POST['content'];

$featureSize = $_POST['featureSize'];

$featureImageFloat = $_POST['featureImageFloat'];


/*********** Adding article in the database **********************/

try{

$createdAt = date("Y-m-d H:i:s", time()+12600);


$stmt = $db->prepare("INSERT INTO article(`title`,`content`,`featureSize`,`featureImageFloat`,`featuredImage`,`createdAt`) values(:title,:content,:featureSize,:featureImageFloat,:featuredImage,:createdAt)");

$stmt->execute(array(':title' => $_POST['title'],':content' => $content , ':featureSize' => $_POST['featureSize'], ':featureImageFloat' => $_POST['featureImageFloat'],':featuredImage' => $featuredImageURL, ':createdAt' => $createdAt ));


$stmt = $db->prepare("SELECT `articleId` from article where `title`=:title");

$stmt->execute(array(':title'=>$_POST['title']));

$articleId = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}








$category = $_POST['category'];

$id = $articleId['articleId'];

$stmt = $db->prepare("INSERT INTO articlecategory(`articleId`,`category`) values( $id ,:category)");

$stmt->bindParam(':category',$cat);

foreach($category as $cat)
{
	$stmt->execute();
}


$_SESSION['flash_notice'] = "Article Posted Successfully :)";

header('Location: admin.php');

?>