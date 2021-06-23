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
                "SELECT users.firstname,users.lastname, sum(wird_two.hifz), sum(wird_two.muraja), sum(wird_two.reading_grade), sum(wird_two.reading) FROM wird_two left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa'
                GROUP BY firstname
            ");
            $stmt->execute();
        }
        else{
            $stmt = $con->prepare(
                "SELECT users.firstname,users.lastname, sum(wird_two.hifz), sum(wird_two.muraja), sum(wird_two.reading_grade), sum(wird_two.reading)
                FROM wird_two
                left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa' AND halqah != 'hofaz' OR 'jam'
                GROUP BY firstname");
            $stmt->execute();
        }   
    }
    if (isset($_POST['filter'])){
        $filter= $_POST['selectfilter'];
        header('Location:' . $filter);
        exit();
    }

    if(isset($_POST['farzDate'])){
        $from= $_POST['fromdate'];
        $to =$_POST['todate'];
        if ($than){
            $stmt = $con->prepare(
                "SELECT users.firstname,users.lastname, sum(wird_two.hifz), sum(wird_two.muraja), sum(wird_two.reading_grade), sum(wird_two.reading) FROM wird_two left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa' AND DATE(wird_two.date) BETWEEN '$from' AND '$to'
                GROUP BY firstname
            ");
            $stmt->execute();
        }
        else{
            $stmt = $con->prepare(
                "SELECT users.firstname,users.lastname, sum(wird_two.hifz), sum(wird_two.muraja), sum(wird_two.reading_grade), sum(wird_two.reading)
                FROM wird_two
                left join users on users.userid = wird_two.user_id
                WHERE users.mstwa = '$mstwa' AND DATE(wird_two.date) BETWEEN '$from' AND '$to' AND halqah != 'hofaz' OR 'jam'
                GROUP BY firstname");
            $stmt->execute();
        }   
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

        
        <p style="margin-top:25px !important; margin-bottom:0">فرز الحصاد بواسطة التاريخ</p>
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

            <input name ="farzDate" type="submit" value="ابحث" class="filtersearch" style="margin-bottom:10px">
        </form>

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

        
        <p style="margin-top:20px">مجموع حصاد مستوى <?php echo $mstwa; ?></p>
        <div style="display:flex; justify-content:flex-end; margin-bottom: 10px; margin-top:20px">
            <a  href ="./mstwaDaily.php?mstwa=<?php echo $mstwa?>" class="addtasme3">الحصاد اليومي<i class="fas fa-tasks"></i></a> 
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
                $rgsum = 0;
                $rsum = 0;
                $hsum = 0;
                $msum = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    echo
                        '<tr>
                        <td>' .  $row['sum(wird_two.reading_grade)'] . '</td>' .
                        '<td>' .  $row['sum(wird_two.reading)'] . '</td>' .
                        '<td>' .  $row['sum(wird_two.muraja)'] . '</td>' .
                        '<td>' .  $row['sum(wird_two.hifz)'] . '</td>' .
                        '<td>'. $row['firstname'] . ' ' . $row['lastname'] .'</td>' .
                            '
                        </tr>';

                        $hsum += $row['sum(wird_two.hifz)'];
                        $msum += $row['sum(wird_two.muraja)'];
                        $rsum += $row['sum(wird_two.reading)'];
                        $rgsum += $row['sum(wird_two.reading_grade)'];

                }
                ?>
                <tr >
                    <td class= "good"> <?php echo $rgsum; ?></td>
                    <td class= "good"> <?php echo $rsum; ?></td>
                    <td class= "good"> <?php echo $msum; ?></td>
                    <td class= "good"> <?php echo $hsum; ?></td>
                    <td class="good">المجموع</td>
                </tr>
            </table>

        </div>

    </div>
</body>
</html>