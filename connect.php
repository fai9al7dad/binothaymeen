<?php
    $dsn = 'mysql:host=localhost;dbname=binothaymeen_oula';
    $user = 'root';
    $pass = 'soOol890';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    try {
        $con = new PDO($dsn,$user,$pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo 'Failed '. $e->getMessage();
    }
?>
