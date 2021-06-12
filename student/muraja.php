<table class="statisticsbox">
    <tr>
    <th>المقدار</th>
    <th>التسميع</th>
    <th>التاريخ</th>
    </tr>

    <?php 
        $stmt = $con->prepare("SELECT hifz,muraja,date,hifz,murajatasmee3,isPLus FROM wird_two WHERE user_id = '$userid' ORDER BY date desc");
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