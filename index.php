<?php
    session_start();
    include 'connect.php';
    $errors = array('username'=>' ','password'=>' ', 'notreg'=>' ');
    $username ='';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = htmlspecialchars($_POST['uname']);
        $password = htmlspecialchars($_POST['password']);
        $hashedpass = sha1($password);

        // validation
        if(empty($username)){
            $errors['username'] = 'يجب ادخال اسم مستخدم';
        }
        if(empty($password)){
            $errors['password'] = 'يجب ادخال كلمة السر';
        }

        // Check for error then redirect
        if(!empty($username) && !empty($password)){
            $stmt = $con->prepare("SELECT username, password,groupID FROM users WHERE username = ? AND password = ?");
            $stmt->execute(array($username,$hashedpass));
            $count = $stmt->rowCount();
            $row = $stmt->fetch();
            $groupID = 0;
            
            if($count == 0){
                $errors['notreg'] = 'الحساب غير مسجل، تأكد من اسم المستخدم وكلمة السر';
            }
            else{
                $groupID = $row['groupID'];
            }
            

            if((int)$groupID > 0 ){
                $_SESSION['username'] = $username;
                header('Location:filters/daily.php');
                exit();
            }
            
            if($count > 0 && $groupID == 0){
                $_SESSION['username'] = $username;
                header('Location:chooseMstwa.php');
                exit();    
            }
        }
    
    }
        
       
       
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بن عثيمين</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="images/logo1.png" type="image/png">
<body>

<form action="<?php echo $_SERVER['PHP_SELF']?>" class="login" method="POST">
    <div class="container">

        <div class="imgcontainer">
            <img src="images/logo1.png" alt="logo">
        </div>

        <?php echo '<p class="bad" style="margin:0">' . $errors['notreg'] . '</p>'?>

        <div class="textup">
            <h3>مرحبا</h3>
            <h1>سجل الدخول</h1>
        </div>

        <div class="username">
            <small class="bad"><?php echo $errors['username']?></small>
            <label for="unameinput">اسم المستخدم</label>
            <input type="text" name="uname" value="<?php echo $username?>" class="unameinput" id="unameinput" autocomplete = "off">
            

        </div>

        <div class="password">
            <small class="bad"><?php echo $errors['password']?></small>
            <label for="passinput">كلمة السر</label>
            <input type="password" name="password" class="passinput" id="passinput">
        </div>
        
        <div class="submitbutton">
            <input type="submit" value="ادخل" class="mainbutton">
        </div>
        <p>ليس لديك حساب؟ <a href="register.php">سجل</a></p>        
    </div>
    
</form>

    
</body>
</html>
