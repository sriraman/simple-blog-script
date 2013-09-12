<?php

session_start();

if(!isset($_POST['host']))
{
  redirect:header('Location: install.php');
}


$host = $_POST['host'];

$db = $_POST['db'];

$username = $_POST['username'];

$password = $_POST['password'];

 $fp = fopen('db_connect.php', 'w+');


fwrite($fp, '<?php

$host= "'.$host.'"; /** Host Name **/

$db = "'.$db.'";    /** Datbase Name **/

$username = "'.$username.'";  /** Username **/

$password = "'.$password.'";  /** Password **/


$db = new PDO("mysql:host=$host;dbname=$db", $username, $password);

?>');


header('Location: install_step2.php');
exit;

?>
