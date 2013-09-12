<?php

require_once('../db_connect.php');
require_once('admin_only_area.php');




try{

$stmt = $db->prepare("UPDATE admin SET `value` = :value WHERE `option` = :option ");

$stmt -> bindParam(':value',$value);

$stmt -> bindParam(':option',$option);

$value = $_POST['name'];
$option = "authorName";

$stmt->execute();

$value = $_POST['fbUrl'];
$option = "fburl";

$stmt->execute();

$value = $_POST['gpUrl'];
$option = "gpurl";

$stmt->execute();

$value= $_POST['twitterUrl'];
$option = "twitterurl";

$stmt->execute();

$value = $_POST['email'];
$option = "email";

$stmt -> execute();


$_SESSION['flash_notice'] = "Profile updated successfully";

header('Location: admin.php');

}catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>