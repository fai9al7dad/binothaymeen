<?php
    include 'connect.php';
    session_start();

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $stmt = $con->prepare("SELECT * FROM users WHERE username = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();
        
        $userid = $row['userid'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $halqah = $row['halqah'];
        $groupID = $row['groupID'];
        $mstwa = $row['mstwa'];



        if($groupID > 0 ){
            $_SESSION['username'] = $username;
            header('Location:filters/daily.php');
            exit();
        }
    }

    else{
        echo'you are not registerd';
        header('Location: index.php');
    }

    if(isset($_POST['create'])){
        $hifz= htmlspecialchars($_POST['hifz']);
        $muraja = htmlspecialchars($_POST['muraja']);
        $htasmee3 = htmlspecialchars($_POST['hifztasme3']);
        $mtasmee3 = htmlspecialchars($_POST['murajatasme3']);
        $reading = htmlspecialchars($_POST['reading']);
        $readingGrade = $reading * 2;
        $date = $_POST['tdate'];
        $isPlus = isset($_POST['plustasmee3']) ? 'set' : 'notset';

        if(!$mtasmee3){
            $mtasmee3 = 'لا يوجد';
        }
        if(!$htasmee3){
            $htasmee3 = 'لا يوجد';
        }
        if(!$reading){
            $reading = 'لم يقرأ';
        }
        if(!$readingGrade){
            $readingGrade = 0;
        }
        if ($date == "today"){
            $stmt = $con->prepare("INSERT INTO wird_two (user_id,hifz,muraja,date,hifztasmee3,murajatasmee3,reading,reading_grade,isPLus) VALUES(?,?,?,now(),?,?,?,?,?)");
       
            $stmt->execute(array($userid,$hifz,$muraja,$htasmee3,$mtasmee3,$reading, $readingGrade,$isPlus));
            echo '<p style="text-align:center;"> تم تسجيل وردك بنجاح</p>';
        }
        else{
            
            $stmt = $con->prepare("INSERT INTO wird_two (user_id,hifz,muraja,date,hifztasmee3,murajatasmee3,isPLus) VALUES(?,?,?,curdate() -1 ,?,?,?)");
       
            $stmt->execute(array($userid,$hifz,$muraja,$htasmee3,$mtasmee3,$reading, $readingGrade, $isPlus));
            
            echo '<p style="text-align:center;"> تم تسجيل وردك بنجاح</p>';
        }
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
                <span style="font-weight:bold">البرنامج الصيفي</span>
                <i class="fas fa-sun"></i>
                <br>
                <span style="font-size:1.5rem"><?php echo ' مستوى ' .$mstwa ?></span>
            </div>
            
            <div class="welcome">
                <h3>مرحبا</h3>
                <h1><?php echo $row["firstname"] . ' ' . $row['lastname']; ?></h1>
            </div>
            
    
        <!--  تسجيل الحفظ والمراجعة والتسميع -->

        <?php
            include "student/hasadForm.php";
            
            include "student/reading.php";

            include "student/hifz.php";
       
            include "student/muraja.php"
        ?>     
      
        </ul>  
        

    </div> <!-- container -->
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