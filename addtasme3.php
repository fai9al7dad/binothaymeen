<?php 
include 'connect.php';
session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $stmt = $con->prepare("SELECT * FROM users where username = '$username'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $halqah = $row['halqah'];
    $than = $row['halqah'] == 'than';

    if($than){
        $stmt = $con->prepare("SELECT * FROM users WHERE groupID = '0' AND halqah != 'hofaz' OR 'jam'");
        $stmt->execute();
        $students = $stmt->fetchAll();
    }else{
        $stmt = $con->prepare("SELECT * FROM users WHERE halqah = '$halqah' AND groupID = '0'");
        $stmt->execute();
        $students = $stmt->fetchAll();
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $sname = htmlspecialchars($_POST['studentname']);
        $hifzt = htmlspecialchars($_POST['hifztasme3']);
        $hifza = htmlspecialchars($_POST['hifzamount']);
        $murajat =htmlspecialchars($_POST['murajatasme3']);
        $murajaa = htmlspecialchars($_POST['murajaamount']);
        $date = $_POST['year'] .'-'. $_POST['month'] .'-'. $_POST['day'];
        $reading =  htmlspecialchars($_POST['reading']);;
        $reading_grade = (int)$reading * 2;
        $didnttasmee3 = $_POST['didnttasmee3'];
        
        $selectstmt = $con->prepare('SELECT userid FROM users where username = ?');
        $selectstmt->execute([$sname]);
        $row= $selectstmt->fetch();
        $user_id = $row['userid'];

        if(!$hifzt){
            $mtasmee3 = 'لا يوجد';
        }
        if(!$hifza){
            $htasmee3 = 0;
        }
        if(!$murajat){
            $murajat = 'لا يوجد';
        }
        if(!$murajaa){
            $murajaa = 0;
        }
        if(!$date){
            $date = 'now()';
        }
        if(!$reading){
            $reading = 'لم يقرأ';
        }
        if(!$reading_grade){
            $reading_grade = 0;
        }
        if (isset($didnttasmee3)){
            $insertstmt = $con->prepare("INSERT INTO wird_two(user_id,hifz,muraja,date,hifztasmee3,murajatasmee3,reading,reading_grade) VALUES (?,?,?,?,?,?,?,?)");
            $result = $insertstmt->execute([$user_id,0, 0,$date,"لا يوجد ","لا يوجد ","لم يقرأ",0]);
        }
        else{
            $insertstmt = $con->prepare("INSERT INTO wird_two(user_id, hifz, muraja, date, hifztasmee3, murajatasmee3, reading, reading_grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $result = $insertstmt->execute([$user_id,$hifza, $murajaa,$date,$hifzt,$murajat,$reading,$reading_grade]);
    
        }
      
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
        <p style="text-align:center">اضافة التسميع</p>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="formedit" method="POST">

        <div class="imgcontainer" style="float:none">
            <img src="images/logo1.png" alt="logo">
        </div>
        
        <a  href ="nottasmee3.php" class="addtasme3"> تسجيل الغير مسمعين <i class="fas fa-plus"></i></a> 

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
                    <option value="2021">2021</option>
                </select>
            </div>
        </div>
        
        <div class="didnttasmee3">
            <label for="didnttasmee3">لم يسمع</label>
            <input name ="didnttasmee3" type="checkbox" value="didnttasme3" id ="didnttasmee3">   
        </div>
             

        <p  style="margin-top: 30px; font-weight:bold" >الحفظ</p>
        <div class="edit">
            <label for="hifzinput">تسميع الحفظ</label>
            <input type="text" name="hifztasme3" class="hifzinput" id="hifzinput" autocomplete ="off">
        </div>

        <div class="edit">
            <label for="hifzinput">عدد الصفحات</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="hifzamount" class="hifzinput" id="hifzinput" autocomplete ="off" step="0.01" min=0>
        </div>

        <p style="margin-top: 30px;font-weight:bold">المراجعة</p>
        <div class="edit">
            <label for="hifzinput">تسميع المراجعة </label>
            <input type="text" name="murajatasme3" class="hifzinput" id="hifzinput" autocomplete ="off">
        </div>

        <div class="edit">
            <label for="hifzinput">عدد الصفحات</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="murajaamount" class="hifzinput" id="hifzinput" autocomplete ="off" step="0.01" min=0>
        </div>

        <p style="margin-top: 30px;font-weight:bold">القراءة</p>

        <div class="edit">
            <label for="readinginput">عدد صفحات القراءة</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="reading" class="readinginput" id="readinginput" autocomplete ="off" step="0.01" min=0>
        </div>

        <div class="submitbutton">
            <input name ="submit" type="submit" value="اضف" class="mainbutton">
        </div>
        <input type="hidden" name ="userid" value = "<?php echo $row['userid']?>">
    
    </form>

    </div>
</body>
</html>
        
    

<script> 
    function onlyNumberKey(evt) { 
          
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
</script>