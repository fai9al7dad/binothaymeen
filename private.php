<?php
include 'connect.php';

$stmt = $con->prepare("select * from users");
$stmt->execute();
$row = $stmt->fetchAll();


?>

<html>
    <head>
    <link rel="stylesheet" href="css/dashboard.css">

    </head>
    <div class="container">


    <table>
        <th>الحلقة</th>
        <th>الاسم المسخدم</th>
        <th>الاسم الاخير</th>
        <th>الاسم الاول</th>
        <?php
            foreach ($row as $rows){
                echo '<tr>';
                echo  '<td>' . $rows['halqah'] . '</td>';
                echo  '<td>' . $rows['username'] . '</td>';
                echo  '<td>' . $rows['lastname'] . '</td>';
                echo  '<td>' . $rows['firstname'] . '</td>';
            }
        ?>

    </table>
    </div>

</html>

