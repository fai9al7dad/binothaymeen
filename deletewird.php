<?php 
include 'connect.php';
session_start();

if(isset($_GET['wirdid'])){
    $id= $_GET['wirdid'];
    $stmt = $con->prepare("DELETE FROM wird_two where wird_id = '$id'");
    $stmt->execute();
    header('Location:filters/daily.php');
}
else if(isset($_GET['userid'])){
    $id= $_GET['userid'];
    $wirdstmt = $con->prepare("SELECT * FROM users where userid = '$id'");
    $wirdstmt->execute();
    $row = $wirdstmt->fetch();
    $username =$row['username'];
    
    // Delete user from database
    $stmt = $con->prepare("DELETE FROM users where userid = '$id'");
    $stmt->execute();

    // Delete user registerd wird from database
    $stmt = $con->prepare("DELETE FROM wird_id where username = '$username'");
    $stmt->execute();
    header('Location:filters/daily.php');
}

?>
