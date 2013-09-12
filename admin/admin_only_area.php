<?php

session_start();


if(!isset($_SESSION['authorName']))
{
	header("Location: admin_login.php");
	exit;
}
else
{
	$stmt = $db->prepare("SELECT `value` from `admin` where 'option'='authorName'");

	$stmt->execute();

	$data = $stmt->fetch();

	print_r($data);
}


?>