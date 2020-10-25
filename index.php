<?php
    session_start();
    include 'connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = $_POST['uname'];
        $password = $_POST['password'];
        $hashedpass = sha1($password);

        $stmt = $con->prepare("SELECT username, password,groupID FROM users WHERE username = ? AND password = ?");
        $stmt->execute(array($username,$hashedpass));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        echo $row['firstname'];
        $groupID = $row['groupID'];
       
        if((int)$groupID > 0 ){
            $_SESSION['username'] = $username;
            header('Location:filters/daily.php');
            exit();

        }
        
        if($count > 0 && (int)$groupID == 0){
            $_SESSION['username'] = $username;
            header('Location:dashboard.php');
            exit();
            
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
        <div class="textup">
            <h3>مرحبا</h3>
            <h1>سجل الدخول</h1>
        </div>
        <div class="username">
            <label for="unameinput">اسم المستخدم</label>
            <input type="text" name="uname" class="unameinput" id="unameinput" autocomplete = "off" required>
        </div>

        <div class="password">
            <label for="passinput">كلمة السر</label>
            <input type="password" name="password" class="passinput" id="passinput" required>
        </div>
        
        <div class="submitbutton">
            <input type="submit" value="ادخل" class="mainbutton">
        </div>
        <p>ليس لديك حساب؟ <a href="register.php">سجل</a></p>        
    </div>
    
</form>

    
</body>
</html>
