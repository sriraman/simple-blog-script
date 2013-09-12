<?php

require('../db_connect.php');
require('admin_only_area.php');


if($_FILES['dp'])
{

	$filename = time().$_FILES['dp']['name'];

	


if (preg_match('/^image\/p?jpeg$/i', $_FILES['dp']['type']) || preg_match('/^image\/p?jpg$/i', $_FILES['dp']['type']) || preg_match('/^image\/gif$/i', $_FILES['dp']['type']) || preg_match('/^image\/(x-)?png$/i', $_FILES['dp']['type']))
{

	include("resize-class.php");

	copy($_FILES['dp']['tmp_name'],"../images/dp/".$filename);

	$resizeObj = new resize("../images/dp/".$filename);

	$resizeObj -> resizeImage(185, 185,'crop');

	$resizeObj -> saveImage("../images/dp/".$filename, 100);
	
	$resizeObj -> resizeImage(32,32,'crop');

	$resizeObj -> saveImage("../images/dp/thumb".$filename,100);

	$authorId = $_SESSION['userdata']['authorId'];
	$stmt = $db -> prepare("UPDATE `admin` SET `value`= '$filename' WHERE `option`= 'profilePic' ");

	$stmt->execute();


	$_SESSION['flash_notice']="Profile picture updated successfully";

	header('Location: admin.php');

}
else
{
	$_SESSION['flash_warning']="We are supporting only jpg images for now :(";

	header('Location: admin.php');
}
}