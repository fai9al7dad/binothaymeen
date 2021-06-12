<?php 
include 'connect.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];

    $stmt = $con->prepare("SELECT * FROM users WHERE halqah = '$halqah' AND groupID = '0'");
    $stmt->execute();
    $students = $stmt->fetchAll();   

    if(isset($_POST['submit'])){
        if(isset($_POST['absent'])){
            foreach ($_POST['absent'] as $userid){
                $stmt = $con->prepare("SELECT * FROM users where userid = '$userid'");
                $stmt->execute();
                $row=$stmt->fetch();
                $user_id = $row['userid'];



                $insertstmt = $con->prepare("INSERT INTO wird_two(user_id,hifz,muraja,date,hifztasmee3,murajatasmee3,reading,reading_grade) VALUES (?,?,?,now(),?,?,?,?)");
                $result = $insertstmt->execute([$user_id,0, 0,"غائب","غائب","غائب", 0]);
                if ($result){
                    echo '<p style="text-align:center">تم التسجيل بنجاح<a class ="editstudent" href="filters/daily.php"> اذهب الى صفحة التسجيل </a></p>';
                }
            }
        }
        else if(isset($_POST['absentexecuse'])){
            foreach ($_POST['absentexecuse'] as $userid){
                $stmt = $con->prepare("SELECT * FROM users where userid = '$userid'");
                $stmt->execute();
                $row=$stmt->fetch();
                $user_id = $row['userid'];

                $insertstmt = $con->prepare("INSERT INTO wird_two(user_id,hifz,muraja,date,hifztasmee3,murajatasmee3,reading,reading_grade) VALUES (?,?,?,now(),?,?,?,?)");
                $result = $insertstmt->execute([$user_id,0, 0,"غائب بعذر","غائب بعذر","غائب بعذر", 0]);
                if ($result){
                    echo '<p style="text-align:center">تم التسجيل بنجاح<a class ="editstudent" href="filters/daily.php"> اذهب الى صفحة التسجيل </a></p>';
                }
            }
        }
        else{
            echo '<p class="bad"style="text-align:center">لم تحضر احد</p>';
        }
    }
    
}


else{
    echo'لست مصرح للدخول';
    header('Location: index.php');
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

</head>
    



<body>
    <div class="container">

    <p style="text-align:center">تسجيل الحضور</p>
        <!-- الطلاب -->
        <div style="text-align:right; margin:10px">
            <a href="filters/daily.php" class="editstudent">الصفحة الرئيسية</a>
        </div>
 
        <div style="overflow-x:auto;">
        <form action=<?php echo $_SERVER['PHP_SELF']?> method="post">
            <table>
                <tr>
                    <th>غائب بعذر</th>
                    <th>غائب</th>
                    <th>الاسم الاخير</th>
                    <th>الاسم الاول</th>
                </tr>
                <?php
                    foreach($students as $student){
                        echo '<tr>';
                        echo '<td> <input type="checkbox" name="absentexecuse[]" value="' . $student['userid'] . '"></td>';
                        echo '<td> <input type="checkbox" name="absent[]" value="' . $student['userid'] . '"></td>';
                        echo '<td>' . $student['lastname'] . '</td>';
                        echo '<td>' . $student['firstname'] . '</td> </tr>';

                    }
                ?>
            </table>
            <div class="submitbutton">
            <input name ="submit" type="submit" value="سجل" class="mainbutton">
        </div>
            </form>
    </div>
</body>
</html>