<?php
include '../connect.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];

    $stmt = $con->prepare("SELECT users.firstname,users.lastname, sum(wird_two.hifz) FROM wird_two left join users on users.userid = wird_two.user_id  WHERE halqah = '$halqah' GROUP BY firstname ORDER BY sum(wird_two.hifz) asc");
    $stmt->execute();
    if (isset($_POST['filter'])){
        $filter= $_POST['selectfilter'];
        header('Location:' . $filter. '.php');
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
    <link rel="icon" href="images/logo1.png" type="image/png">

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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input class="filtersearch" type="submit" value="ابحث" name="filter">
            <select name="selectfilter" id="filter">
                <option value=""></option>
                <option value="daily">التسجيل اليومي</option>
                <option value="highesthifz">الاعلى حفظا</option>
                <option value="highestmuraja">الاعلى مراجعة</option>
                <option value="lowesthifz">الاقل حفظا</option>
                <option value="lowestmuraja">الاقل مراجعة</option>
            </select>
            




        </form>
        <p>الترتيب بواسطة الأقل حفظا</p>
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>الحفظ</th>
                    <th>الإسم</th>
                </tr>

                <?php
                $sum = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    echo
                        '<tr>
                            <td>' .  $row['sum(wird_two.hifz)'] . '</td>' .
                            '<td>'. $row['firstname'] . ' ' . $row['lastname'] .'</td>' .
                            '
                        </tr>';

                        $sum += $row['sum(wird_two.hifz)'];

                }
                ?>
                <tr >
                    <td class= "good"> <?php echo $sum; ?></td>
                    <td class="good">المجموع</td>
                </tr>
            </table>

        </div>

    </div>
</body>
</html>