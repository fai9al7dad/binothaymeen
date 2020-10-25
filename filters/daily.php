<?php 
include '../connect.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];

    $stmt = $con->prepare("SELECT username,firstname,lastname,hifz,muraja,date,hifztasmee3,murajatasmee3 FROM wird WHERE halqah = '$halqah' order by wirdid desc");
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

        <p style ="text-align:right; margin-top:57px; font-size:30px">احصائيات <a class="editstudent" href="../students.php"> الطلاب</a></p>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- <div class="studentsearch">
                <label for="search">ابحث عن طالب</label>
                <div class="clear"></div>
                <input id="search" type="text" autocomplete = "off">
            </div> -->
            <input class="filtersearch" type="submit" value="ابحث" name="filter">
            <select name="selectfilter" id="filter">
                <option value="daily">التسجيل اليومي</option>
                <option value="highesthifz">الاعلى حفظا</option>
                <option value="highestmuraja">الاعلى مراجعة</option>
                <option value="lowesthifz">الاقل حفظا</option>
                <option value="lowestmuraja">الاقل مراجعة</option>
            </select>
            

        </form>
        <p>الترتيب بواسطة اخر التسجيلات </p>

        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>عجز المراجعة</th>
                    <th>عدد الصفحات</th>
                    <th>المراجعة</th>
                    <th>عجز الحفظ</th>
                    <th>عدد الصفحات</th>
                    <th>الحفظ</th>
                    <th>التاريخ</th>
                    <th>الإسم</th>
                </tr>
                <?php

                $mlate =0;
                $hlate =0;
                $table='';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $username = $row['username'];
                    // Ajz logic
                    $murajacheck = $con->prepare("SELECT muraja FROM users WHERE username = '$username'");
                    $murajacheck->execute();
                    $mamount = $murajacheck->fetch();

                    $hifzcheck = $con->prepare("SELECT hifz FROM users WHERE username = '$username'");
                    $hifzcheck->execute();
                    $hamount = $hifzcheck->fetch();
                    echo 
                        '<tr>';
                            if ($row['muraja'] >$mamount['muraja']){
                                echo '<td>' . $mlate =0 . '</td>';
                                echo "<td class = 'good'>" . $row['muraja'] ."</td>";
                            }
                            elseif ($row['muraja'] < $mamount['muraja']){
                                $mlate = (int)$row['muraja'] - (int)$mamount['muraja'];
                                echo '<td class="bad">' . $mlate . '</td>';
                                echo "<td class = 'bad' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                               
                            }
                            else{
                                echo '<td>' . $mlate=0 . '</td>';
                                echo "<td class = 'hifz' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                            }
                            echo '<td>' . $row['murajatasmee3'] . '</td>';
                            // hifz
                            
                            if ( $row['hifz'] > $hamount['hifz']){
                                echo '<td>' . $hlate=0 . '</td>';
                                echo "<td class = 'good'>" . $row['hifz'] ."</td>";
                              
                            }
                            elseif ($row['hifz'] < $hamount['hifz']){
                                $hlate = (int)$row['hifz'] - (int)$hamount['hifz'];
                                echo '<td class="bad">' . $hlate . '</td>';
                                echo "<td class = 'bad' style ='clear:left'>" . $row['hifz'] ."</td>"; 
                             

                            }
                            else{
                                echo '<td>' . $hlate=0 . '</td>';
                                echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                            }
                            echo '<td>' . $row['hifztasmee3'] . '</td>';
                            echo '<td>' . $row['date'] . '</td>' .
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