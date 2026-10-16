<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$res_id=(int)$_GET['res'];
$delete=mysqli_query($conn,"delete from resources where res_id='".$res_id."'");
if($delete){ header('location:add-resource.php'); }
else{ echo "Failed to delete resource. It may be linked to other records."; }
?>
