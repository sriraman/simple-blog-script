<?php

require_once('../db_connect.php');
require_once('admin_only_area.php');




try{

$stmt = $db->prepare("UPDATE admin SET `value` = :value WHERE `option` = :option ");

$stmt -> bindParam(':value',$value);

$stmt -> bindParam(':option',$option);

$value = $_POST['siteTitle'];
$option = "title";

$stmt->execute();

$value = $_POST['footer'];
$option = "footer";

$stmt->execute();

$_SESSION['flash_notice'] = "Settings updated successfully";

header('Location: admin.php');

}catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>