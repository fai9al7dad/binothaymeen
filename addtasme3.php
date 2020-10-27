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


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $sname = $_POST['studentname'];
        $hifzt = $_POST['hifztasme3'];
        $hifza = $_POST['hifzamount'];
        $murajat =$_POST['murajatasme3'];
        $murajaa =$_POST['murajaamount'];
        $date = $_POST['year'] .'-'. $_POST['month'] .'-'. $_POST['day'];
        
        $selectstmt = $con->prepare('SELECT * FROM users where username = ?');
        $selectstmt->execute([$sname]);
        $row= $selectstmt->fetch();
        $firstname = $row['firstname'];
        $lastname =$row['lastname'];
        $halqah =$row['halqah'];

        $insertstmt = $con->prepare("INSERT INTO wird(firstname,lastname,username,halqah,hifz,muraja,date,hifztasmee3,murajatasmee3) VALUES (?,?,?,?,?,?,DATE ?,?,?)");
        $result = $insertstmt->execute([$firstname,$lastname,$sname,$halqah,$hifza, $murajaa,$date,$hifzt,$murajat]);

        echo '<p style="text-align:center">تم التسجيل بنجاح<a class ="editstudent" href="filters/daily.php"> اذهب الى صفحة التسجيل </a></p>';

        
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

</head>


<body>
    <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="formedit" method="POST">

        <div class="imgcontainer" style="float:none">
            <img src="images/logo1.png" alt="logo">
        </div>

        <div class="edit">
            <label for="studentname"> اسم الطالب</label>
            <select name="studentname" id="studentname">
                <?php
                    foreach ($students as $student){
                        echo '<option value="'.$student['username'] .'">' . $student['firstname'] . ' '. $student['lastname'] . '</option>'; 
                    }
                                 
                ?>
            </select>
            
        </div>
        
        <p style="margin-top: 30px; font-weight:bold">التاريخ</p>
        <small><?php echo ' تاريخ اليوم ' . date("Y-m-d")?></small>
        <div class="edit" style="display:flex; flex-direction:row; justify-content:flex-end">
            <div style="display:flex; flex-direction:column;">
                <label for="day">اليوم</label>
                <select name="day" id ="day">
                        <?php
                            for ($i >=3; $i<=31; $i++){
                                echo '<option value="'.$i.'">'. $i. '</option>';
                            }
                        ?>
                </select>
            </div>

            <div style="display:flex; flex-direction:column;">
                <label for="month">الشهر</label>
                <select name="month" id ="month">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>

            <div style="display:flex; flex-direction:column;">
                <label for="year">السنة</label>
                <select name="year" id ="year">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>

        </div>

        <p  style="margin-top: 30px; font-weight:bold" >الحفظ</p>
        <div class="edit">
            <label for="hifzinput">تسميع الحفظ</label>
            <input type="text" name="hifztasme3" class="hifzinput" id="hifzinput" autocomplete ="off">
        </div>

        <div class="edit">
            <label for="hifzinput">عدد الصفحات</label>
            <input type="number" name="hifzamount" class="hifzinput" id="hifzinput" autocomplete ="off" step="0.01" min=0>
        </div>

        <p style="margin-top: 30px;font-weight:bold">المراجعة</p>
        <div class="edit">
            <label for="hifzinput">تسميع المراجعة </label>
            <input type="text" name="murajatasme3" class="hifzinput" id="hifzinput" autocomplete ="off">
        </div>

        <div class="edit">
            <label for="hifzinput">عدد الصفحات</label>
            <input type="number" name="murajaamount" class="hifzinput" id="hifzinput" autocomplete ="off" step="0.01" min=0>
        </div>

      

        
        <div class="submitbutton">
            <input name ="submit" type="submit" value="اضف" class="mainbutton">
        </div>
        <input type="hidden" name ="userid" value = "<?php echo $row['userid']?>">
    
    </form>

    </div>
</body>
</html>
        
    
