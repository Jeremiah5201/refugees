<?php 
define('DB_HOST', "localhost");
define('DB_USER',"root");
define('DB_PASS',"");
define('DB_NAME',"refugees_db");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$conn){
die("Error Establishing Database Connection");
}
?>
