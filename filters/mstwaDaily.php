<?php 
include '../connect.php';
session_start();


    if(isset($_SESSION['username'])){
        if(isset($_GET['mstwa'])){
        $mstwa= $_GET['mstwa'];
        $username = $_SESSION['username'];
        $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $than = $row['halqah'] == 'than';
        $halqah = $row['halqah'];
    
        if ($than){
            $stmt = $con->prepare(
                "SELECT users.firstname, users.lastname ,
                wird_two.hifz, wird_two.muraja, wird_two.reading_grade ,wird_two.reading
                 FROM wird_two left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa'
                order by date desc

            ");
            $stmt->execute();
        }
        else{
            $stmt = $con->prepare(
                "SELECT users.firstname,users.lastname,wird_two.hifz ,wird_two.muraja ,wird_two.reading_grade ,wird_two.reading 
                FROM wird_two
                left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa' AND halqah != 'hofaz' OR 'jam'
                order by date desc

                ");
            $stmt->execute();
        }   
    }
    if (isset($_POST['filter'])){
        $filter= $_POST['selectfilter'];
        header('Location:' . $filter);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">

</head>




<body>
    <div class="container">
        <!--  الهيدر  -->
        <header>
            <div class="welcome">
                <h3>مرحبا</h3>
                <a href="../logout.php"><p style ="font-size:12px;">تسجيل الخروج</p></a>
            </div>
            <div class="imgcontainer">
                <img src="../images/logo1.png" alt="logo">
            </div>
            <div class="clear"></div>
        </header>

        <div class="clear"></div>

        
        <!-- <p style="margin-top:25px !important; margin-bottom:0">فرز الحصاد بواسطة التاريخ</p>
        <form action="<?php // echo $_SERVER['PHP_SELF']?>" method="POST">
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

            <input name ="submit" type="submit" value="ابحث" class="filtersearch" style="margin-bottom:10px">
        </form> -->

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

        
        <p style="margin-top:20px"> حصاد مستوى <?php echo $mstwa; ?></p>
        <div style="display:flex; justify-content:flex-end; margin-bottom: 10px; margin-top:20px">
            <a  href ="./mstwaHasad.php?mstwa=<?php echo $mstwa?>" class="addtasme3">مجموع الحصاد<i class="fas fa-tasks"></i></a> 
        </div>
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>درجة القراءة</th>
                    <th>القراءة</th>
                    <th>المراجعة</th>
                    <th>الحفظ</th>
                    <th>الإسم</th>
                </tr>

                <?php

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo
                        '<tr>
                        <td>' .  $row['reading_grade'] . '</td>' .
                        '<td>' .  $row['reading'] . '</td>' .
                        '<td>' .  $row['muraja'] . '</td>' .
                        '<td>' .  $row['hifz'] . '</td>' .
                        '<td>'. $row['firstname'] . ' ' . $row['lastname'] .'</td>' .
                            '
                        </tr>';


                }
                ?>
            </table>

        </div>

    </div>
</body>
</html>