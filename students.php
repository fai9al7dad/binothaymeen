<?php 
include 'connect.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];
    $than = $row['halqah'] == 'than';

    if($than){
        $stmt = $con->prepare("SELECT * FROM users WHERE groupID = '0' AND halqah != 'jam' OR 'hofaz' ");
        $stmt->execute();
        $students = $stmt->fetchAll();   
    }else{
        $stmt = $con->prepare("SELECT * FROM users WHERE halqah = '$halqah' AND groupID = '0'");
        $stmt->execute();
        $students = $stmt->fetchAll();   

    }
}

else{
    echo'you are not registerd';
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
        <!--  الهيدر  -->
        <header>
            <div class="welcome">
                <h3>مرحبا</h3>
                <h1><?php echo $row["firstname"] . ' ' . $row['lastname']; ?></h1>
                <a href="logout.php"><p style ="font-size:12px;">تسجيل الخروج</p></a>
            </div>
            <div class="imgcontainer">
                <img src="images/logo1.png" alt="logo">
            </div>
            <div class="clear"></div>
        </header> 

        <div class="clear"></div>
        <?php
            if(($_SERVER['REQUEST_METHOD'] == "POST")){
                $hifz = htmlspecialchars($_POST['hifz']);
                $muraja = htmlspecialchars($_POST['muraja']);
                $id = htmlspecialchars($_POST['userid']);

                $update = $con->prepare("UPDATE users SET hifz=?, muraja =? WHERE userid = ?");
                $update->execute([$hifz,$muraja,$id]);
                echo "<p>تم التعديل بنجاح</p>";
       

             }
        ?>  
        <!-- الطلاب -->
        <div style="text-align:right; margin:10px">
            <a href="filters/daily.php" class="editstudent">الصفحة الرئيسية</a>
        </div>
 
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>الحذف</th>
                    <th>الحصاد</th>
                    <th>التعديل</th>
                    <th>ورد المراجعة</th>
                    <th>ورد الحفظ</th>
                    <th>الاسم الاخير</th>
                    <th>الاسم الاول</th>
                </tr>
                
                <?php
                    foreach($students as $student){
                        echo '<tr>';
                        echo '<td><a href="deletewird.php?userid='.$student['userid'] .'"class="fas fa-minus-square" style="color:#ff5151"></a></td>';
                        echo '<td><a href="studenthasad.php?userid='.$student['userid'] .'"class="fas fa-chart-bar" style="color:#2997ff"></a></td>';
                        echo '<td class="edit"><a href="editstudent.php?userid='.$student['userid'] .'"class="fa fa-edit" style="color:#2997ff"></a></td>';
                        echo '<td>' . $student['muraja'] . '</td>';
                        echo '<td>' . $student['hifz'] . '</td>';
                        echo '<td>' . $student['lastname'] . '</td>';
                        echo '<td>' . $student['firstname'] . '</td> </tr>';

                    }
                ?>
            </table>

    </div>
</body>
</html>