<?php
        include 'connect.php';
        session_start();

        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            $stmt = $con->prepare("SELECT * FROM users WHERE username = '$username'");
            $stmt->execute();
            $row = $stmt->fetch();
            $groupID = $row['groupID'];

            if((int)$groupID > 0){
                header('Location:filters/daily.php');

            }
            else if(!empty($row['mstwa']) && (int)$groupID == 0){
                header('Location:dashboard.php');
            }
        }

        if(isset($_POST['create'])){
            $mstwa= htmlspecialchars($_POST['mstwa']);
            $stmt = $con->prepare("UPDATE users SET mstwa = ? where username = ?");
            $stmt->execute(array($mstwa,$username));
            header('Location:dashboard.php');
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/studentDashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">


    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
</head>

<body>
        <!--  الهيدر  -->

        <header>
            <div class="hcontainer">
                <img src="images/logo1.png" alt="logo">
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
           
        </header>  

        <div class="container">

            <div class="textWelcome">
                <span>البرنامج الصيفي</span>
                <i class="fas fa-sun"></i>
            </div>

            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" style="margin-top:20px; text-align:center; color:#03abb5">
                <span style="font-size:20px !important"><?php echo 'مرحبا ' . '<br/>' . $row["firstname"] . ' ' . $row['lastname']; ?></span>

                <h1>اختر مستواك</h1>
                <select name="mstwa" style="width:100%; direction: rtl; padding: 15px; font-weight:bold">
                    <option value="المهرة">المهرة</option>
                    <option value="الأترجة">الأترجة</option>
                    <option value="الفرقان">الفرقان</option>
                    <option value="السراج">السراج</option>
                </select>
                <div class="submitbutton">
                    <button name ="create" type="submit" class="mainbutton" style="font-weight:bold; margin-top:20px"><i class="fas fa-plus"></i> اختر </button>
                </div>
        </form>
        </div>
</body>