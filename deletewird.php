<?php 
include 'connect.php';
session_start();

if(isset($_GET['wirdid'])){
    $id= $_GET['wirdid'];
    $stmt = $con->prepare("DELETE FROM wird where wirdid = '$id'");
    $stmt->execute();
    header('Location:filters/daily.php');
}


?>
