<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){
    header('location:staff-login.php');
    exit;
}
$l_id=(int)$_GET['l'];
$delete=mysqli_query($conn,"delete from location where l_id = '".$l_id."'");
if($delete){
    header('location:add-location.php');
}else{
    echo "Failed to delete location. It may be linked to other records.";
}
?>
