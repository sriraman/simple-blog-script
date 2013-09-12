<?php

require('../db_connect.php');

require('admin_only_area.php');

if(!isset($_GET['id']))
{
	header("Location: index.php");
}


	$article = $db->prepare("SELECT * FROM article WHERE articleId = :id");

	$article->execute(array('id'=>$_GET['id']));

	$article = $article->fetch();

	if($article==NULL)
	{
		$_SESSION['flash_warning'] = "Illegal Access detected..";
		header("Location: admin.php");
		exit;
	}



$id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM `article` WHERE articleId= $id");

$stmt->execute();

$stmt2 = $db->prepare("DELETE FROM `articleCategory` WHERE articleId = $id");

$stmt2->execute();

$_SESSION['flash_notice']="Article deleted successfully";

@header('Location: admin.php');

?>