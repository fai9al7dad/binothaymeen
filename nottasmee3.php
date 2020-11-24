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
            if(isset($_POST['notasmee3'])){
                foreach ($_POST['notasmee3'] as $userid){
                    $stmt = $con->prepare("SELECT * FROM users where userid = '$userid'");
                    $stmt->execute();
                    $row=$stmt->fetch();
                    $firstname = $row['firstname'];
                    $lastname =$row['lastname'];
                    $halqah =$row['halqah'];
                    $username = $row['username'];
                    $date = $_POST['date'];
    
    
                    $insertstmt = $con->prepare(
                        " INSERT INTO wird(firstname,lastname,username,halqah,hifz,muraja,date,hifztasmee3,murajatasmee3) VALUES (?,?,?,?,?,?,?,?,?)
                        ");
                        $result = $insertstmt->execute([$firstname,$lastname,$username,$halqah,0, 0,$date,"لم يسمع","لم يسمع"]);
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
        echo'you are not registerd';
        header('Location: index.php');
    }

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

</head>


<body>
    <  <div class="container">

<p style="text-align:center">تسجيل الغير مسمعين</p>
    <!-- الطلاب -->
    <div style="text-align:right; margin:10px">
        <a href="filters/daily.php" class="editstudent">الصفحة الرئيسية</a>
    </div>


    <div style="overflow-x:auto;">
    <form action=<?php echo $_SERVER['PHP_SELF']?> method="post">

            <div class="farzhasad" style="display:flex; justify-content:flex-end">
                <div style="display:flex; flex-direction:column">
                    <label for="date">التاريخ</label>
                    <input type="date" name="date" id="date">
                </div>
            </div>

        <table>
            <tr>
                <th>لم يسمع</th>
                <th>الاسم الاخير</th>
                <th>الاسم الاول</th>
            </tr>
            <?php
                foreach($students as $student){
                    echo '<tr>';
                    echo '<td> <input type="checkbox" name="notasmee3[]" value="' . $student['userid'] . '"></td>';
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