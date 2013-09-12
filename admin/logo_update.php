<?php


require('../db_connect.php');
require('admin_only_area.php');



if(isset($_FILES['logo']))
{

	$filename = time().$_FILES['logo']['name'];

	


if (preg_match('/^image\/p?jpeg$/i', $_FILES['logo']['type']) || preg_match('/^image\/gif$/i', $_FILES['logo']['type']) || preg_match('/^image\/(x-)?png$/i', $_FILES['logo']['type']))
{

	copy($_FILES['logo']['tmp_name'],"../images/".$filename);

	$stmt = $db->prepare("UPDATE `admin` SET `value` = '".$filename."' where `option` = 'logo'");
	$stmt->execute();

	$_SESSION['flash_notice'] = "Logo updated successfully :)";
	header('Location: admin.php');

}
else
{
	$_SESSION['flash_warning']="We are supporting only jpg images for now :(";

	header('Location: admin.php');
}
}