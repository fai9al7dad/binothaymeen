<?php 
include '../connect.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];
    $groupID = $row['groupID'];
    $than = $row['halqah'] == 'than';
    if($groupID ==0 ){
        $_SESSION['username'] = $username;
        header('Location:../dashboard.php');
        exit();
    }

    if ($than){
        $stmt = $con->prepare("SELECT 
            wird_two.wird_id, wird_two.hifz, wird_two.muraja, wird_two.date, wird_two.hifztasmee3, wird_two.murajatasmee3, wird_two.reading,wird_two.reading_grade,
            users.username, users.firstname, users.lastname
            FROM wird_two
            LEFT JOIN users ON users.userid = wird_two.user_id
            WHERE halqah != 'jam' OR 'hofaz'
            order by date desc
        ");

        $stmt->execute();
    }
    else{
        $stmt = $con->prepare("SELECT 
            wird_two.wird_id, wird_two.hifz, wird_two.muraja, wird_two.date, wird_two.hifztasmee3, wird_two.murajatasmee3, wird_two.reading,wird_two.reading_grade,
            users.username, users.firstname, users.lastname
            FROM wird_two
            LEFT JOIN users ON users.userid = wird_two.user_id
            WHERE halqah = '$halqah'
            order by date desc
        ");
    }

    $stmt->execute();
    if (isset($_POST['filter'])){
        $filter= $_POST['selectfilter'];
        header('Location:' . $filter);
    }
    if(isset($_POST['submit'])){
        $from= $_POST['fromdate'];
        $to =$_POST['todate'];
        $stmt = $con->prepare("SELECT wirdid,username,firstname,lastname,hifz,muraja,date,hifztasmee3,murajatasmee3 FROM wird WHERE halqah = '$halqah' and date between '$from' and '$to' order by date desc");
        $stmt->execute();
    }
    
}

else{
    echo'you are not registerd';
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="icon" href="../images/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">


</head>

<body>
    <div class="container">
        <!--  الهيدر  -->
        <header>
            <div class="welcome">
                <h3>مرحبا</h3>
                <h1><?php echo $row["firstname"] . ' ' . $row['lastname']; ?></h1>
                <a href="../logout.php"><p style ="font-size:12px;">تسجيل الخروج</p></a>
            </div>
            <div class="imgcontainer">
                <img src="../images/logo1.png" alt="logo">
            </div>
            <div class="clear"></div>
        </header> 

        <div class="clear"></div>
        <!-- الاحصائيات -->

        <p style ="text-align:right;font-size:30px">احصائيات <a class="editstudent" href="../students.php"> الطلاب</a></p>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input class="filtersearch" type="submit" value="ابحث" name="filter">
            <select name="selectfilter" id="filter">
                <option value="daily.php">التسجيل اليومي</option>
                <option value="totalHasad.php">مجموع الحصاد</option>
                <option value="mstwaHasad.php?mstwa=المهرة">المهرة</option>
                <option value="mstwaHasad.php?mstwa=الفرقان">الفرقان</option>
                <option value="mstwaHasad.php?mstwa=الأترجة">الأترجة</option>
                <option value="mstwaHasad.php?mstwa=السراج">السراج</option>
            </select>
        </form>

        <p style="margin-top:25px !important; margin-bottom:0">فرز الحصاد بواسطة التاريخ</p>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="farzhasad" style="display:flex; justify-content:flex-end">
                <div class="flexcol">
                    <label for="todate">الى</label>
                    <input type="date" name="todate" id="todate">
                </div>

                <div class="flexcol">
                    <label for="fromdate">من</label>
                    <input type="date" name="fromdate" id="fromdate">
                </div>
            </div>

            <input name ="submit" type="submit" value="ابحث"class="filtersearch" style="margin-bottom:10px">
        </form>

        <div style="display:flex; justify-content:flex-end; margin-bottom: 10px; margin-top:20px">
            <a  href ="../attendees.php" class="addtasme3"> تسجيل الحضور <i class="fas fa-tasks"></i></a> 
            <a  href ="../addtasme3.php" class="addtasme3"> اضف تسميع <i class="fas fa-plus"></i></a> 
        </div>

        
        
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>حذف</th>
                    <!-- <th>عجز المراجعة</th> -->
                    <th>عدد الصفحات</th>
                    <th>المراجعة</th>
                    <!-- <th>عجز الحفظ</th> -->
                    <th>عدد الصفحات</th>
                    <th>الحفظ</th>
                    <!-- <th>عجز القراءة</th> -->
                    <th>الدرجة</th>
                    <th>القراءة</th>
                    <th>التاريخ</th>
                    <th>الإسم</th>
                    <th>المستوى</th>
                    <?php
                        if($than){
                            echo '<th>الحلقة</th>';
                        }
                    ?>
                </tr>
                <?php

                $mlate =0;
                $hlate =0;
                $rlate =0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $username = $row['username'];
                    // Ajz logic
                    $userStmt = $con->prepare("SELECT halqah, mstwa,hifz,muraja FROM users WHERE username = '$username'");
                    $userStmt->execute();
                    $userRow = $userStmt->fetch();
                    $mamount = $userRow['muraja'];
                    $hamount = $userRow['hifz'];
                    $halqah = $userRow['halqah'];
                    $mstwa = $userRow['mstwa'];

                    echo 
                        '<tr>
                            
                        <td class="edit"><a href="../deletewird.php?wirdid='.$row['wird_id'] .'"class="fas fa-minus-square" style="color:#ff5151; font-size:20px"></a></td>';
                            // muraja
                            // if ($row['muraja'] >$mamount['muraja']){
                            //     echo '<td>' . $mlate =0 . '</td>';
                            //     echo "<td class = 'good'>" . $row['muraja'] ."</td>";
                            // }
                            // elseif ($row['muraja'] < $mamount['muraja']){
                            //     $mlate = (int)$row['muraja'] - (int)$mamount['muraja'];
                            //     echo '<td class="bad">' . $mlate . '</td>';
                            //     echo "<td class = 'bad' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                               
                            // }
                            // else{
                            //     echo '<td>' . $mlate=0 . '</td>';
                            // }
                            echo "<td class = 'hifz' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                            echo '<td>' . $row['murajatasmee3'] . '</td>';
                            // hifz
                            
                            // if ( $row['hifz'] > $hamount['hifz']){
                            //     echo '<td>' . $hlate=0 . '</td>';
                            //     echo "<td class = 'good'>" . $row['hifz'] ."</td>";
                              
                            // }
                            // elseif ($row['hifz'] < $hamount['hifz']){
                            //     $hlate = (int)$row['hifz'] - (int)$hamount['hifz'];
                            //     echo '<td class="bad">' . $hlate . '</td>';
                            //     echo "<td class = 'bad' style ='clear:left'>" . $row['hifz'] ."</td>"; 
                            // }
                            // else{
                            //     echo '<td>' . $hlate=0 . '</td>';
                            //     echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                            // }
                            
                            echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                            echo '<td>' . $row['hifztasmee3'] . '</td>';

                            // reading

                            // if ( $row['reading'] > 5){
                            //     echo '<td>' . $rlate=0 . '</td>';
                            //     echo "<td class = 'good'>" . $row['reading_grade'] ."</td>";
                              
                            // }
                            // elseif ($row['reading'] < 5){
                            //     $rlate = 5- (int)$row['reading'];
                            //     echo '<td class="bad">' . $rlate . '</td>';
                            //     echo "<td class = 'bad' style ='clear:left'>" . $row['reading_grade'] ."</td>"; 
                            // }
                            // else{
                            //     echo '<td>' . $rlate=0 . '</td>';
                            //     echo "<td>" . $row['reading_grade'] ."</td>"; 
                            // }
                            echo "<td>" . $row['reading_grade'] ."</td>"; 

                            echo '<td>' . $row['reading'] . '</td>';
                            
                            echo '<td>' . $row['date'] . '</td>' .


                            '<td>'. $row['firstname'] . ' ' . $row['lastname'] .'</td>
                            <td>' . $userRow['mstwa'] . '</td>';
                           if($than){
                               echo '<td>' . $userRow['halqah'] . '</td>';
                           } 

                        echo '</tr>';
                }

                ?>
            </table>
        </div>
      
    </div>

</body>
</html>