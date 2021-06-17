<?php 
include 'connect.php';
session_start();

if(isset($_GET['userid'])){
    $id= $_GET['userid'];
    $stmt = $con->prepare("SELECT * FROM  users where userid = '$id'");
    $stmt->execute();
    $row = $stmt->fetch();
    
    $stmt = $con->prepare("SELECT * FROM wird_two WHERE user_id = '$id' order by date desc");
    $stmt->execute();

    if(isset($_GET['submit'])){
        $from= $_GET['fromdate'];
        $to =$_GET['todate'];
        $stmt = $con->prepare("SELECT * FROM wird_two WHERE user_id = '$id' and date between '$from' and '$to' order by date desc");
        $stmt->execute();
    }
    
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
        <div class="imgcontainer" style="float:none">
            <img src="images/logo1.png" alt="logo" style="width:190px;height:170px">
        </div>
        <p> حصاد الطالب <?php echo $row['firstname'] . ' ' . $row['lastname']?></p>

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
            <div class="farzhasad" style="display:flex;flex-direcation:column; justify-content:flex-end">
                <div class="flexcol">
                    <label for="todate">الى</label>
                    <input type="date" name="todate" id="todate">
                </div>

                <div class="flexcol">
                    <label for="fromdate">من</label>
                    <input type="date" name="fromdate" id="fromdate">
                </div>
                <input type="hidden" name="userid" value = "<?php echo $id?>" >
            </div>
            <input name ="submit" type="submit" value="ابحث"class="filtersearch" style="margin-bottom:10px">

        </form>
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>درجة القراءة</th>
                    <th>القراءة</th>
                    <th>عدد الصفحات</th>
                    <th>المراجعة</th>
                    <th>عدد الصفحات</th>
                    <th>الحفظ</th>
                    <th>التاريخ</th>
                </tr>
                <?php
                $rgsum = 0;
                $rsum = 0;
                $mlate =0;
                $hlate =0;
                $date =0;
                $hifzsum =0;
                $hifzajz =0;
                $murajasum =0;
                $murajaajz =0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    // Ajz logic
                    $murajacheck = $con->prepare("SELECT muraja FROM users WHERE userid = '$id'");
                    $murajacheck->execute();
                    $mamount = $murajacheck->fetch();

                    $hifzcheck = $con->prepare("SELECT hifz FROM users WHERE userid = '$id'");
                    $hifzcheck->execute();
                    $hamount = $hifzcheck->fetch();

                    echo 
                        '<tr>'; 
                            echo "<td>" . $row['reading_grade'] ."</td>";
                            $rgsum += $row['reading_grade'];

                            echo "<td>" . $row['reading'] ."</td>";
                            $rsum += $row['reading'];

                            
                            echo "<td>" . $row['muraja'] ."</td>";
                            $murajasum += $row['muraja'];
                            echo '<td>' . $row['murajatasmee3'] . '</td>';
                            // hifz
                            
                            echo "<td>" . $row['hifz'] ."</td>";
                            $hifzsum += $row['hifz'];
                            echo '<td>' . $row['hifztasmee3'] . '</td>';
        
                            echo '<td>' . $row['date'] . '</td>' .

                        '</tr>';
                        $date +=1;
                }
                ?>
                <tr>
                    <td colspan ="9" style="font-weight:bold; background-color:#252a48;font-size:18px">
                    مجموع الحصاد
                    </td>
                </tr>
                <tr>
                
                    <td><?php echo $rgsum ?></td>
                    <td><?php echo $rsum ?></td>
                    <td><?php echo $murajasum ?></td>
                    <td>-</td>
                    <td><?php echo $hifzsum ?></td>
                    <td>-</td>
                    <td><?php echo  ' ايام ' . $date?></td>
                </tr>
            </table>
        </div>
      


    </div>
</body>
</html>
        