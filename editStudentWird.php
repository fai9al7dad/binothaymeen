<?php 
include 'connect.php';
session_start();

if(isset($_GET['wirdid'])){
    $id= $_GET['wirdid'];
    $stmt = $con->prepare("SELECT * FROM wird_two where wird_id = '$id'");
    $stmt->execute();
    $row = $stmt->fetch();
}
if(isset($_POST['submit'])){
    $hifz = htmlspecialchars($_POST['hifz']);
    $muraja = htmlspecialchars($_POST['muraja']);
    $reading = htmlspecialchars($_POST['reading']);
    $readingGrade = $reading * 2;
    $date = $_POST['year'] .'-'. $_POST['month'] .'-'. $_POST['day'];

    $update = $con->prepare("UPDATE wird_two SET hifz=?, muraja =?, reading = ?, reading_grade = ?, date = ? WHERE wird_id = ?");
    $update->execute([$hifz,$muraja,$reading,$readingGrade, $date, $id]);
    header('Location: dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
    <link rel="stylesheet" href="css/studentDashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">

</head>
    



<body>
    <div class="container">
    <form aaction="<?php $_SERVER['PHP_SELF'] ?>" class="formedit" method="POST">

    <p>تعديل التاريخ</p>
    <div class="edit" style="display:flex; flex-direction:row; ">
            <div style="display:flex; flex-direction:column;width: 100%;">
                <label for="day">اليوم</label>
                <select name="day" id ="day" value=2>
                     <option value ="<?php echo substr($row['date'],8); ?>" selected="selected"><?php echo substr($row['date'],8); ?></option>
                        <?php
                            for ($i >=3; $i<=31; $i++){
                                echo '<option value="'.$i.'">'. $i. '</option>';
                            }
                        ?>
                </select>
            </div>

            <div style="display:flex; flex-direction:column; width: 100%; margin-left: 10px">
                <label for="month">الشهر</label>
                <select name="month" id ="month">
                    <option value ="<?php echo substr($row['date'],5,2); ?>" selected="selected"><?php echo substr($row['date'],5,2); ?></option>

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

            <div style="display:flex; flex-direction:column; width: 100%; margin-left: 10px">
                <label for="year">السنة</label>
                <select name="year" id ="year">
                    <option value="2021">2021</option>
                </select>
            </div>
        </div>

        <p>تعديل الحفظ</p>
        <div class="edit" style="display:flex; flex-direction:column; width: 100%;">
            <label for="hifzinput">ورد الحفظ</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="hifz" class="hifzinput" style="text-align:right" id="hifzinput" autocomplete = "off" value ="<?php echo $row['hifz']?>" step='0.5' min ='0' >
        </div>

        <p>تعديل المراجعة</p>
        <div class="edit" style="display:flex; flex-direction:column; width: 100%;" >
            <label for="murajainput">ورد المراجعة</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="muraja" class="murajainput" style="text-align:right" id="murajainput" autocomplete ="off" value = "<?php echo $row['muraja']?>" step='0.5' min ='0'>
        </div>

        <p>تعديل ورد القراءة</p>
        <div class="edit" style="display:flex; flex-direction:column; width: 100%; ">
            <label for="readinginput">ورد القراءة</label>
            <input onkeypress="return onlyNumberKey(event)" type="number" name="reading" class="readinginput" style="text-align:right" id="readinginput" autocomplete ="off" value = "<?php echo $row['reading']?>" step='1' min ='0'>
        </div>
        
        <div class="submitbutton">
            <input name ="submit" type="submit" value="تعديل" class="mainbutton">
        </div>
    
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