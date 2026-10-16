<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$ref_id=(int)$_GET['ref'];
$delete=mysqli_query($conn,"delete from refugee where ref_id='".$ref_id."'");
if($delete){ header('location:refugee.php'); }
else{ echo "Failed to delete refugee."; }
?>
