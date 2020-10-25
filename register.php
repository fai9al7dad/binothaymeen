<?php 
include 'connect.php';
    
    if (isset($_POST['create'])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $uname = $_POST["uname"];
        $halqah = $_POST["halqah"];
        $hifz = $_POST["hifz"];
        $murajaa = $_POST["murajaa"];
        $pass = $_POST["pass"];
        $hashpass = sha1($pass);

        $stmt = $con->prepare("INSERT INTO users (firstname,lastname,username,halqah,hifz,muraja,password) VALUES (?,?,?,?,?,?,?)");
        $result = $stmt->execute(array($fname,$lname,$uname,$halqah,$hifz,$murajaa,$hashpass));

        if($result){
            header('Location:index.php');
        }
        else{
            header('Location:register.php');
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="icon" href="images/logo1.png" type="image/png">

</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class = "register" method ="POST">

        <div class="container">

            <div class="imgcontainer">
                <img src="images/logo1.png" alt="logo">
            </div>

            <div class="textup">
                <h1>أنشئ حساب</h1>
            </div>
            <div class="fname">
                <label for="fnameinput">الإسم الأول</label>
                <input type="text" name="fname" class="fnameinput" id="fnameinput" autocomplete = "off" required>
            </div>

            <div class="lname">
                <label for="lnameinput">الإسم الأخير</label>
                <input type="text" name="lname" class="lnameinput" id="lnameinput" autocomplete = "off">
            </div>

            <div class="uname">
                <label for="unameinput">اسم المستخدم</label>
                <input type="text" name="uname" class="unameinput" id="unameinput" autocomplete = "off" required>
            </div>
            
            <div class="halqah">
                <label for="halqahinput">الحلقة</label>
                <select name="halqah" id="halqahinput" required>
                    <option value="oula">حلقة أولى ثانوي</option>
                    <option value="thanea">حلقة ثاني ثانوي</option>
                    <option value="thaltha">حلقة ثالث ثانوي</option>
                </select>
            </div>

            <div class="hifz">
                <label for="hifzinput">ورد الحفظ اليومي</label>
                <input type="number" name="hifz" class="hifzinput" id="hifzinput"  autocomplete = "off" step="0.01" min=0 required>
            </div>

            <div class="murajaa">
                <label for="murajaainput">ورد المراجعة اليومي</label>
                <input type="number" name="murajaa" class="murajaainput" id="murajaainput" autocomplete = "off" step="0.01" min=0 required>
            </div>

            <div class="pass">
                <label for="passinput">كلمة السر</label>
                <input type="password" name="pass" class="passinput" id="passinput" required>
            </div>
            
            <div class="submitbutton">
                <input name ="create" type="submit" value="سجل" class="mainbutton">
            </div>
            <p> لديك حساب؟ <a href="index.php">سجل الدخول</a></p>        
        </div>
    
    </form>
    
</body>
</html>