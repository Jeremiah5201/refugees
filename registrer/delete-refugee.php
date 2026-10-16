<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['registrar']) || $_SESSION['registrar']==""){ header('location:index.php'); exit; }
$ref_id=(int)$_GET['ref'];
$c_id=(int)$_SESSION['camp'];
$delete=mysqli_query($conn,"delete from refugee where ref_id='".$ref_id."' and c_id='".$c_id."'");
header('location:refugee.php');
exit;
?>
