<?php
    include 'connect.php';
    session_start();

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $stmt = $con->prepare("SELECT * FROM users WHERE username = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();

        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $halqah = $row['halqah'];
    }

    else{
        echo'you are not registerd';
        header('Location: index.php');
    }

    if(isset($_POST['create'])){
         $hifz=  $_POST['hifz'];
         $muraja = $_POST['muraja'];
         $htasmee3 = $_POST['hifztasme3'];
         $mtasmee3 = $_POST['murajatasme3'];


        $stmt = $con->prepare("INSERT INTO wird (firstname,lastname,hifz,muraja,date,halqah,username, hifztasmee3,murajatasmee3) VALUES(?,?,?,?,now(),?,?,?,?)");

        $stmt->execute(array($firstname,$lastname,$hifz,$muraja,$halqah,$username,$htasmee3,$mtasmee3));

        echo '<p style="text-align:center;"> تم تسجيل وردك بنجاح</p>';
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="images/logo1.png" type="image/png">

    <title><?php echo basename($_SERVER['PHP_SELF'])?></title>
</head>
<body>

    <div class="container">

        <!--  الهيدر  -->

        <header>
            <div class="welcome">
                <h3>مرحبا</h3>
                <h1><?php echo $row["firstname"] . ' ' . $row['lastname']; ?></h1>
                <a href="logout.php"><p style ="font-size:12px;">تسجيل الخروج</p></a>
            </div>
            <div class="imgcontainer">
                <img src="images/logo1.png" alt="logo">
            </div>
            <div class="clear"></div>

        </header>  
    
        <div class="clear"></div>

        <!--  تسجيل الحفظ والمراجعة والتسميع -->

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method = "POST">
            <div class="hifz">
                <p>الحفظ</p>
                <div class="boxcontainer">
                    <small>كم سمعت اليوم؟</small>
                    <input name ="hifz" type="number" placeholder ="ادخل '0' اذا لم تسمع'" autocomplete ="off" step = "0.01" min =0 required>
                </div>
            </div>
            <div class="clear"></div>

            <div class="hifz">
                <div class="boxcontainer">
                    <small>من فين لفين؟</small>
                    <input name ="hifztasme3" type="text" placeholder ="النور 1 - 25'" autocomplete ="off"  required>
                </div>
            </div>

            <div class="muraja">
                <p>المراجعة</p>
                <div class="boxcontainer">
                    <small>كم سمعت اليوم؟</small>
                    <input name = "muraja" type="number" placeholder ="ادخل '0' اذا لم تُسمع'" autocomplete ="off" step="0.01" min=0 required>
                </div>

                <div class="muraja">
                <div class="boxcontainer">
                    <small>من فين لفين؟</small>
                    <input name ="murajatasme3" type="text" placeholder ="جزء تبارك'" autocomplete ="off"  required>
                </div>
            </div>
                
            </div>
  

            <div class="submitbutton">
                <input name ="create" type="submit" value="سجل وردك" class="mainbutton">
            </div>
        </form>

        <!-- الإحصائيات -->

        <!-- احصائيات الحفظ -->

         <p style ="text-align:right; margin-top:57px">احصائيات الحفظ</p>
         <ul class="statisticsbox">
            <div class="hifzstats">
                <?php 
                    // DATE
                    $stmt = $con->prepare("SELECT hifz,muraja,date,hifztasmee3 FROM wird WHERE username = '$username'");
                    $stmt->execute();
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "<li class = 'date' style=clear:right>" .$row['date']. ' | '. $row['hifztasmee3'] ."</li>";
                    }
                    

                    $stmt = $con->prepare("SELECT hifz,muraja,date,hifz FROM wird WHERE username = '$username'");
                    $stmt->execute();

                    // AMOUNT

                    $stmt2 = $con->prepare("SELECT hifz FROM users WHERE username = '$username'");
                    $stmt2->execute();
                    $hamount = $stmt2->fetch();
                    
                    $late = 0;    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        if ( (float)$row['hifz'] > (float)$hamount['hifz']){
                            echo "<li class = 'hifz good' style ='clear:left'>" . $row['hifz'] . "</li>";
                            $ajz = $row['hifz'] - $hamount['hifz'];
                            $late -= $ajz;
                        }
                        elseif ((float)$row['hifz'] < (float)$hamount['hifz']){
                            echo "<li class = 'hifz bad' style ='clear:left'>" . $row['hifz'] ."</li>"; 
                            $ajz = $row['hifz'] - $hamount['hifz'];
                            $late -= $ajz;
                        }
                        else{
                            echo "<li class = 'hifz' style ='clear:left'>" . $row['hifz'] ."</li>"; 
                        }
                    }
                ?>

            </div>

            <div class="ajz">
                <hr class="hrstyle">
                <p style="float:right; font-size: 16px">مقدار العجز</p>
             
                <p style ='float:left; font-size: 16px'>
                  <?php if ($late<0){
                        echo $late =0;
                      }else{
                          echo (float)$late;
                      }
                    ?></p>
            </div>
        </ul>

        <!-- احصائيات المراجعة -->
        
         <p style ="text-align:right; margin-top:57px">احصائيات المراجعة</p>

         <ul class="statisticsbox">
            <div class="murajastats">
                
                <?php 
                    // DATE
                    $stmt = $con->prepare("SELECT hifz,muraja,date,murajatasmee3 FROM wird WHERE username = '$username'");
                    $stmt->execute();
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "<li class = 'date' style='clear:right'>" . $row['date'] . ' | '. $row['murajatasmee3'] ."</li>";
                    }

                    $stmt = $con->prepare("SELECT hifz,muraja,date FROM wird WHERE username = '$username'");
                    $stmt->execute();

                    // AMOUNT

                    $stmt2 = $con->prepare("SELECT muraja FROM users WHERE username = '$username'");
                    $stmt2->execute();
                    $hamount = $stmt2->fetch();
                    
                    $late = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        if ( (float)$row['muraja'] > (float)$hamount['muraja']){
                            echo "<li class = 'muraja good' style ='clear:left'>" . $row['muraja'] ."</li>";
                            $ajz = $row['muraja'] - $hamount['muraja'];
                            $late -= $ajz;
                        }
                        elseif ((float)$row['muraja'] < (float)$hamount['muraja']){
                            echo "<li class = 'muraja bad' style ='clear:left'>" . $row['muraja'] ."</li>"; 
                            $ajz = $row['muraja'] - $hamount['muraja'];
                            $late -= $ajz;
                        }
                        else{
                            echo "<li class = 'muraja' style ='clear:left'>" . $row['muraja'] ."</li>"; 
                        }
                    }
                ?>
            </div> 
            
            <!-- حساب العجز -->
            <div class="ajz">
                <hr class="hrstyle">
                <p style="float:right; font-size: 16px">مقدار العجز</p>
                <p style ='float:left; font-size: 16px'>
                  <?php if ($late<0){
                        echo $late =0;
                      }else{
                          echo (float)$late;
                      }
                    ?></p>
            </div>
        </ul>  
        

    </div> <!-- container -->
</body>
</html>

<script src="js/script.js"></script>