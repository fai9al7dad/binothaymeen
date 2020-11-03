<?php 
include 'connect.php';
session_start();

if(isset($_GET['userid'])){
    $id= $_GET['userid'];
    $stmt = $con->prepare("SELECT * FROM  users where userid = '$id'");
    $stmt->execute();
    $row = $stmt->fetch();
    $username = $row['username'];
    
    $stmt = $con->prepare("SELECT * FROM wird WHERE username = '$username' order by date desc");
    $stmt->execute();


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
                </tr>
                <?php

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
                            if ($row['muraja'] >$mamount['muraja']){
                                echo '<td>' . $mlate =0 . '</td>';
                                echo "<td class = 'good'>" . $row['muraja'] ."</td>";
                            }
                            elseif ($row['muraja'] < $mamount['muraja']){
                                $mlate = (int)$row['muraja'] - (int)$mamount['muraja'];
                                echo '<td class="bad">' . $mlate . '</td>';
                                echo "<td class = 'bad' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                                $murajaajz += $mlate;
                            }
                            else{
                                echo '<td>' . $mlate=0 . '</td>';
                                echo "<td class = 'hifz' style ='clear:left'>" . $row['muraja'] ."</td>"; 
                            }
                            echo '<td>' . $row['murajatasmee3'] . '</td>';
                            $murajasum += $row['muraja'];
                            // hifz
                            
                            if ( $row['hifz'] > $hamount['hifz']){
                                echo '<td>' . $hlate=0 . '</td>';
                                echo "<td class = 'good'>" . $row['hifz'] ."</td>";
                              
                            }
                            elseif ($row['hifz'] < $hamount['hifz']){
                                $hlate = (int)$row['hifz'] - (int)$hamount['hifz'];
                                echo '<td class="bad">' . $hlate . '</td>';
                                echo "<td class = 'bad' style ='clear:left'>" . $row['hifz'] ."</td>"; 
                                $hifzajz +=$hlate;
                                
                            }
                            else{
                                echo '<td>' . $hlate=0 . '</td>';
                                echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                            }
            
                            $hifzsum += $row['hifz'];

                            echo '<td>' . $row['hifztasmee3'] . '</td>';

                            echo '<td>' . $row['date'] . '</td>' .

                        '</tr>';
                        $date +=1;
                }
                ?>
                <tr>
                    <td colspan ="7" style="font-weight:bold; background-color:#252a48;font-size:18px">
                    مجموع الحصاد
                    </td>
                </tr>
                <tr>
                    <td class="bad"><?php echo $murajaajz ?></td>
                    <td><?php echo $murajasum ?></td>
                    <td>-</td>
                    <td class="bad"><?php echo $hifzajz ?></td>
                    <td><?php echo $hifzsum ?></td>
                    <td>-</td>
                    <td><?php echo  ' ايام ' . $date?></td>
                </tr>
            </table>
        </div>
      


    </div>
</body>
</html>
        