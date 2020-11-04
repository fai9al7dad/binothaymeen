<?php 
include 'connect.php';
session_start();

if(isset($_GET['wirdid'])){
    $id= $_GET['wirdid'];
    $stmt = $con->prepare("DELETE FROM wird where wirdid = '$id'");
    $stmt->execute();
    header('Location:filters/daily.php');
}
else if(isset($_GET['userid'])){
    $id= $_GET['userid'];
    $stmt = $con->prepare("DELETE FROM users where userid = '$id'");
    $stmt->execute();
    header('Location:filters/daily.php');
}

?>
