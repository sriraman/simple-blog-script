<?php

require_once('../db_connect.php');

require_once('admin_only_area.php');


try{
	
$stmt = $db->prepare('INSERT INTO category VALUES(:category,:description)');

$stmt->execute(array(':category'=>$_POST['category'],':description'=>$_POST['description']));

$_SESSION['flash_notice'] = "Category added successfully";

header('Location: admin.php');

exit;

}catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}


?>