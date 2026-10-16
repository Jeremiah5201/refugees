<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$age_id=(int)$_GET['age'];
$delete=mysqli_query($conn,"delete from age_range where age_id='".$age_id."'");
if($delete){ header('location:refugee-age-range.php'); }
else{ echo "Failed to delete age range. It may be linked to other records."; }
?>
