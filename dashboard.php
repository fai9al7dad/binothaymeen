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
        $groupID = $row['groupID'];



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
        $date = $_POST['tdate'];
        $isPlus = isset($_POST['plustasmee3']) ? 'set' : 'notset';


        if ($date == "today"){
            $stmt = $con->prepare("INSERT INTO wird (firstname,lastname,hifz,muraja,date,halqah,username, hifztasmee3,murajatasmee3,isPLus) VALUES(?,?,?,?,now(),?,?,?,?,?)");
       
            $stmt->execute(array($firstname,$lastname,$hifz,$muraja,$halqah,$username,$htasmee3,$mtasmee3,$isPlus));
            echo '<p style="text-align:center;"> تم تسجيل وردك بنجاح</p>';
        }
        else{
            $stmt = $con->prepare("INSERT INTO wird (firstname,lastname,hifz,muraja,date,halqah,username, hifztasmee3,murajatasmee3,isPLus) VALUES(?,?,?,?,curdate() -1 ,?,?,?,?,?)");
       
            $stmt->execute(array($firstname,$lastname,$hifz,$muraja,$halqah,$username,$htasmee3,$mtasmee3,$isPlus));
            
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

            <div class="welcome">
                <h3>مرحبا</h3>
                <h1><?php echo $row["firstname"] . ' ' . $row['lastname']; ?></h1>
            </div>
            
     
    
        <!--  تسجيل الحفظ والمراجعة والتسميع -->

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method = "POST">
            <div class="hifz">
                <p>الحفظ</p>
                <div class="boxcontainer">
                    <label for="hifz">كم سمعت اليوم؟</label>
                    <input id="hifz" onkeypress="return onlyNumberKey(event)" name ="hifz" value="0" type="number" required  autocomplete ="off" step = "0.5" min =0>
                </div>
            </div>

            <div class="hifz">
                <div class="boxcontainer">
                    <label for="hifztasmee3">من فين لفين؟</label>
                    <input id = "hifztasmee3" name ="hifztasme3" type="text" default = null placeholder ="اترك فارغا ان لم تسمع" autocomplete ="off">
                </div>
            </div>

            <div class="muraja">
                <p>المراجعة</p>
                <div class="boxcontainer">
                    <label for ="muraja">كم سمعت اليوم؟</label>
                    <input onkeypress="return onlyNumberKey(event)" name = "muraja"  id ="muraja" value="0" type="number"  required autocomplete ="off" step="0.5" min=0>
                </div>

                <div class="muraja">
                <div class="boxcontainer">
                    <label for="murajatasmee3">من فين لفين؟</label>
                    <input id = "murajatasmee3" name ="murajatasme3" type="text" placeholder ="اترك فارغا ان لسمع" autocomplete ="off">
                </div>
            </div>
                
            <div class="datebuttonscontainer">
                <label class="datebuttons">
                    <input type="radio" name="tdate" value="yesterday" >
                    <span class="checkmark"></span>
                    امس
                </label>

                <label class="datebuttons">
                    <input type="radio" checked="checked" name="tdate" value="today">
                    <span class="checkmark"></span>
                    اليوم
                </label>
            </div>

            <div class="plustasme" style="margin-bottom:26px;margin-top:20px">
                <label for="plustasmee3">  تسميع زائد؟ <small style="color:#ababab"> لايحسب عجز </small></label>
                <input type="checkbox" name="plustasmee3" id="plustasmee3">
            </div>

            <div class="submitbutton">
                <button name ="create" type="submit" class="mainbutton"> سجل <i class="fas fa-plus"></i>
                </button>
            </div>
        </form>

        <!-- الإحصائيات -->

        <!-- احصائيات الحفظ -->
         <table class="statisticsbox">
             <tr>
                <th>المقدار</th>
                <th>التسميع</th>
                <th>التاريخ</th>
             </tr>

                <?php 
                    // DATe
                    $stmt = $con->prepare("SELECT hifz,muraja,date,hifz,hifztasmee3,wirdid,isPLus FROM wird WHERE username = '$username'");
                    $stmt->execute();
                    $stmt2 = $con->prepare("SELECT hifz FROM users WHERE username = '$username'");
                    $stmt2->execute();
                    $hamount = $stmt2->fetch();
                    $late=0;

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr>';
                        $isPlus = $row['isPLus'];


                        if($isPlus == 'set'){
                            echo "<td class = 'hifz good'>" . $row['hifz'] . "</td>";
                            $late -= $row['hifz'];
                        }

                        if ($isPlus != 'set' && ((float)$row['hifz'] > (float)$hamount['hifz'])){
                            echo "<td class = 'hifz good'>" . $row['hifz'] . "</td>";
                            $ajz = $row['hifz'] - $hamount['hifz'];
                            $late -= $ajz;
                        }

                        elseif ($isPlus != 'set' && ((float)$row['hifz'] < (float)$hamount['hifz'])){
                            echo "<td class = 'hifz bad'>" . $row['hifz'] ."</td>"; 
                            $ajz = $row['hifz'] - $hamount['hifz'];
                            $late -= $ajz;
                        }
                        else if ($isPlus != 'set' && ((float)$row['hifz'] == (float)$hamount['hifz'])){
                            echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                        }

                        echo "<td class>" .$row['hifztasmee3'] ."</td>";
                        echo "<td class = 'date'>" .$row['date'] ."</td>";


                        echo '</tr>';
                    }
                    echo "<div class='ajz'>";
                   
                    if ($late>0 && $late < 50){
                        echo
                            '<p class="late"> ' .$late .' :مقدار العجز  </p>';
                    }
                    else if ($late>=50){
                        $helperDiv = '<div class="helpermessage">لديك عجز عالي، استعن بالله ولا تعجز</div>';
                        echo
                            '<p class="biglate"> '.$late. ' :مقدار العجز  </p>';
                    }
                    else{
                        $late=0;
                        echo
                            '<p class="nolate"> '.$late. ' :مقدار العجز  </p>';
                    }

                    echo '
                        <p>احصائيات المراجعة</p>
                    </div>';
                    if(isset($helperDiv)){
                        echo $helperDiv;
                    }

                ?>
         
        </table>


        <!-- احصائيات المراجعة -->
                    
         <table class="statisticsbox">
             <tr>
                <th>المقدار</th>
                <th>التسميع</th>
                <th>التاريخ</th>
             </tr>

                <?php 
                    $stmt = $con->prepare("SELECT hifz,muraja,date,hifz,murajatasmee3,isPLus FROM wird WHERE username = '$username'");
                    $stmt->execute();

                    $stmt2 = $con->prepare("SELECT muraja FROM users WHERE username = '$username'");
                    $stmt2->execute();
                    $mamount = $stmt2->fetch();
                    $late=0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $isPlus = $row['isPLus'];

                        echo '<tr>';

                        if($isPlus == 'set'){
                            echo "<td class = 'muraja good'>" . $row['muraja'] . "</td>";
                            $late -= $row['muraja'];
                        }

                        if ($isPlus != 'set' && ((float)$row['muraja'] > (float)$mamount['muraja'])){
                            echo "<td class = 'muraja good'>" . $row['muraja'] . "</td>";
                            $ajz = $row['muraja'] - $mamount['muraja'];
                            $late -= $ajz;
                        }

                        else if ($isPlus != 'set' && ((float)$row['muraja'] < (float)$mamount['muraja'])){
                            echo "<td class = 'muraja bad'>" . $row['muraja'] ."</td>"; 
                            $ajz = $row['muraja'] - $mamount['muraja'];
                            $late -= $ajz;
                        }
                        else if ($isPlus != 'set' && ((float)$row['muraja'] == (float)$mamount['muraja'])){
                            echo "<td class = 'muraja'>" . $row['muraja'] ."</td>"; 
                        }

        
                        echo "<td class>" .$row['murajatasmee3'] ."</td>";
                        echo "<td class = 'date'>" .$row['date'] ."</td>";


                        echo '</tr>';
                    }
                    echo "<div class='ajz'>";
                    
                    if ($late>0 && $late < 50){
                        echo
                            '<p class="late"> ' .$late .' :مقدار العجز  </p>';
                    }
                    else if ($late>=50){
                        $helperDiv = '<div class="helpermessage">لديك عجز عالي، استعن بالله ولا تعجز</div>';
                        echo
                            '<p class="biglate"> '.$late. ' :مقدار العجز  </p>';
                    }
                    else{
                        $late=0;
                        echo
                            '<p class="nolate"> '.$late. ' :مقدار العجز  </p>';
                    }

                    echo '
                        <p>احصائيات المراجعة</p>
                    </div>';
                    if(isset($helperDiv)){
                        echo $helperDiv;
                    }

                ?>


         
        </table>
     
      
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