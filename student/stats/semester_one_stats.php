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
