<table class="statisticsbox">
        <tr>
        <th>المقدار</th>
        <th>التسميع</th>
        <th>التاريخ</th>
        </tr>

        <?php 
            // DATe
            $stmt = $con->prepare("SELECT hifz,muraja,date,hifz,hifztasmee3,wird_id,isPLus FROM wird_two WHERE user_id = '$userid' ORDER BY date desc ");
            $stmt->execute();
            $stmt2 = $con->prepare("SELECT hifz FROM users WHERE username = '$username'");
            $stmt2->execute();
            $hamount = $stmt2->fetch();
            $late=0;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo '<tr>';
                $isPlus = $row['isPLus'];

                echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 

                // if($isPlus == 'set'){
                //     echo "<td class = 'hifz good'>" . $row['hifz'] . "</td>";
                //     $late -= $row['hifz'];
                // }

                // if ($isPlus != 'set' && ((float)$row['hifz'] > (float)$hamount['hifz'])){
                //     echo "<td class = 'hifz good'>" . $row['hifz'] . "</td>";
                //     $ajz = $row['hifz'] - $hamount['hifz'];
                //     $late -= $ajz;
                // }

                // elseif ($isPlus != 'set' && ((float)$row['hifz'] < (float)$hamount['hifz'])){
                //     echo "<td class = 'hifz bad'>" . $row['hifz'] ."</td>"; 
                //     $ajz = $row['hifz'] - $hamount['hifz'];
                //     $late -= $ajz;
                // }
                // else if ($isPlus != 'set' && ((float)$row['hifz'] == (float)$hamount['hifz'])){
                //     echo "<td class = 'hifz'>" . $row['hifz'] ."</td>"; 
                // }
                
                echo "<td class>" .$row['hifztasmee3'] ."</td>";
                echo "<td class = 'date'>" .$row['date'] ."</td>";


                echo '</tr>';
            }
            
            echo "<div style='text-align:center; font-weight:bold'>";
            
            // echo "<div class='ajz'>";
            // if ($late>0 && $late < 50){
            //     echo
            //         '<p class="late"> ' .$late .' :مقدار العجز  </p>';
            // }
            // else if ($late>=50){
            //     $helperDiv = '<div class="helpermessage">لديك عجز عالي، استعن بالله ولا تعجز</div>';
            //     echo
            //         '<p class="biglate"> '.$late. ' :مقدار العجز  </p>';
            // }
            // else{
            //     $late=0;
            //     echo
            //         '<p class="nolate"> '.$late. ' :مقدار العجز  </p>';
            // }

            echo '
                <p>احصائيات الحفظ</p>
            </div>';
            // if(isset($helperDiv)){
            //     echo $helperDiv;
            // }

        ?>
    
</table>

