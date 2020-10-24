<?php
    $dsn = 'mysql:host=us-cdbr-east-02.cleardb.com;dbname=heroku_01f7e53d968aa6c';
    $user = 'b6c8d727357aed';
    $pass = '873ee654';
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
