<?php 
include 'connect.php';
$errors = array('firstname'=>'','lastname'=>'', 'username'=>'', 'halqah'=>'', 'hifz'=>'', 'muraja'=>'', 'password'=>'');

    if (isset($_POST['create'])){
        $fname = htmlspecialchars($_POST["fname"]);
        $lname = htmlspecialchars($_POST["lname"]);
        $uname = htmlspecialchars($_POST["uname"]);
        $halqah = htmlspecialchars($_POST["halqah"]);
        $hifz = htmlspecialchars($_POST["hifz"]);
        $murajaa = htmlspecialchars($_POST["murajaa"]);
        $pass = htmlspecialchars($_POST["pass"]);
        $hashpass = sha1($pass);
        
         // validation
        if(empty($uname)){
            $errors['username'] = 'يجب ادخال اسم مستخدم';
        }
        else{
            if(preg_match('/[^A-Za-z0-9]/', $uname)){
                $errors['username'] = 'اسم المستخدم يجب ان يكون بالانقليزي';
            }
        }
        
        if(empty($pass)){
            $errors['password'] = 'يجب ادخال كلمة السر';
        }
        if(empty($fname)){
            $errors['firstname'] = 'يجب ادخال الاسم الاول';
        } 
        if(empty($lname)){
            $errors['lastname'] = 'يجب ادخال اسم العائلة(اللقب) ';
        }
        if(empty($halqah)){
            $errors['halqah'] = 'يجب ادخال الحلقة ';
        }
        if(empty($hifz) && $hifz !=0){
            $errors['hifz'] = 'يجب ادخال ورد الحفظ';
        }
        if(empty($murajaa) && $murajaa !=0){
            $errors['muraja'] = 'يجب ادخال ورد المراجعة';
        }
          
   

        if (array_filter($errors) == []){
            $stmt = $con->prepare("INSERT INTO users (firstname,lastname,username,halqah,hifz,muraja,password) VALUES (?,?,?,?,?,?,?)");
            $result = $stmt->execute(array($fname,$lname,$uname,$halqah,$hifz,$murajaa,$hashpass));
            if($result){
                header('Location:index.php');
            }
            else{
                header('Location:register.php');
            }
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
                <small class="bad"><?php echo $errors['firstname']?></small>
                <label for="fnameinput">الإسم الأول</label>
                <input type="text" name="fname" class="fnameinput" id="fnameinput" autocomplete = "off" >

            </div>

            <div class="lname">
                <small class="bad"><?php echo $errors['lastname']?></small>
                <label for="lnameinput">الإسم الأخير</label>
                <input type="text" name="lname" class="lnameinput" id="lnameinput" autocomplete = "off">

            </div>

            <div class="uname">
                <small class="bad"><?php echo $errors['username']?></small>
                <label for="unameinput">اسم المستخدم</label>
                <input type="text" name="uname" class="unameinput" id="unameinput" autocomplete = "off"> 

            </div>
            
            <div class="halqah">
                <small class="bad"><?php echo $errors['halqah']?></small>
                <label for="halqahinput">الحلقة</label>
                <select name="halqah" id="halqahinput" >
                    <option value="oula">حلقة أولى ثانوي</option>
                    <option value="thanea">حلقة ثاني ثانوي</option>
                    <option value="thaltha">حلقة ثالث ثانوي</option>
                    <option value="jam">حلقة الجامعيين</option>
                </select>
                

            </div>

            <div class="hifz">
                <small class="bad"><?php echo $errors['hifz']?></small>
                <label for="hifzinput">ورد الحفظ اليومي</label>
                <input type="number" name="hifz" class="hifzinput" id="hifzinput"  autocomplete = "off" step="0.5" min=0 value=0 onkeypress="return onlyNumberKey(event)">
            </div>

            <div class="murajaa">
                <small class="bad"><?php echo $errors['muraja']?></small>
                <label for="murajaainput">ورد المراجعة اليومي</label>
                <input type="number" name="murajaa" class="murajaainput" id="murajaainput" autocomplete = "off" step="0.5" min=0 value=0 onkeypress="return onlyNumberKey(event)">
            </div>

            <div class="pass">
                <small class="bad"><?php echo $errors['password']?></small>
                <label for="passinput">كلمة السر</label>
                <input type="password" name="pass" class="passinput" id="passinput" >

            </div>
            
            <div class="submitbutton">
                <input name ="create" type="submit" value="سجل" class="mainbutton">
            </div>
            <p> لديك حساب؟ <a href="index.php">سجل الدخول</a></p>        
        </div>
    
    </form>
    
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