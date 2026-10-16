<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['registrar']) || $_SESSION['registrar']==""){ header('location:index.php'); exit; }
$need_id=(int)$_GET['need'];
$c_id=(int)$_SESSION['camp'];
mysqli_query($conn,"delete from camp_need where need_id='".$need_id."' and c_id='".$c_id."'");
header('location:camp-needs.php');
exit;
?>
