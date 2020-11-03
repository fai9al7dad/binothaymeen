<?php 
include 'connect.php';
session_start();

if(isset($_GET['userid'])){
    $id= $_GET['userid'];
    $stmt = $con->prepare("SELECT * FROM users where userid = '$id'");
    $stmt->execute();
    $row = $stmt->fetch();

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">

</head>
    



<body>
    <div class="container">
    <form action="students.php"  class="formedit" method="POST">
        <div class="imgcontainer" style="float:none">
            <img src="images/logo1.png" alt="logo" style="width:190px;height:170px">
        </div>
        <p>تعديل ورد الطالب <?php echo $row['firstname'] . ' ' . $row['lastname']?></p>
     
        <div class="edit">
            <label for="hifzinput">ورد الحفظ</label>
            <input type="number" name="hifz" class="hifzinput" id="hifzinput" autocomplete = "off" value ="<?php echo $row['hifz']?>" step='0.1' min ='0' >
        </div>

        <div class="edit">
            <label for="murajainput">ورد المراجعة</label>
            <input type="number" name="muraja" class="murajainput" id="murajainput" autocomplete ="off" value = "<?php echo $row['muraja']?>" step='0.1' min ='0'>
        </div>
        
        <div class="submitbutton">
            <input name ="submit" type="submit" value="تعديل" class="mainbutton">
        </div>
        <input type="hidden" name ="userid" value = "<?php echo $row['userid']?>">
    
    </form>

    </div>
</body>
</html>
        