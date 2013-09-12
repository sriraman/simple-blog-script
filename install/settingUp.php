<?php
session_start();
require_once('../db_connect.php');

if($_POST['siteTitle']==NULL)
{
	$_SESSION['flash_warning'] = "Illegal access detected";
	header('Location: setup.php');
	exit;
}

if($_POST['password']!=$_POST['rpassword'])
{
	$_SESSION['flash_warning'] = "Password is not matching";
	header('Location: setup.php');
	exit;
}
else{

	$value = addslashes($_POST['siteTitle']);

	$stmt = $db->prepare("update `admin` SET `value` = '".$value."' where `option` = 'title'");

	$stmt->execute();

	$value = addslashes($_POST['name']);

	$stmt = $db->prepare("update `admin` SET `value` = '". $value."' where `option` = 'name'");

	$stmt->execute();

	$value = addslashes($_POST['email']);

	$stmt = $db->prepare("update `admin` SET `value` = '". $value."' where `option` = 'email'");

	$stmt->execute();

	$value = addslashes($_POST['password']);

	$stmt = $db->prepare("update `admin` SET `value` = '". $value."' where `option` = 'password'");

	$stmt->execute();

	$_SESSION['flash_notice'] = "Site settings updated successfully";

	header('Location: ../admin/admin.php');
	exit;
}


	


?>