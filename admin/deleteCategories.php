<?php

require_once('../db_connect.php');
require_once('admin_only_area.php');


if(isset($_POST['categories']))
{
	$stmt = $db->prepare("DELETE FROM category where category = :categoryName");

	$stmt->bindParam(':categoryName',$category);

	$stmt2 = $db->prepare("DELETE FROM articlecategory WHERE category = :categoryName");

	$stmt2->bindParam(':categoryName',$category);

	foreach($_POST['categories'] as $category)
	{
		$stmt->execute();
		$stmt2->execute();
	}

}

$_SESSION['flash_warning'] = "Selected categories are deleted.. ";
header('Location: admin.php');

?>
